<?php

namespace App\Models;

use Carbon\Carbon;
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

    protected $fillable = [
      'order_proses_id',
      'truck_id',
      'driver_id',
      'ship_id',
      'shipping_line_id',
      'date_detail',
      'eta',
      'etd',
      'date_muat',
      'date_bongkar',
      'bag_send',
      'bag_received',
      'kg_send',
      'kg_received',
      'bl',
      'bruto',
      'tara',
      'netto',
      'status_detail',
      'note_detail',
      'container_number',
      'seal_number',
      'lock_number',
      'vessel_name',
      'status',
      'selesai_at',
      'is_selesai',
      'segment_type'
    ];
    
    protected $guarded = ['id'];
    
    protected $hidden = ['created_at', 'updated_at'];
    
    public function trucks(): BelongsTo
    {
        return $this->belongsTo(Truck::class, 'truck_id');
    }

    public function drivers(): BelongsTo
    {
        return $this->belongsTo(Driver::class, 'driver_id');
    }

    public function ships(): BelongsTo
    {
        return $this->belongsTo(Ship::class, 'ship_id');
    }

    public function shipping_lines(): BelongsTo
    {
        return $this->belongsTo(ShippingLine::class, 'shipping_line_id');
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

    public function getKirimAttribute()
    {
        $parts = [];

        if ($this->date_muat) {
            $muat = Carbon::parse($this->date_muat)->format('d M Y');
            $parts[] = "Tgl: {$muat}";
        }

        if ($this->kg_send) {
            $kirim = number_format($this->kg_send, 0, ',', '.');
            $parts[] = "Kirim: {$kirim} Kg";
        }
        return implode('<br>', $parts) ?: '—';
    }

    public function getTerimaAttribute()
    {
        $parts = [];

        if ($this->date_bongkar) {
            $bongkar = Carbon::parse($this->date_bongkar)->format('d M Y');
            $parts[] = "Tgl: {$bongkar}";
        }

        if ($this->kg_received) {
            $terima = number_format($this->kg_received, 0, ',', '.');
            $parts[] = "Terima: {$terima} Kg";
        }
        return implode('<br>', $parts) ?: '—';
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

        if ($this->getIsContainerForwardAttribute()) {
            return $tarif * 1;
        } else {
            return $tarif * $netto;
        }
    }

    public function getIsContainerForwardAttribute(): bool
    {
        return $this->order_proses->type_proses === 'container'
            && $this->order_proses->operation_proses === 'teruskan';
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

    public function hasCompleteCost(): bool
    {
        if ($this->trucks?->ownership === 'company') {
            return $this->driverCost && $this->driverCost->uang_sangu !== null;
        }
        if ($this->trucks?->ownership === 'rental') {
            return $this->rentalCost && $this->rentalCost->tarif_rental !== null;
        }

        return false;
    }

}
