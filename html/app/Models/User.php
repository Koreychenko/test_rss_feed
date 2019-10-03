<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    public $timestamps = false;
    protected $table = 'users';
    protected $fillable = [
        'email',
        'password'
    ];
    protected $hiddden = [
        'password'
    ];

    public function validate($data) {
        if (!(($data['email']) && ($data['password']))) {
            throw new \Exception('Invalid email or password');
        }
    }
}