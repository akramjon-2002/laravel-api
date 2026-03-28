# conversations-api Specification

## Purpose
TBD - created by archiving change backend-api-for-dashboard. Update Purpose after archive.
## Requirements
### Requirement: Conversations API SHALL list user conversations
Система SHALL предоставлять endpoint списка диалогов для текущего пользователя с последним сообщением и временем последней активности.

#### Scenario: Список диалогов
- **WHEN** клиент запрашивает список диалогов
- **THEN** система возвращает диалоги пользователя, отсортированные по `last_message_at` по убыванию

### Requirement: Conversations API SHALL expose message history
Система SHALL предоставлять endpoint истории сообщений для выбранного диалога.

#### Scenario: Получение сообщений
- **WHEN** клиент запрашивает сообщения существующего диалога, в котором участвует пользователь
- **THEN** система возвращает упорядоченную историю сообщений этого диалога

### Requirement: Conversations API SHALL allow sending a new message
Система SHALL поддерживать отправку нового текстового сообщения в существующий диалог пользователя.

#### Scenario: Отправка сообщения
- **WHEN** клиент отправляет валидное текстовое сообщение в существующий диалог
- **THEN** система сохраняет сообщение, обновляет `last_message_at` диалога и возвращает созданный ресурс сообщения

#### Scenario: Сообщение в чужой диалог
- **WHEN** клиент пытается отправить сообщение в диалог, участником которого он не является
- **THEN** система отклоняет запрос

