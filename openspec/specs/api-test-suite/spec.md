# api-test-suite Specification

## Purpose
TBD - created by archiving change backend-api-for-dashboard. Update Purpose after archive.
## Requirements
### Requirement: API implementation SHALL include feature tests for core user flows
Система MUST иметь feature tests для основных сценариев overview, tasks, mentors, conversations и settings.

#### Scenario: Покрытие ключевых экранов
- **WHEN** разработчик запускает тестовый набор проекта
- **THEN** в нем присутствуют feature tests для всех основных capability этого change

### Requirement: Follow and messaging flows SHALL be test-covered
Система MUST иметь отдельные tests для follow / unfollow и для отправки сообщения.

#### Scenario: Покрытие действий пользователя
- **WHEN** тестовый набор выполняется
- **THEN** сценарии изменения follow state и создания нового сообщения проверяются автоматически

### Requirement: Architectural rules SHALL be verified by automated tests
Система MUST содержать architecture tests, проверяющие использование repository, action и service layer.

#### Scenario: Проверка архитектурных ограничений
- **WHEN** выполняются architecture tests
- **THEN** они выявляют нарушения слоев и запрещенные зависимости между контроллерами, actions, repositories и services

### Requirement: External integrations SHALL be isolated in tests
Внешние сервисы MUST быть замоканы, зафейканы или иным образом изолированы в тестах.

#### Scenario: Изоляция внешнего avatar provider
- **WHEN** тесты затрагивают avatar service
- **THEN** выполнение не зависит от реального сетевого вызова к внешнему провайдеру

