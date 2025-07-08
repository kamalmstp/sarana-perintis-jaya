<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class OrderProses extends Model
{
    //

    // add fillable
    protected $fillable = [
      'order_id',
      'do_number',
      'po_number',
      'so_number',
      'item_proses',
      'total_kg_proses',
      'total_bag_proses',
      'delivery_location_id',
      'type_proses',
      'tally_proses',
      'tarif',
      'operation_proses',
      'total_container_proses',
      'no_container_proses',
      'lock_number_proses',
      'vessel_name_proses',
      'warehouse_proses',
      'invoice_status',
      'note_proses',
    ];
    // add guaded
    protected $guarded = ['id'];
    // add hidden
    protected $hidden = ['created_at', 'updated_at'];
    
    public function orders(): BelongsTo
    {
      return $this->belongsTo(Order::class, 'order_id');
    }
    
    public function locations(): BelongsTo
    {
        return $this->belongsTo(Location::class, 'delivery_location_id');
    }
    
    public function order_detail(): HasMany
    {
        return $this->hasMany(OrderDetail::class);
    }

    public function laborPaymentDetails(): HasMany
    {
        return $this->hasMany(LaborPaymentDetail::class);
    }

    public function getTotalNettoAttribute()
    {
        return $this->order_detail()->sum('netto');
    }

    public function getCustomLabelAttribute()
    {
        return "{$this->orders->customers->name} - DO: {$this->do_number} / PO: {$this->po_number} / SO: {$this->so_number}";
    }

    public function getCustomNumberAttribute()
    {
        $parts = [];

        if ($this->do_number !== '-') {
            $parts[] = "DO: {$this->do_number}";
        }

        if ($this->po_number) {
            $parts[] = "PO: {$this->po_number}";
        }

        if ($this->so_number) {
            $parts[] = "SO: {$this->so_number}";
        }

        return implode('<br>', $parts) ?: '—';
    }



    public function getStatusAttribute(): string
    {
        $total = $this->order_detail()->count();

        if ($total === 0) {
            return 'belum_dimulai';
        }

        $selesaiCount = $this->order_detail()->where('status', 'selesai')->count();

        if ($selesaiCount === 0) {
            return 'belum_dimulai';
        }

        if ($selesaiCount < $total) {
            return 'dalam_proses';
        }

        return 'selesai';
    }
}
