<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
 
class HelpDesks extends Model
{
    use HasFactory;
    protected $fillable=[
        'emp_id', 'category', 'subject', 'description', 'file_path','mime_type','file_name', 'cc_to', 'priority','status','mail','mobile','distributor_name','selected_equipment','request_id'
     ];
    public function emp()
    {
        return $this->belongsTo(EmployeeDetails::class, 'emp_id', 'emp_id');
    }
    public function request()
    {
        return $this->belongsTo(Request::class, 'emp_id');// Update the foreign key as necessary
    }
 // HelpDesks Model
 public function incidentRequests()
 {
     return $this->hasMany(IncidentRequest::class, 'incident_id', 'emp_id');
 }
 // In HelpDesks model (HelpDesks.php)
// In HelpDesks model (HelpDesks.php)
public function status()
{
    return $this->belongsTo(StatusType::class, 'status_code', 'status_code');
}


    public function isImage()
    {
        return 'data:image/jpeg;base64,' . base64_encode($this->attributes['file_path']);
    }
    public function getImageUrlAttribute()
    {
        return $this->file_path ? 'data:image/jpeg;base64,' . base64_encode($this->file_path) : null;
    }

}