<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class conversionFile extends Model
{
    use HasFactory;

    protected $fillable = ['conversion_id','file'];

    public function getFilePathAttribute(){
        if(!empty($this->attributes['file'])){
            return asset('storage/'.$this->attributes['file']);
        }
    }
}
