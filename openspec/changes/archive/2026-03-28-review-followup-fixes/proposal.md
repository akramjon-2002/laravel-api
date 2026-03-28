## Why

После employer-style review остались точечные замечания по security, performance и testing hardening. Эти правки нужны сейчас, чтобы закрыть login brute-force risk, убрать лишнюю нагрузку в overview и сделать regression coverage устойчивее.

## What Changes

- Добавить rate limiting для `POST /api/auth/login`
- Упростить overview aggregation, убрав лишнюю eager loading зависимость и сократив число count-запросов
- Сделать mentor aggregate fields (`tasks_count`, `reviews_count`, `rating`) зависимыми от связанных данных, а не от stale seed counters
- Усилить factory/test слой, чтобы критичные feature tests меньше зависели от фиксированного seeded набора

## Capabilities

### New Capabilities
- `auth-api`: требования к token login flow и его rate limiting

### Modified Capabilities
- `dashboard-api`: overview должен строиться только для authenticated user context и опираться на актуальную persisted aggregation
- `mentors-api`: mentor summary fields должны отражать актуальные связанные tasks/reviews
- `api-test-suite`: regression tests должны покрывать review-driven security/performance sensitive cases

## Impact

- `routes/api.php`, auth flow, middleware configuration
- overview aggregation in actions/repositories
- mentor repository/action/resource pipeline
- factories and feature tests
