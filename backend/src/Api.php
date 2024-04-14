<?php

namespace Task;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Routing\RouteCollectorProxy;

class Api {
    protected $app;
    protected $pdo;

    public function __construct(App $app) {
        $this->app = $app;
        $this->pdo = $this->createPDO();
    }

    protected function createPDO() {
        $dsn = 'mysql:host=127.0.0.1;dbname=task';
        $user = 'root';
        $password = 'secret';

        try {
            return new \PDO($dsn, $user, $password);
        } catch (\PDOException $e) {
            die('Database connection failed: ' . $e->getMessage());
        }
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
                // Запрос к базе данных для получения всех товаров
                $statement = $this->pdo->query('SELECT * FROM products');
                $products = $statement->fetchAll(\PDO::FETCH_ASSOC);

                // Возвращаем JSON-ответ с товарами
                $response->getBody()->write(json_encode($products));
                return $response->withHeader('Content-Type', 'application/json');
            });

            // Маршрут для получения конкретного товара по ID
            $group->get('/get/{id}', function (Request $request, Response $response, array $args) {
                $id = $args['id'];

                // Запрос к базе данных для получения товара по ID
                $statement = $this->pdo->prepare('SELECT * FROM products WHERE id = :id');
                $statement->execute(['id' => $id]);
                $product = $statement->fetch(\PDO::FETCH_ASSOC);

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
                // Получаем данные JSON из тела запроса
                $jsonBody = $request->getBody();
                $data = json_decode($jsonBody, true);
            
                if ($data === null) {
                    // Ошибка в JSON-данных, возвращаем ошибку
                    return $response->withStatus(400)->write(json_encode(['error' => 'Invalid JSON']));
                }
            
                // Выполнение запроса к базе данных для добавления нового товара
                $statement = $this->pdo->prepare('INSERT INTO products (name, price, count, supplier_email) VALUES (:name, :price, :count, :supplier_email)');
                $success = $statement->execute([
                    'name' => $data['name'],
                    'price' => $data['price'],
                    'count' => $data['count'],
                    'supplier_email' => $data['supplier_email']
                ]);

                if (!$success) {
                    // Если произошла ошибка при добавлении товара, возвращаем ошибку
                    $response = $response->withStatus(500);
                    $response->getBody()->write(json_encode(['error' => 'Failed to add product']));
                    return $response->withHeader('Content-Type', 'application/json');
                }

                // Возвращаем успешный JSON-ответ
                $response->getBody()->write(json_encode(['success' => true]));
                return $response->withHeader('Content-Type', 'application/json');
            });

            // Маршрут для редактирования товара по ID
            $group->put('/edit/{id}', function (Request $request, Response $response, array $args) {
                $id = $args['id'];
                $data = $request->getBody();
            
                // Преобразуем JSON в ассоциативный массив
                $jsonData = json_decode($data, true);
            
                if ($jsonData === null) {
                    // Ошибка в JSON-данных, возвращаем ошибку
                    return $response->withStatus(400)->write(json_encode(['error' => 'Invalid JSON']));
                }
            
                // Выполнение запроса к базе данных для обновления товара
                $statement = $this->pdo->prepare('UPDATE products SET name = :name, price = :price, count = :count, supplier_email = :supplier_email WHERE id = :id');
                $success = $statement->execute([
                    'id' => $id,
                    'name' => $jsonData['name'],
                    'price' => $jsonData['price'],
                    'count' => $jsonData['count'],
                    'supplier_email' => $jsonData['supplier_email']
                ]);
            
                if (!$success) {
                    // Если произошла ошибка при обновлении товара, возвращаем ошибку
                    $response = $response->withStatus(500);
                    $response->getBody()->write(json_encode(['error' => 'Failed to update product']));
                    return $response->withHeader('Content-Type', 'application/json');
                }
            
                // Возвращаем успешный JSON-ответ
                $response->getBody()->write(json_encode(['success' => true]));
                return $response->withHeader('Content-Type', 'application/json');
            });
            

            // Маршрут для удаления товара по ID
            $group->delete('/delete/{id}', function (Request $request, Response $response, array $args) {
                $id = $args['id'];
            
                // Выполнение запроса к базе данных для удаления товара
                $statement = $this->pdo->prepare('DELETE FROM products WHERE id = :id');
                $success = $statement->execute(['id' => $id]);
            
                if (!$success) {
                    // Если произошла ошибка при удалении товара, возвращаем ошибку
                    $response = $response->withStatus(500);
                    $response->getBody()->write(json_encode(['error' => 'Failed to delete product']));
                    return $response->withHeader('Content-Type', 'application/json');
                }
            
                // Возвращаем успешный JSON-ответ
                $response->getBody()->write(json_encode(['success' => true]));
                return $response->withHeader('Content-Type', 'application/json');
            });
        });
    }
}
