<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Storage;

class OrderDetail extends Model
{
    const STATUS_PENDING = 'pending';
    const STATUS_MENUNGGU_BIAYA = 'menunggu_biaya';
    const STATUS_PROSES = 'proses';
    const STATUS_SELESAI = 'selesai';

    // add fillable
    protected $fillable = [
      'order_proses_id',
      'truck_id',
      'driver_id',
      'date_detail',
      'bag_send',
      'bag_received',
      'bruto',
      'tara',
      'netto',
      'status_detail',
      'note_detail',
      'status',
      'selesai_at',
      'is_selesai'
    ];
    // add guaded
    protected $guarded = ['id'];
    // add hidden
    protected $hidden = ['created_at', 'updated_at'];
    
    public function trucks(): BelongsTo
    {
        return $this->belongsTo(Truck::class, 'truck_id');
    }

    public function drivers(): BelongsTo
    {
        return $this->belongsTo(Driver::class, 'driver_id');
    }
    
    public function order_proses(): BelongsTo
    {
        return $this->belongsTo(OrderProses::class);
    }

    public function driverCost(): HasOne
    {
        return $this->hasOne(DriverCosts::class);
    }

    public function rentalCost(): HasOne
    {
        return $this->hasOne(RentalCosts::class);
    }

    protected static function booted(): void
    {
        static::saving(function ($orderDetail) {
            if (!is_null($orderDetail->bruto) && !is_null($orderDetail->tara)) {
                $orderDetail->netto = $orderDetail->bruto - $orderDetail->tara;
            } else {
                $orderDetail->netto = null;
            }
        });
    }

    public function getTotalBiayaAttribute(): float
    {
        $tarif = $this->order_proses?->tarif ?? 0;
        $netto = $this->bruto - $this->tara;
        
        return $tarif * $netto;
    }

    public static function getStatuses(): array
    {
        return [
            self::STATUS_PENDING => 'Pending',
            self::STATUS_MENUNGGU_BIAYA => 'Menunggu Biaya',
            self::STATUS_PROSES => 'Proses',
            self::STATUS_SELESAI => 'Selesai',
        ];
    }

    // Contoh method untuk update otomatis status berdasarkan kondisi biaya dan selesai_at
    public function updateStatusAutomatically(): void
    {
        if ($this->selesai_at !== null && $this->hasCompleteCost()) {
            $this->status = self::STATUS_SELESAI;
        } elseif ($this->selesai_at === null ) {
            $this->status = self::STATUS_PROSES;
        } else{ 
            $this->status = self::STATUS_MENUNGGU_BIAYA;
        }

        $this->save();
    }

    // Contoh cek biaya sudah lengkap, sesuaikan dengan field cost milikmu
    public function hasCompleteCost(): bool
    {
        if ($this->trucks?->ownership === 'company') {
            return $this->driverCost && $this->driverCost->uang_sangu !== null; // contoh cek
        }
        if ($this->trucks?->ownership === 'rental') {
            return $this->rentalCost && $this->rentalCost->tarif_rental !== null;
        }

        return false;
    }

}
