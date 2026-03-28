# IELTS Zone Dashboard API

Backend API for the provided dashboard frontend test assignment, implemented with Laravel 11 and PostgreSQL.

## Stack

- PHP 8.2+
- Laravel 11
- PostgreSQL
- Pest
- OpenSpec
- Laravel Boost

## Architecture

The project follows the patterns required by the assignment:

- `Repository Pattern`: all database access goes through repository interfaces and Eloquent implementations.
- `Action / Command Pattern`: core business use cases are implemented as dedicated action classes.
- `Service Layer Pattern`: external integrations are isolated behind service contracts.

Application flow:

- Controllers accept requests and return API resources.
- Actions coordinate the use case.
- Repositories handle persistence.
- Services handle external providers such as avatar generation.

## Covered Scope

The API covers the main flows of the provided UI:

- `Overview`
- `Tasks`
- `Mentors`
- `Messages`
- `Settings`

Implemented endpoints include:

- `POST /api/auth/login`
- `GET /api/auth/me`
- `POST /api/auth/logout`
- `GET /api/overview`
- `GET /api/tasks`
- `GET /api/tasks/{task}`
- `GET /api/tasks/{task}/steps`
- `GET /api/mentors`
- `GET /api/mentors/recent`
- `GET /api/mentors/{mentor}`
- `POST /api/mentors/{mentor}/follow`
- `DELETE /api/mentors/{mentor}/follow`
- `GET /api/conversations`
- `GET /api/conversations/{conversation}/messages`
- `POST /api/conversations/{conversation}/messages`
- `GET /api/settings`
- `PUT /api/settings`

## Domain Model

Main tables:

- `users`
- `categories`
- `mentors`
- `tasks`
- `task_steps`
- `task_user`
- `mentor_followers`
- `reviews`
- `conversations`
- `conversation_participants`
- `messages`
- `user_settings`

The project ships with demo seed data so the API can be exercised immediately after migrations.

Seeded authentication credentials:

- `email`: `dennis@example.com`
- `password`: `password`

## External Service Example

To satisfy the service layer requirement, avatar resolution is isolated behind:

- `App\Contracts\Services\AvatarServiceInterface`
- `App\Services\DiceBearAvatarService`

This keeps external URL generation out of controllers, actions, and repositories.

## Testing

Test coverage includes:

- feature tests for auth, overview, tasks, mentors, conversations, and settings
- flow tests for follow / unfollow and send message
- auth flow tests for login, me, logout, and protected route access
- architecture tests for controller / action / repository / service boundaries
- service isolation tests for the avatar integration

Run the full suite with:

```bash
php artisan test
```

## Local Setup

1. Copy environment variables:

```bash
cp .env.example .env
```

2. Configure PostgreSQL credentials in `.env`.

Default local values used in this project:

```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=ielts
DB_USERNAME=postgres
DB_PASSWORD=postgres
```

3. Run migrations and seed demo data:

```bash
php artisan migrate:fresh --seed
```

4. Start the application:

```bash
php artisan serve --host=127.0.0.1 --port=8081
```

## Demo Commands

Useful commands for a short reviewer demo:

```bash
php artisan migrate:fresh --seed
php artisan route:list --path=api
php artisan test
```

Quick endpoint checks:

```bash
curl -X POST http://127.0.0.1:8081/api/auth/login -H "Content-Type: application/json" -d "{\"email\":\"dennis@example.com\",\"password\":\"password\",\"device_name\":\"cli\"}"
```

## Postman

Ready-to-import files are included in:

- `postman/IELTS Zone Dashboard API.postman_collection.json`
- `postman/Local.postman_environment.json`

Default variables use seeded demo IDs:

- `baseUrl=http://127.0.0.1:8081`
- `email=dennis@example.com`
- `password=password`
- `taskId=1`
- `mentorId=1`
- `conversationId=1`
- `categoryId=1`

Use the `Auth -> Login` request first. It stores the returned Sanctum token into the active Postman environment automatically.


