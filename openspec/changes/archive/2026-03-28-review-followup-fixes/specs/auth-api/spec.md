## ADDED Requirements

### Requirement: Auth login endpoint SHALL be rate limited
Система SHALL ограничивать частоту запросов к `POST /api/auth/login`, чтобы уменьшить риск brute-force попыток без влияния на остальные dashboard endpoints.

#### Scenario: Excessive login attempts
- **WHEN** клиент отправляет слишком много login attempts за короткий период
- **THEN** система возвращает rate limited response

#### Scenario: Normal login traffic
- **WHEN** клиент использует login endpoint в пределах лимита
- **THEN** система продолжает обрабатывать credentials по обычному auth flow
