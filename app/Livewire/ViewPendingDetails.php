<?php
// File Name                       : ViewPendingDetails.php
// Description                     : This file contains the implementation displaying details of approved leaves and it will appear only for manager after approving leaves
// Creator                         : Bandari Divya
// Email                           : bandaridivya1@gmail.com
// Organization                    : PayG.
// Date                            : 2024-03-07
// Framework                       : Laravel (10.10 Version)
// Programming Language            : PHP (8.1 Version)
// Database                        : MySQL
// Models                          : EmployeeDetails,LeaveRequest
namespace App\Livewire;

use App\Helpers\FlashMessageHelper;
use App\Mail\LeaveApprovalNotification;
use App\Models\LeaveRequest;
use App\Models\Notification;
use App\Models\EmployeeDetails;
use Google\Service\AnalyticsData\OrderBy;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use PDOException;

class ViewPendingDetails extends Component
{
    public $employeeDetails = [];
    public $employeeId;
    public $leaveRequests;
    public $count = 0;
    public $isLoggedInEmpInCcTo;
    public $applying_to = [];
    public $matchingLeaveApplications = [];
    public $leaveRequest;
    public $leaveApplications = [];
    public $selectedYear;
    public $filter = '';
    public $index;
    public function mount()
    {
        //for year selection
        $this->selectedYear = Carbon::now()->format('Y');
        $this->fetchPendingLeaveApplications($this->filter = null);
    }

    public function fetchPendingLeaveApplications($filter = null)
    {
        try {
            $employeeId = auth()->guard('emp')->user()->emp_id;
            $threeWorkingDaysAgo = $this->subtractWorkingDays(3);
            // Base query for fetching leave applications
            $query = LeaveRequest::where(function ($query) {
                $query->where('leave_applications.leave_status', 5)
                    ->orWhere('leave_applications.cancel_status', 7);
            })
                ->join('employee_details', 'leave_applications.emp_id', '=', 'employee_details.emp_id')
                ->join('status_types', 'status_types.status_code', '=', 'leave_applications.leave_status')
                ->where('leave_applications.created_at', '>=', $threeWorkingDaysAgo)
                ->OrderBy('leave_applications.created_at', 'desc');

            // Search query conditions
            if ($filter !== null) {
                $query->where(function ($query) use ($filter) {
                    $query->where('employee_details.first_name', 'like', '%' . $filter . '%')
                        ->orWhere('employee_details.last_name', 'like', '%' . $filter . '%')
                        ->orWheree('leave_applications.category_type', 'like', '%' . $filter . '%')
                        ->orWhere('leave_applications.emp_id', 'like', '%' . $filter . '%')
                        ->orWhere('leave_applications.leave_type', 'like', '%' . $filter . '%')
                        ->orWhere('status_types.status_name', 'like', '%' . $filter . '%');
                });
            }

            // Applying conditions for employee's role in the leave application
            $query->where(function ($query) use ($employeeId) {
                $query->whereJsonContains('applying_to', [['manager_id' => $employeeId]])
                    ->orWhereJsonContains('cc_to', [['emp_id' => $employeeId]]);
            });

            // Fetch the leave applications with required fields
            $this->leaveRequests = $query->get(['leave_applications.*', 'employee_details.image', 'employee_details.first_name', 'employee_details.last_name']);

            $matchingLeaveApplications = [];

            $allCcToEmpIds = []; // Array to collect all cc_to emp_ids

            foreach ($this->leaveRequests as $leaveRequest) {
                $leaveRequest->from_date = Carbon::parse($leaveRequest->from_date);
                $leaveRequest->to_date = Carbon::parse($leaveRequest->to_date);

                $applyingToJson = trim($leaveRequest->applying_to);
                $applyingArray = is_array($applyingToJson) ? $applyingToJson : json_decode($applyingToJson, true);

                $ccToJson = trim($leaveRequest->cc_to);
                $ccArray = is_array($ccToJson) ? $ccToJson : json_decode($ccToJson, true);

                // Collect all cc_to emp_ids
                if (!empty($ccArray)) {
                    foreach ($ccArray as $cc) {
                        if (isset($cc['emp_id'])) {
                            $allCcToEmpIds[] = $cc['emp_id']; // Store each emp_id
                        }
                    }
                }

                $isManagerInApplyingTo = isset($applyingArray[0]['manager_id']) && $applyingArray[0]['manager_id'] == $employeeId;
                $isEmpInCcTo = isset($ccArray[0]['emp_id']) && $ccArray[0]['emp_id'];

                if ($isManagerInApplyingTo || $isEmpInCcTo) {

                    $fromDateYear = Carbon::parse($leaveRequest->from_date)->format('Y');

                    if ($fromDateYear == $this->selectedYear) {
                        $leaveBalances = LeaveBalances::getLeaveBalances($leaveRequest->emp_id, $this->selectedYear);
                    } else {
                        $leaveBalances = 0;
                    }
                    $matchingLeaveApplications[] = [
                        'leaveRequest' => $leaveRequest,
                        'leaveBalances' => $leaveBalances,
                    ];
                }
            }
            // After the foreach, compare the collection with the logged-in emp_id
            $this->isLoggedInEmpInCcTo = in_array($employeeId, $allCcToEmpIds);
            $this->leaveApplications = $matchingLeaveApplications;
            $this->count = count($matchingLeaveApplications);
        } catch (\Illuminate\Database\QueryException $e) {
            FlashMessageHelper::flashError('Error while getting the data. Please try again.');
        } catch (PDOException $e) {
            FlashMessageHelper::flashError('Connection error . Please try again.');
        } catch (\Exception $e) {
            FlashMessageHelper::flashError('Connection error . Please try again.');
        }
    }

    private function subtractWorkingDays($days)
    {
        $date = Carbon::now();

        while ($days > 0) {
            $date->subDay();

            // Check if it's a weekday (Monday to Friday)
            if ($date->isWeekday()) {
                $days--;
            }
        }

        return $date;
    }
    // Check if there are pending leave requests
    public function hasPendingLeave()
    {
        try {
            // Check if there are pending leave requests
            return $this->leaveRequests->where('leave_status', 5)->isNotEmpty();
        } catch (\Exception $e) {
            FlashMessageHelper::flashError('Error while getting leave request. Please try again.');
        }
    }

    //calcilate number of days in a leave application
    public function calculateNumberOfDays($fromDate, $fromSession, $toDate, $toSession, $leaveType)
    {
        try {
            $startDate = Carbon::parse($fromDate);
            $endDate = Carbon::parse($toDate);

            // Check if the start or end date is a weekend
            if ($startDate->isWeekend() || $endDate->isWeekend()) {
                return 0;
            }

            // Check if the start and end sessions are different on the same day
            if (
                $startDate->isSameDay($endDate) &&
                $this->getSessionNumber($fromSession) === $this->getSessionNumber($toSession)
            ) {
                // Inner condition to check if both start and end dates are weekdays
                if (!$startDate->isWeekend() && !$endDate->isWeekend()) {
                    return 0.5;
                } else {
                    // If either start or end date is a weekend, return 0
                    return 0;
                }
            }

            if (
                $startDate->isSameDay($endDate) &&
                $this->getSessionNumber($fromSession) !== $this->getSessionNumber($toSession)
            ) {
                // Inner condition to check if both start and end dates are weekdays
                if (!$startDate->isWeekend() && !$endDate->isWeekend()) {
                    return 1;
                } else {
                    // If either start or end date is a weekend, return 0
                    return 0;
                }
            }

            $totalDays = 0;

            while ($startDate->lte($endDate)) {
                if ($leaveType == 'Sick Leave') {
                    $totalDays += 1;
                } else {
                    if ($startDate->isWeekday()) {
                        $totalDays += 1;
                    }
                }
                // Move to the next day
                $startDate->addDay();
            }

            // Deduct weekends based on the session numbers
            if ($this->getSessionNumber($fromSession) > 1) {
                $totalDays -= $this->getSessionNumber($fromSession) - 1; // Deduct days for the starting session
            }
            if ($this->getSessionNumber($toSession) < 2) {
                $totalDays -= 2 - $this->getSessionNumber($toSession); // Deduct days for the ending session
            }
            // Adjust for half days
            if ($this->getSessionNumber($fromSession) === $this->getSessionNumber($toSession)) {
                // If start and end sessions are the same, check if the session is not 1
                if ($this->getSessionNumber($fromSession) !== 1) {
                    $totalDays += 0.5; // Add half a day
                } else {
                    $totalDays += 0.5;
                }
            } elseif ($this->getSessionNumber($fromSession) !== $this->getSessionNumber($toSession)) {
                if ($this->getSessionNumber($fromSession) !== 1) {
                    $totalDays += 1; // Add half a day
                }
            } else {
                $totalDays += ($this->getSessionNumber($toSession) - $this->getSessionNumber($fromSession) + 1) * 0.5;
            }

            return $totalDays;
        } catch (\Exception $e) {
            return 'Error: ' . $e->getMessage();
        }
    }


    private function getSessionNumber($session)
    {
        // You might need to customize this based on your actual session values
        return (int) str_replace('Session ', '', $session);
    }



    //This method used to approve leave application by manager
    public function approveLeave($index)
    {
        try {
            $employeeId = auth()->guard('emp')->user()->emp_id;
            $leaveRequest = $this->leaveApplications[$index]['leaveRequest'];
            // Get employee email
            $sendEmailToEmp = EmployeeDetails::where('emp_id', $leaveRequest->emp_id)->pluck('email')->first();

            $createdDate = Carbon::parse($leaveRequest->created_at);
            $daysSinceCreation = $createdDate->diffInDays(Carbon::now());

            if ($leaveRequest->leave_status === 2) {
                FlashMessageHelper::flashWarning('Leave application is already approved.');
            } else {
                if ($daysSinceCreation > 3 || $leaveRequest->leave_status !== 2) {
                    $leaveRequest->leave_status = 2;
                    $leaveRequest->updated_at = now();
                    $leaveRequest->action_by = $employeeId;
                    $leaveRequest->save();
                    Notification::create([
                        'emp_id' =>  $employeeId,
                        'notification_type' => 'leaveApprove',
                        'leave_type' => $leaveRequest->leave_type,
                        'assignee' => $leaveRequest->emp_id,
                    ]);
                    FlashMessageHelper::flashSuccess('Leave application approved successfully.');
                    // Sending email to employee and CC emails
                    $applyingToDetails = json_decode($leaveRequest->applying_to, true);
                    $ccToDetails = json_decode($leaveRequest->cc_to, true);

                    // Extract CC emails
                    $ccEmails = array_map(fn($cc) => $cc['email'], $ccToDetails);
                    $ccEmails = array_slice($ccEmails, 0, 5); // Limit to 5

                    // Only send email if employee or CC emails are not empty
                    if (!empty($sendEmailToEmp) || !empty($ccEmails)) {

                        // Send email to the main recipient (the employee)
                        if (!empty($sendEmailToEmp)) {
                            Mail::to($sendEmailToEmp)
                                ->send(new LeaveApprovalNotification($leaveRequest, $applyingToDetails, $ccToDetails, true));
                        }

                        // Send emails to CC recipients with different content
                        if (!empty($ccEmails)) {
                            $mail = Mail::to($ccEmails); // Send to the applying-to email first

                            // Add CC email if available
                            if (!empty($ccToEmail)) {
                                $mail->cc($ccToEmail); // Add CC email
                            }

                            // Send the leave cancel notification email
                            $mail->send(new LeaveApprovalNotification(
                                $leaveRequest,        // Leave request object
                                $applyingToDetails,  // First applying-to recipient's details
                                $ccToDetails,    // CC details
                                false                 // Set forMainRecipient to false (since this is not for the main applicant)
                            ));
                        }
                    }
                }
            }

            $this->fetchPendingLeaveApplications();
        } catch (\Exception $e) {
            FlashMessageHelper::flashError('Failed to approve leave application. Please try again.');
        }
    }

    //This method used to approve leave cancel application by manager
    public function approveLeaveCancel($index)
    {
        try {
            $employeeId = auth()->guard('emp')->user()->emp_id;

            // Find the leave request by ID
            $leaveRequest = $this->leaveApplications[$index]['leaveRequest'];
            $sendEmailToEmp = EmployeeDetails::where('emp_id', $leaveRequest->emp_id)->pluck('email')->first();
            // Calculate the difference in days from the created date to now
            $createdDate = Carbon::parse($leaveRequest->created_at);
            $daysSinceCreation = $createdDate->diffInDays(Carbon::now());

            // Check if status is already approved
            if ($leaveRequest->cancel_status === 2) {
                FlashMessageHelper::flashWarning('Leave application is already approved.');
            } else {
                // Check if days since creation is more than 3 days or status is not yet approved
                if ($daysSinceCreation > 3 || $leaveRequest->cancel_status !== 2) {

                    // Find any other leave request matching from_date, from_session, to_date, to_session
                    $matchingLeaveRequest = LeaveRequest::where('emp_id', $leaveRequest->emp_id)
                        ->where('from_date', $leaveRequest->from_date)
                        ->where('from_session', $leaveRequest->from_session)
                        ->where('to_date', $leaveRequest->to_date)
                        ->where('to_session', $leaveRequest->to_session)
                        ->where('cancel_status', '=', 6)
                        ->first();
                    if ($matchingLeaveRequest) {
                        // Update the matching request status to 'rejected'
                        $matchingLeaveRequest->leave_status = 2;
                        $matchingLeaveRequest->cancel_status = 2;
                        $matchingLeaveRequest->updated_at = now();
                        $matchingLeaveRequest->action_by = $employeeId;
                        $matchingLeaveRequest->save();
                    }

                    // Update the current leave request status to 'approved'
                    $leaveRequest->cancel_status = 2;
                    $leaveRequest->leave_status = 2;
                    $leaveRequest->updated_at = now();
                    $leaveRequest->action_by = $employeeId;
                    $leaveRequest->save();
                    FlashMessageHelper::flashSuccess('Leave cancel application approved successfully.');
                    // Sending email to employee and CC emails
                    $applyingToDetails = json_decode($leaveRequest->applying_to, true);
                    $ccToDetails = json_decode($leaveRequest->cc_to, true);

                    // Extract CC emails
                    $ccEmails = array_map(fn($cc) => $cc['email'], $ccToDetails);
                    $ccEmails = array_slice($ccEmails, 0, 5); // Limit to 5

                    // Only send email if employee or CC emails are not empty
                    if (!empty($sendEmailToEmp) || !empty($ccEmails)) {
                        // Send email to the main recipient (the employee)
                        dd($sendEmailToEmp);
                        if (!empty($sendEmailToEmp)) {
                            Mail::to($sendEmailToEmp)
                                ->send(new LeaveApprovalNotification($leaveRequest, $applyingToDetails, $ccToDetails, true));
                            FlashMessageHelper::flashSuccess('sent email sussceesfully');
                        }

                        // Send emails to CC recipients with different content
                        if (!empty($ccEmails)) {
                            $mail = Mail::to($ccEmails); // Send to the applying-to email first

                            // Add CC email if available
                            if (!empty($ccToEmail)) {
                                $mail->cc($ccToEmail); // Add CC email
                            }

                            // Send the leave cancel notification email
                            $mail->send(new LeaveApprovalNotification(
                                $leaveRequest,        // Leave request object
                                $applyingToDetails,  // First applying-to recipient's details
                                $ccToDetails,    // CC details
                                false                 // Set forMainRecipient to false (since this is not for the main applicant)
                            ));
                        }
                        $this->fetchPendingLeaveApplications();
                    }
                }
            }
        } catch (\Exception $e) {
            FlashMessageHelper::flashError('Failed to approve leave application. Please try again.');
        }
    }

    public function rejectLeaveCancel($index)
    {
        try {
            $employeeId = auth()->guard('emp')->user()->emp_id;

            // Find the leave request by ID
            $leaveRequest = $this->leaveApplications[$index]['leaveRequest'];
            $sendEmailToEmp = EmployeeDetails::where('emp_id', $leaveRequest->emp_id)->pluck('email')->first();

            // Calculate the difference in days from the created date to now
            $createdDate = Carbon::parse($leaveRequest->created_at);
            $daysSinceCreation = $createdDate->diffInDays(Carbon::now());

            // Check if status is already approved
            if ($leaveRequest->cancel_status === 3) {
                FlashMessageHelper::flashWarning('Leave cancel application is already rejected.');
            } else {
                // Check if days since creation is more than 3 days or status is not yet approved
                if ($daysSinceCreation > 3 || $leaveRequest->cancel_status !== 3) {
                    // Find any other leave request matching from_date, from_session, to_date, to_session
                    $matchingLeaveRequest = LeaveRequest::where('emp_id', $leaveRequest->emp_id)
                        ->where('from_date', $leaveRequest->from_date)
                        ->where('from_session', $leaveRequest->from_session)
                        ->where('to_date', $leaveRequest->to_date)
                        ->where('to_session', $leaveRequest->to_session)
                        ->where('cancel_status', '=', 6)
                        ->first();
                    if ($matchingLeaveRequest) {
                        // Update the matching request status to 'rejected'
                        $matchingLeaveRequest->cancel_status = 3;
                        $matchingLeaveRequest->updated_at = now();
                        $matchingLeaveRequest->action_by = $employeeId;
                        $matchingLeaveRequest->save();
                    }

                    // Update the current leave request status to 'approved'
                    $leaveRequest->cancel_status = 3;
                    $leaveRequest->leave_status = 3;
                    $leaveRequest->updated_at = now();
                    $leaveRequest->action_by = $employeeId;
                    $leaveRequest->save();
                    FlashMessageHelper::flashSuccess('Leave cancel application rejected successfully.');
                    // Sending email to employee and CC emails
                    $applyingToDetails = json_decode($leaveRequest->applying_to, true);
                    $ccToDetails = json_decode($leaveRequest->cc_to, true);

                    // Extract CC emails
                    $ccEmails = array_map(fn($cc) => $cc['email'], $ccToDetails);
                    $ccEmails = array_slice($ccEmails, 0, 5); // Limit to 5

                    // Only send email if employee or CC emails are not empty
                    if (!empty($sendEmailToEmp) || !empty($ccEmails)) {
                        // Send email to the main recipient (the employee)
                        if (!empty($sendEmailToEmp)) {
                            Mail::to($sendEmailToEmp)
                                ->send(new LeaveApprovalNotification($leaveRequest, $applyingToDetails, $ccToDetails, true));
                        }

                        // Send emails to CC recipients with different content
                        if (!empty($ccEmails)) {
                            $mail = Mail::to($ccEmails); // Send to the applying-to email first

                            // Add CC email if available
                            if (!empty($ccToEmail)) {
                                $mail->cc($ccToEmail); // Add CC email
                            }

                            // Send the leave cancel notification email
                            $mail->send(new LeaveApprovalNotification(
                                $leaveRequest,        // Leave request object
                                $applyingToDetails,  // First applying-to recipient's details
                                $ccToDetails,    // CC details
                                false                 // Set forMainRecipient to false (since this is not for the main applicant)
                            ));
                        }
                        $this->fetchPendingLeaveApplications();
                    }
                }
            }
        } catch (\Exception $e) {
            // Handle the exception
            FlashMessageHelper::flashError('Failed to approve leave application. Please try again.');
        }
    }

    //this to reject the leave
    public function rejectLeave($index)
    {
        try {
            $employeeId = auth()->guard('emp')->user()->emp_id;
            // Find the leave request by ID
            $leaveRequest = $this->leaveApplications[$index]['leaveRequest'];
            $sendEmailToEmp = EmployeeDetails::where('emp_id', $leaveRequest->emp_id)->pluck('email')->first();
            // Update status to 'rejected'
            $leaveRequest->leave_status = 3;
            $leaveRequest->updated_at = now();
            $leaveRequest->action_by = $employeeId;
            $leaveRequest->save();
            Notification::create([
                'emp_id' =>  $employeeId,
                'notification_type' => 'leaveReject',
                "leave_type" => $leaveRequest->leave_type,
                'assignee' => $leaveRequest->emp_id,
            ]);
            FlashMessageHelper::flashSuccess('Leave application rejected successfully.');
            // Sending email to employee and CC emails
            $applyingToDetails = json_decode($leaveRequest->applying_to, true);
            $ccToDetails = json_decode($leaveRequest->cc_to, true);

            // Extract CC emails
            $ccEmails = array_map(fn($cc) => $cc['email'], $ccToDetails);
            $ccEmails = array_slice($ccEmails, 0, 5); // Limit to 5

            // Only send email if employee or CC emails are not empty
            if (!empty($sendEmailToEmp) || !empty($ccEmails)) {
                // Send email to the main recipient (the employee)
                if (!empty($sendEmailToEmp)) {
                    Mail::to($sendEmailToEmp)
                        ->send(new LeaveApprovalNotification($leaveRequest, $applyingToDetails, $ccToDetails, true));
                }

                // Send emails to CC recipients with different content
                if (!empty($ccEmails)) {
                    $mail = Mail::to($ccEmails); // Send to the applying-to email first

                    // Add CC email if available
                    if (!empty($ccToEmail)) {
                        $mail->cc($ccToEmail); // Add CC email
                    }

                    // Send the leave cancel notification email
                    $mail->send(new LeaveApprovalNotification(
                        $leaveRequest,        // Leave request object
                        $applyingToDetails,  // First applying-to recipient's details
                        $ccToDetails,    // CC details
                        false                 // Set forMainRecipient to false (since this is not for the main applicant)
                    ));
                }
            }
            $this->fetchPendingLeaveApplications();
        } catch (\Exception $e) {
            // Flash a message to the session
            FlashMessageHelper::flashError('An error occurred while rejecting leave application.');
        }
    }
    // Method to handle search input change
    public function updatedSearchQuery($value)
    {
        $this->filter = $value;
        // Call fetchPendingLeaveApplications with updated $filter
        $this->fetchPendingLeaveApplications($this->filter);
    }
    public function render()
    {
        return view('livewire.view-pending-details', [
            'leaveApplications' => $this->leaveApplications,
            'filter' => $this->filter,
            'count' => $this->count,
            'isLoggedInEmpInCcTo' => $this->isLoggedInEmpInCcTo
        ]);
    }
}
