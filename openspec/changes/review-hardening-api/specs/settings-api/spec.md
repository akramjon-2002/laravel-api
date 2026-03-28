## MODIFIED Requirements

### Requirement: Settings API SHALL validate and reject malformed payloads
Система SHALL различать validation errors и malformed JSON payloads для update settings endpoint.

#### Scenario: Некорректный JSON body
- **WHEN** клиент отправляет malformed JSON в settings update
- **THEN** система возвращает `400 Bad Request`

#### Scenario: Валидный JSON с невалидными полями
- **WHEN** клиент отправляет синтаксически валидный JSON с невалидными значениями
- **THEN** система возвращает `422 Unprocessable Entity`
