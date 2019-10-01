<?php

namespace App\Controllers;

use App\Models\User;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class RegisterController extends AbstractController
{
    public function registerAction(Request $request, Response $response, $args)
    {
            $data = $request->getQueryParams();

            if ((isset($data['email'])) && (isset($data['password']))) {
                $user = new User();
                $user->setAttribute('email', $data['email'])
                    ->setAttribute('password', $data['password'])->save();
            }

            $this->addData('status', 'ok');

        return $this->sendJson($response);
    }

    public function checkEmailAction(Request $request, Response $response, $args)
    {
        $data = $request->getQueryParams();
        if (isset($data['email']) && ($data['email'])) {
            $emailsCount = $this->getTable()->where('email', '=', $data['email'])->count();
            if ($emailsCount) {
                $this->addData('status', 'registered');
            } else {
                $this->addData('status', 'free');
            }
        }
        return $this->sendJson($response);
    }
}