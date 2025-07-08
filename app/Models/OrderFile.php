<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderFile extends Model
{
    // add fillable
    protected $fillable = ['order_id', 'file_path', 'file_name', 'file_type'];
    // add guaded
    protected $guarded = ['id'];
    // add hidden
    protected $hidden = ['created_at', 'updated_at'];

    public function order()
        {
            return $this->belongsTo(Order::class);
        }
}