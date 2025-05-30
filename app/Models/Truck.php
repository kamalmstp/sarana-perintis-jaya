<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Truck extends Model
{
    //

    // add fillable
    protected $fillable = [
      'plate_number',
      'ownership',
      'notes'
      ];

    // add guaded
    protected $guarded = ['id'];
    // add hidden
    protected $hidden = ['created_at', 'updated_at'];
    
    // Format plat nomor otomatis
    public function setPlateNumberAttribute($value)
    {
        $this->attributes['plate_number'] = strtoupper($value);
    }
}
