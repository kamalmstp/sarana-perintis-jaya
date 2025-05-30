<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class Customer extends Model
{
    //

    // add fillable
    protected $fillable = [
      'name',
      'code',
      'pic_name',
      'pic_phone',
      'pic_email',
      'address',
      'note'
    ];
    // add guaded
    protected $guarded = ['id'];
    // add hidden
    protected $hidden = ['created_at', 'updated_at'];
    
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
