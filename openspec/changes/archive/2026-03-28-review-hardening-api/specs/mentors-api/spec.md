## MODIFIED Requirements

### Requirement: Mentors API SHALL expose safe public mentor payloads
Система SHALL не раскрывать лишние чувствительные пользовательские поля в mentor-related public payloads.

#### Scenario: Список менторов и related user summaries
- **WHEN** клиент получает mentor-related payloads
- **THEN** система не раскрывает лишние пользовательские поля, не нужные для UI

### Requirement: Mentors API SHALL use reliable aggregate metrics
Система SHALL использовать согласованный подход к `tasks_count`, `reviews_count` и `rating`, чтобы list/detail/sort опирались на актуальные данные.

#### Scenario: List и detail mentor metrics
- **WHEN** клиент получает mentor list или mentor detail
- **THEN** агрегатные поля согласованы между собой и не зависят только от seed-time значений
