<?php

namespace App\Mail;

use App\Helpers\FlashMessageHelper;
use App\Models\EmployeeDetails;
use App\Models\HolidayCalendar;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class LeaveApplicationNotification extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $leaveRequest;
    public $employeeDetails;
    public $applyingToDetails;
    public $ccToDetails;
    public $cancelStatus;
    public $leaveCategory;
    public function __construct($leaveRequest, $applyingToDetails, $ccToDetails)
    {
        $this->leaveRequest = $leaveRequest;
        $this->applyingToDetails = $applyingToDetails;
        $this->ccToDetails = $ccToDetails;
        $this->employeeDetails = EmployeeDetails::where('emp_id', $leaveRequest->emp_id)->first();
    }
    public function build()
    {
        // Calculate number of days before passing to the view
        $numberOfDays = $this->calculateNumberOfDays(
            $this->leaveRequest->from_date,
            $this->leaveRequest->from_session,
            $this->leaveRequest->to_date,
            $this->leaveRequest->to_session,
            $this->leaveRequest->leave_type
        );

        return $this->view('mails.leave_application_notification')
            ->with([
                'leaveRequest' => $this->leaveRequest,
                'applyingToDetails' => $this->applyingToDetails,
                'ccToDetails' => $this->ccToDetails,
                'employeeDetails' => $this->employeeDetails,
                'numberOfDays' => $numberOfDays,
                'leave_status' => $this->leaveRequest->leave_status,
                'leaveCategory' => $this->leaveRequest->category_type,
                'cancelStatus' => $this->leaveRequest->cancel_status,
            ]);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $subject = '';
        if ($this->leaveRequest->category_type === 'Leave'){
            if ($this->leaveRequest->leave_status === 4) {
                $subject = 'Leave Application from: ' . ucwords(strtolower($this->employeeDetails->first_name)) . ' ' . ucwords(strtolower($this->employeeDetails->last_name)) . ' (' . $this->employeeDetails->emp_id . ') has been withdrawn.';
            } else {
                $subject = 'Leave Application from: ' . ucwords(strtolower($this->employeeDetails->first_name)) . ' ' . ucwords(strtolower($this->employeeDetails->last_name)) . ' (' . $this->employeeDetails->emp_id . ')';
            }
        }else{
            if ($this->leaveRequest->cancel_status === 4) {
                $subject = 'Leave Cancel Application from: ' . ucwords(strtolower($this->employeeDetails->first_name)) . ' ' . ucwords(strtolower($this->employeeDetails->last_name)) . ' (' . $this->employeeDetails->emp_id . ') has been withdrawn.';
            } else {
                $subject = 'Leave Cancel Application from: ' . ucwords(strtolower($this->employeeDetails->first_name)) . ' ' . ucwords(strtolower($this->employeeDetails->last_name)) . ' (' . $this->employeeDetails->emp_id . ')';
            }
        }

        return new Envelope(
            subject: $subject // Use the subject variable here
        );
    }


    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mails.leave_application_notification',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
    public function calculateNumberOfDays($fromDate, $fromSession, $toDate, $toSession, $leaveType)
    {
        try {
            $startDate = Carbon::parse($fromDate);
            $endDate = Carbon::parse($toDate);

            // Fetch holidays between the fromDate and toDate
            $holidays = HolidayCalendar::whereBetween('date', [$startDate, $endDate])->get();

            // Check if the start or end date is a weekend for non-Marriage leave
            if (!in_array($leaveType, ['Marriage Leave', 'Sick Leave', 'Maternity Leave', 'Paternity Leave']) && ($startDate->isWeekend() || $endDate->isWeekend())) {
                return 0;
            }

            // Check if the start and end sessions are different on the same day
            if (
                $startDate->isSameDay($endDate) &&
                $this->getSessionNumber($fromSession) === $this->getSessionNumber($toSession)
            ) {
                // Inner condition to check if both start and end dates are weekdays (for non-Marriage leave)
                if (!in_array($leaveType, ['Marriage Leave', 'Sick Leave', 'Maternity Leave', 'Paternity Leave']) && !$startDate->isWeekend() && !$endDate->isWeekend() && !$this->isHoliday($startDate, $holidays) && !$this->isHoliday($endDate, $holidays)) {
                    return 0.5;
                } else {
                    return 0.5;
                }
            }

            if (
                $startDate->isSameDay($endDate) &&
                $this->getSessionNumber($fromSession) !== $this->getSessionNumber($toSession)
            ) {
                // Inner condition to check if both start and end dates are weekdays (for non-Marriage leave)
                if (!in_array($leaveType, ['Marriage Leave', 'Sick Leave', 'Maternity Leave', 'Paternity Leave']) && !$startDate->isWeekend() && !$endDate->isWeekend() && !$this->isHoliday($startDate, $holidays) && !$this->isHoliday($endDate, $holidays)) {
                    return 1;
                } else {
                    return 1;
                }
            }

            $totalDays = 0;

            while ($startDate->lte($endDate)) {
                // For non-Marriage leave type, skip holidays and weekends, otherwise include weekdays
                if (!in_array($leaveType, ['Marriage Leave', 'Sick Leave', 'Maternity Leave', 'Paternity Leave'])) {
                    if (!$this->isHoliday($startDate, $holidays) && $startDate->isWeekday()) {
                        $totalDays += 1;
                    }
                } else {
                    // For Marriage leave type, count all weekdays without excluding weekends or holidays
                    if (!$this->isHoliday($startDate, $holidays)) {
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
            FlashMessageHelper::flashError('An error occurred while calculating the number of days.');
            return false;
        }
    }

    private function getSessionNumber($session)
    {
        return (int) str_replace('Session ', '', $session);
    }
}
