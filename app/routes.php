<?php

declare(strict_types=1);

use App\Application\Actions\Auth\LoginAction;
use App\Application\Actions\Auth\LogoutAction;
use App\Application\Actions\Calculator\CalcAction;
use App\Application\Actions\Calculator\CalculateAction;
use App\Application\Actions\Calculator\EquationAction;
use App\Application\Actions\Category\AddCategoryAction;
use App\Application\Actions\Category\DeleteCategoryAction;
use App\Application\Actions\Category\DetailCategoryAction;
use App\Application\Actions\Category\ListCategoryAction;
use App\Application\Actions\Category\UpdateCategoryAction;
use App\Application\Actions\FileUpload\DownloadImageAction;
use App\Application\Actions\FileUpload\UploadImageAction;
use App\Application\Actions\Image\DownImageAction;
use App\Application\Actions\Image\UpImageAction;
use App\Application\Actions\Posts\AddPostAction;
use App\Application\Actions\Posts\DeletePostAction;
use App\Application\Actions\Posts\GetAllPostAction;
use App\Application\Actions\Posts\GetDetailPostAction;
use App\Application\Actions\Posts\UpdatePostAction;
use App\Application\Middleware\AdminMiddleware;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;
use Slim\Psr7\Stream;

return function (App $app) {
    $app->options('/{routes:.*}', function (Request $request, Response $response) {
        // CORS Pre-Flight OPTIONS Request Handler
        return $response;
    });

    $app->get('/', function (Request $request, Response $response) {
        $response->getBody()->write('Xin chao');
        return $response;
    })->setName('hello');

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

    $app->get("/posts", GetAllPostAction::class);
    $app->get("/posts/{postId:[0-9]+}", GetDetailPostAction::class)->add(AdminMiddleware::class);;
    $app->post("/posts", AddPostAction::class);
    $app->post("/posts/{postId:[0-9]+}", UpdatePostAction::class);
    $app->get("/posts/{postId:[0-9]+}/delete", DeletePostAction::class);

    $app->get("/posts/maxComment", function (Request $request, Response $response, array $args) {

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

    $app->get("/categories", ListCategoryAction::class);
    $app->get("/category/{catId}", DetailCategoryAction::class);
    $app->post("/category", AddCategoryAction::class);
    $app->post("/category/{catId:[0-9]+}/update", UpdateCategoryAction::class);
    $app->get("/category/{catId}/delete", DeleteCategoryAction::class);

    $app->get("/category/{catId}/post/{postId}", DetailCategoryAction::class);

    $app->post("/login", LoginAction::class);
    $app->get("/logout", LogoutAction::class);

    $app->post("/uploadImage", UploadImageAction::class);
    $app->get("/downloadImage", DownloadImageAction::class);

    $app->group("/image", function ($group) {
        $group->get("/download", DownImageAction::class);
        $group->post("/upload", UpImageAction::class);
    });


    $app->get("/static/{filetype}/{filename}", function (Request $request, Response $response, array $args) {
        $filename = $args['filename'];
        $filetype = $args['filetype'];
        $directory = __DIR__ . "/../public/static";
        $path = $directory . "/$filetype/$filename";

        if (file_exists($path)) {
            $fh = fopen($path, 'rb');
            $file_stream = new Stream($fh);

            return $response->withBody($file_stream);
        }
        return $response->withStatus(404, "File not found");
    });
};
