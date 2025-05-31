<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class TruckMaintenance extends Model
{
    //

    // add fillable
    protected $fillable = [
        'name',
        'date',
        'truck_id',
        'qty',
        'price'
    ];
    // add guaded
    protected $guarded = ['id'];
    // add hidden
    protected $hidden = ['created_at', 'updated_at'];

    public function trucks(): BelongsTo
    {
        return $this->belongsTo(Truck::class, 'truck_id');
    }
}
