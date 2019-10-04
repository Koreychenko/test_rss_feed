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
    public $timeService;
    /**
     * AuthService constructor.
     * @param Builder $table
     */
    public function __construct(Builder $table, TimeService $timeService)
    {
        $this->table = $table;
        $this->timeService = $timeService;
    }

    /**
     * Generate new token for the specified user
     *
     * @param User $user
     * @return Token
     */
    public function generateToken(User $user)
    {
        $token = new Token();
        $token->setAttribute('user_id', $user->getAttribute('id'));
        $token->setAttribute('token', md5($user->getAttribute('email') . microtime() . rand(0, 100)));
        $this->renewToken($token);
        $token->save();
        return $token;
    }

    /**
     * Update the token
     *
     * @param Token $token
     * @return Token
     * @throws \Exception
     */
    public function renewToken(Token &$token)
    {
        $token->setAttribute('expire', $this->timeService->getDate()->add(new DateInterval('P1D')));
        return $token;
    }

    /**
     * Check is token exist and not expired
     *
     * @param string $token
     * @return bool
     * @throws \Exception
     */
    public function checkToken(string $token)
    {
        if ($token = Token::select()->where('token', $token)->first()) {
            if (new DateTime($token->getAttribute('expire')) < $this->timeService->getDate()) {
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

    /**
     * Delete token
     *
     * @param Token $token
     * @throws \Exception
     */
    public function deleteToken(Token $token)
    {
        $token->delete();
    }


}