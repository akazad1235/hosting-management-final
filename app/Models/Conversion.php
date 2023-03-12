<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conversion extends Model
{
    use HasFactory;

    protected $guarded = [];


    public function ticket(){
        return $this->belongsTo(Ticket::class, 'ticket_id', 'id');
    }

    /*
     * user info get
     */
    public function customer(){
        return $this->belongsTo(Customer::class);
    }
    public function admin(){
        return $this->belongsTo(Admin::class);
    }
    public function conversionFile(){
        return $this->hasMany(conversionFile::class, 'conversion_id', 'id');
    }

}
