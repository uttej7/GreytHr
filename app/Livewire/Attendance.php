<?php
/*Created by:Pranita Priyadarshi*/
/*This submodule will be showing users swipe time and also ur attendance status*/
// File Name                       : Attendance.php
// Description                     : This file contains the implementation of a EmployeesAttendance by this we can know attendance of particular employees in a month.
// Creator                         : Pranita Priyadarshi
// Email                           : priyadarshipranita72@gmail.com
// Organization                    : PayG.
// Date                            : 2023-03-07
// Framework                       : Laravel (10.10 Version)
// Programming Language            : PHP (8.1 Version)
// Database                        : MySQL
// Models                          : LeaveRequest,EmployeeDetails,HolidayCalendar,SwipeRecord
namespace App\Livewire;

use App\Helpers\FlashMessageHelper;
use App\Models\EmployeeDetails;
use App\Models\SwipeRecord;
use App\Models\HolidayCalendar;
use App\Models\LeaveRequest;
use App\Models\RegularisationDates;
use Livewire\Component;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Torann\GeoIP\Facades\GeoIP;

class Attendance extends Component
{
    public $currentDate2;
    public $hours;

    public $country;

    public $city;

    public $postal_code;
    public $totalWorkingPercentage;
    public $minutesFormatted;

    public $avgWorkHoursFromJuly = 0;

    public $last_out_time;

    public $excessHrs;
    public $percentageDifference;
    public $currentDate;
    public $date1;

    public $avgSignInTime;


    public $averageWorkHours;

    public $totalnumberofEarlyOut = 0;
    public $percentageOfWorkHrs;
    public $percentageOfWorkHours;

    public $averageWorkHoursForModalTitle = 0;
    public $CurrentDate;
    public $avgSignOutTime;

    public $first_in_time_for_date;

    public $last_out_time_for_date;
    public $swipe_records_count;
    public $clickedDate;
    public $currentWeekday;

    public $timeDifferences;

    public $totalWorkingDays;
    public $calendar;
    public $selectedDate;
    public $shortFallHrs;
    public $work_hrs_in_shift_time;
    public $swipe_record;
    public $holiday;
    public $leaveApplies;
    public $first_in_time;
    public $year;
    public $currentDate2record;
    public $month;
    public $actualHours = [];
    public $firstSwipeTime;
    public $secondSwipeTime;
    public $swiperecords;
    public $currentDate1;

    public $currentDate2recordin;

    public $currentDate2recordout;

    public $showCalendar = true;
    public $date2;
    public $modalTitle = '';

    public $countofAbsent;
    public $view_student_swipe_time;
    public $view_student_in_or_out;
    public $swipeRecordId;

    public $swiperecordsfortoggleButton;
    public $swiperecord;
    public $from_date;
    public $to_date;
    public $status;
    public $dynamicDate;
    public $view_student_emp_id;
    public $view_employee_swipe_time;
    public $currentDate2recordexists;


    public $defaultfaCalendar = 1;
    public $dateclicked;
    public $view_table_in;

    public $count;
    public $view_table_out;
    public $employeeDetails;
    public $changeDate = 0;
    public $student;
    public $selectedRecordId = null;

    public $toggleButton = false;
    public $regularised_by;

    public $regularised_date;

    public $regularised_reason;

    public $regularised_date_to_check;

    public $avgWorkingHrsForModalTitle;
    public $legend = true;
    public $isNextMonth = 0;
    public $record;

    public $dateToCheck;

    public $Swiperecords;
    public $employeeId;



    public $employeeIdForRegularisation;

    public $totalDurationFormatted;

    public $avgDurationFormatted;
    public $öpenattendanceperiod = false;

    public $averageFormattedTime = '00:00';
    public $totalDurationFormatted1;
    public $errorMessage;
    public $showRegularisationDialog = false;
    public $distinctDates;
    public $isPresent;
    public $table;
    public $previousMonth;
    public $session1 = 0;
    public $session2 = 0;
    public $session1ArrowDirection = 'right';
    public $session2ArrowDirection = 'right';

    public $averageHoursWorked;

    public $totalcount = 0;

    public $averageMinutesWorked;
    public $avgSwipeInTime = null;
    public $avgSwipeOutTime = null;
    public $totalmodalDays;

    public $avgWorkHoursPreviousMonth;
    public $averageworkhours;

    public $totalLateInSwipes = 0;
    public $totalnumberofLeaves = 0;

    public $timeDifferenceInMinutesForCalendar = 0;
    public $start_date_for_insights;
    public $averageWorkHrsForCurrentMonth = null;
    public $averageFormattedTimeForCurrentMonth;
    public $holidayCountForInsightsPeriod;
    public $weekendDays = 0;
    public $daysWithRecords = 0;

    public $previousMonthTotalMinutes;

    public $currentMonthTotalMinutes;
    public $avergageFirstInTime = 0;

    public $averageLastOutTime = 0;
    public $totalnumberofAbsents = 0;
    public $percentageinworkhrsforattendance;
    public $leaveTaken = 0;
    public $totalHoursWorked = 0;

    public $totalMinutesWorked = 0;
    public $avgWorkHours = 0;
    public $avgLateIn = 0;
    public $avgEarlyOut = 0;

    public $k, $k1;
    public $showMessage = false;

    public $employee;
    //This function will help us to toggle the arrow present in session fields


    public function closeRegularisationModal()
    {
        try {
            // Attempt to perform the action
            $this->showRegularisationDialog = false;
        } catch (\Exception $e) {
            // Handle the exception
            // You can log the error, show a user-friendly message, or handle it as needed
            // For example, you might log the exception message:
            error_log('Error closing regularisation modal: ' . $e->getMessage());

            // Optionally, you can display a user-friendly message or perform other actions
            // $this->showErrorMessage('An error occurred while closing the modal.');
        }
    }
    public function calculateDifferenceInAvgWorkHours($date)
    {
        // Get the current month and previous month dates
        $currentMonthStart = \Carbon\Carbon::parse($date . '-01')->startOfMonth()->toDateString();
        $currentMonthEnd = \Carbon\Carbon::parse($date)->endOfMonth()->toDateString(); // Today's date
        $previousMonthDate = \Carbon\Carbon::parse($date)->subMonth()->format('Y-m');

        // Log the initial dates
        Log::info('Initial dates:', [
            'date' => $date,
            'currentMonthStart' => $currentMonthStart,
            'currentMonthEnd' => $currentMonthEnd,
            'previousMonthDate' => $previousMonthDate
        ]);

        if (
            \Carbon\Carbon::parse($currentMonthEnd)->greaterThan(\Carbon\Carbon::today()) &&
            \Carbon\Carbon::parse($currentMonthEnd)->isSameMonth(\Carbon\Carbon::today()) &&
            \Carbon\Carbon::parse($currentMonthEnd)->isSameYear(\Carbon\Carbon::today())
        ) {
            $currentMonthEnd = \Carbon\Carbon::today()->toDateString(); // Set to today's date if greater
            Log::info('Current month end adjusted to today:', ['currentMonthEnd' => $currentMonthEnd]);
        } elseif (\Carbon\Carbon::parse($currentMonthEnd)->greaterThan(\Carbon\Carbon::today())) {
            Log::warning('Current month end is greater than today. Returning \'-\'');
            return '-';
        }

        $previousMonthStart = \Carbon\Carbon::parse($previousMonthDate . '-01')->startOfMonth()->toDateString();
        $previousMonthEnd = \Carbon\Carbon::parse($previousMonthDate)->endOfMonth()->toDateString(); // End of previous month

        // Log previous month dates
        Log::info('Previous month dates:', [
            'previousMonthStart' => $previousMonthStart,
            'previousMonthEnd' => $previousMonthEnd
        ]);

        if (
            \Carbon\Carbon::parse($previousMonthEnd)->greaterThan(\Carbon\Carbon::today()) &&
            \Carbon\Carbon::parse($previousMonthEnd)->isSameMonth(\Carbon\Carbon::today()) &&
            \Carbon\Carbon::parse($previousMonthEnd)->isSameYear(\Carbon\Carbon::today())
        ) {
            $previousMonthEnd = \Carbon\Carbon::today()->toDateString(); // Set to today's date if greater
            Log::info('Previous month end adjusted to today:', ['previousMonthEnd' => $previousMonthEnd]);
        } elseif (\Carbon\Carbon::parse($previousMonthEnd)->greaterThan(\Carbon\Carbon::today())) {
            Log::warning('Previous month end is greater than today. Returning \'-\'');
            return '-';
        }

        // Log before calculation
        Log::info('Calling calculateAverageWorkHoursAndPercentage for current and previous months', [
            'currentMonthStart' => $currentMonthStart,
            'currentMonthEnd' => $currentMonthEnd,
            'previousMonthStart' => $previousMonthStart,
            'previousMonthEnd' => $previousMonthEnd
        ]);

        // Calculate average work hours for current and previous months
        $avgWorkHoursCurrentMonth = $this->calculateAverageWorkHoursAndPercentage($currentMonthStart, $currentMonthEnd);
        $avgWorkHoursPreviousMonth = $this->calculateAverageWorkHoursAndPercentage($previousMonthStart, $previousMonthEnd);

        // Log average work hours
        Log::info('Average work hours:', [
            'avgWorkHoursCurrentMonth' => $avgWorkHoursCurrentMonth,
            'avgWorkHoursPreviousMonth' => $avgWorkHoursPreviousMonth
        ]);

        // Convert the average work hours (HH:MM) to total minutes for comparison
        list($currentMonthHours, $currentMonthMinutes) = explode(':', $avgWorkHoursCurrentMonth);
        list($previousMonthHours, $previousMonthMinutes) = explode(':', $avgWorkHoursPreviousMonth);

        $this->currentMonthTotalMinutes = ($currentMonthHours * 60) + $currentMonthMinutes;
        $this->previousMonthTotalMinutes = ($previousMonthHours * 60) + $previousMonthMinutes;

        // Log total minutes
        Log::info('Total minutes:', [
            'currentMonthTotalMinutes' => $this->currentMonthTotalMinutes,
            'previousMonthTotalMinutes' => $this->previousMonthTotalMinutes
        ]);


        // Calculate the difference in minutes
        $differenceInMinutes = $this->currentMonthTotalMinutes - $this->previousMonthTotalMinutes;

        Log::info('Difference in minutes:', ['differenceInMinutes' => $differenceInMinutes]);

        if ($this->previousMonthTotalMinutes != 0) {
            $this->percentageDifference = ($differenceInMinutes / $this->previousMonthTotalMinutes) * 100;
        } else {
            $this->percentageDifference = 0;
        }

        // Convert the difference back to hours and minutes
        $hoursDifference = intdiv($differenceInMinutes, 60);
        $minutesDifference = $differenceInMinutes % 60;

        Log::info('Final difference:', [
            'hoursDifference' => $hoursDifference,
            'minutesDifference' => $minutesDifference,
            'percentageDifference' => $this->percentageDifference
        ]);

    return $this->percentageDifference;
}


public function calculateAverageWorkHoursAndPercentage($startDate, $endDate)
{
    Log::info("Welcome to calculateAverageWorkHoursAndPercentage for: $startDate and $endDate");
    $employeeId = auth()->guard('emp')->user()->emp_id;
    Log::info("Starting calculation for Employee ID: $employeeId");

    // Retrieve swipe records within the given date range
    
    
        $records = SwipeRecord::where('emp_id', $employeeId)
        ->whereDate('created_at', '>=', $startDate)
        ->whereDate('created_at', '<=', $endDate)
        ->orderBy('created_at', 'asc') // Ensure records are ordered by date and time
        ->get();

// Group by date and fetch the first IN and last OUT for each date
        $dailyRecords = $records->groupBy(function ($record) {
        return Carbon::parse($record->created_at)->toDateString();
        })->map(function ($groupedRecords) {
        $firstIn = $groupedRecords->firstWhere('in_or_out', 'IN');
        $lastOut = $groupedRecords->where('in_or_out', 'OUT')->sortByDesc('created_at')->first();

        return collect(['first_in' => $firstIn, 'last_out' => $lastOut])->filter(); // Remove nulls
        });
        // dd($dailyRecords);
    Log::info("Swipe records retrieved: " . json_encode($records));

    // Group swipes by date
    // $dailySwipes = $records->groupBy(function ($swipe) {
    //     return Carbon::parse($swipe->created_at)->toDateString();
    // });
    // Log::info("Swipe records grouped by date: " . json_encode($dailySwipes->keys()));

    // Get leave requests for the employee within the date range
    $leaveRequests = LeaveRequest::where('emp_id', $employeeId)
        ->where('leave_applications.leave_status', 2)
        ->where(function ($query) use ($startDate, $endDate) {
            $query->whereDate('from_date', '<=', $endDate)
                  ->whereDate('to_date', '>=', $startDate);
        })
        ->join('status_types', 'status_types.status_code', '=', 'leave_applications.leave_status')
        ->select('leave_applications.*', 'status_types.status_name')
        ->get();
    Log::info("Leave requests retrieved: " . $leaveRequests->count());

    $totalMinutes = 0;
    $workingDaysCount = 0;

    // Determine if the current month is involved
    $today = Carbon::now();
    $isCurrentMonth = Carbon::parse($startDate)->isSameMonth($today) && Carbon::parse($endDate)->isSameMonth($today);
    Log::info("Is Current Month: " . ($isCurrentMonth ? 'Yes' : 'No'));

    // Calculate the total working days in the date range
    $currentDate = Carbon::parse($startDate);
    $endDate = Carbon::parse($endDate);

    while ($currentDate <= $endDate) {
        Log::info("Processing date: " . $currentDate->toDateString());

        if ($isCurrentMonth && $currentDate->isSameDay($today)) {
            Log::info("Skipping current date as it's today.");
            $currentDate->addDay();
            continue;
        }

        $isWeekend = $currentDate->isWeekend();
        $isHoliday = HolidayCalendar::where('date', $currentDate->toDateString())->exists();
        $isOnLeave = $leaveRequests->contains(function ($leaveRequest) use ($currentDate) {
            return $currentDate->between($leaveRequest->from_date, $leaveRequest->to_date);
        });

        Log::info("Date: " . $currentDate->toDateString() . ", Weekend: " . ($isWeekend ? 'Yes' : 'No') . 
                  ", Holiday: " . ($isHoliday ? 'Yes' : 'No') . ", On Leave: " . ($isOnLeave ? 'Yes' : 'No'));

        if (!$isWeekend && !$isHoliday && !$isOnLeave) {
            $workingDaysCount++;
        }

        $currentDate->addDay();
    }
    Log::info("Total Working Days Count: $workingDaysCount");

    foreach ($dailyRecords as $date => $swipesForDay) {
        Log::info("Processing swipe data for date: $date");
        $inTime = null;
        $dayMinutes = 0;
        $carbonDate = Carbon::parse($date);

        $isWeekend = $carbonDate->isWeekend();
        $isHoliday = HolidayCalendar::where('date', $carbonDate->toDateString())->exists();
        $isOnLeave = $leaveRequests->contains(function ($leaveRequest) use ($carbonDate) {
            return $carbonDate->between($leaveRequest->from_date, $leaveRequest->to_date);
        });

        Log::info("Date: $date, Weekend: " . ($isWeekend ? 'Yes' : 'No') . 
                  ", Holiday: " . ($isHoliday ? 'Yes' : 'No') . ", On Leave: " . ($isOnLeave ? 'Yes' : 'No'));
        Log::info($swipesForDay);
        if (!$isWeekend && !$isHoliday && !$isOnLeave) {
            foreach ($swipesForDay as $swipe) {
                Log::info("Processing swipe record: " . json_encode($swipe));
                if ($swipe->in_or_out === 'IN') {
                    $inTime = Carbon::parse($swipe->swipe_time);
                    Log::info("IN Time: " . $inTime);
                }

                if ($swipe->in_or_out === 'OUT' && $inTime) {
                    $outTime = Carbon::parse($swipe->swipe_time);
                    $dayMinutes += $inTime->diffInMinutes($outTime);
                    Log::info("OUT Time: " . $outTime . ", Minutes Worked: " . $inTime->diffInMinutes($outTime));
                    $inTime = null;
                }
            }

            if ($inTime && $dayMinutes === 0) {
                Log::info("Unmatched IN Time without OUT: " . $inTime);
                $dayMinutes = 0;
            }

            $totalMinutes += $dayMinutes;
        }
        Log::info("Date: $date, Day Minutes: $dayMinutes, Total Minutes So Far: $totalMinutes");
    }

    if ($workingDaysCount > 0) {
        $averageMinutes = $totalMinutes / $workingDaysCount;
    } else {
        $averageMinutes = 0;
    }

    $hours = intdiv($averageMinutes, 60);
    $minutes = $averageMinutes % 60;

    $averageWorkHours = sprintf('%02d:%02d', $hours, $minutes);

    Log::info("Average Work Hours: $averageWorkHours");

    return $averageWorkHours;
}



    public function toggleSession1Fields()
    {
        try {
            $this->session1 = !$this->session1;
            $this->session1ArrowDirection = ($this->session1) ? 'left' : 'right';
        } catch (\Exception $e) {
            // Log the exception
            Log::error('Error in toggleSession1Fields method: ' . $e->getMessage());

            // Optionally, you can set some default values or handle the error in a user-friendly way
            $this->session1 = false;
            $this->session1ArrowDirection = 'right';

            // You can also set a session message or an error message to inform the user
            FlashMessageHelper::flashError('An error occurred while toggling session fields. Please try again later.');
        }
    }
    //This function will help us to toggle the arrow present in session fields
    public function toggleSession2Fields()
    {
        try {
            $this->session2 = !$this->session2;
            $this->session2ArrowDirection = ($this->session2) ? 'left' : 'right';
            // dd($this->session1);
        } catch (\Exception $e) {
            // Log the exception
            Log::error('Error in toggleSession2Fields method: ' . $e->getMessage());

            // Optionally, you can set some default values or handle the error in a user-friendly way
            $this->session2 = false;
            $this->session2ArrowDirection = 'right';

            // You can also set a session message or an error message to inform the user
            FlashMessageHelper::flashError('An error occurred while toggling session fields. Please try again later.');
        }
    }
    public  $averageWorkingHours, $percentageOfHoursWorked, $yearA, $monthA;

    public function calculateMetrics()
    {
        $employeeId = auth()->guard('emp')->user()->emp_id;

        // Get the current date

        // Specify the current month and year
        $swipes = SwipeRecord::where('emp_id', $employeeId)
            ->whereYear('created_at', $this->yearA)
            ->whereMonth('created_at', $this->monthA)
            ->orderBy('swipe_time')
            ->get();


        // Initialize arrays to store in and out swipes
        $inSwipes = [];
        $outSwipes = [];

        // Process swipe records
        foreach ($swipes as $swipe) {
            $date = Carbon::parse($swipe->swipe_time)->toDateString();
            if ($swipe->in_or_out === 'IN') {
                if (!isset($inSwipes[$date])) {
                    $inSwipes[$date] = [];
                }
                $inSwipes[$date][] = $swipe;
            } elseif ($swipe->in_or_out === 'OUT') {
                if (!isset($outSwipes[$date])) {
                    $outSwipes[$date] = [];
                }
                $outSwipes[$date][] = $swipe;
            }
        }

        // Calculate total hours worked in the month
        $totalHoursWorked = 0;
        foreach ($inSwipes as $date => $inSwipeArray) {
            if (isset($outSwipes[$date])) {
                foreach ($inSwipeArray as $index => $inSwipe) {
                    if (isset($outSwipes[$date][$index])) {
                        $inTime = Carbon::parse($inSwipe->swipe_time);
                        $outTime = Carbon::parse($outSwipes[$date][$index]->swipe_time);
                        $totalHoursWorked += $outTime->diffInHours($inTime);
                    }
                }
            }
        }

        // Calculate the number of working days in the current month
        $startDate = Carbon::create($this->yearA, $this->monthA, 1);
        $endDate = $startDate->copy()->endOfMonth();
        $workingDaysCount = 0;

        while ($startDate->lte($endDate)) {
            if ($startDate->isWeekday()) {
                $workingDaysCount++;
            }
            $startDate->addDay();
        }

        // Define the standard daily hours
        $standardDailyHours = 9;

        // Calculate the standard monthly hours
        $standardMonthlyHours = $standardDailyHours * $workingDaysCount;

        // Calculate the average working hours for the month
        $this->averageWorkingHours = $workingDaysCount > 0 ? $totalHoursWorked / $workingDaysCount : 0;

        // Calculate the percentage of hours worked relative to the standard monthly hours
        $this->percentageOfHoursWorked = $standardMonthlyHours > 0 ? ($totalHoursWorked / $standardMonthlyHours) * 100 : 0;
    }

    public function mount()
    {

        // Output results

        try {

            $this->employee = EmployeeDetails::where('emp_id', auth()->guard('emp')->user()->emp_id)->select('emp_id', 'first_name', 'last_name', 'shift_type')->first();
            $this->from_date = Carbon::now()->subMonth()->startOfMonth()->toDateString();
            $this->start_date_for_insights = Carbon::now()->startOfMonth()->format('Y-m-d');
            $this->to_date = Carbon::now()->toDateString();
            $this->updateModalTitle();
            $this->calculateAvgWorkingHrs($this->from_date, $this->to_date, $this->employee->emp_id);
            $fromDate = Carbon::createFromFormat('Y-m-d', $this->from_date);
            $toDate = Carbon::createFromFormat('Y-m-d', $this->to_date);
            $currentDate = Carbon::parse($this->from_date);
            $endDate = Carbon::parse($this->to_date);
            $totalHoursWorked = 0;
            $totalMinutesWorked = 0;
            $ip = request()->ip();
            $location = GeoIP::getLocation($ip);
            $lat = $location['lat'];
            $lon = $location['lon'];
            $this->country = $location['country'];
            $this->city = $location['city'];
            $this->postal_code = $location['postal_code'];
            $firstDateOfPreviousMonth = Carbon::now()->subMonth()->startOfMonth();

            // Get the current date of the current month
            $currentDateOfCurrentMonth = Carbon::now()->endOfDay();

            $this->year = now()->year;
            $this->month = now()->month;
            $this->generateCalendar();
            $startOfMonth = '2024-08-01';
            $endOfMonth = '2024-08-31';

            while ($currentDate->lte($endDate)) {
                $dateString = $currentDate->toDateString();

                // Get "IN" and "OUT" times for the current date
                $inTimes = SwipeRecord::where('emp_id', auth()->guard('emp')->user()->emp_id)
                    ->where('in_or_out', 'IN')
                    ->whereDate('created_at', $dateString)
                    ->pluck('swipe_time');

                $outTimes = SwipeRecord::where('emp_id', auth()->guard('emp')->user()->emp_id)
                    ->where('in_or_out', 'OUT')
                    ->whereDate('created_at', $dateString)
                    ->pluck('swipe_time');

                $totalDifferenceForDay = 0;
                // Calculate total time differences for the current date
                foreach ($inTimes as $index => $inTime) {
                    if (isset($outTimes[$index])) {
                        $inCarbon = Carbon::parse($inTime);
                        $outCarbon = Carbon::parse($outTimes[$index]);
                        $difference = $outCarbon->diffInSeconds($inCarbon);
                        $totalDifferenceForDay += $difference;
                        $timeDifferences[$dateString][] = $difference;
                        // Store differences for each date
                    }
                }
                $currentDate->addDay(); // Move to the next day
            }

            // Optionally, calculate average time difference per day




            // $this->calculateTotalDays();
            $this->previousMonth = Carbon::now()->subMonth()->format('F');

            $swipeRecords = SwipeRecord::where('emp_id', auth()->guard('emp')->user()->emp_id)->get();

            // Group the swipe records by the date part only
            $groupedDates = $swipeRecords->groupBy(function ($record) {
                return Carbon::parse($record->created_at)->format('Y-m-d');
            });

            $this->distinctDates = $groupedDates->mapWithKeys(function ($records, $key) {
                $inRecord = $records->where('in_or_out', 'IN')->first();
                $outRecord = $records->where('in_or_out', 'OUT')->last();

                return [
                    $key => [
                        'in' => "IN",
                        'first_in_time' => optional($inRecord)->swipe_time,
                        'last_out_time' => optional($outRecord)->swipe_time,
                        'out' => "OUT",
                    ]
                ];
            });


            // Get the current date and store it in the $currentDate property
            $this->currentDate = date('d');
            $this->currentWeekday = date('D');
            $this->currentDate1 = date('d M Y');
            $this->swiperecords = SwipeRecord::all();
            $startOfMonth = Carbon::now()->startOfMonth();
            $today = Carbon::now();
            $this->percentageinworkhrsforattendance = $this->calculateDifferenceInAvgWorkHours(\Carbon\Carbon::now()->format('Y-m'));

            $this->averageWorkHrsForCurrentMonth = $this->calculateAverageWorkHoursAndPercentage($startOfMonth->toDateString(), $today->toDateString());

            // $this->averageworkhours=$averageWorkHrsForCurrentMonth['average_work_hours'];

            // $this->percentageOfWorkHrs=$averageWorkHrsForCurrentMonth['work_percentage'];

        } catch (\Exception $e) {
            // Log the exception
            Log::error('Error in mount method: ' . $e->getMessage());
            // Handle the error in a user-friendly way, e.g., setting default values
            $this->from_date = now()->startOfMonth()->toDateString();
            $this->to_date = now()->toDateString();
            $this->distinctDates = collect();
            $this->currentDate = date('d');
            $this->currentWeekday = date('D');
            $this->currentDate1 = date('d M Y');
            $this->swiperecords = collect();
            $this->year = now()->year;
            $this->month = now()->month;

            // Optionally, you can set a session message or an error message to inform the user
            FlashMessageHelper::flashError('An error occurred while initializing the component. Please try again later.');
        }
    }


    public function showTable()
    {
        try {
            // Your code that might throw an exception
            $this->defaultfaCalendar = 0;
        } catch (\Exception $e) {
            // Handle the exception
            // You can log the error or set an error message
            Log::error('Error in showTable method: ' . $e->getMessage());
            // Optionally, you can set a user-friendly message to be displayed
            $errorMessage = 'An error occurred while updating the calendar. Please try again later.';
        }
    }

    public function showBars()
    {
        try {
            $this->defaultfaCalendar = 1;
            $this->showMessage = false;
        } catch (\Exception $e) {
            Log::error('Error in showBars method: ' . $e->getMessage());
            FlashMessageHelper::flashError('An error occurred while showing the bars. Please try again later.');
        }
    }
    //This function will help us to calculate the number of public holidays in a particular month
    protected function getPublicHolidaysForMonth($year, $month)
    {
        try {
            return HolidayCalendar::whereYear('date', $year)
                ->whereMonth('date', $month)
                ->get();
        } catch (\Exception $e) {
            Log::error('Error in getPublicHolidaysForMonth method: ' . $e->getMessage());
            FlashMessageHelper::flashError('An error occurred while fetching public holidays. Please try again later.');
            return collect(); // Return an empty collection to handle the error gracefully
        }
    }

    public function showlargebox($k)
    {
        try {
            $this->k1 = $k;
            $this->dispatchBrowserEvent('refreshModal', ['k1' => $this->k1]);
        } catch (\Exception $e) {
            Log::error('Error in showlargebox method: ' . $e->getMessage());
            FlashMessageHelper::flashError('An error occurred while showing the large box. Please try again later.');
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
    //This function will help us to check if the employee is present on this particular date or not
    private function isEmployeePresentOnDate($date)
    {
        try {
            $employeeId = auth()->guard('emp')->user()->emp_id;



            return SwipeRecord::where('emp_id', $employeeId)->whereDate('created_at', $date)->exists();
        } catch (\Exception $e) {
            Log::error('Error in isEmployeePresentOnDate method: ' . $e->getMessage());
            FlashMessageHelper::flashError('An error occurred while checking employee presence. Please try again later.');
            return false; // Return false to handle the error gracefully
        }
    }
    private function isHolidayOnDate($date)
    {
        $checkHoliday = HolidayCalendar::where('date', $date)->exists();
        return $checkHoliday;
    }
    //This function will help us to check if the employee is on leave for this particular date or not
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
                ->join('status_types', 'status_types.status_code', '=', 'leave_applications.leave_status') // Join with status_types
                ->exists();
        } catch (\Exception $e) {
            Log::error('Error in isEmployeeLeaveOnDate method: ' . $e->getMessage());
            FlashMessageHelper::flashError('An error occurred while checking employee leave. Please try again later.');
            return false; // Return false to handle the error gracefully
        }
    }
    private function caluclateNumberofLeaves($startDate, $endDate, $employeeId)
    {
        $countofleaves = 0;
        $currentDate = $startDate->copy();
        $flag = false;

        while ($currentDate->lt($endDate)) {
            $flag = LeaveRequest::where('emp_id', $employeeId)
                ->where('leave_applications.leave_status', 2)
                ->where(function ($query) use ($currentDate) {
                    $query->whereDate('from_date', '<=', $currentDate)
                        ->whereDate('to_date', '>=', $currentDate);
                })
                ->join('status_types', 'status_types.status_code', '=', 'leave_applications.leave_status') // Join with status_types table
                ->exists();
            if ($flag == true) {
                $countofleaves++;
            }
            $currentDate->addDay();
            $flag = false;
        }

        return $countofleaves;
    }
    //This function will help us to check the leave type of employee
    private function getLeaveType($date, $employeeId)
    {
        try {
            return LeaveRequest::where('emp_id', $employeeId)
                ->whereDate('from_date', '<=', $date)
                ->whereDate('to_date', '>=', $date)
                ->value('leave_type');
        } catch (\Exception $e) {
            Log::error('Error in getLeaveType method: ' . $e->getMessage());
            FlashMessageHelper::flashError('An error occurred while fetching leave type. Please try again later.');
            return null; // Return null to handle the error gracefully
        }
    }
    private function isDateRegularized($date, $employeeId)
    {
        $records = RegularisationDates::where('emp_id', $employeeId)->get();

        foreach ($records as $record) {
            $regularisationEntries = json_decode($record->regularisation_entries, true);
            foreach ($regularisationEntries as $entry) {
                if ($entry['date'] === $date) {
                    return true;
                }
            }
        }

        return false;
    }

    //This function will help us to create the calendar
    public function generateCalendar()
    {
        try {
            $employeeId = auth()->guard('emp')->user()->emp_id;
            Log::info('Employee ID:', ['employeeId' => $employeeId]);

            $firstDay = Carbon::create($this->year, $this->month, 1);
            $daysInMonth = $firstDay->daysInMonth;
            $today = now();

            Log::info('First Day of Month:', ['firstDay' => $firstDay->toDateString()]);
            Log::info('Days in Month:', ['daysInMonth' => $daysInMonth]);
            Log::info('Today:', ['today' => $today->toDateString()]);

            $calendar = [];
            $dayCount = 1;

            // Fetch public holidays for the current month
            $publicHolidays = $this->getPublicHolidaysForMonth($this->year, $this->month);
            Log::info('Public Holidays for Current Month:', ['publicHolidays' => $publicHolidays]);

            $firstDayOfWeek = $firstDay->dayOfWeek;
            Log::info('First Day of Week:', ['firstDayOfWeek' => $firstDayOfWeek]);

            $startOfPreviousMonth = $firstDay->copy()->subMonth();
            $publicHolidaysPreviousMonth = $this->getPublicHolidaysForMonth(
                $startOfPreviousMonth->year,
                $startOfPreviousMonth->month
            );
            $lastDayOfPreviousMonth = $firstDay->copy()->subDay();

            Log::info('Start of Previous Month:', ['startOfPreviousMonth' => $startOfPreviousMonth->toDateString()]);
            Log::info('Public Holidays for Previous Month:', ['publicHolidaysPreviousMonth' => $publicHolidaysPreviousMonth]);

            for ($i = 0; $i < ceil(($firstDayOfWeek + $daysInMonth) / 7); $i++) {
                $week = [];

                for ($j = 0; $j < 7; $j++) {
                    if ($i === 0 && $j < $firstDay->dayOfWeek) {
                        $previousMonthDays = $lastDayOfPreviousMonth->copy()->subDays($firstDay->dayOfWeek - $j - 1);
                        Log::info('Previous Month Day:', ['previousMonthDays' => $previousMonthDays->toDateString()]);

                        $week[] = [
                            'day' => $previousMonthDays->day,
                            'isToday' => false,
                            'isPublicHoliday' => in_array($previousMonthDays->toDateString(), $publicHolidaysPreviousMonth->pluck('date')->toArray()),
                            'isCurrentMonth' => false,
                            'isPreviousMonth' => true,
                            'isRegularised' => false,
                            'backgroundColor' => '',
                            'status' => '',
                            'onleave' => ''
                        ];
                    } elseif ($dayCount <= $daysInMonth) {
                        $date = Carbon::create($this->year, $this->month, $dayCount);
                        Log::info('Processing Date:', ['date' => $date->toDateString()]);

                        $isAbsentFor = false;
                        $isHalfDayPresent = false;

                        $isToday = $dayCount === $today->day && $this->month === $today->month && $this->year === $today->year;
                        $isPublicHoliday = in_array($date->toDateString(), $publicHolidays->pluck('date')->toArray());
                        Log::info('Is Public Holiday:', ['isPublicHoliday' => $isPublicHoliday]);
                        $isHoliday = HolidayCalendar::where('date', $date->toDateString())->exists();
                        $isRegularised = $this->isEmployeeRegularisedOnDate($date->toDateString());
                        Log::info('Is Regularised:', ['isRegularised' => $isRegularised]);

                        $isOnLeave = $this->isEmployeeLeaveOnDate($date->toDateString(), $employeeId);
                        Log::info('Is On Leave:', ['isOnLeave' => $isOnLeave]);

                        $leaveType = $this->getLeaveType($date->toDateString(), $employeeId);
                        Log::info('Leave Type:', ['leaveType' => $leaveType]);

                        $backgroundColor = $isPublicHoliday ? 'background-color: IRIS;' : '';
                        if (!$isOnLeave && !$isHoliday && !$date->isWeekend()) {
                            $isPresentOnDate = $this->isEmployeePresentOnDate($date);

                            if ($isPresentOnDate) {
                                Log::info('Employee Present On Date: ' . $date->toDateString());

                                // Fetch both IN and OUT records together to minimize queries
                                // Default to IN if no OUT time
                                $swipeRecords = SwipeRecord::where('emp_id', $employeeId)
                                    ->whereDate('created_at', $date->toDateString())
                                    ->whereIn('in_or_out', ['IN', 'OUT'])
                                    ->get();

                                $inSwipeTime = $swipeRecords->firstWhere('in_or_out', 'IN');
                                $outSwipeTime = $swipeRecords->firstWhere('in_or_out', 'OUT') ?? $inSwipeTime;

                                if ($inSwipeTime) {
                                    Log::info('Swipe In Time for Date: ' . $date->toDateString() . ' is ' . $inSwipeTime->swipe_time);
                                } else {
                                    Log::warning('No Swipe In Time for Date: ' . $date->toDateString());
                                }

                                if ($outSwipeTime) {
                                    Log::info('Swipe Out Time for Date: ' . $date->toDateString() . ' is ' . $outSwipeTime->swipe_time);
                                } else {
                                    Log::warning('No Swipe Out Time for Date: ' . $date->toDateString());
                                }
                                if ($inSwipeTime && $outSwipeTime) {
                                    $inTime = Carbon::parse($inSwipeTime->swipe_time);
                                    $outTime = Carbon::parse($outSwipeTime->swipe_time);

                                    $timeDifference = $inTime->diffInMinutes($outTime); // Calculate difference in minutes
                                    $hours = floor($timeDifference / 60);
                                    $minutes = $timeDifference % 60;
                                    if ($timeDifference < 240) {
                                        $isAbsentFor = true;
                                    } elseif ($timeDifference >= 240 && $timeDifference < 480) {
                                        // Between 4 hours and 8 hours, mark as half-day present
                                        $isHalfDayPresent = true;
                                    }

                                    Log::info('Time difference for Date: ' . $date->toDateString() . ' is ' . sprintf('%02d', $hours) . ':' . sprintf('%02d', $minutes));
                                }
                            } else {
                                $inSwipeTime = null;
                                $outSwipeTime = null;
                                $timeDifference = null; // Calculate difference in minutes

                            }
                        }
                        if ($isOnLeave) {
                            switch ($leaveType) {
                                case 'Casual Leave Probation':
                                    $status = 'CLP';
                                    break;
                                case 'Sick Leave':
                                    $status = 'SL';
                                    break;
                                case 'Loss Of Pay':
                                    $status = 'LOP';
                                    break;
                                case 'Casual Leave':
                                    $status = 'CL';
                                    break;
                                case 'Marriage Leave':
                                    $status = 'ML';
                                    break;
                                case 'Paternity Leave':
                                    $status = 'PL';
                                    break;
                                case 'Maternity Leave':
                                    $status = 'MTL';
                                    break;
                                default:
                                    $status = 'L';
                                    break;
                            }
                        } else {
                            $isAbsent = !$this->isEmployeePresentOnDate($date->toDateString()) || $isAbsentFor;
                            if ($isAbsent) {
                                $status = 'A';
                            } elseif ($isHalfDayPresent) {
                                $status = 'HP';
                            } else {
                                $status = 'P';
                            }
                        }


                        $week[] = [
                            'day' => $dayCount,
                            'isToday' => $isToday,
                            'isPublicHoliday' => $isPublicHoliday,
                            'isCurrentMonth' => true,
                            'isRegularised' => $isRegularised,
                            'isPreviousMonth' => false,
                            'backgroundColor' => $backgroundColor,
                            'onleave' => $isOnLeave,
                            'status' => $status,
                        ];

                        $dayCount++;
                    } else {
                        $week[] = [
                            'day' => $dayCount - $daysInMonth,
                            'isToday' => false,
                            'isPublicHoliday' => false,
                            'isCurrentMonth' => false,
                            'isRegularised' => false,
                            'isNextMonth' => true,
                            'backgroundColor' => '',
                            'onleave' => false,
                            'status' => '',
                        ];
                        $dayCount++;
                    }
                }
                $calendar[] = $week;
            }

            Log::info('Generated Calendar:', ['calendar' => $calendar]);

            $this->calendar = $calendar;
        } catch (\Exception $e) {
            Log::error('Error in generateCalendar method: ' . $e->getMessage());
            FlashMessageHelper::flashError('An error occurred while generating the calendar. Please try again later.');

            $this->calendar = []; // Set calendar to empty array in case of error
        }
    }
    //This function will help us to check the details related to the particular date in the calendar
    public function updateDate($date1)
    {
        try {
            $parsedDate = Carbon::parse($date1);

            $this->dateToCheck = $date1;

            if ($parsedDate->format('Y-m-d') < Carbon::now()->format('Y-m-d')) {

                $this->changeDate = 1;
            }
        } catch (\Exception $e) {
            Log::error('Error in updateDate method: ' . $e->getMessage());
            FlashMessageHelper::flashError('An error occurred while updating the date. Please try again later.');
        }
    }
    //This function will help us to check whether the employee is absent 'A' or present 'P'
    public function dateClicked($date1)
    {
        try {

            $date1 = trim($date1);

            $this->selectedDate = $this->year . '-' . $this->month . '-' . str_pad($date1, 2, '0', STR_PAD_LEFT);

            $isSwipedIn = SwipeRecord::whereDate('created_at', $date1)->where('in_or_out', 'In')->exists();
            $isSwipedOut = SwipeRecord::whereDate('created_at', $date1)->where('in_or_out', 'Out')->exists();

            if (!$isSwipedIn) {
                // Employee did not swipe in
                $this->selectedDate = $date1;
                $this->status = 'A';
            } elseif (!$isSwipedOut) {
                // Employee swiped in but not out
                $this->selectedDate = $date1;
                $this->status = 'P';
            }
            $this->updateDate($date1);
            $this->dateclicked = $date1;
        } catch (\Exception $e) {
            Log::error('Error in dateClicked method: ' . $e->getMessage());
            FlashMessageHelper::flashError('An error occurred while processing the date click. Please try again later.');
        }
    }

    public function updatedFromDate($value)
    {
        try {
            // Additional logic if needed when from_date is updated
            $this->start_date_for_insights = $value;
            $this->updateModalTitle();
        } catch (\Exception $e) {
            Log::error('Error in updatedFromDate method: ' . $e->getMessage());
            FlashMessageHelper::flashError('An error occurred while updating the from date. Please try again later.');
        }
    }

    public function updatedToDate($value)
    {
        try {
            // Additional logic if needed when to_date is updated
            $this->to_date = $value;
            $this->updateModalTitle();
        } catch (\Exception $e) {
            Log::error('Error in updatedToDate method: ' . $e->getMessage());
            FlashMessageHelper::flashError('An error occurred while updating the to date. Please try again later.');
        }
    }
    public function openlegend()
    {
        $this->legend = !$this->legend;
    }
    private function calculateTotalNumberOfAbsents($startDate, $endDate)
    {
        $absentDays = 0;

        // Add a log entry for the start and end date
        Log::info('Calculating total number of absents between: ' . $startDate->format('Y-m-d') . ' and ' . $endDate->format('Y-m-d'));

    // Loop through each date between start and end date
    for ($date = $startDate->copy(); $date->lte($endDate); $date->addDay()) {
        
        // Log the current date being checked
        Log::info('Checking for absence on: ' . $date->format('Y-m-d'));
        if(!$date->isWeekend())
        {
            $holiday=HolidayCalendar::where('date',$date)->exists();
            if(!$holiday)
            {
                $isOnLeave=$this->isEmployeeLeaveOnDate($date->format('Y-m-d'),auth()->guard('emp')->user()->emp_id);
                if(!$isOnLeave)
                {
                    $isAbsent = !$this->isEmployeePresentOnDate($date->format('Y-m-d'));
                    Log::info('Is employee absent on ' . $date->format('Y-m-d') . '? ' . ($isAbsent ? 'Yes' : 'No'));
                    if ($isAbsent) {
                        $absentDays++;
                        // Log the increment of absent days
                        Log::info('Absent days count incremented to: ' . $absentDays);
                    }
                }
            }
            
        }
        // Check if the employee is absent on the current date
        

            // Log the result of the absence check



        }

        // Log the final absent days count
        Log::info('Total number of absent days: ' . $absentDays);

        return $absentDays;
    }

    private function updateModalTitle()
    {
        try {
            // Format the dates and update the modal title

            $formattedFromDate = Carbon::parse($this->start_date_for_insights)->format('Y-m-d');
            $formattedToDate = Carbon::parse($this->to_date)->format('Y-m-d');
            if ($formattedFromDate > $formattedToDate) {
                $formattedFromDateForModalTitle = Carbon::parse($this->start_date_for_insights)->format('d M');
                $formattedToDateForModalTitle = Carbon::parse($this->to_date)->format('d M');
                $this->modalTitle = "Insights for Attendance Period $formattedFromDateForModalTitle - $formattedToDateForModalTitle";
                $this->addError('date_range', 'The start date cannot be greater than the end date.');
                return; // Stop execution if validation fails
            }
            if ($formattedFromDate >=  Carbon::today()->format('Y-m-d') && $formattedToDate >=  Carbon::today()->format('Y-m-d')) {
                $formattedFromDateForModalTitle = Carbon::parse($this->start_date_for_insights)->format('d M');
                $formattedToDateForModalTitle = Carbon::parse($this->to_date)->format('d M');
                $this->modalTitle = "Insights for Attendance Period $formattedFromDateForModalTitle - $formattedToDateForModalTitle";
                // Set values to '-' and average work hours to '00:00'
                $this->totalWorkingDays = '-';
                $this->totalLateInSwipes = '-';
                $this->totalnumberofEarlyOut = '-';
                $this->totalnumberofLeaves = '-';
                $this->totalnumberofAbsents = '-';
                $this->averageWorkHoursForModalTitle = '-';
                $this->avergageFirstInTime = 'N/A';
                $this->averageLastOutTime = 'N/A';
                return; // Stop execution after setting values
            }
            if ($formattedToDate >  Carbon::today()->format('Y-m-d')) {
                $formattedFromDateForModalTitle = Carbon::parse($this->start_date_for_insights)->format('d M');
                $formattedToDateForModalTitle = Carbon::parse($this->to_date)->format('d M');
                $this->modalTitle = "Insights for Attendance Period $formattedFromDateForModalTitle - $formattedToDateForModalTitle";
                // Set values to '-' and average work hours to '00:00'
                $this->totalWorkingDays = '-';
                $this->totalLateInSwipes = '-';
                $this->totalnumberofEarlyOut = '-';
                $this->totalnumberofLeaves = '-';
                $this->totalnumberofAbsents = '-';
                $this->averageWorkHoursForModalTitle = '-';
                $this->avergageFirstInTime = 'N/A';
                $this->averageLastOutTime = 'N/A';
                return; // Stop execution after setting values
            }

            $fromDatetemp = Carbon::parse($this->start_date_for_insights);
            $toDatetemp = Carbon::parse($this->to_date);
            $formattedFromDateForModalTitle = Carbon::parse($this->start_date_for_insights)->format('d M');
            $formattedToDateForModalTitle = Carbon::parse($this->to_date)->format('d M');
            
            $this->modalTitle = "Insights for Attendance Period $formattedFromDateForModalTitle - $formattedToDateForModalTitle";

            $this->totalWorkingDays = $this->calculateTotalWorkingDays($fromDatetemp, $toDatetemp);
            $insights = $this->calculatetotalLateInSwipes(Carbon::parse($this->start_date_for_insights), Carbon::parse($this->to_date));
            $outsights = $this->calculatetotalEarlyOutSwipes(Carbon::parse($this->start_date_for_insights), Carbon::parse($this->to_date));
            $this->totalLateInSwipes = $insights['lateSwipeCount'];
            $this->totalnumberofLeaves = $this->calculateTotalNumberOfLeaves(Carbon::parse($this->start_date_for_insights), Carbon::parse($this->to_date));
            $this->totalnumberofAbsents = $this->calculateTotalNumberOfAbsents(Carbon::parse($this->start_date_for_insights), Carbon::parse($this->to_date));
            $this->totalnumberofEarlyOut = $outsights['EarlyOutCount'];
            $this->averageLastOutTime = $outsights['averageLastOutTime'];
            $this->avergageFirstInTime = $insights['averageFirstInTime'];

            // $this->totalnumberofLeaves = $this->calculateTotalNumberOfLeaves($fromDatetemp, $toDatetemp);


            $this->averageWorkHoursForModalTitle = $this->calculateAverageWorkHoursAndPercentage(Carbon::parse($this->start_date_for_insights), Carbon::parse($this->to_date));

            // $timePattern = '/^\d{2}:\d{2}:\d{2}$/';
            // if (!empty($this->averageLastOutTime) && !empty($this->avergageFirstInTime) && 
            //         preg_match($timePattern, $this->averageLastOutTime) && preg_match($timePattern, $this->avergageFirstInTime)) {

            //         $lastOutTime = Carbon::createFromFormat('H:i:s', $this->averageLastOutTime);
            //         $firstInTime = Carbon::createFromFormat('H:i:s', $this->avergageFirstInTime);

            //         // Calculate time difference if both times are valid
            //         $timeDifferenceFormatted = gmdate('H:i', $lastOutTime->diffInSeconds($firstInTime));
            //         $this->averageWorkHoursForModalTitle = $timeDifferenceFormatted;

            //     } else {
            //         // Log the issue for debugging purposes
            //         Log::warning('Invalid time format for averageLastOutTime or avergageFirstInTime.');

            //         // Set fallback value
            //         $this->averageWorkHoursForModalTitle = '00:00'; 
            //     }

            $FirstInTimes = SwipeRecord::where('emp_id', auth()->guard('emp')->user()->emp_id)
                ->where('in_or_out', 'IN')
                ->whereBetween('created_at', [$formattedFromDate, $formattedToDate])
                ->select('swipe_time')->get();

            $FirstOutTimes = SwipeRecord::where('emp_id', auth()->guard('emp')->user()->emp_id)
                ->where('in_or_out', 'OUT')
                ->whereBetween('created_at', [$formattedFromDate, $formattedToDate])
                ->select('swipe_time')->get();

            $totalDuration = CarbonInterval::seconds(0);
            $totalDuration1 = CarbonInterval::seconds(0);

            foreach ($FirstInTimes as $record) {
                $time = Carbon::parse($record->swipe_time);
                $totalDuration->addSeconds($time->secondsSinceMidnight());
            }

            foreach ($FirstOutTimes as $record) {
                $time1 = Carbon::parse($record->swipe_time);
                $totalDuration1->addSeconds($time1->secondsSinceMidnight());
            }

            $this->totalDurationFormatted = $totalDuration->cascade()->format('%H:%I:%S');
            $this->totalDurationFormatted1 = $totalDuration1->cascade()->format('%H:%I:%S');

            // Convert total duration to seconds for calculation
            $totalSeconds = $totalDuration->totalSeconds;
            $totalSeconds1 = $totalDuration1->totalSeconds;

            $FirstInTimesCount = SwipeRecord::where('emp_id', auth()->guard('emp')->user()->emp_id)
                ->where('in_or_out', 'IN')
                ->whereBetween('created_at', [$formattedFromDate, $formattedToDate])
                ->count();

            if ($FirstInTimesCount > 0) {
                $this->avgDurationFormatted = $totalSeconds / $FirstInTimesCount;
            } else {
                $this->avgDurationFormatted = 0; // Handle division by zero
            }
        } catch (\Exception $e) {
            Log::error('Error in updateModalTitle method: ' . $e->getMessage());
            FlashMessageHelper::flashError('An error occurred while updating the modal title. Please try again later.');
        }
    }

    private function calculatetotalLateInSwipes($startDate, $endDate)
    {
        // Parse start and end dates using Carbon
        $startDate = Carbon::parse($startDate);
        $endDate = Carbon::parse($endDate);
        $lateSwipeCount = 0;
        $firstInCount = 0;
        $totalFirstInSeconds = 0;


        Log::info('Start Date: ' . $startDate->toDateString() . ', End Date: ' . $endDate->toDateString());

        // Iterate through the date range
        while ($startDate->lte($endDate)) {
            $tempStartDate = $startDate->toDateString();

            // Check if the date is a holiday, weekend, or employee is on leave
            $isweekend = $startDate->isWeekend();

            $isHoliday = HolidayCalendar::whereDate('date', $tempStartDate)->exists();

            $isOnLeave = $this->isEmployeeLeaveOnDate($tempStartDate, auth()->guard('emp')->user()->emp_id);
            $isPresent = SwipeRecord::where('emp_id', auth()->guard('emp')->user()->emp_id)->where('in_or_out', 'IN')->whereDate('created_at', $tempStartDate)->first();


            // Log the status of the current day
            Log::info("Date: $tempStartDate, IsHoliday: " . ($isHoliday ? 'Yes' : 'No') .
                ", IsWeekend: " . ($isweekend ? 'Yes' : 'No') .
                ", IsOnLeave: " . ($isOnLeave ? 'Yes' : 'No') .
                ", IsPresent: " . (!empty($isPresent) ? 'Yes' : 'No'));

            // If not a holiday, weekend, or leave day, and the employee is present
            if (!$isHoliday && !$isweekend && !$isOnLeave && !empty($isPresent)) {
                // Check for late swipes
                $firstInCount++;
                try {
                    $swipeTime = Carbon::createFromFormat('H:i:s', $isPresent->swipe_time);
                    $limitTime = Carbon::createFromTime(10, 0, 0);
                } catch (\Exception $e) {
                    $swipeTime = Carbon::createFromFormat('H:i', $isPresent->swipe_time);
                    $limitTime = Carbon::createFromTime(10, 0);
                }
                $totalFirstInSeconds += $swipeTime->diffInSeconds(Carbon::createFromTime(0, 0, 0));
                if ($swipeTime->greaterThan($limitTime)) {
                    $lateSwipeExists = true;
                } else {
                    // Swipe time is 10:00 AM or later
                    $lateSwipeExists = false;
                }
                // Log the late swipe check
                Log::info("Late Swipe Exists: " . ($lateSwipeExists ? 'Yes' : 'No') . " on Date: $tempStartDate" . " on Time: $swipeTime");

                // Increment late swipe count if a late swipe is found
                if ($lateSwipeExists == true) {
                    $lateSwipeCount++;
                    Log::info("Late Swipe Count Incremented: $lateSwipeCount");
                }
                Log::info(message: "First In Count Incremented: $firstInCount");
            }

            // Move to the next day
            $startDate->addDay();
        }

        // Log the final late swipe count
        Log::info("Total Late Swipes: $lateSwipeCount");
        if ($firstInCount > 0) {
            $averageFirstInSeconds = $totalFirstInSeconds / $firstInCount;
            $averageFirstInTime = Carbon::createFromTime(0, 0, 0)->addSeconds($averageFirstInSeconds);
        } else {
            $averageFirstInTime = null;  // No valid first in records
        }

        // Log results
        Log::info("Total First In Count: $firstInCount, Late Swipe Count: $lateSwipeCount");
        Log::info("Average First In Time: " . ($averageFirstInTime ? $averageFirstInTime->format('H:i:s') : 'N/A'));

        return [
            'averageFirstInTime' => $averageFirstInTime ? $averageFirstInTime->format('H:i:s') : 'N/A',
            'lateSwipeCount' => $lateSwipeCount,

        ];
    }
    private function calculatetotalEarlyOutSwipes($startDate, $endDate)
    {
        log::info('early out method called');
        // Parse start and end dates using Carbon
        $startDate = Carbon::parse($startDate);
        $endDate = Carbon::parse($endDate);
        $earlyOutCount = 0;
        $lastOutCount = 0;
        $totalLastOutSeconds = 0;
        Log::info('Start Date: ' . $startDate->toDateString() . ', End Date: ' . $endDate->toDateString());

        // Iterate through the date range
        while ($startDate->lte($endDate)) {
            $tempStartDate = $startDate->toDateString();

            // Check if the date is a holiday, weekend, or employee is on leave
            $isHoliday = HolidayCalendar::whereDate('date', $tempStartDate)->exists();
            $isweekend = $startDate->isWeekend();
            $isOnLeave = $this->isEmployeeLeaveOnDate($tempStartDate, auth()->guard('emp')->user()->emp_id);
            $isPresent = SwipeRecord::where('emp_id', auth()->guard('emp')->user()->emp_id)->where('in_or_out', 'OUT')->whereDate('created_at', $tempStartDate)->orderByDesc('created_at')->first();

            if (empty($isPresent)) {
                $isPresent = SwipeRecord::where('emp_id', auth()->guard('emp')->user()->emp_id)->where('in_or_out', 'IN')->whereDate('created_at', $tempStartDate)->first();
            }


            // Log the status of the current day
            Log::info("Date: $tempStartDate, IsHoliday: " . ($isHoliday ? 'Yes' : 'No') .
                ", IsWeekend: " . ($isweekend ? 'Yes' : 'No') .
                ", IsOnLeave: " . ($isOnLeave ? 'Yes' : 'No') .
                ", IsPresent: " . (!empty($isPresent) ? 'Yes' : 'No'));

            // If not a holiday, weekend, or leave day, and the employee is present
            if (!$isHoliday && !$isweekend && !$isOnLeave && !empty($isPresent)) {
                // Check for late swipes
                $lastOutCount++;
                try {
                    $swipeTime = Carbon::createFromFormat('H:i:s', $isPresent->swipe_time);
                    $limitTime = Carbon::createFromTime(19, 0, 0);
                } catch (\Exception $e) {
                    $swipeTime = Carbon::createFromFormat('H:i', $isPresent->swipe_time);
                    $limitTime = Carbon::createFromTime(19, 0);
                }
                $totalLastOutSeconds += $swipeTime->diffInSeconds(Carbon::createFromTime(0, 0, 0));
                if ($swipeTime->lessThan($limitTime)) {
                    $earlyOutExists = true;
                } else {
                    // Swipe time is 10:00 AM or later
                    $earlyOutExists = false;
                }


                // Log the late swipe check
                Log::info("Early Out  Exists: " . ($earlyOutExists ? 'Yes' : 'No') . " on Date: $tempStartDate");

                // Increment late swipe count if a late swipe is found
                if ($earlyOutExists) {
                    $earlyOutCount++;
                    Log::info("Early Out Count Incremented: $earlyOutCount");
                }
            }

            // Move to the next day
            $startDate->addDay();
        }
        if ($lastOutCount > 0) {
            $averageLastOutSeconds = $totalLastOutSeconds / $lastOutCount;
            $averageLastOutTime = Carbon::createFromTime(0, 0, 0)->addSeconds($averageLastOutSeconds);
        } else {
            $averageLastOutTime = null;  // No valid first in records
        }
        return [
            'averageLastOutTime' => $averageLastOutTime ? $averageLastOutTime->format('H:i:s') : 'N/A',
            'EarlyOutCount' => $earlyOutCount,

        ];
    }
    private function calculateAvgWorkingHrs($employeeId)
    {
        $currentDate = Carbon::now()->startOfMonth();
        $endDate = Carbon::now()->endOfMonth();
        $this->averageFormattedTime = '00:00';
        $standardWorkingMinutesPerDay = 9 * 60;
        $totalMinutesWorked = 0;  // Initialize total minutes worked
        $daysWithRecords = 0;
        while ($currentDate->lt($endDate)) {
            $SwipeInRecord = SwipeRecord::where('emp_id', $employeeId)->whereDate('created_at', $currentDate)->where('in_or_out', 'IN')->first();
            $SwipeOutRecord = SwipeRecord::where('emp_id', $employeeId)->whereDate('created_at', $currentDate)->where('in_or_out', 'OUT')->first();
            if ($SwipeInRecord && $SwipeOutRecord) {
                // Get the swipe times
                $swipeInTime = Carbon::parse($SwipeInRecord->swipe_time);
                $swipeOutTime = Carbon::parse($SwipeOutRecord->swipe_time);

                $timeDifferenceInMinutes = $swipeOutTime->diffInMinutes($swipeInTime);
                $workingHoursPercentage = ($timeDifferenceInMinutes / $standardWorkingMinutesPerDay) * 100;
                // Add the time difference to the total minutes worked
                $totalMinutesWorked += $timeDifferenceInMinutes;

                // Increment the count of days with records
                $daysWithRecords++;
                // echo " (" . round($workingHoursPercentage, 2) . "% of standard working hours)";
            }
            $currentDate->addDay();
        }
        if ($daysWithRecords > 0) {
            $averageMinutes = $totalMinutesWorked / $daysWithRecords;
            $averageHours = floor($averageMinutes / 60);
            $averageRemainingMinutes = $averageMinutes % 60;

            $this->averageFormattedTimeForCurrentMonth = sprintf('%02d:%02d', $averageHours, $averageRemainingMinutes);

            // Return or use the average formatted time

        }
        // $this->averageFormattedTime=$this->calculateAvgWorkHours()-$this->calculateAvgWorkHoursForPreviousMonth();
        $totalPossibleWorkingMinutes = $daysWithRecords * $standardWorkingMinutesPerDay;

        // Calculate the percentage of total minutes worked
        if ($totalPossibleWorkingMinutes > 0) {
            $this->totalWorkingPercentage = ($totalMinutesWorked / $totalPossibleWorkingMinutes) * 100;
        } else {
            $this->totalWorkingPercentage = 0;
        }
    }
    public function opentoggleButton()
    {

        $this->toggleButton = !$this->toggleButton;
    }
    private function countHolidaysBetweenDates($startDate, $endDate)
    {
        $holidayCount = HolidayCalendar::whereBetween('date', [$startDate, $endDate])->get();


        return $holidayCount;
    }
    private function countWeekendsBetweenDates($startDate, $endDate)
    {
        $weekendCount = 0;

        // Iterate through the date range
        $currentDate = $startDate->copy();
        while ($currentDate->lte($endDate)) {
            // Check if the current day is a Saturday (6) or Sunday (7)
            if ($currentDate->isSaturday() || $currentDate->isSunday()) {
                $weekendCount++;
            }
            // Move to the next day
            $currentDate->addDay();
        }

        return $weekendCount;
    }
    private function calculateTotalWorkingDays($startDate, $endDate)
    {
        $workingDays = 0;

        // Iterate through the date range
        while ($startDate->lte($endDate)) {
            // Check if the day is not Saturday (6) or Sunday (7)
            if (!$startDate->isWeekend()) {
                $workingDays++;
            }
            // Move to the next day
            $startDate->addDay();
        }

        return $workingDays;
    }
    private function calculateTotalNumberOfLeaves($startDate, $endDate)
    {
        $leaveCount = 0;

        Log::info('Starting leave calculation from ' . $startDate->toDateString() . ' to ' . $endDate->toDateString());

    // Iterate through the date range
    while ($startDate->lte($endDate)) {
        $tempStartDate = $startDate->toDateString();

            // Check if the current date is a holiday
            $isHoliday = HolidayCalendar::where('date', $tempStartDate)->exists();

            // Skip weekends (Saturday and Sunday) or holidays
            if ($startDate->isWeekend()) {
                Log::info('Skipping weekend: ' . $tempStartDate);
            } elseif ($isHoliday) {
                Log::info('Skipping holiday: ' . $tempStartDate);
            } else {
                // Log current date and status
                Log::info('Checking date: ' . $tempStartDate);

                // Check if employee is on leave on this date
                $isOnLeave = $this->isEmployeeLeaveOnDate($tempStartDate, auth()->guard('emp')->user()->emp_id);
                Log::info('Is on leave: ' . ($isOnLeave ? 'Yes' : 'No'));

                if ($isOnLeave) {
                    $leaveCount++;
                }
            }

            // Move to the next day
            $startDate->addDay();
        }

        Log::info('Total leave count (excluding weekends and holidays): ' . $leaveCount);

        return $leaveCount;
    }
    public function calculateTotalDays()
    {
        try {

            $startDate = Carbon::parse($this->start_date_for_insights);
            $endDate = Carbon::parse($this->to_date);
            $originalEndDate = $endDate->copy();
            $this->updateModalTitle();
        } catch (\Exception $e) {
            Log::error('Error in calculateTotalDays method: ' . $e->getMessage());
            FlashMessageHelper::flashError('An error occurred while calculating total days. Please try again later.');
        }
    }
    private function calculateNumberofWeekends($startDate, $endDate)
    {
        $weekendDays = 0;
        $currentDate = $startDate->copy();
        while ($currentDate->lt($endDate)) {
            if ($currentDate->isSaturday() || $currentDate->isSunday()) {
                $weekendDays++;
            }
            $currentDate->addDay();
        }

        return $weekendDays;
    }
    private function calculateWorkingDays($startDate, $endDate, $employeeId)
    {
        try {

            $workingDays = 0;
            $currentDate = $startDate->copy();

            while ($currentDate->lte($endDate)) {
                if ($currentDate->isWeekday() && !$this->isEmployeeLeaveOnDate($currentDate, $employeeId) && $this->isEmployeePresentOnDate($currentDate)) {
                    $workingDays++;
                }
                $currentDate->addDay();
            }

            return $workingDays;
        } catch (\Exception $e) {
            Log::error('Error in calculateWorkingDays method: ' . $e->getMessage());
            FlashMessageHelper::flashError('An error occurred while calculating working days. Please try again later.');

            return 0;
        }
    }
    private function calculateWorkingDaysForModalTitle($startDate, $endDate, $employeeId)
    {
        try {

            $workingDays = 0;
            $currentDate = $startDate->copy();

            while ($currentDate->lt($endDate)) {
                if ($currentDate->isWeekday() && !$this->isEmployeeLeaveOnDate($currentDate, $employeeId) && $this->isEmployeePresentOnDate($currentDate)) {
                    $workingDays++;
                }
                $currentDate->addDay();
            }

            return $workingDays;
        } catch (\Exception $e) {
            Log::error('Error in calculateWorkingDays method: ' . $e->getMessage());
            FlashMessageHelper::flashError('An error occurred while calculating working days. Please try again later.');

            return 0;
        }
    }

    private function calculateActualHours($swipe_records)
    {
        try {
            $this->actualHours = [];

            for ($i = 0; $i < count($swipe_records) - 1; $i += 2) {
                $firstSwipeTime = strtotime($swipe_records[$i]->swipe_time);
                $secondSwipeTime = strtotime($swipe_records[$i + 1]->swipe_time);

                $timeDifference = $secondSwipeTime - $firstSwipeTime;

                $hours = floor($timeDifference / 3600);
                $minutes = floor(($timeDifference % 3600) / 60);

                $this->actualHours[] = sprintf("%02dhrs %02dmins", $hours, $minutes);
            }
        } catch (\Exception $e) {
            Log::error('Error in calculateActualHours method: ' . $e->getMessage());
            FlashMessageHelper::flashError('An error occurred while calculating actual hours. Please try again later.');
        }
    }
    public function viewDetails($id)
    {
        try {
            $this->showSR = true;
            $student = SwipeRecord::find($id);
            $this->view_student_emp_id = $student->emp_id;
            $this->view_student_swipe_time = $student->swipe_time;
            $this->view_student_in_or_out = $student->in_or_out;
        } catch (\Exception $e) {
            Log::error('Error in viewDetails method: ' . $e->getMessage());
            FlashMessageHelper::flashError('An error occurred while viewing details. Please try again later.');
        }
    }
    public function closeViewStudentModal()
    {
        try {
            $this->view_student_emp_id = '';
            $this->view_student_swipe_time = '';
            $this->view_student_in_or_out = '';
        } catch (\Exception $e) {
            Log::error('Error in closeViewStudentModal method: ' . $e->getMessage());
            FlashMessageHelper::flashError('An error occurred while closing view student modal. Please try again later.');
        }
    }
    public $show = false;
    public $show1 = false;
    public function showViewStudentModal()
    {
        try {
            $this->show = true;
        } catch (\Exception $e) {
            Log::error('Error in showViewStudentModal method: ' . $e->getMessage());
            FlashMessageHelper::flashError('An error occurred while showing view student modal. Please try again later.');
        }
    }

    public function showViewTableModal()
    {
        try {
            $this->show1 = true;
        } catch (\Exception $e) {
            Log::error('Error in showViewTableModal method: ' . $e->getMessage());
            FlashMessageHelper::flashError('An error occurred while showing view table modal. Please try again later.');
        }
    }

    public $showSR = false;
    public function openSwipes()
    {
        try {
            $this->showSR = true;
        } catch (\Exception $e) {
            Log::error('Error in openSwipes method: ' . $e->getMessage());
            FlashMessageHelper::flashError('An error occurred while opening swipes. Please try again later.');
        }
    }
    public function closeSWIPESR()
    {
        try {
            $this->showSR = false;
        } catch (\Exception $e) {
            Log::error('Error in closeSWIPESR method: ' . $e->getMessage());
            FlashMessageHelper::flashError('An error occurred while closing SWIPESR. Please try again later.');
        }
    }
    public function close1()
    {
        try {
            $this->show1 = false;
        } catch (\Exception $e) {
            Log::error('Error in close1 method: ' . $e->getMessage());
            FlashMessageHelper::flashError('An error occurred while closing 1. Please try again later.');
        }
    }
    public function calculateAvgWorkHoursForPreviousMonth()
    {
        // Get the start and end dates of the previous month
        $startDate = Carbon::now()->subMonth()->startOfMonth();
        $endDate = Carbon::now()->subMonth()->endOfMonth();

        // Retrieve all SwipeRecord entries for the previous month
        $records = SwipeRecord::whereBetween('created_at', [$startDate, $endDate])
            ->orderBy('swipe_time') // Ensure we order records by swipe time
            ->get();

        // Initialize variables
        $totalHours = 0;
        $recordCount = 0;

        // Group records by date
        $groupedRecords = $records->groupBy(function ($record) {
            return Carbon::parse($record->swipe_time)->toDateString();
        });

        // Iterate through each group (each day)
        foreach ($groupedRecords as $date => $dayRecords) {
            $swipeIn = $dayRecords->where('in_or_out', 'IN')->first();
            $swipeOut = $dayRecords->where('in_or_out', 'OUT')->last();

            if ($swipeIn && $swipeOut) {
                $swipeInTime = Carbon::parse($swipeIn->swipe_time);
                $swipeOutTime = Carbon::parse($swipeOut->swipe_time);

                // Calculate the difference in hours and add to total hours
                $totalHours += $swipeOutTime->diffInHours($swipeInTime);
                $recordCount++;
            }
        }

        // Calculate average hours worked
        $avgWorkHours = $recordCount > 0 ? $totalHours / $recordCount : 0;

        return $avgWorkHours;
    }
    public function calculateAvgWorkHours()
    {
        // Get the start and end dates of the current month
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        // Retrieve all SwipeRecord entries for the current month
        $records = SwipeRecord::whereBetween('created_at', [$startOfMonth, $endOfMonth])->get();

        // Initialize total hours
        $totalHours = 0;
        $recordCount = 0;

        // Iterate through records and calculate total working hours
        foreach ($records as $record) {
            $swipeIn = Carbon::parse($record->swipe_in);
            $swipeOut = Carbon::parse($record->swipe_out);

            // Calculate the difference in hours and add to total hours
            $totalHours += $swipeOut->diffInHours($swipeIn);
            $recordCount++;
        }

        // Calculate average hours worked
        $avgWorkHours = $recordCount > 0 ? $totalHours / $recordCount : 0;

        return $avgWorkHours;
    }
    public function beforeMonth()
    {
        try {
            $date = Carbon::create($this->year, $this->month, 1)->subMonth();
            $this->year = $date->year;
            $this->month = $date->month;
            $today = Carbon::today();
            $this->generateCalendar();
            $startDateOfPreviousMonth = $date->startOfMonth()->toDateString();
            $endDateOfPreviousMonth = $date->endOfMonth()->toDateString();
            if ($today->year == $date->year && $today->month == $date->month && $endDateOfPreviousMonth > $today->toDateString()) {
                // Adjust $endDateOfPreviousMonth to today's date since it's greater than today

                $this->averageWorkHrsForCurrentMonth = $this->calculateAverageWorkHoursAndPercentage($startDateOfPreviousMonth, $today->toDateString());
            } elseif ($today->year >= $date->year && $today->month >= $date->month && $endDateOfPreviousMonth > $today->toDateString()) {
                $this->averageWorkHrsForCurrentMonth = '-';
            } else {
                $this->averageWorkHrsForCurrentMonth = $this->calculateAverageWorkHoursAndPercentage($startDateOfPreviousMonth, $endDateOfPreviousMonth);
            }
            //$this->averageWorkHrsForCurrentMonth = $this->calculateAverageWorkHoursAndPercentage($startDateOfPreviousMonth, $endDateOfPreviousMonth);


            // $previousMonthStart = $date->subMonth()->startOfMonth()->toDateString();
            $this->percentageinworkhrsforattendance = $this->calculateDifferenceInAvgWorkHours($date->format('Y-m'));

            $this->dateClicked($date->startOfMonth()->toDateString());
        } catch (\Exception $e) {
            Log::error('Error in beforeMonth method: ' . $e->getMessage());
            FlashMessageHelper::flashError('An error occurred while navigating to the previous month. Please try again later.');
        }
    }

    public function nextMonth()
    {
        try {
            $date = Carbon::create($this->year, $this->month, 1)->addMonth();
            $this->year = $date->year;
            $this->month = $date->month;
            $today = Carbon::today();
            $this->generateCalendar();
            $this->changeDate = 1;
            $this->dateClicked($date->toDateString());
            $nextdate = Carbon::create($date->year, $date->month, 1)->addMonth();
            $lastDateOfNextMonth = $date->endOfMonth()->toDateString();
            $startDateOfPreviousMonth = $date->startOfMonth()->toDateString();
            $endDateOfPreviousMonth = $date->endOfMonth()->toDateString();
            if ($today->year == $date->year && $today->month == $date->month && $endDateOfPreviousMonth > $today->toDateString()) {
                // Adjust $endDateOfPreviousMonth to today's date since it's greater than today

                $this->averageWorkHrsForCurrentMonth = $this->calculateAverageWorkHoursAndPercentage($startDateOfPreviousMonth, $today->toDateString());
            } elseif ($today->year >= $date->year && $today->month >= $date->month && $endDateOfPreviousMonth > $today->toDateString()) {
                $this->averageWorkHrsForCurrentMonth = '-';
            } else {
                $this->averageWorkHrsForCurrentMonth = $this->calculateAverageWorkHoursAndPercentage($startDateOfPreviousMonth, $endDateOfPreviousMonth);
            }
            $this->percentageinworkhrsforattendance = $this->calculateDifferenceInAvgWorkHours($date->format('Y-m'));
        } catch (\Exception $e) {
            Log::error('Error in nextMonth method: ' . $e->getMessage());
            FlashMessageHelper::flashError('An error occurred while navigating to the next month. Please try again later.');
        }
    }

    public function öpenattendanceperiodModal()
    {

        $this->öpenattendanceperiod = true;
    }
    public function closeattendanceperiodModal()
    {
        $this->öpenattendanceperiod = false;
        $this->start_date_for_insights = Carbon::now()->startOfMonth()->format('Y-m-d');
        $this->to_date = Carbon::now()->toDateString();
        $this->updateModalTitle();
    }
    public function checkDateInRegularisationEntries($d)
    {
        try {
            $this->showRegularisationDialog = true;
            $employeeId = auth()->guard('emp')->user()->emp_id;

            $regularisationRecords = RegularisationDates::where('emp_id', $employeeId)
                ->whereIn('regularisation_dates.status', [2, 13]) // Include both approved (2) and status (13)
                ->join('status_types', 'status_types.status_code', '=', 'regularisation_dates.status') // Join with status_types table
                ->select('regularisation_dates.*', 'status_types.status_name') // Select fields from both tables
                ->get();

            $dateFound = false;
            $result = null;

            foreach ($regularisationRecords as $record) {
                $entries = json_decode($record->regularisation_entries, true);

                foreach ($entries as $entry) {
                    if (isset($entry['date']) && $entry['date'] === $d) {
                        $dateFound = true;
                        $result = [
                            'date' => $entry['date'],
                            'reason' => $entry['reason'],
                            'approved_date' => $record['approved_date'],
                            'approved_by' => $record['approved_by']
                        ];
                        break 2; // Exit both loops
                    }
                }
            }


            if ($result) {
                $this->regularised_date_to_check = $result['date'];
                $this->regularised_by = $result['approved_by'];
                $this->regularised_date = $result['approved_date'];
                $this->regularised_reason = $result['reason'];
            } else {
                $this->regularised_date_to_check = null;
                $this->regularised_by = null;
                $this->regularised_date = null;
                $this->regularised_reason = null;
            }
        } catch (\Exception $e) {
            // Handle the exception
            Log::error('Error in checkDateInRegularisationEntries method: ' . $e->getMessage());
            // Optionally, you can set a user-friendly message to be displayed
            $this->errorMessage = 'An error occurred while checking the regularisation entries. Please try again later.';

            // Reset the fields in case of an error
            $this->regularised_date_to_check = null;
            $this->regularised_by = null;
            $this->regularised_date = null;
            $this->regularised_reason = null;
        }
    }

    public function render()
    {
        try {
            $this->dynamicDate = now()->format('Y-m-d');
            $employeeId = auth()->guard('emp')->user()->emp_id;
            $this->employeeIdForRegularisation = auth()->guard('emp')->user()->emp_id;
            $this->swiperecord = SwipeRecord::where('swipe_records.emp_id', $employeeId)
                ->where('is_regularized', 1)
                ->join('employee_details', 'swipe_records.emp_id', '=', 'employee_details.emp_id')
                ->select('swipe_records.*', 'employee_details.first_name', 'employee_details.last_name')
                ->get();

            $currentDate = Carbon::now()->format('Y-m-d');
            $holiday = HolidayCalendar::all();
            $today = Carbon::today();
            $data = SwipeRecord::join('employee_details', 'swipe_records.emp_id', '=', 'employee_details.emp_id')
                ->where('swipe_records.emp_id', auth()->guard('emp')->user()->emp_id)
                ->whereDate('swipe_records.created_at', $today)
                ->select('swipe_records.*', 'employee_details.first_name', 'employee_details.last_name')
                ->get();

            $this->holiday = HolidayCalendar::all();
            $this->leaveApplies = LeaveRequest::where('emp_id', auth()->guard('emp')->user()->emp_id)->get();

            if ($this->changeDate == 1) {
                $this->currentDate2 = $this->dateclicked;
                if ($this->isEmployeeRegularisedOnDate($this->currentDate2) == true) {

                    $this->currentDate2recordin = SwipeRecord::where('emp_id', auth()->guard('emp')->user()->emp_id)->whereDate('created_at', $this->currentDate2)->where('in_or_out', 'IN')->where('is_regularized', 1)->first();
                    $this->currentDate2recordout = SwipeRecord::where('emp_id', auth()->guard('emp')->user()->emp_id)->whereDate('created_at', $this->currentDate2)->where('in_or_out', 'OUT')->where('is_regularized', 1)->first();
                } else {

                    $this->currentDate2recordin = SwipeRecord::where('emp_id', auth()->guard('emp')->user()->emp_id)->whereDate('created_at', $this->currentDate2)->where('in_or_out', 'IN')->first();
                    $this->currentDate2recordout = SwipeRecord::where('emp_id', auth()->guard('emp')->user()->emp_id)->whereDate('created_at', $this->currentDate2)->where('in_or_out', 'OUT')->orderBy('updated_at', 'desc')->first();
                }

                if (isset($this->currentDate2recordin) && isset($this->currentDate2recordout)) {
                    $this->first_in_time = substr($this->currentDate2recordin->swipe_time, 0, 5);
                    $this->last_out_time = substr($this->currentDate2recordout->swipe_time, 0, 5);
                    $firstInTime = Carbon::createFromFormat('H:i', $this->first_in_time);
                    $lastOutTime = Carbon::createFromFormat('H:i', $this->last_out_time);

                    if ($lastOutTime < $firstInTime) {
                        $lastOutTime->addDay();
                    }

                    if ($lastOutTime < $firstInTime) {
                        $lastOutTime->addDay();
                    }
                    $this->first_in_time_for_date = $firstInTime;
                    $this->last_out_time_for_date = $lastOutTime;

                    $this->timeDifferenceInMinutesForCalendar = $lastOutTime->diffInMinutes($firstInTime);
                    $this->hours = floor($this->timeDifferenceInMinutesForCalendar / 60);
                    $minutes = $this->timeDifferenceInMinutesForCalendar % 60;
                    $this->minutesFormatted = str_pad($minutes, 2, '0', STR_PAD_LEFT);
                } elseif (!isset($this->currentDate2recordout) && isset($this->currentDate2recordin)) {
                    $this->first_in_time = substr($this->currentDate2recordin->swipe_time, 0, 5);;
                    $this->last_out_time = substr($this->currentDate2recordin->swipe_time, 0, 5);;
                } else {
                    $this->first_in_time = '-';
                    $this->last_out_time = '-';
                }
                if (Carbon::parse($this->currentDate2)->isWeekend()) {
                    $this->shortFallHrs = '-';
                    $this->work_hrs_in_shift_time = '-';
                    $this->excessHrs = '-';
                } elseif ($this->isHolidayOnDate($this->currentDate2)) {
                    $this->shortFallHrs = '-';
                    $this->work_hrs_in_shift_time = '-';
                    $this->excessHrs = '-';
                } elseif ($this->first_in_time == $this->last_out_time) {
                    $this->shortFallHrs = '-';
                    $this->work_hrs_in_shift_time = '-';
                    $this->excessHrs = '-';
                } else {
                    $standardMinutesForShortFall = 9 * 60; // 9 hours in minutes (540 minutes)
                    $timeDifferenceForShortFall = $standardMinutesForShortFall - $this->timeDifferenceInMinutesForCalendar; // Subtracting the time difference

                    // Convert the result to hours and minutes
                    $shortfallhours = floor($timeDifferenceForShortFall / 60); // Get the full hours
                    $shortfallminutes = $timeDifferenceForShortFall % 60; // Get the remaining minutes

                    // Format the result in HH:MM format
                    if ($timeDifferenceForShortFall == 0) {
                        $this->shortFallHrs = '08:59';
                        $this->excessHrs = '-';
                    } elseif ($this->timeDifferenceInMinutesForCalendar > $standardMinutesForShortFall) {
                        $this->shortFallHrs = '-';
                        $timeDifferenceForExcess = $this->timeDifferenceInMinutesForCalendar - $standardMinutesForShortFall;
                        $excesshours = floor($timeDifferenceForExcess / 60); // Get the full hours
                        $excessminutes = $timeDifferenceForExcess % 60; // Get the remaining minutes
                        $this->excessHrs = sprintf('%02d:%02d', $excesshours, $excessminutes);
                    } else {
                        $this->shortFallHrs = sprintf('%02d:%02d', $shortfallhours, $shortfallminutes);
                        $this->excessHrs = '-';
                    }


                    $this->work_hrs_in_shift_time = '09:00';
                }
                $this->currentDate2recordexists = SwipeRecord::where('emp_id', auth()->guard('emp')->user()->emp_id)->whereDate('created_at', $this->currentDate2)->exists();
            } else {
                $this->currentDate2 = Carbon::now()->format('Y-m-d');
            }

            $swipe_records = SwipeRecord::where('emp_id', auth()->guard('emp')->user()->emp_id)->whereDate('created_at', $this->currentDate2)->get();
            $this->swipe_records_count = SwipeRecord::where('emp_id', auth()->guard('emp')->user()->emp_id)->whereDate('created_at', $this->currentDate2)->count();
            $this->swiperecordsfortoggleButton = SwipeRecord::where('emp_id', auth()->guard('emp')->user()->emp_id)->whereDate('created_at', $this->currentDate2)->get();
            $swipe_records1 = SwipeRecord::where('emp_id', auth()->guard('emp')->user()->emp_id)->orderBy('created_at', 'desc')->get();

            $this->calculateActualHours($swipe_records);
            return view('livewire.attendance', [
                'Holiday' => $this->holiday,
                'Swiperecords' => $swipe_records,
                'SwiperecordsCount' => $this->swipe_records_count,
                'Swiperecords1' => $swipe_records1,
                'data' => $data,
                'CurrentDateTwoRecord' => $this->currentDate2record,
                'ChangeDate' => $this->changeDate,
                'CurrentDate2recordexists' => $this->currentDate2recordexists,
                'avgLateIn' => $this->avgLateIn,
                'avgEarlyOut' => $this->avgEarlyOut,
                'avgSignOutTime' => $this->avgSwipeOutTime,
                'modalTitle' => $this->modalTitle,

            ]);
        } catch (\Exception $e) {
            Log::error('Error in render method: ' . $e->getMessage());
            FlashMessageHelper::flashError('An error occurred while rendering the page. Please try again later.');
            return view('livewire.attendance'); // Return an empty view or handle it as appropriate
        }
    }
}
