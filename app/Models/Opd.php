<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Opd extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    // public function scopeFilter($query, array $filters) {
    //     $query->when($filters['search'], function($query, $search){
    //         $query->where('opd_name', 'LIKE', '%' . $search . '%');
    //     });
    // }

    public function user() {
        return $this->hasMany(User::class);
    }

}
