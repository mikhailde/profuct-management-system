-- Создание базы данных, если она не существует
CREATE DATABASE IF NOT EXISTS task;

-- Использование базы данных task
USE task;

-- Создание таблицы для хранения данных о товарах
CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    count INT NOT NULL,
    supplier_email VARCHAR(255) NOT NULL
);

-- Вставка тестовых данных
INSERT INTO products (name, price, count, supplier_email) VALUES
    ('Товар 1', 100.50, 10, 'supplier1@example.com'),
    ('Товар 2', 200.75, 20, 'supplier2@example.com'),
    ('Товар 3', 300.25, 15, 'supplier3@example.com');
