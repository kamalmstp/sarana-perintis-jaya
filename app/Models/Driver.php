<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}
