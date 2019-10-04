<?php

class APICallsTest extends App\Tests\TestCase
{
    protected $app;

    protected $token;

    public function setUp()
    {
        $config = require __DIR__ . '/../../app/config/config.php';
        $this->app = (new App\App($config))->get();
    }

    public function testGetFeed() {

        /* Get feed without authorization */
        $request = $this->formatRequest('get', '/api/feed');
        $response = $this->getResponse(function() use ($request) {$this->app->run($request);});
        $this->assertJson($response);
        $this->assertEquals('{"error":"noauth"}', $response);
    }

    public function tetGetFeedWrongMethod() {
        /* Get feed using wrong method */
        $request = $this->formatRequest('post', '/api/feed');
        $this->expectException(\Slim\Exception\HttpMethodNotAllowedException::class);
        $this->app->run($request);
    }

    public function testRegisterWithEmptyParameters()
    {
        $request = $this->formatRequest('post', '/api/register');
        $response = $this->getResponse(function() use ($request) {$this->app->run($request);});
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
        $response = $this->getResponse(function() use ($request) {$this->app->run($request);});
        $this->assertJson($response);

        $response = json_decode($response);
        $token = $response->token;

        $this->assertNotEmpty($token);

        $request = $this->formatRequest('get', '/api/feed', ['x-token' => $token]);

        $response = $this->getResponse(function() use ($request) {$this->app->run($request);});

        $this->assertJson($response);

        $response = json_decode($response);

        $this->assertObjectHasAttribute('feed', $response);
        $this->assertObjectHasAttribute('mostFrequentWords', $response);
    }

    public function testRegisterAndLogin()
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
        $response = $this->getResponse(function() use ($request) {$this->app->run($request);});
        $this->assertJson($response);

        $response = json_decode($response);

        $token = $response->token;

        $this->assertNotEmpty($token);

        $request = $this->formatRequest('post', '/api/login', [], $body);
        $response = $this->getResponse(function() use ($request) {$this->app->run($request);});
        $this->assertJson($response);

        $response = json_decode($response);
        $token = $response->token;

        $this->assertNotEmpty($token);
    }

    public function testCheckEmail()
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
        $response = $this->getResponse(function() use ($request) {$this->app->run($request);});
        $this->assertJson($response);

        $response = json_decode($response);

        $token = $response->token;

        $this->assertNotEmpty($token);

        $body = [
            'email' => $email,
        ];

        $request = $this->formatRequest('POST', '/api/check-email', [], $body);
        $response = $this->getResponse(function() use ($request) {$this->app->run($request);});
        $this->assertJson($response);

        $response = json_decode($response);

        $this->assertEquals(false, $response->valid);

        $body = [
            'email' => md5($email),
        ];

        $request = $this->formatRequest('POST', '/api/check-email', [], $body);
        $response = $this->getResponse(function() use ($request) {$this->app->run($request);});
        $this->assertJson($response);

        $response = json_decode($response);

        $this->assertEquals(true, $response->valid);
    }

    public function testCallWithExpiredToken()
    {
        $email = md5(microtime());

        $body = [
            'form' => [
                'email' => $email,
                'password' => $email
            ]
        ];

        $request = $this->formatRequest('post', '/api/register', [], $body);
        $response = $this->getResponse(function() use ($request) {$this->app->run($request);});
        $this->assertJson($response);

        $response = json_decode($response);
        $token = $response->token;
        $this->assertNotEmpty($token);

        /* Change date to future */
        $now = (new DateTime())->add(new DateInterval('P10D'));

        define('FAKE_TIME', $now->format('d.m.Y H:i:s'));

        $request = $this->formatRequest('get', '/api/feed', ['x-token' => $token]);

        $response = $this->getResponse(function() use ($request) {$this->app->run($request);});

        $this->assertJson($response);

        $this->assertEquals('{"error":"noauth"}', $response);

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
        $response = $this->getResponse(function() use ($request) {$this->app->run($request);});
        $this->assertJson($response);

        $response = json_decode($response);
        $token = $response->token;
        $this->assertNotEmpty($token);

        $request = $this->formatRequest('get', '/api/feed', ['x-token' => $token . 'INVALID']);

        $response = $this->getResponse(function() use ($request) {$this->app->run($request);});

        $this->assertJson($response);

        $this->assertEquals('{"error":"noauth"}', $response);
    }

    public function testTimeService()
    {
        $timeService = new \App\Services\TimeService();
        $date = $timeService->getDate();
        $this->assertInstanceOf(\DateTime::class, $date);

        $timeService = new \App\Services\TimeService((new DateTime())->format('d.m.Y H:i:s'));
        $date = $timeService->getDate();
        $this->assertInstanceOf(\DateTime::class, $date);
    }

    public function testTimeServiceWrongDate()
    {
        $date = (new \App\Services\TimeService('WRONG_DATE'))->getDate();
        $this->assertInstanceOf(\DateTime::class, $date);
    }

}