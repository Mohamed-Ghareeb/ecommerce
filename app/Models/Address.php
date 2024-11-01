<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $guarded = ['id'];
    
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function geFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }
}
