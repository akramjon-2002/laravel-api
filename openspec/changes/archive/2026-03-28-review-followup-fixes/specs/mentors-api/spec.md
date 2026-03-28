## MODIFIED Requirements

### Requirement: Mentor resources SHALL include review and task summary fields
Ресурс ментора SHALL содержать поля `tasks_count`, `rating` и `reviews_count`, рассчитанные из связанных persisted tasks и reviews, а не из устаревших seed-only counters.

#### Scenario: Related data changes
- **WHEN** количество задач или отзывов ментора меняется
- **THEN** следующий mentor response отражает актуальные aggregate values
