<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assign extends Model
{
    use HasFactory;
      /**
     * The attributes that are mass assignable.
     *	
     * @var array
     */
    protected $fillable = [
        'bus_id', 'location_id_from','location_id_end','assign_date','assign_by'
    ];
    public function bus()
    {
        return $this->belongsTo(Bus::class, 'bus_id');
    }

    public function locationStart()
    {
        return $this->belongsTo(Location::class, 'location_id_from');
    }
    public function locationEnd()
    {
       
        return $this->belongsTo(Location::class, 'location_id_end');
    }
}
