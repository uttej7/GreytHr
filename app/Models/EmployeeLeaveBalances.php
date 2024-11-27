<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
 
class EmployeeLeaveBalances extends Model
{
    use HasFactory;
 
    // Fields that can be mass-assigned
    protected $fillable = [
        'emp_id',
        'leave_scheme',
        'period',
        'status',
        'periodicity',
        'leave_policy_id'
    ];

    protected static function boot()
    {
        parent::boot();
    }
    /**
     * Get the employee associated with the leave balance.
     */
    public function employee()
    {
        return $this->belongsTo(EmployeeDetails::class, 'emp_id', 'emp_id');
    }
 
    /**
     * Get the leave balance for a given year, leave type, and employee.
     *
     * @param string $employeeId
     * @param string $leaveName
     * @param int $year
     * @return int
     */
    public static function getLeaveBalancePerYear($employeeId, $leaveName, $year)
    {
        
        // Retrieve the record for the specific employee and year
        $balance = self::where('emp_id', $employeeId)
        ->where('period', 'like', "%$year%")
            ->first();

            if ($balance) {
                // Decode the JSON leave_policy_id column
                $leavePolicies = is_string($balance->leave_policy_id) ? json_decode($balance->leave_policy_id, true) : $balance->leave_policy_id;
            
                if (is_array($leavePolicies)) {
                    foreach ($leavePolicies as $policy) {
                        // Check if the leave_name matches the specified leave name
                        if (isset($policy['leave_name']) && $policy['leave_name'] == $leaveName) {
                            // Return the grant_days for the specified leave_name
                            return $policy['grant_days'];
                        }
                    }
                }
            }

        // Return 0 if the leave type is not found or if no record exists
        return 0;
    }
 
}

