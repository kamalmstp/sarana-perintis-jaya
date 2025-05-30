<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class OrderDetail extends Model
{
    //

    // add fillable
    protected $fillable = [
      'order_proses_id',
      'truck_id',
      'date_detail',
      'bag_send',
      'bag_received',
      'bruto',
      'tara',
      'netto',
      'status_detail',
      'note_detail'
    ];
    // add guaded
    protected $guarded = ['id'];
    // add hidden
    protected $hidden = ['created_at', 'updated_at'];
    
    public function trucks(): BelongsTo
    {
        return $this->belongsTo(Truck::class);
    }
    
    public function order_proses(): BelongsTo
    {
        return $this->belongsTo(OrderProses::class);
    }
}
