## ADDED Requirements

### Requirement: API overview SHALL return dashboard data for the current user context
Система SHALL предоставлять единый endpoint overview, который возвращает данные dashboard для текущего пользователя или demo-user контекста.

#### Scenario: Получение overview
- **WHEN** клиент вызывает endpoint overview
- **THEN** система возвращает успешный ответ с агрегированными блоками dashboard для текущего пользовательского контекста

### Requirement: Overview response SHALL include stable dashboard sections
Ответ overview SHALL содержать блоки `user`, `summary_metrics`, `activity`, `upcoming_tasks`, `task_today` и `monthly_mentors`.

#### Scenario: Полный состав overview
- **WHEN** overview успешно сформирован
- **THEN** ответ содержит все обязательные секции даже если часть из них возвращает пустые коллекции

### Requirement: Overview aggregation SHALL be based on persisted domain data
Система MUST собирать overview из данных задач, менторов, связей пользователя и настроек, а не из захардкоженных статических массивов в контроллере.

#### Scenario: Агрегация из базы данных
- **WHEN** данные пользователя, задач или менторов меняются в базе
- **THEN** следующий ответ overview отражает актуальное состояние агрегированных данных
