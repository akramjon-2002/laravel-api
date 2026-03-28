## ADDED Requirements

### Requirement: Settings API SHALL expose current user settings
Система SHALL предоставлять endpoint для получения пользовательских настроек текущего контекста.

#### Scenario: Получение настроек
- **WHEN** клиент запрашивает настройки
- **THEN** система возвращает `language`, `timezone`, `time_format` и доступные флаги уведомлений

### Requirement: Settings API SHALL allow updating editable settings
Система SHALL позволять обновлять поддерживаемые пользовательские настройки через отдельный endpoint.

#### Scenario: Обновление настроек
- **WHEN** клиент отправляет валидные значения настроек
- **THEN** система сохраняет изменения и возвращает обновленный ресурс настроек

#### Scenario: Невалидные настройки
- **WHEN** клиент отправляет невалидный timezone, language или time format
- **THEN** система отклоняет запрос с ошибкой валидации
