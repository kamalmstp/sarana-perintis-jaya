<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class Invoice extends Model
{
    //

    // add fillable
    protected $fillable = [
        'order_id',
        'customer_name',
        'invoice_number',
        'invoice_date',
        'due_date',
        'total_amount',
        'status',
        'notes',
        'created_by'
    ];
    // add guaded
    protected $guarded = ['id'];
    // add hidden
    protected $hidden = ['created_at', 'updated_at'];

    public function getSubTotalAttribute(): float
    {
        return $this->items->sum(function ($item){
            $tarif = $item->order_proses?->tarif ?? 0;
            return $tarif;
        });
    }

    public function items()
    {
        return $this->hasMany(InvoiceItem::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
}
