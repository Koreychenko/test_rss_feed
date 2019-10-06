<?php


class CorrectTokenTest extends App\Tests\TestCase
{
    protected $app;

    protected $token;

    protected $email;

    public function setUp()
    {
        $config = require __DIR__ . '/../../app/config/config.php';
        $this->app = (new App\App($config))->get();

        $email = md5(microtime());

        $this->email = $email;
        $body = [
            'form' => [
                'email' => $email,
                'password' => $email
            ]
        ];

        $request = $this->formatRequest('post', '/api/register', [], $body);
        $response = $this->app->handle($request);
        $response = (string) $response->getBody();
        $this->assertJson($response);

        $response = json_decode($response);
        $token = $response->token;
        $this->assertNotEmpty($token);

        $this->token = $token;
    }

    public function testGetFeed()
    {
        $request = $this->formatRequest('get', '/api/feed', ['x-token' => $this->token]);

        $response = $this->app->handle($request);
        $response = (string) $response->getBody();

        $this->assertJson($response);

        $response = json_decode($response);

        $this->assertObjectHasAttribute('feed', $response);
        $this->assertObjectHasAttribute('mostFrequentWords', $response);
    }

    public function testLogin()
    {
        $body = [
            'form' => [
                'email' => $this->email,
                'password' => $this->email
            ]
        ];

        $request = $this->formatRequest('post', '/api/login', [], $body);
        $response = $this->app->handle($request);
        $response = (string) $response->getBody();
        $this->assertJson($response);

        $response = json_decode($response);
        $token = $response->token;

        $this->assertNotEmpty($token);
    }


    public function testCheckEmail()
    {
        $body = [
            'email' => $this->email,
        ];

        $request = $this->formatRequest('POST', '/api/check-email', [], $body);
        $response = $this->app->handle($request);
        $response = (string) $response->getBody();
        $this->assertJson($response);

        $response = json_decode($response);

        $this->assertEquals(false, $response->valid);

        $body = [
            'email' => md5($this->email),
        ];

        $request = $this->formatRequest('POST', '/api/check-email', [], $body);
        $response = $this->app->handle($request);
        $response = (string) $response->getBody();
        $this->assertJson($response);

        $response = json_decode($response);

        $this->assertEquals(true, $response->valid);
    }

    public function testCallWithExpiredToken()
    {
        /* Change date to future */
        $now = (new DateTime())->add(new DateInterval('P10D'));

        define('FAKE_TIME', $now->format('d.m.Y H:i:s'));

        $request = $this->formatRequest('get', '/api/feed', ['x-token' => $this->token]);

        $response = $this->app->handle($request);
        $response = (string) $response->getBody();

        $this->assertJson($response);

        $this->assertEquals('{"error":"noauth"}', $response);
    }

}