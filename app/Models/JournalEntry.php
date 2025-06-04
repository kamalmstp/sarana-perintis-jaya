<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class JournalEntry extends Model
{
    //

    // add fillable
    protected $fillable = [
        'date',
        'description',
        'reference_type',
        'reference_id',
        'posted',
    ];
    // add guaded
    protected $guarded = ['id'];
    // add hidden
    protected $hidden = ['created_at', 'updated_at'];

    public function lines(): HasMany
    {
        return $this->hasMany(JournalEntryLine::class);
    }

    public function reference(): MorphTo
    {
        return $this->morphTo();
    }

    protected static function booted()
    {
        static::saving(function ($entry) {
            $debit = $entry->lines->sum('debit');
            $credit = $entry->lines->sum('credit');

            if ($debit != $credit) {
                throw ValidationException::withMessages(['lines' => 'Debit dan kredit harus seimbang']);
            }
        });
    }
}
