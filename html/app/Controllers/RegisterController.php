<?php

namespace App\Controllers;

use App\Models\User;
use App\Services\AuthService;
use Illuminate\Database\Query\Builder;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use Exception;

class RegisterController extends AbstractController
{

    protected $table;
    protected $authService;

    /**
     * RegisterController constructor.
     * @param Builder $table
     * @param AuthService $authService
     */
    public function __construct(
        Builder $table,
        AuthService $authService
    ) {
        $this->table = $table;
        $this->authService = $authService;
    }

    /**
     *
     * Register User callback
     *
     * @param Request $request
     * @param Response $response
     * @param $args
     * @return \Psr\Http\Message\MessageInterface|\Slim\Psr7\Message
     */
    public function registerAction(Request $request, Response $response, $args)
    {
        $data = $request->getParsedBody();

        try {
            $user = new User();
            $user->validate($data['form']);
            $user->setAttribute('email', $data['form']['email'])
                ->setAttribute('password', md5($data['form']['password']))->save();
            $token = $this->authService->generateToken($user);
            $this->addData('token', $token->getAttribute('token'));
        } catch (Exception $e) {
            $this->addError($e->getMessage());
        }

        return $this->sendJson($response);
    }

    /**
     *
     * Login User callback
     *
     * @param Request $request
     * @param Response $response
     * @param $args
     * @return \Psr\Http\Message\MessageInterface|\Slim\Psr7\Message
     */
    public function loginAction(Request $request, Response $response, $args)
    {
        $data = $request->getParsedBody();

        if ((isset($data['form']['email'])) && (isset($data['form']['password']))) {
            try {
                $user = User::select()->where('email', '=', $data['form']['email'])->where('password', '=',
                    md5($data['form']['password']))->first();
                if ($user) {
                    $token = $this->authService->generateToken($user);
                    $this->addData('token', $token->getAttribute('token'));
                } else {
                    $this->addError('Wrong email or password');
                }
            } catch (Exception $e) {
                $this->addError($e->getMessage());
            }
        } else {
            $this->addError('Please provide both email and password');
        }

        return $this->sendJson($response);
    }

    /**
     *
     * Check email callback
     *
     * @param Request $request
     * @param Response $response
     * @param $args
     * @return \Psr\Http\Message\MessageInterface|\Slim\Psr7\Message
     */
    public function checkEmailAction(Request $request, Response $response, $args)
    {
        $data = $request->getParsedBody();
        if (isset($data['email']) && ($data['email'])) {
            $emailsCount = $this->getTable()->where('email', '=', $data['email'])->count();
            if ($emailsCount) {
                $this->addData('valid', false);
            } else {
                $this->addData('valid', true);
            }
        }
        return $this->sendJson($response);
    }

    /**
     * @return Builder
     */
    public function getTable(): Builder
    {
        return $this->table;
    }
}