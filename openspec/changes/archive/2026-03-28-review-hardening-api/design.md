## Context

Проект уже покрывает основной frontend-dashboard API и проходит текущий test suite, но ряд решений был принят как MVP shortcut. Для финальной сдачи нужно привести реализацию ближе к ожиданиям строгого Laravel reviewer:

- auth не должен подменяться demo-user fallback в production-like API;
- actions должны быть use-case oriented, а не только pass-through слоем;
- внешняя service integration должна остаться изолированной, но публичные responses не должны раскрывать лишние поля;
- API error semantics должны быть согласованы для malformed JSON, validation errors, missing resources и method mismatch;
- conversations и mentor/task flows должны быть чище с точки зрения layering;
- тесты должны проверять важные сценарии без чрезмерной зависимости от сидера.

## Goals / Non-Goals

**Goals:**
- Ввести минимальную, но реальную аутентификацию через Sanctum.
- Устранить архитектурные замечания, которые могут быть критичны в review.
- Сделать API contracts более безопасными и предсказуемыми.
- Улучшить тесты и снизить их хрупкость.
- Сохранить уже реализованный продуктовый scope без перехода в полную auth platform или admin panel.

**Non-Goals:**
- Не строить полноценный registration / password reset / email verification flow.
- Не добавлять realtime chat.
- Не вводить тяжелые CQRS/event-sourcing решения ради формального “pattern purity”.
- Не переписывать весь проект с нуля ради идеологических изменений.

## Decisions

### 1. Authentication будет добавлена через Sanctum personal access tokens

Решение:
- добавить login/logout/me endpoints;
- защитить dashboard endpoints через `auth:sanctum`;
- убрать demo-user fallback из runtime API flows.

Почему:
- это самое прямое исправление главного review-замечания;
- Sanctum нативен для Laravel и хорошо подходит для test task уровня.

### 2. Resource-specific not-found semantics останутся централизованными

Решение:
- сохранить central error rendering в `bootstrap/app.php`;
- использовать domain-specific `ApiResourceNotFoundException`;
- не возвращать debug-heavy payloads для API routes.

Почему:
- это соответствует Laravel Boost best practices;
- так проще держать consistent JSON errors для `400/404/405/422`.

### 3. Conversations resource flow будет очищен от request attribute smuggling

Решение:
- вычисление counterparty перенести из request attribute зависимости в repository/action/resource DTO-like preparation;
- resource должен получать уже достаточный контекст без mutation request object.

Почему:
- request не должен использоваться как транспорт бизнес-контекста;
- это явное замечание reviewer и реальная architectural smell.

### 4. Task status будет переведен на enum

Решение:
- ввести PHP backed enum для task status;
- обновить model casts / validation / repository conditions / seed data.

Почему:
- это усиливает типобезопасность;
- уменьшает риск строковых опечаток в бизнес-логике.

### 5. Mentor metrics будут считаться более честно

Решение:
- уйти от слепого доверия seed-only cached fields;
- в list/detail flows использовать агрегаты из связей, либо централизованное recalculation logic;
- cached columns допустимы только если обновляются согласованно.

Почему:
- stale denormalized values подрывают доверие к модели;
- reviewer справедливо отметил этот риск.

### 6. Actions будут усилены выборочно, а не косметически

Решение:
- не трогать каждый single-line action только ради размера;
- но там, где есть реальный use-case orchestration, перенести в action логику подготовки/проверки/обновления;
- repositories оставить ответственными за persistence/query concerns.

Почему:
- это pragmatic balance между чистой архитектурой и overengineering.

### 7. Tests будут постепенно отвязаны от сидера в критичных сценариях

Решение:
- happy-path smoke coverage может частично остаться seed-backed;
- review-sensitive tests перевести на локальные factories/fixtures;
- добавить auth tests и regression tests на review findings.

Почему:
- это уменьшит хрупкость и покажет более зрелый testing approach.

## Risks / Trade-offs

- Добавление Sanctum изменит способ ручного тестирования в Postman: понадобятся login и token.
- Перевод на enum затронет несколько слоев сразу, включая seeds, repositories и tests.
- Пересчет mentor metrics может увеличить query cost; нужно удержать баланс между correctness и производительностью.
- Ослабление зависимости от сидера увеличит размер test fixtures, но улучшит изоляцию.

## Migration Plan

1. Архивировать завершенный implementation change и открыть новый hardening change.
2. Подключить Sanctum и перевести API на authenticated context.
3. Убрать data exposure и усилить validation/contracts.
4. Исправить task/conversation architectural issues.
5. Ввести enum/index и пересмотреть mentor aggregates.
6. Улучшить tests и снова прогнать весь suite.
7. Провалидировать новый OpenSpec change и финальное состояние проекта.

## Open Questions

- Для login достаточно ли email + password seeded user, или нужен отдельный factory-backed auth fixture?
- Mentor metrics считать on-demand в query или поддерживать через централизованный recalc/update hook?
