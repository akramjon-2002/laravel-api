## Context

Текущий backend уже соответствует основным требованиям задания, но review выявил четыре follow-up проблемы: login endpoint без throttle, лишние overview queries, stale mentor metrics и хрупкий CategoryFactory для factory-heavy tests. Изменения затрагивают routing, aggregation queries, mentor hydration logic и regression tests.

## Goals / Non-Goals

**Goals:**
- ограничить login endpoint предсказуемым rate limit
- уменьшить избыточные запросы в overview без изменения API shape
- считать mentor metrics из реальных связей `tasks` и `reviews`
- сделать ключевые mentor tests менее завязанными на seeded fixtures

**Non-Goals:**
- переписывать весь auth flow
- менять публичный JSON contract mentors/tasks/overview
- вводить отдельный caching layer для overview

## Decisions

- Добавить `throttle` непосредственно на `POST /api/auth/login`, чтобы ограничение было локальным и не затрагивало остальные protected API routes.
- Убрать `loadMissing('settings')` из overview action, так как settings не сериализуются в overview payload.
- Оставить overview repository ответственным за aggregation, но сократить repeated counts до grouped status aggregation.
- Перенести mentor summary truth source на relation-backed aggregate aliases (`withCount`, `withAvg`), а actions использовать для hydration response state (`is_followed`, normalized metrics).
- В regression tests использовать локально созданные mentors/categories там, где проверяется detail/follow behavior, чтобы tests не зависели от seeded names.

## Risks / Trade-offs

- [Throttle слишком строгий] → Использовать умеренный лимит на login и не применять его к остальным auth routes.
- [Aggregation refactor может поменять сортировку mentors] → Зафиксировать regression tests для detail/list semantics.
- [Factory changes могут столкнуться с seeded unique constraints] → Использовать явные slug/name в тестах, где нужен deterministic fixture.

## Migration Plan

- Изменения backward-compatible для API consumers
- После deploy достаточно обычного `php artisan test` и smoke-check login/overview
- Дополнительных rollback-only migration steps не требуется

## Open Questions

- Нужен ли в будущем отдельный кастомный rate limiter profile для login вместо inline throttle middleware
