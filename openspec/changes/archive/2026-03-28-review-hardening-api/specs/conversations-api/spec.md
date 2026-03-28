## MODIFIED Requirements

### Requirement: Conversations API SHALL expose message history
Система SHALL предоставлять endpoint истории сообщений для выбранного диалога без утечек лишнего пользовательского контекста и с согласованными ошибками not found.

#### Scenario: Несуществующий диалог
- **WHEN** клиент запрашивает сообщения несуществующего или недоступного диалога
- **THEN** система возвращает resource-specific JSON not found response

### Requirement: Conversations API SHALL allow sending a new message
Система SHALL поддерживать отправку нового текстового сообщения в существующий диалог пользователя и отклонять malformed JSON payloads.

#### Scenario: Некорректный JSON payload
- **WHEN** клиент отправляет malformed JSON body
- **THEN** система возвращает bad request response
