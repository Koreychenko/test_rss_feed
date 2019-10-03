<?php


namespace App\Controllers\Middlewares;


use App\Services\AuthService;
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

    protected $table;

    /**
     * @var AuthService $authService ;
     */
    protected $authService;

    public function __construct(
        Container $container
    ) {
        $this->table = $container->get('db')->table('token');
        $this->authService = $container->get(AuthService::class);
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
        $token = $request->getHeaderLine('x-token');
        if ((!$token) || (!$this->authService->checkToken($token))) {
            $response = (new ResponseFactory)->createResponse();
            $responseData = ['error' => 'noauth'];
            $payload = json_encode($responseData);

            $response->getBody()->write($payload);
            return $response
                ->withHeader('Content-Type', 'application/json');
        }

        return $handler->handle($request);
    }

}