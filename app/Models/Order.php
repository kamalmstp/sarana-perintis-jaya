<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class Order extends Model
{
    
    protected $fillable = [
      'customer_id',
      'spk_number',
      'spk_date',
      'delivery_term',
      'is_antar_pulau',
      'item',
      'period',
      'total_kg',
      'total_bag',
      'loading_location_id',
      'note',
    ];
    // add guaded
    protected $guarded = ['id'];
    // add hidden
    protected $hidden = ['created_at', 'updated_at'];
    
    public function order_proses(): HasMany
    {
        return $this->hasMany(OrderProses::class);
    }

    public function files()
    {
        return $this->hasMany(OrderFile::class);
    }

    public function getFormattedFilesAttribute()
    {
        return $this->files->map(function ($file) {
            return [
                'id' => $file->id,
                'type' => $file->file_type,
                'path' => $file->file_path,
            ];
        })->values()->toArray();
    }
    
    public function customers(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
    
    public function locations(): BelongsTo
    {
        return $this->belongsTo(Location::class, 'loading_location_id');
    }

    public function getStatusAttribute(): string
    {
        $total = $this->order_proses()->count();

        if ($total === 0) {
            return 'draft';
        }

        $selesaiCount = $this->order_proses->filter(fn ($do) => $do->status === 'selesai')->count();

        if ($selesaiCount === 0) {
            return 'proses';
        }

        if ($selesaiCount < $total) {
            return 'selesai_sebagian';
        }

        return 'selesai';
    }
}
