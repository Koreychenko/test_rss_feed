<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Exception;

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

    /**
     * Simple parameters validation
     *
     * @param $data
     * @throws \Exception
     */
    public function validate($data) {
        if (!(($data['email']) && ($data['password']))) {
            throw new Exception('Invalid email or password');
        }
    }
}