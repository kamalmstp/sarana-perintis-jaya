<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

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

    public function order_detail(): HasMany
    {
        return $this->hasMany(OrderDetail::class);
    }

    public function truck_maintenance(): HasMany
    {
        return $this->hasMany(TruckMaintenance::class);
    }
}
