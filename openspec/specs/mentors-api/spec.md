# mentors-api Specification

## Purpose
TBD - created by archiving change backend-api-for-dashboard. Update Purpose after archive.
## Requirements
### Requirement: Mentors API SHALL support listing with search, filtering, sorting and pagination
Система SHALL предоставлять endpoint списка менторов с поддержкой поиска по имени или роли, фильтра по категории, сортировки и пагинации.

#### Scenario: Список менторов с параметрами
- **WHEN** клиент запрашивает список менторов с query-параметрами
- **THEN** система возвращает только подходящих менторов и metadata пагинации

### Requirement: Mentors API SHALL expose recent mentors
Система SHALL предоставлять отдельный endpoint recent mentors для компактного блока overview / mentors UI.

#### Scenario: Получение recent mentors
- **WHEN** клиент запрашивает recent mentors
- **THEN** система возвращает ограниченный список менторов в согласованном формате карточек

### Requirement: Mentors API SHALL support follow state transitions
Система SHALL поддерживать действия follow и unfollow для текущего пользователя относительно выбранного ментора.

#### Scenario: Follow mentor
- **WHEN** клиент отправляет запрос follow для существующего ментора
- **THEN** система создает или сохраняет состояние подписки пользователя на этого ментора

#### Scenario: Unfollow mentor
- **WHEN** клиент отправляет запрос unfollow для существующего ментора
- **THEN** система удаляет или отключает состояние подписки пользователя на этого ментора

### Requirement: Mentor resources SHALL include review and task summary fields
Ресурс ментора SHALL содержать поля, необходимые frontend-у: имя, роль, описание, avatar, tasks_count, rating, reviews_count и follow_state.

#### Scenario: Карточка ментора для UI
- **WHEN** система сериализует данные ментора
- **THEN** ответ содержит все поля, необходимые для построения карточек mentors UI

