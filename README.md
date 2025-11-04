# Руководство по запуску проекта
## Готовый .env уже в репозитории(тестовый проект, терять нечего)

## Требования

- Docker
- Docker Compose

## Запуск окружения

Сборка и запуск контейнеров:

```bash
docker compose up -d --build
```

## Установка зависимостей

Установка зависимостей Composer внутри контейнера PHP:

```bash
docker compose exec php composer install --no-interaction
```

## Применение миграций

```bash
docker compose exec php php bin/console doctrine:migrations:migrate --no-interaction
```

## Создание администратора

```bash
docker compose exec php php bin/console app:create-admin
```

## Доступ к API

- API Platform: `http://localhost:8080/api`
- Swagger UI: `http://localhost:8080/api/docs`

## Дополнительные команды

Остановка контейнеров:

```bash
docker compose down
```
