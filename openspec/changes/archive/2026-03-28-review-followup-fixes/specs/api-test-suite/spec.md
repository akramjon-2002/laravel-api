## MODIFIED Requirements

### Requirement: API implementation SHALL include feature tests for core user flows
Система MUST иметь feature tests для основных сценариев overview, tasks, mentors, conversations и settings, при этом критичные mentor scenarios SHOULD использовать локальные deterministic fixtures вместо привязки к seeded именам.

#### Scenario: Factory-based mentor regression coverage
- **WHEN** разработчик запускает test suite
- **THEN** mentor detail/follow regressions проверяются через локально созданные fixtures

### Requirement: API test suite SHALL cover review-sensitive regressions
Набор тестов SHALL проверять review-sensitive regression scenarios для login protection, tightened public payloads и live mentor aggregates.

#### Scenario: Review follow-up verification
- **WHEN** разработчик запускает полный test suite
- **THEN** suite выявляет регрессии в throttle, mentor metrics и security-sensitive API behavior
