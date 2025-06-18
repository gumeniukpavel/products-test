# Product API (PHP 8.2 + PostgreSQL)

## 🧾 Features
- REST API with PHP 8.2
- PostgreSQL + PDO
- PSR-4 Autoloading
- Symfony Validator with PHP Attributes
- DTO
- Dockerized + Migration Script
- PHPUnit tests

## 🚀 Setup

```bash
git clone <repo>
cd <repo>
cp .env.example .env
docker-compose up -d --build
docker-compose exec app composer migrate
```

API will be available at: http://localhost:8000

## 🔍 Endpoints

- `POST /products`
- `GET /products/{id}`
- `PATCH /products/{id}`
- `DELETE /products/{id}`
- `GET /products?category=electronics&price=1000`
```