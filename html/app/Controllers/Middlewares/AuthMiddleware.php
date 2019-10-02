<?php


namespace App\Controllers\Middlewares;


use Illuminate\Container\Container;
use Illuminate\Database\Query\Builder;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Tuupola\Http\Factory\ResponseFactory;
use Tuupola\Middleware\DoublePassTrait;

class AuthMiddleware implements MiddlewareInterface
{
    use DoublePassTrait;

    public $options;

    protected $table;

    public function __construct(
        Container $container, $options
    ) {
        $this->table = $container->get('db')->table('token');
        $this->options = $options;
    }

    /**
     * @return Builder
     */
    public function getTable(): Builder
    {
        return $this->table;
    }

    /**
     * Execute as PSR-15 middleware.
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if (!in_array($request->getUri()->getPath(), $this->options['exclude'])) {
            $token = $request->getHeader('x-token');

            if ((!$token) || (!$this->checkToken($token))) {
                $response = (new ResponseFactory)->createResponse();
                $responseData = ['error' => 'noauth'];
                $payload = json_encode($responseData);

                $response->getBody()->write($payload);
                return $response
                    ->withHeader('Content-Type', 'application/json');
            }
        }

        return $handler->handle($request);
    }

    public function checkToken($token) {
        $token = $this->table->where('token', '=', $token)->first();
        return ($token);
    }

}