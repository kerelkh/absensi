<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absen extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function getAbsenTimeAttribute(){
        return (new Carbon($this->attributes['absen_time']))->format('d-m-Y H:i:s');
    }
}
