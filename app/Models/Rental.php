<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class Rental extends Model
{
    //

    // add fillable
    protected $fillable = [
        'name',
        'npwp',
    ];
    // add guaded
    protected $guarded = ['id'];
    // add hidden
    protected $hidden = ['created_at', 'updated_at'];

    public function rentalCost(): HasMany
    {
        return $this->hasMany(RentalCosts::class);
    }
}
