<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Vinkla\Hashids\Facades\Hashids;
use Illuminate\Support\Facades\Log;

class EmpSalary extends Model
{
    use HasFactory;

    protected $fillable = ['sal_id', 'bank_id', 'salary', 'effective_date', 'remarks', 'month_of_sal'];
    protected $appends = ['basic', 'hra', 'medical', 'special', 'conveyance', 'pf'];

    private $decodedSalary = null; // Cache decoded salary for repeated calculations

    /**
     * Set and encode salary before saving.
     */
    public function setSalaryAttribute($value)
    {
        $decimalPlaces = strpos($value, '.') !== false ? strlen(substr(strrchr($value, "."), 1)) : 0;
        $factor = pow(10, $decimalPlaces);
        $this->attributes['salary'] = Hashids::encode(intval($value * $factor), $decimalPlaces);
    }

    /**
     * Decode salary for calculations and cache the result.
     */
    public function getDecodedSalary()
    {
        if ($this->decodedSalary === null) {
            $decoded = Hashids::decode($this->attributes['salary']);
            if (count($decoded) === 0) {
                // If decoding fails, return 0
                $this->decodedSalary = 0;
            } else {
                $integerValue = $decoded[0];
                $decimalPlaces = $decoded[1] ?? 0;
                $this->decodedSalary = $integerValue / pow(10, $decimalPlaces);
            }
        }
        return $this->decodedSalary;
    }

    /**
     * Define relationship with EmpSalaryRevision.
     */
    public function salaryRevision()
    {
        return $this->belongsTo(EmpSalaryRevision::class, 'sal_id');
    }

    /**
     * Salary breakdown attributes.
     */
    public function getBasicAttribute()
    {
        return $this->getDecodedSalary() > 0 ? $this->calculatePercentageOfSalary(0.4) : 0;
    }

    public function getHraAttribute()
    {
        return $this->basic > 0 ? $this->basic * 0.4 : 0;
    }

    public function getMedicalAttribute()
    {
        return 1250;
    }

    public function getConveyanceAttribute()
    {
        return 1600;
    }

    public function getSpecialAttribute()
    {
        $totalDeductions = $this->basic + $this->hra + $this->conveyance + $this->medical + $this->pf;
        return $this->getDecodedSalary() > 0 ? max($this->getDecodedSalary() - $totalDeductions, 0) : 0;
    }

    public function getPfAttribute()
    {
        return $this->basic > 0 ? $this->calculatePercentageOfBasic(0.12) : 0;
    }

    public function calculateEsi()
    {
        return $this->basic > 0 ? $this->calculatePercentageOfBasic(0.0075) : 0;
    }

    public function calculateProfTax()
    {
        return 150;
    }

    public function calculateTotalDeductions()
    {
        return $this->pf + $this->calculateEsi() + $this->calculateProfTax();
    }

    public function calculateTotalAllowance()
    {
        return $this->basic + $this->hra + $this->conveyance + $this->medical + $this->special;
    }

    /**
     * Helper methods.
     */
    private function calculatePercentageOfSalary($percentage)
    {
        return $this->getDecodedSalary() > 0 ? $this->getDecodedSalary() * $percentage : 0;
    }

    private function calculatePercentageOfBasic($percentage)
    {
        return $this->basic > 0 ? $this->basic * $percentage : 0;
    }

    /**
     * Get employee salary by employee ID.
     */
    public function getEmployeeByEmpId($emp_id)
    {
        return $this->where('emp_id', $emp_id)->first();
    }

    public function decodedSalary($value)
    {
        return $value ? $this->decodeCTC($value) : 0;
    }
    public function calculateSalaryComponents($value)
    {
        $gross = $value ? $this->decodeCTC($value) : 0;
        // $gross=20853;

        // Calculate each component
        $basic =round($gross * 0.4200,2); // 41.96%
        $hra =round($gross * 0.168,2);// 16.8%
        $conveyance = round($gross * 0.0767,2); // 7.67%
        $medicalAllowance = round($gross * 0.0600,2); // 5.99%
        $specialAllowance = round($gross * 0.275,2); // 27.5%

        $pf = round($gross * 0.0504,2); // 5.04%
        $esi = round($gross * 0.00753,2); // 0.753%
        $professionalTax = round($gross * 0.0096,2); // 0.96%

        // Calculate total deductions
        $totalDeductions =round( $pf + $esi + $professionalTax,2); //6.753%

        // Calculate total
        $total = round($basic + $hra + $conveyance + $medicalAllowance + $specialAllowance,2);

        // Return all components and total
        return [
            'basic' => $basic,
            'hra' => $hra,
            'conveyance' => $conveyance,
            'medical_allowance' => $medicalAllowance,
            'special_allowance' => $specialAllowance,
            'earnings' => $total,
            'gross'=> $gross,
            'pf' => $pf,
            'esi' => $esi,
            'professional_tax' => $professionalTax,
            'total_deductions' => $totalDeductions,
            'net_pay'=> $total- $totalDeductions
        ];
    }

    private function decodeCTC($value)
    {
        Log::info('Decoding CTC: ' . $value);
        $decoded = Hashids::decode($value);

        if (count($decoded) === 0) {
            return 0;
        }

        $integerValue = $decoded[0];
        $decimalPlaces = $decoded[1] ?? 0;

        return $integerValue / pow(10, $decimalPlaces);
    }
}
