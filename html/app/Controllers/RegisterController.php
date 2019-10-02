<?php

namespace App\Controllers;

use App\Models\User;
use Illuminate\Database\Query\Builder;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class RegisterController extends AbstractController
{

    protected $table;

    public function __construct(
        Builder $table
    ) {
        $this->table = $table;
    }

    /**
     * @return Builder
     */
    public function getTable(): Builder
    {
        return $this->table;
    }

    public function registerAction(Request $request, Response $response, $args)
    {
        $data = $this->getJsonData($request);

        if ((isset($data['form']['email'])) && (isset($data['form']['password']))) {

            try {
                $user = new User();
                $user->setAttribute('email', $data['form']['email'])
                    ->setAttribute('password', $data['form']['password'])->save();
                $this->addData('token', 'ok');
            } catch (\Exception $e) {
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
                $login = $this->getTable()->where('email', '=', $data['email'])->where('password', '=', md5($data['password']))->count();
                if ($login) {
                    $this->addData('status', 'ok');
                } else {
                    $this->addError('Wrong username or password');
                }
            } catch (\Exception $e) {
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
}