<?php

use App\Services\TimeService;
use Slim\Exception\HttpMethodNotAllowedException;

class APICallsTest extends App\Tests\TestCase
{
    protected $app;

    public function setUp()
    {
        $config = require __DIR__ . '/../../app/config/config.php';
        $this->app = (new App\App($config))->get();
    }

    public function testGetFeedNoToken()
    {

        /* Get feed without authorization */
        $request = $this->formatRequest('get', '/api/feed');
        $response = $this->app->handle($request);
        $response = (string)$response->getBody();
        $this->assertJson($response);
        $this->assertEquals('{"error":"noauth"}', $response);
    }

    public function tetGetFeedWrongMethod()
    {
        /* Get feed using wrong method */
        $request = $this->formatRequest('post', '/api/feed');
        $this->expectException(HttpMethodNotAllowedException::class);
        $this->app->run($request);
    }

    public function testRegisterWithEmptyParameters()
    {
        $request = $this->formatRequest('post', '/api/register');
        $response = $this->app->handle($request);
        $response = (string)$response->getBody();
        $this->assertJson($response);
        $this->assertEquals('{"errors":["Invalid email or password"]}', $response);
    }

    public function testRegisterWithCorrectParameters()
    {
        /* Get feed using wrong method */
        $email = md5(microtime());

        $body = [
            'form' => [
                'email' => $email,
                'password' => $email
            ]
        ];

        $request = $this->formatRequest('post', '/api/register', [], $body);
        $response = $this->app->handle($request);
        $response = (string)$response->getBody();
        $this->assertJson($response);

        $response = json_decode($response);
        $token = $response->token;

        $this->assertNotEmpty($token);
    }

    public function testCallWithInvalidToken()
    {
        $email = md5(microtime());

        $body = [
            'form' => [
                'email' => $email,
                'password' => $email
            ]
        ];

        $request = $this->formatRequest('post', '/api/register', [], $body);
        $response = $this->app->handle($request);
        $response = (string)$response->getBody();
        $this->assertJson($response);

        $response = json_decode($response);
        $token = $response->token;
        $this->assertNotEmpty($token);

        $request = $this->formatRequest('get', '/api/feed', ['x-token' => $token . 'INVALID']);

        $response = $this->app->handle($request);
        $response = (string)$response->getBody();

        $this->assertJson($response);

        $this->assertEquals('{"error":"noauth"}', $response);
    }

    public function testTimeService()
    {
        $timeService = new TimeService();
        $date = $timeService->getDate();
        $this->assertInstanceOf(DateTime::class, $date);

        $timeService = new TimeService((new DateTime())->format('d.m.Y H:i:s'));
        $date = $timeService->getDate();
        $this->assertInstanceOf(DateTime::class, $date);
    }

    public function testTimeServiceWrongDate()
    {
        $date = (new TimeService('WRONG_DATE'))->getDate();
        $this->assertInstanceOf(DateTime::class, $date);
    }

}