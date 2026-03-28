## Why

После первичной реализации backend API проект требует второй волны улучшений перед финальной сдачей. Внешний review показал несколько реальных слабых мест: отсутствие аутентификации, избыточно тонкие action-классы, неидеальная подготовка conversation resources, лишние публичные поля в API, зависимость части тестов от сидера и недостаточно строгая доменная модель задач и менторов.

Цель этого change — не расширять продуктовый scope, а довести уже реализованный backend до более зрелого уровня с точки зрения архитектуры, безопасности, API-контрактов и проверяемости.

## What Changes

- Будет добавлена минимальная token-based аутентификация на Laravel Sanctum для API.
- Публичные API endpoints будут переведены с demo-user fallback на authenticated user context.
- Будет усилена модель ошибок API для security- и review-sensitive сценариев.
- Будут устранены лишние данные в публичных responses, включая `email` в user summary payloads.
- Будет устранен двойной запрос в task steps flow.
- Conversations resource flow будет переработан без передачи бизнес-контекста через request attributes.
- Будет введен enum для статуса задач и индекс на `tasks.status`.
- Логика mentor metrics (`tasks_count`, `reviews_count`, `rating`) будет сделана более честной и согласованной.
- Будет усилен test suite: меньше привязки к сидеру, больше явных fixture/factory сценариев и больше edge-case coverage.

## Capabilities

### New Capabilities
- `auth-api`: API SHALL support authenticated access to protected dashboard endpoints using Sanctum tokens.

### Modified Capabilities
- `dashboard-api`: overview SHALL work in authenticated user context.
- `tasks-api`: tasks SHALL use a stricter domain model and more consistent not-found / step-loading behavior.
- `mentors-api`: mentors SHALL expose safer public payloads and more reliable aggregate metrics.
- `conversations-api`: conversations SHALL return cleaner counterparty payloads and consistent resource-specific errors.
- `settings-api`: settings SHALL reject malformed payloads and operate in authenticated user context.
- `api-test-suite`: tests SHALL cover the revised auth, error handling, and resource semantics.

## Impact

- Будут затронуты `routes/api.php`, `bootstrap/app.php`, `app/Actions`, `app/Repositories`, `app/Http`, `app/Models`, `database/`, `tests/`, `composer.json` и OpenSpec specs.
- Появится dependency на Sanctum и migration / model / middleware integration под token auth.
- Часть API-контрактов будет tightened, особенно для error responses и user summary payloads.
