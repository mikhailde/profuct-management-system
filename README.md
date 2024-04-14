# Шаблон backend приложения

Это шаблон backend приложения на PHP с использованием Docker.

## Установка и настройка

Скачать [Docker Desktop](https://www.docker.com/products/docker-desktop/), если еще не установлен.

Добавить новую строку в файл hosts:
```
127.0.0.1 task.loc
```
На Linux и macOS этот файл располагается по пути `/etc/hosts`, на Windows — `C:\Windows\System32\drivers\etc\hosts`. Для редактирования потребуются права администратора.

## Запуск и работа с приложением

Запустить приложение:
```bash
docker-compose up -d
```

При первичном запуске скачаются все нужные образы. Последующие запуски будут только запускать образы, если они уже скачаны.

После успешного запуска приложение станет доступно по адресу http://task.loc.

Остановить приложение:
```bash
docker-compose down
```

Остановка и повторный запуск могут потребоваться в случае, если вы меняли конфиг nginx.

Выполнить одну из команд Composer:
```bash
docker-compose exec -w /var/www/task.loc php composer <команда>
```
Например, `composer install` будет вызываться следующим образом:
```bash
docker-compose exec -w /var/www/task.loc php composer install
```

Для подключения к базе данных MySQL используются следующие данные:
- Host: mysql
- Имя пользователя: root
- Пароль: secret
- Имя базы данных: task
- Порт: 3306
При желании, данные можно поменять в файле `docker-compose.yml`.
