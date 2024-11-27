<?php

/*
 * File Name                       : EmployeeSwipesData.php
 * Description                     : This file contains the implementation of all the employees who swiped in today and we can get the swipe record of the employees before today's date.
 * Creator                         : Pranita Priyadarshi
 * Email                           : priyadarshipranita72@gmail.com
 * Organization                    : PayG.
 * Date                            : 2023-12-07
 * Framework                       : Laravel (10.10 Version)
 * Programming Language            : PHP (8.1 Version)
 * Database                        : MySQL
 * Models                          : SwipeRecord, EmployeeDetails
 */

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use App\Models\SwipeRecord;
use App\Models\EmployeeDetails;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Illuminate\Support\Facades\Log;
use Jenssegers\Agent\Agent;
use Spatie\SimpleExcel\SimpleExcelWriter;

class EmployeeSwipesData extends Component
{
    public $employees;
    public $startDate;
    public $endDate;
    public $selectedSwipeTime;
    public $search = '';
    public $searching = 0;
    public $selectedSwipeLogTime = [];
    public $swipeLogTime = null;
    public $status;

    public function mount()
    {
        try {
            $today = now()->startOfDay();
            $authUser = Auth::user();
            $userId = $authUser->emp_id;

            $managedEmployees = EmployeeDetails::where('manager_id', $userId)
                ->where('employee_status', 'active')
                ->get();

            // Check if the user swiped today
            $userSwipesToday = SwipeRecord::where('emp_id', $authUser->emp_id)
                ->where('created_at', '>=', $today)
                ->where('created_at', '<', $today->copy()->endOfDay())
                ->exists();

            $agent = new Agent();
            $this->status = $userSwipesToday ? ($agent->isMobile() ? 'Mobile' : ($agent->isDesktop() ? 'Desktop' : '-')) : '-';
        } catch (\Exception $e) {
            Log::error('Error in mount method: ' . $e->getMessage());
            $this->status = 'Error';
        }
    }

    public function updatedStartDate()
    {
        // Check the selected dates after updating start date
        $this->checkDates();
    }

    public function updatedEndDate()
    {
        // Check the selected dates after updating end date
        $this->checkDates();
    }

    public function downloadFileforSwipes()
    {
        try {
            $today = now()->toDateString();
            $authUser = Auth::user();
            $userId = $authUser->emp_id;

            // $managedEmployees = EmployeeDetails::where('manager_id', $userId)
            //     ->where('employee_status', 'active')
            //     ->get();

            $swipeData = [];

            // foreach ($managedEmployees as $employee) {
                // $normalizedEmployeeId = str_replace('-', '', $employee->emp_id);

                // Fetch the first swipe log for each employee for today
                // $employeeSwipeLog = DB::connection('sqlsrv')
                //     ->table('DeviceLogs_' . now()->month . '_' . now()->year)
                //     ->select('UserId', 'logDate', 'Direction')
                //     ->where('UserId', $normalizedEmployeeId)
                //     ->whereDate('logDate', $today)
                //     ->orderBy('logDate')
                //     ->first();

                // Add the employee and their swipe log (if any) to the results
                // if ($employeeSwipeLog) {
                //     $swipeData[] = [
                //         'Employee ID' => $employee->emp_id,
                //         'Employee Name' => ucfirst(strtolower($employee->first_name)) . ' ' . ucfirst(strtolower($employee->last_name)),
                //         'Swipe Date' => Carbon::parse($employeeSwipeLog->logDate)->format('d-M-Y'),
                //         'Swipe Time' => Carbon::parse($employeeSwipeLog->logDate)->format('h:i A'),
                //         'Direction' => $employeeSwipeLog->Direction,
                //     ];
                // }
            // }

            $headerColumns = ['Employee ID', 'Employee Name', 'Swipe Date', 'Swipe Time', 'Direction'];
            $filePath = storage_path('app/todays_present_employees.xlsx');

            SimpleExcelWriter::create($filePath)
                ->addRow($headerColumns)
                ->addRows($swipeData)
                ->close();

            return response()->download($filePath, 'todays_present_employees.xlsx');
        } catch (\Exception $e) {
            Log::error('Error downloading file for swipes: ' . $e->getMessage());
            session()->flash('error', 'An error occurred while downloading the file for swipes. Please try again.');
            return redirect()->back();
        }
    }

    public function searchEmployee()
    {
        $this->searching = 1;
    }

    public function processSwipeLogs($managedEmployees, $today)
    {
        $swipeData = [];
    $todaySwipeRecords = SwipeRecord::whereDate('created_at', $today)
        ->whereIn('emp_id', $managedEmployees->pluck('emp_id'))
        ->get()
        ->keyBy('emp_id');

    $normalizedIds = $managedEmployees->pluck('emp_id')->map(function ($id) {
        return str_replace('-', '', $id);
    });

    
    $externalSwipeLogs = DB::connection('sqlsrv')
        ->table('DeviceLogs_' . now()->month . '_' . now()->year)
        ->select('UserId', 'logDate', 'Direction')
        ->whereIn('UserId', $normalizedIds)
        ->whereDate('logDate', $today)
        ->get();

    foreach ($managedEmployees as $employee) {
        $normalizedEmployeeId = str_replace('-', '', $employee->emp_id);
        
        // Check if there's a swipe record from the external database
        $employeeSwipeLog = $externalSwipeLogs->firstWhere('UserId', $normalizedEmployeeId);

        if (!$employeeSwipeLog && isset($todaySwipeRecords[$employee->emp_id])) {
            // Use swipe record from local database if it exists
            $employeeSwipeLog = $todaySwipeRecords[$employee->emp_id];
        }

        if ($employeeSwipeLog) {
            $swipeData[] = [
                'employee' => $employee,
                'swipe_log' => $employeeSwipeLog,
            ];
        }
    }

    return $swipeData;
    }

    
    public function render()
    {
        $today = now()->toDateString();
        $authUser = Auth::user();
        $userId = $authUser->emp_id;
    
        // Retrieve active employees managed by the user
        $managedEmployees = EmployeeDetails::where('manager_id', $userId)
            ->where('employee_status', 'active')
            ->get(); // Adjust the pagination number as needed
    
        $this->employees = $this->processSwipeLogs($managedEmployees, $today); // Process and fetch employees' swipe logs
        return view('livewire.employee-swipes-data', [
            'SignedInEmployees' => $this->employees,
        ]);
    }
}