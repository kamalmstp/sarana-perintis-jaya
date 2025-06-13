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

    protected static function booted()
    {
        static::created(function ($service) {
            $service->createJournalOnService();
        });
    }

    public function createJournalOnService()
    {
        $journal = JournalEntry::create([
            'date' => $this->date,
            'description' => 'Biaya perawatan ' . $this->trucks->plate_number,
            'reference_type' => self::class,
            'reference_id' => $this->id,
        ]);

        $kas = Account::where('code', '1100')->first(); // Kas
        $biaya = Account::where('code', '5300')->first(); // Biaya Perawatan
        $total = $this->price * $this->qty;

        $journal->lines()->createMany([
            [
                'account_id' => $kas->id,
                'debit' => 0,
                'credit' => $total,
            ],
            [
                'account_id' => $biaya->id,
                'debit' => $total,
                'credit' => 0,
            ],
        ]);
    }
}
