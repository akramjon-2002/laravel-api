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

## External Service Example

To satisfy the service layer requirement, avatar resolution is isolated behind:

- `App\Contracts\Services\AvatarServiceInterface`
- `App\Services\DiceBearAvatarService`

This keeps external URL generation out of controllers, actions, and repositories.

## Testing

Test coverage includes:

- feature tests for overview, tasks, mentors, conversations, and settings
- flow tests for follow / unfollow and send message
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
php artisan serve
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
curl http://127.0.0.1:8000/api/overview
curl http://127.0.0.1:8000/api/tasks
curl http://127.0.0.1:8000/api/mentors
curl http://127.0.0.1:8000/api/conversations
curl http://127.0.0.1:8000/api/settings
```

## OpenSpec Workflow

The implementation is tracked through OpenSpec in:

- `openspec/changes/backend-api-for-dashboard/`

Validation command:

```bash
openspec validate backend-api-for-dashboard
```

## Reviewer Notes

This submission focuses on the main dashboard API flows and the required architectural patterns. Messaging is intentionally limited to inbox-oriented flows needed by the provided UI, and authentication is kept lightweight through a demo-user context so the scope stays aligned with the backend API objective of the assignment.
