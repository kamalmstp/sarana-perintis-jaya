<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class Driver extends Model
{
    //

    // add fillable
    protected $fillable = [
      'name',
      'identity_number',
      'phone',
      'type',
      'status',
      'note'
    ];
    protected $casts = [
      'type' => 'string',
      'status' => 'string',
    ];
    // add guaded
    protected $guarded = ['id'];
    // add hidden
    protected $hidden = ['created_at', 'updated_at'];

    public function order_detail(): HasMany
    {
        return $this->hasMany(OrderDetail::class);
    }
}
