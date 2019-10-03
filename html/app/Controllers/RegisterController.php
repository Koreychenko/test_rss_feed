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

    public function __construct(
        Builder $table,
        AuthService $authService
    ) {
        $this->table = $table;
        $this->authService = $authService;
    }

    public function registerAction(Request $request, Response $response, $args)
    {
        $data = $this->getJsonData($request);

        if ((isset($data['form']['email'])) && (isset($data['form']['password']))) {

            try {
                $user = new User();
                $user->setAttribute('email', $data['form']['email'])
                    ->setAttribute('password', md5($data['form']['password']))->save();
                $token = $this->authService->generateToken($user);
                $this->addData('token', $token->getAttribute('token'));
            } catch (Exception $e) {
                $this->addError($e->getMessage());
            }

        }

        return $this->sendJson($response);
    }

    public function loginAction(Request $request, Response $response, $args)
    {
        $data = $this->getJsonData($request);

        if ((isset($data['email'])) && (isset($data['password']))) {
            try {
                $user = User::select()->where('email', '=', $data['email'])->where('password', '=',
                    md5($data['password']))->first();
                if ($user) {
                    $token = $this->authService->generateToken($user);
                    $this->addData('token', $token->getAttribute('token'));
                } else {
                    $this->addError('Wrong username or password');
                }
            } catch (Exception $e) {
                $this->addError($e->getMessage());
            }

        }

        return $this->sendJson($response);
    }

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