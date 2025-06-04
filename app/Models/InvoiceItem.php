<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class InvoiceItem extends Model
{
    //

    // add fillable
    protected $fillable = [
        'invoice_id',
        'order_proses_id',
        'description',
        'amount',
    ];
    // add guaded
    protected $guarded = ['id'];
    // add hidden
    protected $hidden = ['created_at', 'updated_at'];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class, 'invoice_id');
    }

    public function order_proses()
    {
        return $this->belongsTo(OrderProses::class, 'order_proses_id');
    }
}
