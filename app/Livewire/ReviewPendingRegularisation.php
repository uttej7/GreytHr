<?php

namespace App\Livewire;

use App\Helpers\FlashMessageHelper;
use App\Mail\RegularisationApprovalMail;
use App\Mail\RegularisationCombinedMail;
use App\Mail\RegularisationRejectionMail;
use App\Models\EmployeeDetails;
use App\Models\RegularisationDates;
use App\Models\RegularisationNew1;
use App\Models\SwipeRecord;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class ReviewPendingRegularisation extends Component
{
    public $regularisationdescription;
    public $regularisationrequest;

    public $employeeEmailForApproval;
    public $regularisationEntries;
    public $ManagerId;
    public $ManagerName;
    public $id;

    public $totalEntries;

    public $remarks = [];

    public $employeeEmailForRejection;
   
    public $empid;
    public $empName;

    public $countofregularisations;
    public $employeeDetails;
    public $regularisationdescrip;
    public function mount($id,$count)
    {
       

        // Loop through each request and reject it
       
        $this->empid = Auth::guard('emp')->user()->emp_id;
        $this->empName = EmployeeDetails::where('emp_id', $this->empid)->first();
        $this->regularisationrequest = RegularisationDates::with('employee')->find($id);
        $subordinateEmpId=$this->regularisationrequest->emp_id;
        $this->employeeDetails = Employeedetails::where('emp_id', $subordinateEmpId)->first();
        $this->ManagerId=$this->regularisationrequest->employee->manager_id;
        
        $this->ManagerName=EmployeeDetails::select('first_name','last_name')->where('emp_id',$this->ManagerId)->first();
        $this->regularisationEntries = json_decode($this->regularisationrequest->regularisation_entries, true);
        $this->countofregularisations=$count;
        $this->totalEntries = count($this->regularisationEntries);
    }
   
    public function approve($date)
    {
        // dd('approve'.$date);
      
        $remark = $this->remarks[$date] ?? null;

        // Log the remark for debugging purposes
        Log::info('Remark:', ['remark' => $remark]);

        // Find the entry with the matching date and update its status
        foreach ($this->regularisationEntries as &$entry) {
            if ($entry['date'] === $date) {
                $entry['status'] = 'approved';
                $entry['remark'] = $remark; // Optionally add the remark to the entry
                FlashMessageHelper::flashSuccess('Regularization Request Approved Successfully');
                
                break;
            }

        }

        // Save the updated regularisationEntries back to the database
        $this->regularisationrequest->regularisation_entries = json_encode($this->regularisationEntries);
        $this->regularisationrequest->save();
    }

    public function rejectAll($id)
    {
        $currentDateTime = Carbon::now();
        $item = RegularisationDates::find($id);
        if(empty($this->remarks))
        {

        }
        else
        {
            $item->approver_remarks=$this->remarks;
        }
        $item->status=3;
        $item->rejected_date = $currentDateTime; 
        $item->rejected_by=$this->ManagerName->first_name . ' ' . $this->ManagerName->last_name;
        $item->save();

        $this->countofregularisations--;
      
       
      
       
        $this->sendRejectionMail($id);
        FlashMessageHelper::flashSuccess('Regularisation Request rejected successfully');
   
    }
    public function sendRejectionMail($id)
    {
        $item = RegularisationDates::find($id); // Ensure you have the correct ID to fetch data
 
        $regularisationEntriesforRejection = json_decode($item->regularisation_entries, true); // Decode the JSON entries
   
    $employee = EmployeeDetails::where('emp_id', $item->emp_id)->first();
    // Prepare the HTML table
    
    $this->employeeEmailForRejection=$employee->email;
    $details = [
     
        'regularisationRequests'=>$regularisationEntriesforRejection,
        'sender_id'=>$employee->emp_id,
        'sender_remarks'=>$item->employee_remarks,
        'receiver_remarks'=>$item->approver_remarks,
       
    ];
 
 
    // Send email to manager
      Mail::to($this->employeeEmailForRejection)->send(new RegularisationRejectionMail($details));
    }
    public function reject($date)
    {
        // dd('reject'.$date);
        $remark = $this->remarks[$date] ?? null;

        // Log the remark for debugging purposes
        Log::info('Remark:', ['remark' => $remark]);

        // Find the entry with the matching date and update its status
        foreach ($this->regularisationEntries as &$entry) {
            if ($entry['date'] === $date) {
                $entry['status'] = 'rejected';
                $entry['remark'] = $remark; // Optionally add the remark to the entry
                FlashMessageHelper::flashSuccess('Regularization Request Rejected Successfully');
                break;
            }
        }

        // Save the updated regularisationEntries back to the database
        $this->regularisationrequest->regularisation_entries = json_encode($this->regularisationEntries);
        $this->regularisationrequest->save();
    }
   
    public function submitRegularisation()
    {
        Log::info('Welcome to submitRegularisation method');
        if ($this->regularisationrequest) {
            Log::info('Regularisation request found, updating status.');
    
            // Update the status field
            $this->regularisationrequest->status = 13;
            $this->regularisationrequest->regularisation_date =  Carbon::now();
            // Save the changes to the database
            $this->regularisationrequest->save();
            Log::info('Regularisation status updated and saved.', ['status' => $this->regularisationrequest->status]);
    
            foreach ($this->regularisationEntries as $entry) {
                Log::info('Processing regularisation entry.', $entry);
                
                // Checking if entry status is approved
                if ($entry['status'] === 'approved') {
                    Log::info('Entry status is approved, creating swipe records.', [
                        'in_time' => $entry['from'],
                        'out_time' => $entry['to'],
                        'date' => $entry['date']
                    ]);
    
                    // Create IN SwipeRecord
                    $swiperecord = new SwipeRecord();
                    $swiperecord->emp_id= $this->regularisationrequest->employee->emp_id;
                    $swiperecord->in_or_out = 'IN';
                    $swiperecord->swipe_time = $entry['from'];
                    $swiperecord->created_at = $entry['date'];
                    $swiperecord->is_regularized = 1;
                    $swiperecord->save();
                    Log::info('IN swipe record saved.', [
                        'emp_id'=>$this->regularisationrequest->employee->emp_id,
                        'swipe_time' => $entry['from'],
                        'created_at' => $entry['date']
                    ]);
    
                    // Create OUT SwipeRecord
                    $swiperecord1 = new SwipeRecord();
                    $swiperecord1->emp_id= $this->regularisationrequest->employee->emp_id;
                    $swiperecord1->in_or_out = 'OUT';
                    $swiperecord1->swipe_time = $entry['to'];
                    $swiperecord1->created_at = $entry['date'];
                    $swiperecord1->is_regularized = 1;
                    $swiperecord1->save();
                    Log::info('OUT swipe record saved.', [
                        'emp_id'=>$this->regularisationrequest->employee->emp_id,
                        'swipe_time' => $entry['to'],
                        'created_at' => $entry['date']
                    ]);
                }
            }
            $this->sendmailForRegularisation($this->regularisationrequest);
            
            // Optionally, add a confirmation message
            FlashMessageHelper::flashSuccess('Regularisation status submitted successfully.');
            Log::info('Regularisation submission complete. Redirecting to review page.');
    
            return redirect()->route('review');
        } else {
            Log::error('Regularisation request not found.');
            FlashMessageHelper::flashError('Regularisation request not found.');
        }
    }
    public function sendmailForRegularisation($r1)
    {
       
        $employee = EmployeeDetails::where('emp_id', $this->regularisationrequest->emp_id)->first();
        $this->employeeEmailForApproval=$employee->email;
        $employee_remarks=$r1->employee_remarks;
        $regularisationEntriesforCombined = json_decode($r1->regularisation_entries, true);

        $details = [
            'employee_remarks'=>$employee_remarks,
            'regularisationRequests'=>$regularisationEntriesforCombined,
            'sender_id'=>$employee->emp_id,
          
           
           
        ];
        Mail::to($this->employeeEmailForApproval)->send(new RegularisationCombinedMail($details));
    }
    public function render()
    {
        $today = Carbon::today();
        return view('livewire.review-pending-regularisation',['regularisationdesc'=>$this->regularisationdescription,'today'=>$today]);
    }
}
