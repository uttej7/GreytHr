<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Salaryslip;
use App\Models\EmployeeDetails;
use App\Models\EmpSalaryRevision;
use App\Models\EmpBankDetail;
use App\Models\EmpPersonalInfo;
use App\Models\EmpSalary;
use DateTime;
use Barryvdh\DomPDF\Facade\Pdf;
use Dompdf\Dompdf;
use Carbon\Carbon;

class SalarySlips extends Component
{
    public $employeeDetails;
    public $employeePersonalDetails;
    public $salaryRevision;
    public $empSalaryDetails;
    public $empBankDetails;
    public $showDetails = true;
    public $hideInfobutton = 'Hide';

    public $selectedMonth, $salaryMonth;
    public $netPay, $basic, $hra, $convayance, $medical, $special, $pf, $esi, $prof_tax, $gross, $salaryDivisions;

    public function changeMonth()
    {

        $this->getSalaryDetails();
    }
    public function toggleDetails()
    {
        $this->showDetails = !$this->showDetails; // Toggle the value
    }

    private function calculateNetPay()
    {
        $totalGrossPay = 0;
        $totalDeductions = 0;

        foreach ($this->salaryRevision as $revision) {
            $totalGrossPay += $revision->calculateTotalAllowance();
            $totalDeductions += $revision->calculateTotalDeductions();
        }

        return $totalGrossPay - $totalDeductions;
    }
    public function downloadPdf()
    {



        // Generate PDF using the fetched data
        $pdf = Pdf::loadView('download-pdf', [
            'employees' =>  $this->employeeDetails,
            'salaryRevision' =>  $this->salaryDivisions,
            'empBankDetails' => $this->empBankDetails,
            'rupeesInText' => $this->convertNumberToWords($this->salaryDivisions['net_pay']),
            'salMonth' => Carbon::parse($this->selectedMonth)->format('F Y')
        ]);

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, 'payslip.pdf');
    }



    public function convertNumberToWords($number)
    {
        // Array to represent numbers from 0 to 19 and the tens up to 90
        $words = [
            0 => 'zero',
            1 => 'one',
            2 => 'two',
            3 => 'three',
            4 => 'four',
            5 => 'five',
            6 => 'six',
            7 => 'seven',
            8 => 'eight',
            9 => 'nine',
            10 => 'ten',
            11 => 'eleven',
            12 => 'twelve',
            13 => 'thirteen',
            14 => 'fourteen',
            15 => 'fifteen',
            16 => 'sixteen',
            17 => 'seventeen',
            18 => 'eighteen',
            19 => 'nineteen',
            20 => 'twenty',
            30 => 'thirty',
            40 => 'forty',
            50 => 'fifty',
            60 => 'sixty',
            70 => 'seventy',
            80 => 'eighty',
            90 => 'ninety'
        ];

        // Handle special cases
        if ($number < 0) {
            return 'minus ' . $this->convertNumberToWords(-$number);
        }

        // Handle numbers less than 100
        if ($number < 100) {
            if ($number < 20) {
                return $words[$number];
            } else {
                $tens = $words[10 * (int) ($number / 10)];
                $ones = $number % 10;
                if ($ones > 0) {
                    return $tens . ' ' . $words[$ones];
                } else {
                    return $tens;
                }
            }
        }

        // Handle numbers greater than or equal to 100
        if ($number < 1000) {
            $hundreds = $words[(int) ($number / 100)] . ' hundred';
            $remainder = $number % 100;
            if ($remainder > 0) {
                return $hundreds . ' ' . $this->convertNumberToWords($remainder);
            } else {
                return $hundreds;
            }
        }

        // Handle larger numbers
        if ($number < 1000000) {
            $thousands = $this->convertNumberToWords((int) ($number / 1000)) . ' thousand';
            $remainder = $number % 1000;
            if ($remainder > 0) {
                return $thousands . ' ' . $this->convertNumberToWords($remainder);
            } else {
                return $thousands;
            }
        }

        // Handle even larger numbers
        if ($number < 1000000000) {
            $millions = $this->convertNumberToWords((int) ($number / 1000000)) . ' million';
            $remainder = $number % 1000000;
            if ($remainder > 0) {
                return $millions . ' ' . $this->convertNumberToWords($remainder);
            } else {
                return $millions;
            }
        }

        // Handle numbers larger than or equal to a billion
        return 'number too large to convert';
    }

    public function getSalaryDetails()
    {
        // dd('ok');

        $employeeId = auth()->guard('emp')->user()->emp_id;


        $this->employeeDetails = EmployeeDetails::select('employee_details.*', 'emp_departments.department')
            ->leftJoin('emp_departments', 'employee_details.dept_id', '=', 'emp_departments.dept_id')
            ->leftJoin('emp_personal_infos', 'employee_details.emp_id', '=', 'emp_personal_infos.emp_id')
            ->where('employee_details.emp_id', $employeeId)
            ->first();

        $this->employeePersonalDetails=EmpPersonalInfo::where('emp_id',$employeeId)->first();


        $this->salaryRevision = EmpSalaryRevision::where('emp_id', $employeeId)->get();
        $this->empSalaryDetails = EmpSalary::join('salary_revisions', 'emp_salaries.sal_id', '=', 'salary_revisions.id')
        ->where('salary_revisions.emp_id',$employeeId)
            ->where('month_of_sal', 'like', $this->selectedMonth . '%')
            ->first();
        // dd($this->empSalaryDetails);

        if ($this->empSalaryDetails) {
            $this->salaryDivisions = $this->empSalaryDetails->calculateSalaryComponents($this->empSalaryDetails->salary);
            $this->empBankDetails = EmpBankDetail::where('emp_id', $employeeId)
                ->where('id', $this->empSalaryDetails->bank_id)->first();
            // dd( $this->salaryDivisions);
        } else {
            // Handle the null case (e.g., log an error or set a default value)
            $this->salaryDivisions = [];
        }
        //    dd( $this->salaryDivisions);
        //    $this->basic=$this->empSalaryDetails->getBasicSalary( $this->empSalaryDetails->salary);
        //    $this->hra=$this->empSalaryDetails->getBasicSalary( $this->empSalaryDetails->salary);
        //    $this->convayance=$this->empSalaryDetails->getBasicSalary( $this->empSalaryDetails->salary);
        //    $this->medical=$this->empSalaryDetails->getBasicSalary( $this->empSalaryDetails->salary);
        //    $this->special=$this->empSalaryDetails->getBasicSalary( $this->empSalaryDetails->salary);
        //    $this->pf=$this->empSalaryDetails->getBasicSalary( $this->empSalaryDetails->salary);
        //    $this->esi=$this->empSalaryDetails->getBasicSalary( $this->empSalaryDetails->salary);
        //    $this->prof_tax=$this->empSalaryDetails->getBasicSalary( $this->empSalaryDetails->salary);
        //    $this->prof_tax=$this->empSalaryDetails->getBasicSalary( $this->empSalaryDetails->salary);




        // $this->empBankDetails = EmpBankDetail::where('emp_id', $employeeId)->get();

    }
    public function mount()
    {
        $this->selectedMonth = now()->format('Y-m');

        $this->getSalaryDetails();
    }

    public function render()
    {
        // Get the current year and month
        $currentYear = date('Y');


        $lastMonth = date('n');

        // Generate options for months from January of the previous year to the current month of the current year
        $options = [];
        $options = [];
        for ($year = $currentYear; $year >= $currentYear - 1; $year--) {
            $startMonth = ($year == $currentYear) ? $lastMonth : 12; // Start from the current month or December
            $endMonth = ($year == $currentYear - 1) ? 1 : 1; // End at January

            for ($month = $startMonth; $month >= $endMonth; $month--) {
                // Format the month to always have two digits
                $monthPadded = sprintf('%02d', $month); // Adds leading zero to single-digit months
                $dateObj = DateTime::createFromFormat('!m', $monthPadded);
                $monthName = $dateObj->format('F');
                $options["$year-$monthPadded"] = "$monthName $year";
            }
        }

        // Example

        // dd( $this->empSalaryDetails);
        // $salaryRevision = new EmpSalaryRevision();

        // Calculate total allowance and deductions
        // $totalGrossPay = 0;
        // $totalDeductions = 0;

        // dd( $totalGrossPay);
        // $this->netPay = $totalGrossPay - $totalDeductions;


        return view('livewire.salary-slips', [
            'employees' => $this->employeeDetails,
            'salaryRevision' => $this->salaryRevision,
            'empBankDetails' => $this->empBankDetails,
            'options' => $options,
            'netPay' => $this->netPay
        ]);
    }
}
