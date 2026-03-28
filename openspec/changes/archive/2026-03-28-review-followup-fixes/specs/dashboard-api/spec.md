## MODIFIED Requirements

### Requirement: API overview SHALL return dashboard data for the current user context
Система SHALL предоставлять единый endpoint overview, который возвращает данные dashboard только для authenticated user context.

#### Scenario: Получение overview
- **WHEN** аутентифицированный клиент вызывает endpoint overview
- **THEN** система возвращает успешный ответ с агрегированными блоками dashboard для текущего пользователя
