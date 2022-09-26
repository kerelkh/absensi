<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'password',
        'role_id',
        'validation',
        'created_by',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function scopeFilter($query, array $filters) {
        $query->when($filters['search'], function($query, $search){
            $query->where('email', 'LIKE', '%' . $search . '%')
                ->orWhere('name', 'LIKE', '%' . $search . '%')
                ->orWhere('nip', 'LIKE', '%' . $search . '%');
        });
    }

    public function scopeFilterOpd($query, array $filters) {
        $query->when($filters['id'], function($query, $id) {
            $query->whereHas('useronopd', function($query) use ($id) {
                $query->where('opd_id', $id);
            } );
        });
    }

    public function scopeFilterValid($query, array $filters) {
        $query->when($filters['valid'], function($query, $valid) {
            $query->whereHas('useronopd', function($query) use ($valid) {
                if($valid == 'valid'){
                    $query->where('valid', 1);
                }else{
                    $query->where('valid', 0);
                }
            });
        });
    }


    public function role() {
        return $this->belongsTo(Role::class, 'role_id', 'id');
    }

    public function opd(){
        return $this->hasOne(UserOnOpd::class);
    }

    public function userDetail(){
        return $this->hasOne(UserDetail::class);
    }

}
