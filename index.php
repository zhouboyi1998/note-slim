<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require __DIR__ . '/vendor/autoload.php';

$app = AppFactory::create();

// 添加路由中间件
$app->addRoutingMiddleware();

// 定义错误处理器
$errorMiddleware = $app->addErrorMiddleware(true, true, true);

// 定义路由
$app->get('/hello/{name}', function (Request $request, Response $response, array $args) {
    // 获取路由参数 name
    $name = $args['name'];

    // 返回的 JSON 数据
    $data = [
        "message" => "Hello, " . htmlspecialchars($name, ENT_QUOTES),
        "code" => 200
    ];

    // 设置响应头
    $response = $response->withHeader('Content-Type', 'application/json');

    // 写入响应体
    $response->getBody()->write(json_encode($data));

    return $response;
});

// 运行应用
$app->run();
