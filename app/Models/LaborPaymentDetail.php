<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class LaborPaymentDetail extends Model
{
    //

    // add fillable
    protected $fillable = [
        'labor_payment_id',
        'order_proses_id',
        'qty_kg',
        'tarif_per_kg',
        'total'
    ];
    // add guaded
    protected $guarded = ['id'];
    // add hidden
    protected $hidden = ['created_at', 'updated_at'];

    // LaborPaymentDetail.php
    public function orderProses(): BelongsTo {
        return $this->belongsTo(OrderProses::class, 'order_proses_id');
    }

    public function laborPayment(): BelongsTo {
        return $this->belongsTo(LaborPayment::class, 'labor_payment_id');
    }
}
