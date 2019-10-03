<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Token extends Model
{
    public $timestamps = false;
    protected $table = 'token';
    protected $fillable = [
        'token',
        'user_id',
        'expire'
    ];

    public function getUser()
    {
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }
}