## MODIFIED Requirements

### Requirement: Tasks API SHALL expose task details
Система SHALL использовать согласованный resource-specific not found response для несуществующей задачи.

#### Scenario: Несуществующая задача
- **WHEN** клиент запрашивает несуществующую задачу
- **THEN** система возвращает JSON ответ `Task not found.`

### Requirement: Tasks API SHALL expose ordered task steps
Система SHALL получать шаги задачи без лишнего дублирующего запроса к задаче и использовать единый not found flow.

#### Scenario: Несуществующая задача при запросе steps
- **WHEN** клиент запрашивает шаги несуществующей задачи
- **THEN** система возвращает JSON ответ `Task not found.`
