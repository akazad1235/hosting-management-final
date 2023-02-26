<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function conversion(){
        return $this->hasOne(Conversion::class);
    }
    public function customer(){
        return $this->belongsTo(Customer::class);
    }
}
