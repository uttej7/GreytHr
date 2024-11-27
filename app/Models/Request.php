<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    use HasFactory;
    protected $fillable = ['emp_id','category', 'request'];
    public function helpDesks()
    {
        return $this->hasMany(HelpDesks::class);
    }
    public function serviceRequest()
    {
        return $this->belongsTo(ServiceRequest::class);
    }

    /**
     * Define a relationship with the IncidentRequest model.
     */
    public function incidentRequest()
    {
        return $this->belongsTo(IncidentRequest::class);
    }
}
