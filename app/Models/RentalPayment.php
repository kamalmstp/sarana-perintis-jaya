<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class RentalPayment extends Model
{
    //

    // add fillable
    protected $fillable = [
        'rental_id',
        'payment_date',
        'receipt_number',
        'total_amount'
    ];
    // add guaded
    protected $guarded = ['id'];
    // add hidden
    protected $hidden = ['created_at', 'updated_at'];

    public function rental()
    {
        return $this->belongsTo(Rental::class, 'rental_id');
    }

    public function rentalCosts(): BelongsToMany
    {
        return $this->belongsToMany(RentalCosts::class, 'rental_costs_rental_payment');
    }
}
