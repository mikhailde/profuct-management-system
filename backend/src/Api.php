<?php

namespace Task;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Routing\RouteCollectorProxy;

class Api {
    protected $app;

    public function __construct(App $app) {
        $this->app = $app;
    }

    public static function init(): void {
        // Создание экземпляра Slim приложения
        $app = new \Slim\App();

        // Регистрация маршрутов API
        $api = new self($app);
        $api->registerRoutes();

        // Запуск приложения
        $app->run();
    }

    public function registerRoutes(): void {
        // Группа маршрутов API
        $this->app->group('/products', function (RouteCollectorProxy $group) {
            // Маршрут для получения всех товаров
            $group->get('/getAll', function (Request $request, Response $response) {
                // Здесь должна быть логика для получения всех товаров из базы данных
                $products = [1,2,3]; // Пример: пустой массив

                // Возвращаем JSON-ответ с товарами
                $response->getBody()->write(json_encode($products));
                return $response->withHeader('Content-Type', 'application/json');
            });

            // Маршрут для получения конкретного товара по ID
            $group->get('/get/{id}', function (Request $request, Response $response, array $args) {
                $id = $args['id'];

                // Здесь должна быть логика для получения товара с указанным ID из базы данных
                $product = null; // Пример: пустой объект

                if (!$product) {
                    // Если товар не найден, возвращаем 404 Not Found
                    $response = $response->withStatus(404);
                    $response->getBody()->write(json_encode(['error' => 'Product not found']));
                    return $response->withHeader('Content-Type', 'application/json');
                }

                // Возвращаем JSON-ответ с найденным товаром
                $response->getBody()->write(json_encode($product));
                return $response->withHeader('Content-Type', 'application/json');
            });

            // Маршрут для добавления нового товара
            $group->post('/add', function (Request $request, Response $response) {
                // Здесь должна быть логика для добавления нового товара в базу данных
                // Данные товара могут быть доступны в $request->getParsedBody()

                // Пример: сохраняем данные нового товара из запроса в базу данных

                // Возвращаем успешный JSON-ответ
                $response->getBody()->write(json_encode(['success' => true]));
                return $response->withHeader('Content-Type', 'application/json');
            });

            // Маршрут для редактирования товара по ID
            $group->put('/edit/{id}', function (Request $request, Response $response, array $args) {
                $id = $args['id'];

                // Здесь должна быть логика для редактирования товара с указанным ID в базе данных
                // Данные товара могут быть доступны в $request->getParsedBody()

                // Пример: обновляем данные товара с указанным ID в базе данных

                // Возвращаем успешный JSON-ответ
                $response->getBody()->write(json_encode(['success' => true]));
                return $response->withHeader('Content-Type', 'application/json');
            });

            // Маршрут для удаления товара по ID
            $group->delete('/delete/{id}', function (Request $request, Response $response, array $args) {
                $id = $args['id'];

                // Здесь должна быть логика для удаления товара с указанным ID из базы данных

                // Пример: удаляем товар с указанным ID из базы данных

                // Возвращаем успешный JSON-ответ
                $response->getBody()->write(json_encode(['success' => true]));
                return $response->withHeader('Content-Type', 'application/json');
            });
        });
    }
}
