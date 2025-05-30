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
}
