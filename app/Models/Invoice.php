<?php

namespace App\Models;

use App\Models\JournalEntry;
use App\Models\JournalEntryLine;
use App\Models\Account;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class Invoice extends Model
{
    // add fillable
    protected $fillable = [
        'order_id',
        'customer_name',
        'invoice_number',
        'invoice_date',
        'paid_at',
        'due_date',
        'total_amount',
        'pais_amount',
        'status',
        'notes',
        'created_by',
        'pdf_path'
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

    protected static function booted()
    {
        static::created(function ($invoice) {
            $invoice->createJournalOnCreation();
        });

        static::updated(function ($invoice) {
            if ($invoice->wasChanged('paid_at') && $invoice->paid_at) {
                $invoice->createJournalOnPayment();
            }
        });
    }

    public function createJournalOnCreation()
    {
        $journal = JournalEntry::create([
            'date' => $this->invoice_date,
            'description' => 'Tagihan Invoice #' . $this->invoice_number,
            'reference_type' => self::class,
            'reference_id' => $this->id,
        ]);

        $piutang = Account::where('code', '1200')->first(); // Piutang Usaha
        $pendapatan = Account::where('code', '4100')->first(); // Pendapatan Ekspedisi

        $journal->lines()->createMany([
            [
                'account_id' => $piutang->id,
                'debit' => $this->total_amount,
                'credit' => 0,
            ],
            [
                'account_id' => $pendapatan->id,
                'debit' => 0,
                'credit' => $this->total_amount,
            ],
        ]);
    }

    public function createJournalOnPayment()
    {
        $journal = JournalEntry::create([
            'date' => $this->paid_at,
            'description' => 'Pembayaran Invoice #' . $this->invoice_number,
            'reference_type' => self::class,
            'reference_id' => $this->id,
        ]);

        $kas = Account::where('code', '1100')->first(); // Kas
        $piutang = Account::where('code', '1200')->first(); // Piutang Usaha

        $journal->lines()->createMany([
            [
                'account_id' => $kas->id,
                'debit' => $this->total_amount,
                'credit' => 0,
            ],
            [
                'account_id' => $piutang->id,
                'debit' => 0,
                'credit' => $this->total_amount,
            ],
        ]);
    }
}
