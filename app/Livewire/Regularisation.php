<?php
// Created by : Pranita Priyadarshi
// About this component: It shows allowing employees to adjust or provide reasons for discrepancies in their recorded work hours
namespace App\Livewire;

use App\Helpers\FlashMessageHelper;
use App\Mail\RegularisationApplyingMail;
use App\Models\EmployeeDetails;
use App\Models\HolidayCalendar;
use App\Models\LeaveRequest;
use App\Models\RegularisationDates;

use App\Models\Regularisations;
use App\Models\SwipeRecord;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class Regularisation extends Component
{
    public $c=false;
    
    public $isApply=1;

    public $isPending=0;
    public $isHistory=0;

    public $date;
    
    public $callcontainer=0;
    public $data;

    public $pendingRegularisations;



    public $historyRegularisations;

    public $regularisationEntriesArray;
    public $selectdate;
    public $data1;
    public $data7;
    public $data8;
    public $shift_start_time = '10:00'; 

    public $shift_end_time = '19:00'; 
    public $manager3;
    public $selectedDates = [];
    public $employee;

    public $regularisationdescription;
    public $calendar=[];
    public $data4;
    public $from;
    public $to;
    public $reason;

    public $remarks;

    public $withdraw_session=false;

    public $showMessage = false;
    public $isdatesApplied=false;
    public $count_for_regularisation=0;

    public $updatedregularisationEntries;
    public $regularisationEntries=[];
    public $manager1;
   
    public $withdrawModal=false;
    public $storedArray;

    public $storedArray1;
    public $numberOfItems;

    public $headreportingmanager;

    public $headreportingmanagerfullName;
    public $year;

    public $ispreviousMonth=false;
    public $month;
    public $currentMonth;

    public $reportingmanagerinloop;
    public $openAccordionForPending = null;

    public $openAccordionForHistory = null;
    public $reportingmanager;
    public $showApplyingToContainer = false;

    public $istogglehigherManagers=false;
    public $heademployees;
    public $chevronButton=false;
    
    public $reportingmanagerfullName;
    public $isdeletedArray=0;
    public $currentYear;
    public $data10;
    public $currentDate;
    public $defaultApply=1;
    public $currentDateTime;

    public $intervalInMinutes = 5; 
    public $shift_times = []; 
    public $count=0;

    public $showAlert=false;
    public $holidays;

    public $monthinFormat;

    public $employeeEmail;
    public $todayMonth;

    public $employeeId;
    public $todayYear;

    public $todayDay;
    public function mount()
    {
        try {
         
            $this->year = now()->year;
            $this->month = now()->month;
            $this->todayYear=now()->year;
            $this->todayMonth=now()->month;
            $this->todayDay = now()->day;
            $this->employeeId = auth()->guard('emp')->user()->emp_id;
            $this->employeeEmail=EmployeeDetails::where('emp_id',$this->employeeId)->first();
            $this->getDaysInMonth($this->year, $this->month);
            $this->monthinFormat = now()->format('F');
            $this->holidays = HolidayCalendar::where('month', $this->monthinFormat)
            ->where('year',  $this->year )
            ->get();
           
            // $this->updateCurrentMonthYear();
            $this->currentDate = now();
            $this->generateCalendar();
            if (session()->has('success')) {
                $this->showMessage = true;
            }
        } catch (\Exception $e) {
            Log::error('Error in mount method: ' . $e->getMessage());
            // Handle the error as needed, such as displaying a message to the user
        }
    }

    public function hideMessage()
    {
        $this->showMessage = false;
    }
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName, [
            'shift_times.*.from' => 'required|date_format:H:i',
            'shift_times.*.to' => 'required|date_format:H:i|after:shift_times.*.from',
            'shift_times.*.reason' => 'required',
        ], [
            'shift_times.*.from.required' => 'Please enter the sign-in time',
            'shift_times.*.from.date_format' => 'Please enter sign-in time in HH:MM format',
            'shift_times.*.to.required' => 'Please enter the sign-out time',
            'shift_times.*.to.date_format' => 'Please enter sign-out time in HH:MM format',
            'shift_times.*.to.after' => 'Sign-out time must be later than sign-in time',
            'shift_times.*.reason.required' => 'Please enter the reason',
        ]);
    }
    public function togglePendingAccordion($id)
    {
        
        if ($this->openAccordionForPending === $id) {
            $this->openAccordionForPending = null; // Close if already open
        } else {
            $this->openAccordionForPending = $id; // Set to open
        }
      
    }
    public function togglehigherManagers($EmpId)
    {
        $this->istogglehigherManagers=!$this->istogglehigherManagers;
        $this->reportingmanager=$EmpId;
        
    }
    public function toggleHistoryAccordion($id)
    {
        
        if ($this->openAccordionForHistory === $id) {
            $this->openAccordionForHistory = null; // Close if already open
        } else {
            $this->openAccordionForHistory = $id; // Set to open
        }
    }
    public function applyingTo()
    {
        $this->chevronButton = !$this->chevronButton;
        $this->showApplyingToContainer = !$this->showApplyingToContainer;
            
    }
    private function isEmployeeLeaveOnDate($date, $employeeId)
    {
        try {
            $employeeId = auth()->guard('emp')->user()->emp_id;


            return LeaveRequest::where('emp_id', $employeeId)
                ->where('leave_applications.leave_status', 2)
                ->where(function ($query) use ($date) {
                    $query->whereDate('from_date', '<=', $date)
                        ->whereDate('to_date', '>=', $date);
                })
                ->join('status_types', 'status_types.status_code', '=', 'leave_applications.leave_status') // Join with status_types table
                ->exists();

        } catch (\Exception $e) {
            Log::error('Error in isEmployeeLeaveOnDate method: ' . $e->getMessage());
            FlashMessageHelper::flashError('An error occurred while checking employee leave. Please try again later.');
      
            return false; // Return false to handle the error gracefully
        }
    }
    public function hideAlert()
    {
        $this->showAlert = false;
    }
    public function submitShifts($date)
    {
        $this->isdatesApplied=false;
        $selectedDate = Carbon::parse($date);
        $selecteddateyear = $selectedDate->year;
        $selecteddatemonth = $selectedDate->month;
        $selecteddateday=$selectedDate->day;
        if($selecteddatemonth==(Carbon::today()->month)&&$selecteddateyear==(Carbon::today()->year)&&$this->todayDay>25&&$selecteddateday<25)
        {
            $sessionKey = 'attendance_lock_flash_time';
            $currentTimestamp = now();
    
            // Check if the flash message has been shown recently (e.g., within 5 seconds)
            if (!session()->has($sessionKey) || $currentTimestamp->diffInSeconds(session($sessionKey)) >= 5) {
                sleep(1);
                FlashMessageHelper::flashError('Attendance Period is locked');
                $this->showAlert = true;
    
                // Update the session with the current timestamp
                session([$sessionKey => $currentTimestamp]);
            }
    
            // Stop further execution
            return;
    
          
        }
        if((Carbon::today()->month)-$selecteddatemonth==1&&$selecteddateyear==(Carbon::today()->year)&&$selecteddateday<25)
        {
           
            $sessionKey1 = 'attendance_lock_flash_time1';
            $currentTimestamp1 = now();
    
            // Check if the flash message has been shown recently (e.g., within 5 seconds)
            if (!session()->has($sessionKey1) || $currentTimestamp1->diffInSeconds(session($sessionKey1)) >= 5) {
                sleep(1);
                FlashMessageHelper::flashError('Attendance Period is locked');
                $this->showAlert = true;
    
                // Update the session with the current timestamp
                session([$sessionKey1 => $currentTimestamp1]);
            }
    
            // Stop further execution
            return;
        }
        if($selecteddateyear<=(Carbon::today()->year)&&(Carbon::today()->month)-$selecteddatemonth>1&&$selecteddateday<=(Carbon::today()->year))
        {
              // Throw a validation error or set a message for the user
           
              $sessionKey3 = 'attendance_lock1_flash_time';
            $currentTimestamp3 = now();
    
            // Check if the flash message has been shown recently (e.g., within 5 seconds)
            if (!session()->has($sessionKey3) || $currentTimestamp3->diffInSeconds(session($sessionKey3)) >= 5) {
                sleep(1);
                FlashMessageHelper::flashError('Attendance Period is locked');
                $this->showAlert = true;
    
                // Update the session with the current timestamp
                session([$sessionKey3 => $currentTimestamp3]);
            }
    
            // Stop further execution
            return;
        }
        if ($selectedDate->greaterThan(Carbon::today())) {
            // Throw a validation error or set a message for the user
            
            $sessionKey4 = 'future_date_flash_time';
            $currentTimestamp4 = now();
    
            // Check if the flash message has been shown recently (e.g., within 5 seconds)
            if (!session()->has($sessionKey4) || $currentTimestamp4->diffInSeconds(session($sessionKey4)) >= 5) {
                sleep(1);
                FlashMessageHelper::flashError('Future Dates are not applicable for regularisation.');
                $this->showAlert = true;
    
                // Update the session with the current timestamp
                session([$sessionKey4 => $currentTimestamp4]);
            }
    
            // Stop further execution
            return;
        }
        if ($selectedDate->EqualTo(Carbon::today())) {
            $sessionKey5 = 'today_date_flash_time';
            $currentTimestamp5 = now();
    
            // Check if the flash message has been shown recently (e.g., within 5 seconds)
            if (!session()->has($sessionKey5) || $currentTimestamp5->diffInSeconds(session($sessionKey5)) >= 5) {
                sleep(1);
                FlashMessageHelper::flashError('Today date is not applicable for Regularisation.');
                $this->showAlert = true;
    
                // Update the session with the current timestamp
                session([$sessionKey5 => $currentTimestamp5]);
            }
    
            // Stop further execution
            return;
        }
        if ($selectedDate->isWeekend()) {
            // Throw a validation error for weekends
            $sessionKey6 = 'weekend_flash_time';
            $currentTimestamp6 = now();
    
            // Check if the flash message has been shown recently (e.g., within 5 seconds)
            if (!session()->has($sessionKey6) || $currentTimestamp6->diffInSeconds(session($sessionKey6)) >= 5) {
                sleep(1);
                FlashMessageHelper::flashError('This is a weekend.Regularisation is not allowed on weekends.');
                $this->showAlert = true;
    
                // Update the session with the current timestamp
                session([$sessionKey6 => $currentTimestamp6]);
            }
    
            // Stop further execution
            return;
        }
        $holiday = HolidayCalendar::where('date', $selectedDate->toDateString())->first();
        if ($holiday) {

            $sessionKey7 = 'holiday_flash_time';
            $currentTimestamp7 = now();
    
            // Check if the flash message has been shown recently (e.g., within 5 seconds)
            if (!session()->has($sessionKey7) || $currentTimestamp7->diffInSeconds(session($sessionKey7)) >= 5) {
                sleep(1);
                FlashMessageHelper::flashError('This is Holiday.Regularisation is not allowed on holidays.');
                $this->showAlert = true;
    
                // Update the session with the current timestamp
                session([$sessionKey7 => $currentTimestamp7]);
            }
    
            // Stop further execution
            return;
        }
        if ($this->isEmployeeLeaveOnDate($selectedDate, auth()->guard('emp')->user()->emp_id)) {
            $sessionKey8 = 'Employee_Leave_On_Date';
            $currentTimestamp8 = now();
    
            // Check if the flash message has been shown recently (e.g., within 5 seconds)
            if (!session()->has($sessionKey8) || $currentTimestamp8->diffInSeconds(session($sessionKey8)) >= 5) {
                sleep(1);
                FlashMessageHelper::flashError('You are on leave on this Date.');
                $this->showAlert = true;
    
                // Update the session with the current timestamp
                session([$sessionKey8 => $currentTimestamp8]);
            }
    
            // Stop further execution
            return;
        }
        if ($this->isEmployeeRegularisedOnDate($selectedDate) ){

            $sessionKey9 = 'Employee_Regularised_On_Date';
            $currentTimestamp9 = now();
    
            // Check if the flash message has been shown recently (e.g., within 5 seconds)
            if (!session()->has($sessionKey9) || $currentTimestamp9->diffInSeconds(session($sessionKey9)) >= 5) {
                sleep(1);
                FlashMessageHelper::flashError('Your Regularisation is Already Approved For this date.');
                $this->showAlert = true;
    
                // Update the session with the current timestamp
                session([$sessionKey9 => $currentTimestamp9]);
            }
    
            // Stop further execution
            return;
        }
        if($this->isEmployeeAppRegOnDate($selectedDate))
        { 
            
        
            $sessionKey10 = 'employee_regularised_on_date';
            $currentTimestamp10 = now();
    
            // Check if the flash message has been shown recently (e.g., within 5 seconds)
            if (!session()->has($sessionKey10) || $currentTimestamp10->diffInSeconds(session($sessionKey10)) >= 5) {
                sleep(1);
                FlashMessageHelper::flashError('You have already applied regularisation for  this date.Its status is pending from manager side.');
                $this->showAlert = true;
    
                // Update the session with the current timestamp
                session([$sessionKey10 => $currentTimestamp10]);
            }
    
            // Stop further execution
            return;

        }
 
        if (!in_array($date, $this->selectedDates)) {
            // Add the date to the selectedDates array only if it's not already selected
            $this->selectedDates[] = $date;
           
            $this->shift_times[]=[
                'date' => $date,
                'from'=>'',
                'to'=>'',
                'reason'=>'',
            ];
        }
        foreach ($this->shift_times as $date => $times) {
            if (preg_match('/^\d{2}:\d{2}$/', $times['from'])) {
                [$hours, $minutes] = explode(':', $times['from']);
                // Process hours and minutes as needed
            } else {
                // Handle invalid input format for start time
            }

            if (preg_match('/^\d{2}:\d{2}$/', $times['to'])) {
                [$hours, $minutes] = explode(':', $times['to']);
                // Process hours and minutes as needed
            } else {
                // Handle invalid input format for end time
            }
        }

        
    }
    private function isEmployeeRegularisedOnDate($date)
    {
        try {
            $employeeId = auth()->guard('emp')->user()->emp_id;
            return SwipeRecord::where('emp_id', $employeeId)->whereDate('created_at', $date)->where('is_regularized', 1)->exists();
        } catch (\Exception $e) {
            Log::error('Error in isEmployeePresentOnDate method: ' . $e->getMessage());
            FlashMessageHelper::flashError('An error occurred while checking employee presence. Please try again later.');
            return false; // Return false to handle the error gracefully
        }
    }
    private function isEmployeeAppRegOnDate($date)
    {
        $employeeId = auth()->guard('emp')->user()->emp_id;
    
        // Log the employee ID and the date we're checking
        Log::info("Checking regularisation entries for employee ID: $employeeId on date: {$date->toDateString()}");
    
        // Fetch the regularisation record for the employee
        $regularisationRecord = RegularisationDates::where('emp_id', $employeeId)
            ->where('status', 5)
            ->where('status', 5)
            ->where('is_withdraw', 0)
            ->get(['regularisation_entries']);  // Get only the JSON field
    
        // Log the query result count
        Log::info("Number of regularisation records fetched: " . $regularisationRecord->count());
    
        // Iterate over the records and check the JSON field
        foreach ($regularisationRecord as $record) {
            // Decode the JSON only once
            $entries = json_decode($record->regularisation_entries, true);
            
            if (is_array($entries)) {
                foreach ($entries as $entry) {
                    // Check if 'date' exists in entry and matches the given date
                    if (isset($entry['date']) && $entry['date'] === $date->toDateString()) {
                        Log::info("Date found in regularisation entries: " . $entry['date']);
                        return true; // Date exists in one of the regularisation entries
                    }
                }
            }
        }
    
        // Log when the date is not found
        Log::info('Date not found in any regularisation entries.');
    
        return false; // Date not found in any regularisation entries
    }
    //This function is used to create calendar
    public function generateCalendar()
    {
        try {
            $firstDay = Carbon::create($this->year, $this->month, 1);
            $daysInMonth = $firstDay->daysInMonth;
            $today = now();
            $calendar = [];
            $dayCount = 1;
            $firstDayOfWeek = $firstDay->dayOfWeek;
            $lastDayOfPreviousMonth = $firstDay->copy()->subDay();
    
            for ($i = 0; $i < ceil(($firstDayOfWeek + $daysInMonth) / 7); $i++) {
                $week = [];
                for ($j = 0; $j < 7; $j++) {
                    if ($i === 0 && $j < $firstDay->dayOfWeek) {
                        $previousMonthDays = $lastDayOfPreviousMonth->copy()->subDays($firstDay->dayOfWeek - $j - 1);
                        $week[] = [
                            'day' => $previousMonthDays->day,
                            'date' => $previousMonthDays->toDateString(),
                            'isToday' => false,
                            'isRegularised' => false,
                            'isCurrentDate' => false,
                            'isCurrentMonth' => false,
                            'isNextMonth'=>false,
                            'isPreviousMonth' => true,
                            'isAfterToday' => $previousMonthDays->isAfter($today),
                        ];
                    } elseif ($dayCount <= $daysInMonth) {
                        $date = Carbon::create($this->year, $this->month, $dayCount);
                        $isToday = $date->isSameDay($today);
                        $isregularised = $this->isEmployeeRegularisedOnDate($date);
                        $week[] = [
                            'day' => $dayCount,
                            'date' => $date->toDateString(),
                            'isToday' => $isToday,
                            'isCurrentDate' => $isToday,
                            'isCurrentMonth' => true,
                            'isPreviousMonth' => false,
                             'isNextMonth'=>false,
                            'isRegularised' => $isregularised,
                            'isAfterToday' => $date->isAfter($today),
                        ];
                        $dayCount++;
                    } else {
                        $nextMonth = $this->month % 12 + 1;
                        $nextYear = $this->year + ($this->month == 12 ? 1 : 0);
                        $nextMonthDays = Carbon::create($nextYear, $nextMonth, $dayCount - $daysInMonth);
                        $week[] = [
                            'day' => $nextMonthDays->day,
                            'date' => $nextMonthDays->toDateString(),
                            'isToday' => false,
                            'isCurrentDate' => false,
                            'isCurrentMonth' => false,
                            'isNextMonth' => true,
                            'isRegularised' => false,
                            'isAfterToday' => $nextMonthDays->isAfter($today),
                        ];
                        $dayCount++;
                    }
                }
                $calendar[] = $week;
            }
            $this->calendar = $calendar;
        } catch (\Exception $e) {
            Log::error('Error in generateCalendar method: ' . $e->getMessage());
            // Handle the error as needed, such as displaying a message to the user
        }
    }
    
    
    //This function will navigate to the previous month in the calendar
    public function previousMonth()
    {
            try {
            
                $this->date = Carbon::create($this->year, $this->month, 1)->subMonth();
            
                $this->year = $this->date->year;
                
                $this->month = $this->date->month;
                if($this->year==Carbon::now()->year&&Carbon::now()->month-$this->month==1)
                {
                    $this->isdatesApplied=true;
                }
                $daysInMonth1 = $this->getDaysInMonth($this->year, $this->month);
                $this->generateCalendar();
                $this->selectedDates=[];
            } catch (\Exception $e) {
                Log::error('Error in previousMonth method: ' . $e->getMessage());
                // Handle the error as needed, such as displaying a message to the user
            }
    }


//This function will navigate to the next month in the calendar
public function nextMonth()
{
    try {
        
      $this->date = Carbon::create($this->year, $this->month, 1)->addMonth();
        
        $this->year = $this->date->year;
        $this->month = $this->date->month;
        $daysInMonth2 = $this->getDaysInMonth($this->year, $this->month);
        $this->generateCalendar();
        $this->selectedDates=[];
    } catch (\Exception $e) {
        Log::error('Error in nextMonth method: ' . $e->getMessage());
        // Handle the error as needed, such as displaying a message to the user
    }
}
 
    //This function will calculate the no of days in a month
    public function getDaysInMonth($year, $month)
    {
        try {
            $date = Carbon::create($year, $month, 1);
            $daysInMonth = $date->daysInMonth;
    
            return collect(range(1, $daysInMonth))->map(function ($day) use ($date) {
                return [
                    'day' => $day,
                    'date' => $date->copy()->addDays($day - 1),
                    'isCurrentDate' => $day === now()->day && $date->isCurrentMonth(),
                ];
            }); 
        } catch (\Exception $e) {
            Log::error('Error in getDaysInMonth method: ' . $e->getMessage());
            // Handle the error as needed, such as returning a default value or displaying a message to the user
            return collect(); // Return an empty collection as a default value
        }
    }
    
   
    
    //This function is used to select the particular date in the calendar and these dates will be stored in the array
    public function selectDate($date)
    {
        try {
            $currentDate = date('Y-m-d');
            if (strtotime($date) < strtotime($currentDate)) {
                if (!in_array($date, $this->selectedDates)) {
                    // Add the date to the selectedDates array only if it's not already selected
                    $this->selectedDates[] = $date;
                    $this->regularisationEntries[] = [
                        'date' => $date,
                        'from' => '',
                        'to' => '',
                        'reason' => '',
                    ];
                }
            }
            $this->storedArray = array($this->selectedDates);
        } catch (\Exception $e) {
            // Log the error or handle it as needed
            Log::error('Error in selectDate method: ' . $e->getMessage());
            // You might want to inform the user about the error or take other appropriate actions
        }
    }
    
    
    //This function will remove the date from the array if we dont want to regularise the attendance on the particular date
    public function deleteStoredArray($index)
    {
        try {
            if (isset($this->selectedDates[$index])) {
                unset($this->selectedDates[$index]);
                $this->selectedDates = array_values($this->selectedDates); // Reindex the array
            }
        
            // Remove the shift time corresponding to the selected date from shift_times array
            if (isset($this->shift_times[$index])) {
                unset($this->shift_times[$index]);
                $this->shift_times = array_values($this->shift_times); // Reindex the array
            }
            // unset($this->shift_times[$index]);
            $this->isdeletedArray += 1;
            $this->updatedregularisationEntries = array_values($this->shift_times);
        } catch (\Exception $e) {
            // Log the error or handle it as needed
            Log::error('Error in deleteStoredArray method: ' . $e->getMessage());
            // You might want to inform the user about the error or take other appropriate actions
        }
    }
    //This function will store regularisation details in the database
    public function storearraydates()
{
    try {
       
        $validatedData = $this->validate([
            'shift_times.*.from' => 'required|date_format:H:i',
            'shift_times.*.to' => 'required|date_format:H:i|after:shift_times.*.from',
            'shift_times.*.reason' => 'required',
        ], [
            'shift_times.*.from.required' => 'Please enter the sign-in time',
            'shift_times.*.from.date_format' => 'Please enter sign-in time in HH:MM format',
            'shift_times.*.to.required' => 'Please enter the sign-out time',
            'shift_times.*.to.date_format' => 'Please enter sign-out time in HH:MM format',
            'shift_times.*.to.after' => 'Sign-out time must be later than sign-in time',
            'shift_times.*.reason.required' => 'Please enter the reason',
        ]);
        $this->isdatesApplied = true;

        $employeeDetails = EmployeeDetails::where('emp_id', auth()->guard('emp')->user()->emp_id)->first();
        $emp_id = $employeeDetails->emp_id;
        $regularisationEntriesJson = json_encode($this->shift_times);
        if ($this->isdeletedArray > 0) {
            $regularisationEntriesArray = $this->updatedregularisationEntries;
        } else {
            $regularisationEntriesArray = json_decode($regularisationEntriesJson, true);
        }
    
        // Count the number of items
        $this->numberOfItems = count($regularisationEntriesArray);

        RegularisationDates::create([
            'emp_id' => $emp_id,
            'employee_remarks' => $this->remarks,
            'regularisation_entries' => $regularisationEntriesJson,
            'is_withdraw' => 0,
            'status'=>5,
            'regularisation_date' => null,
        ]);
        FlashMessageHelper::flashSuccess('Hurry Up! Regularisation Created  successfully');
        sleep(1);
        $details = [
           
            'regularisationRequests'=>$regularisationEntriesArray,
            'employee_id'=>$this->employeeId,
           
        ];
        Mail::to($this->employeeEmail)->send(new RegularisationApplyingMail($details));

 
        $this->remarks='';
        $regularisationEntriesJson = [];
        $this->regularisationEntries = [];
        $this->shift_times=[];
    } catch (\Exception $e) {
        // Log the error or handle it as needed
        Log::error('Error in storearraydates method: ' . $e->getMessage());
        
        // You might want to inform the user about the error or take other appropriate actions
        FlashMessageHelper::flashError('Please enter the fields before submitting for regularisation.');
        
    }
}

//This function will show the page where we can apply for regularisation    
public function applyButton()
{
    try {
        $this->isApply = 1;
        $this->isPending = 0;
        $this->isHistory = 0;
        $this->defaultApply = 1;
    } catch (\Exception $e) {
        // Handle any exceptions that might occur
        // For example, log the error or show a message to the user
        Log::error('Error occurred while applying: ' . $e->getMessage());
        FlashMessageHelper::flashError('An error occurred while applying.');
        
    }
}
//This function will show the page where we can see the pending regularisation details
public function pendingButton()
{
    try {
        $this->isApply = 0;
        $this->isPending = 1;
        $this->isHistory = 0;
        $this->defaultApply = 0;
    } catch (\Exception $e) {
        // Handle any exceptions that might occur
        Log::error('Error occurred while changing to pending state: ' . $e->getMessage());
        FlashMessageHelper::flashError('An error occurred while changing to pending state.');
       
    }
}
//This function will show the page where we can see the approved,rejected and withdrawn regularisation details
public function historyButton()
{
    try {
        $this->isApply = 0;
        $this->isPending = 0;
        $this->isHistory = 1;
        $this->defaultApply = 0;
    } catch (\Exception $e) {
        // Handle any exceptions that might occur
        Log::error('Error occurred while changing to history state: ' . $e->getMessage());
        FlashMessageHelper::flashError('An error occurred while changing to history state.');
        
    }
}


    public function storePost()
    {
        $employeeDetails = EmployeeDetails::where('emp_id', auth()->guard('emp')->user()->emp_id)->first();
        $emp_id = $employeeDetails->emp_id;
        
        try {
            RegularisationDates::create([
                'emp_id' => $emp_id,
                'from' => $this->from,
                'to' => $this->to,
                'reason' => $this->reason,
                'is_withdraw' => 0,
                'regularisation_date' => $this->selectedDate,
            ]);
            FlashMessageHelper::flashSuccess('Hurry Up! Action completed successfully');
           
        } catch (\Exception $ex) {
            FlashMessageHelper::flashError('Something goes wrong!!');
            
        }
    }
 //This function will withdraw the regularisation page 
    public function withdraw($id)
    {
        try {
          
            $currentDateTime = Carbon::now();
            $this->data = RegularisationDates::where('id', $id)->update([
                'is_withdraw' => 1,
                'withdraw_date' => $currentDateTime,
                'status'=> 4,
            ]);
            $this->withdraw_session = true;
            $this->withdrawModal=false;
            FlashMessageHelper::flashSuccess('Hurry Up! Regularisation withdrawn  successfully');
           

        } catch (\Exception $ex) {
            FlashMessageHelper::flashError('Something went wrong while withdrawing regularisation.');
          
        }
    }
    //This function will update the count of regularisation
    public function updateCount()
    {
        try {
            $this->c = true;
        } catch (\Exception $e) {
            Log::error('Error occurred while updating count: ' . $e->getMessage());
            FlashMessageHelper::flashError('An error occurred while updating count.');
        }
    }

    public function openWithdrawModal()
    {
        $this->withdrawModal=true;
    }
    public function closewithdrawModal()
    {
        $this->withdrawModal=false;
    }
       
    public function render()
    {
        try {
            $loggedInEmpId = Auth::guard('emp')->user()->emp_id;
            $s4 = EmployeeDetails::where('emp_id', auth()->guard('emp')->user()->emp_id)->pluck('manager_id')->first();
            $employeeDetails = EmployeeDetails::select('manager_id')
                ->where('emp_id', $loggedInEmpId)
                ->first();  
            
            $empid = $employeeDetails->manager_id ?? null;
            if($this->istogglehigherManagers==true)
            {
                $this->reportingmanager = $this->reportingmanager;

            }
            else
            {
                $this->reportingmanager = EmployeeDetails::where('emp_id', $loggedInEmpId)->value('manager_id');
            }
            $this->headreportingmanager = EmployeeDetails::where('emp_id', $loggedInEmpId)->value('dept_head');
            $this->reportingmanagerinloop=EmployeeDetails::where('emp_id', $loggedInEmpId)->value('manager_id');
            $this->reportingmanagerfullName=EmployeeDetails::where('emp_id',$this->reportingmanager)->first();
            $this->heademployees = EmployeeDetails::whereIn('emp_id', [ $this->reportingmanagerinloop,$this->headreportingmanager])->get();

            $employeeDetails1 = $empid ? EmployeeDetails::where('emp_id', $empid)->first() : null;
           
            $isManager = EmployeeDetails::where('manager_id', $loggedInEmpId)->exists();
            $subordinateEmployeeIds = EmployeeDetails::where('manager_id', $loggedInEmpId)
                ->pluck('first_name', 'last_name')
                ->toArray();
            $pendingRegularisations = RegularisationDates::where('regularisation_dates.emp_id', $loggedInEmpId)
                ->where('regularisation_dates.status', 5)
                ->where('regularisation_dates.is_withdraw', 0)
                ->join('status_types', 'regularisation_dates.status', '=', 'status_types.status_code')
                ->select('regularisation_dates.*', 'status_types.status_name') // Select fields from both tables
                ->orderByDesc('regularisation_dates.updated_at')
                ->get();
            
            $this->pendingRegularisations = $pendingRegularisations->filter(function ($regularisation) {
                return $regularisation->regularisation_entries !== "[]";
            });

            $historyRegularisations = RegularisationDates::where('regularisation_dates.emp_id', $loggedInEmpId)
                ->whereIn('regularisation_dates.status', [2, 4, 3]) // Use numeric status codes
                ->join('status_types', 'regularisation_dates.status', '=', 'status_types.status_code') // Join with status_types
                ->select('regularisation_dates.*', 'status_types.status_name') // Select all from regularisation_dates and status_name from status_types
                ->orderByDesc('regularisation_dates.updated_at')
                ->get();        
          
            $this->historyRegularisations = $historyRegularisations->filter(function ($regularisation) {
                return $regularisation->regularisation_entries !== "[]";
            });
          
            $manager = EmployeeDetails::select('manager_id')->distinct()->get();   
            $this->data10 = RegularisationDates::where('status', 5)->get();
            $this->manager1 = EmployeeDetails::where('emp_id', $loggedInEmpId)->first();
            $this->data = RegularisationDates::where('is_withdraw', '0')->count();
            $this->data8 = RegularisationDates::where('is_withdraw', '0')->get();
            $this->data1 = RegularisationDates::where('status', 5)->first();
            $this->data4 = RegularisationDates::where('is_withdraw', '1')->count();
            $this->data7 = RegularisationDates::all();
            $employee = EmployeeDetails::where('emp_id', $loggedInEmpId)->first();
            
            if ($employee) {
                $this->manager3 = EmployeeDetails::find($employee->manager_id);
            }
    
            return view('livewire.regularisation', [
                'CallContainer' => $this->callcontainer,
                'manager_report' => $s4,
                'isManager1' => $isManager,
                'daysInMonth' => $this->getDaysInMonth($this->year, $this->month),
                'subordinate' => $subordinateEmployeeIds,
                'show' => $this->c,
                'manager11' => $manager,
                'count' => $this->c,
                'count1' => $this->data,
                'data2' => $this->data1,
                'data5' => $this->data4,
                'data81' => $this->data7,
                'withdraw' => $this->data8,
                'data11' => $this->data10,

                'EmployeeDetails' => $employeeDetails1
            ]);
        } catch (\Exception $e) {
            // Handle the exception, log the error, and return a user-friendly response
            error_log('Error in render method: ' . $e->getMessage());
            
            // Optionally, you can set default values or return an error view
            $this->pendingRegularisations = [];
            $this->historyRegularisations = [];
            $this->data10 = [];
            $this->manager1 = null;
            $this->data = 0;
            $this->data8 = [];
            $this->data1 = null;
            $this->data4 = 0;
            $this->data7 = [];
            $this->manager3 = null;
            $employeeDetails1 = null;
    
            // Return a view with default or error data
            return view('livewire.regularisation', [
                'CallContainer' => $this->callcontainer,
                'manager_report' => $s4 ?? null,
                'isManager1' => $isManager ?? false,
                'daysInMonth' => $this->getDaysInMonth($this->year, $this->month),
                'subordinate' => $subordinateEmployeeIds ?? [],
                'show' => $this->c ?? false,
                'manager11' => $manager ?? [],
                'count' => $this->c ?? 0,
                'count1' => $this->data ?? 0,
                'manager2' => $this->manager3 ?? null,
                'data2' => $this->data1 ?? null,
                'data5' => $this->data4 ?? 0,
                'data81' => $this->data7 ?? [],
                'withdraw' => $this->data8 ?? [],
                'data11' => $this->data10 ?? [],
                'manager2' => $this->manager1 ?? null,
                'EmployeeDetails' => $employeeDetails1 ?? null
            ]);
        }      
    }
}
