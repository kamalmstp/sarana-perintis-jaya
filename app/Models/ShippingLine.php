<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShippingLine extends Model
{
    protected $fillable = ['name', 'address', 'contact', 'note'];
    // add guaded
    protected $guarded = ['id'];
    // add hidden
    protected $hidden = ['created_at', 'updated_at'];

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class, 'shipping_line_id');
    }
}
