# Шаблон микросервисной архитектуры

Этот репозиторий служит для шаблона создания микросервиса

## Локальное развертывание микросервиса

Для запуска микросервиса требуется Docker и Docker Compose Plugin V2

```bash
# Запуск контейнера
docker-compose up -d

# Загрузка зависимостей PHP пакетов
docker-compose exec app composer install

# Копирование ENV переменных
docker-compose exec app cp .env.example .env

# Генерация ключа приложения
docker-compose exec app php artisan key:generate
```

Локальное развертывание завершено!

## Продуктовое развертывание

Для продуктового развертывания подготовлен файл Dockerfile. Для его запуска
достаточно передать необходимые ENV переменные. Такие
как доступы к базе данных, редис и т.д.

Основные можно отметить:
- LOG_CHANNEL
- DB_CONNECTION
- DB_HOST
- DB_PORT
- DB_DATABASE
- DB_USERNAME
- DB_PASSWORD

Переменную `APP_NAME` можно заменить в .env.example, чтобы постоянно 
не прокидывать в сборку

### Важно после первой сборки

После первой сборки рекомендуется заменить `APP_KEY` в файле Dockerfile, после
первой сборки вызовите комманду в контейнере приложения:

```bash
# Запуск комманды для получения нового ключа приложения
php artisan key:generate
```

После вызова этой комманду нужно подставить полученый ключ в Dockerfile
