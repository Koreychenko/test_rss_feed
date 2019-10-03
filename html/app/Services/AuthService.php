<?php


namespace App\Services;


use App\Models\Token;
use App\Models\User;
use Illuminate\Database\Query\Builder;
use DateTime;
use DateInterval;

class AuthService
{
    public $table;

    public function __construct(Builder $table)
    {
        $this->table = $table;
    }

    public function generateToken(User $user)
    {
        $token = new Token();
        $token->setAttribute('user_id', $user->getAttribute('id'));
        $token->setAttribute('token', md5($user->getAttribute('email') . time()));
        $this->renewToken($token);
        $token->save();
        return $token;
    }

    public function renewToken(Token &$token)
    {
        $token->setAttribute('expire', (new DateTime())->add(new DateInterval('P1D')));
        return $token;
    }

    public function checkToken(string $token)
    {
        if ($token = Token::select()->where('token', $token)->first()) {
            if (new DateTime($token->getAttribute('expire')) < new DateTime()) {
                $this->deleteToken($token);
                return false;
            } else {
                $this->renewToken($token);
                $token->save();
                return true;
            }
        }
        return false;
    }

    public function deleteToken(Token $token)
    {
        $token->delete();
    }


}