<?php

declare(strict_types=1);

use App\Application\Actions\Calculator\CalcAction;
use App\Application\Actions\Calculator\CalculateAction;
use App\Application\Actions\Calculator\EquationAction;
use App\Application\Actions\User\ListUsersAction;
use App\Application\Actions\User\ViewUserAction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

return function (App $app) {
    $app->options('/{routes:.*}', function (Request $request, Response $response) {
        // CORS Pre-Flight OPTIONS Request Handler
        return $response;
    });

    $app->get('/', function (Request $request, Response $response) {
        $response->getBody()->write('Xin chao');
        return $response;
    })->setName('hello');


    // $app->get('/xinchao', function (Request $request, Response $response) {
    //     $response->getBody()->write('Xin chao cac ban');
    //     return $response;
    // });

    $app->get('/xinchao[/{lang}[/{name}]]', function (Request $request, Response $response, array $args) {

        if (array_key_exists('lang', $args) && $args['lang'] === 'vi') {
            $welcomeMessage = "Xin chao cac ban";
        } else {
            $welcomeMessage = "Hello everyone!";
        }

        $response->getBody()->write($welcomeMessage);
        return $response;
    });

    $app->post('/product/{productId:[1-9]{1}[0-9]*}', function (Request $request, Response $response, array $args) {

        $productId = intval($args['productId']);

        if (array_key_exists('productId', $args)) {
            $output = "Đang xem sản phẩm $productId";
        }

        $tinhTrang = "con hang";
        if ($productId < 10) {
            $tinhTrang = "het hang";
        }

        $response->getBody()->write("$output : $tinhTrang");
        return $response;
    });


    $app->get('/{a:[0-9]+}/{pheptinh:cong|tru|nhan|chia}/{b:[0-9]+}', function (Request $request, Response $response, array $args) {

        $a = intval($args['a']);
        $pheptinh = $args['pheptinh'];
        $b = intval($args['b']);

        switch ($pheptinh) {
            case 'cong':
                $kq = $a + $b;
                break;
            case 'tru':
                $kq = $a - $b;
                break;
            case 'nhan':
                $kq = $a * $b;
                break;
            case 'chia':
                $kq = $a / $b;
                break;
            default:
                $kq = '?';
        }

        $response->getBody()->write("Ket qua la: $kq");
        return $response;
    });

    $app->post('/test', CalculateAction::class);

    $app->group(
        '/test1',
        function (Group $group) {

            $group->get('', function (Request $request, Response $response) {
                $response->getBody()->write('Xin chao');
                return $response;
            });

            $group->get('/family', function (Request $request, Response $response) {
                $response->getBody()->write('Xin chao 2 me con');
                return $response;
            });
        }
    );

    $app->post("/myaction", CalcAction::class);

    $app->post("/equation", EquationAction::class);

    $app->get("/posts", function (Request $request, Response $response, array $args) {

        try {
            $db = $this->get(PDO::class);

            $sth = $db->prepare("SELECT * FROM posts");
            $sth->execute();

            $data = $sth->fetchAll(PDO::FETCH_CLASS);

            $payload = json_encode($data);
            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json');
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    });

    $app->get("/posts/{postId}", function (Request $request, Response $response, array $args) {

        $postId = $args['postId'];

        try {
            $db = $this->get(PDO::class);

            $sth = $db->prepare("SELECT * FROM posts WHERE id = ?");
            $sth->execute([$postId]);

            $data = $sth->fetchAll(PDO::FETCH_CLASS);

            $payload = json_encode($data);
            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json');
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    });

    $app->post("/posts", function (Request $request, Response $response, array $args) {

        try {
            $db = $this->get(PDO::class);

            // $db->exec("INSERT INTO posts ( title, content, category_id) VALUES ( 'abc', 'abc', 1)");

            $sth = $db->prepare("SELECT * FROM posts WHERE id < 10");
            $sth->execute();

            $data = $sth->fetchAll(PDO::FETCH_CLASS);

            $payload = json_encode($data);
            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json');
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    });

    $app->put("/posts/{postId}", function (Request $request, Response $response, array $args) {

        try {
            $db = $this->get(PDO::class);

            // $db->exec("INSERT INTO posts ( title, content, category_id) VALUES ( 'abc', 'abc', 1)");

            $sth = $db->prepare("SELECT * FROM posts WHERE id < 10");
            $sth->execute();

            $data = $sth->fetchAll(PDO::FETCH_CLASS);

            $payload = json_encode($data);
            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json');
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    });

    $app->delete("/posts/{postId}", function (Request $request, Response $response, array $args) {

        try {
            $db = $this->get(PDO::class);

            // $db->exec("INSERT INTO posts ( title, content, category_id) VALUES ( 'abc', 'abc', 1)");

            $sth = $db->prepare("SELECT * FROM posts WHERE id < 10");
            $sth->execute();

            $data = $sth->fetchAll(PDO::FETCH_CLASS);

            $payload = json_encode($data);
            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json');
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    });

    $app->delete("/posts/maxComment", function (Request $request, Response $response, array $args) {

        try {
            $db = $this->get(PDO::class);

            $sth = $db->prepare("SELECT * FROM posts WHERE id < 10");
            $sth->execute();

            $data = $sth->fetchAll(PDO::FETCH_CLASS);

            $payload = json_encode($data);
            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json');
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    });
};
