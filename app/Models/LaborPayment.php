<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class LaborPayment extends Model
{
    //

    // add fillable
    protected $fillable = [
        'receipt_number',
        'payment_date'
    ];
    // add guaded
    protected $guarded = ['id'];
    // add hidden
    protected $hidden = ['created_at', 'updated_at'];

    // LaborPayment.php
    public function details(): HasMany {
        return $this->hasMany(LaborPaymentDetail::class);
    }
}
