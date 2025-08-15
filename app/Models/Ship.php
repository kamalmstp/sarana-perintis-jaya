<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ship extends Model
{
    protected $fillable = ['name', 'code', 'type', 'note'];
    // add guaded
    protected $guarded = ['id'];
    // add hidden
    protected $hidden = ['created_at', 'updated_at'];

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class, 'ship_id');
    }
}
