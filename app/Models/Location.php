<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class Location extends Model
{
    //

    // add fillable
    protected $fillable = [
      'name',
      'address',
      'note',
      'latitude',
      'longitude'
    ];
    // add guaded
    protected $guarded = ['id'];
    // add hidden
    protected $hidden = ['created_at', 'updated_at'];
    
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
    
    public function order_proses(): HasMany
    {
        return $this->hasMany(OrderProses::class);
    }
}
