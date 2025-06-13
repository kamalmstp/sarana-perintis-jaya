<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class RentalCosts extends Model
{
    //

    // add fillable
    protected $fillable = [
        'order_detail_id',
        'rental_id',
        'tarif_rental',
        'no_kwitansi',
        'no_surat_jalan',
        'status',
        'pph',
        'note'
    ];
    // add guaded
    protected $guarded = ['id'];
    // add hidden
    protected $hidden = ['created_at', 'updated_at'];

    public function orderDetail(): BelongsTo
    {
        return $this->belongsTo(OrderDetail::class, 'order_detail_id');
    }

    public function rental(): BelongsTo
    {
        return $this->belongsTo(Rental::class, 'rental_id')->withDefault();
    }

    public function getBiayaRentalAttribute(): float
    {
        $qty = $this->orderDetail?->netto ?? 0;
        $tarif = $this->tarif_rental ?? 0;
        
        return $qty * $tarif;
    }
}
