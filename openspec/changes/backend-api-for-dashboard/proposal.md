## Why

Нужно реализовать backend API для предоставленного frontend-dashboard, чтобы показать на тестовом задании не только рабочие эндпоинты, но и зрелую архитектуру на Laravel 11. Из требований задания критично продемонстрировать PostgreSQL, Repository Pattern, Action / Command Pattern, Service Layer Pattern и покрытие тестами.

## What Changes

- Будет реализован API для экранов `Overview`, `Task`, `Mentors`, `Message` и `Settings`.
- Будет введена доменная модель для пользователей, задач, менторов, диалогов, сообщений, настроек и связанных сущностей.
- Будет добавлен слой репозиториев для всех обращений к базе данных.
- Будет добавлен слой action-классов для основной бизнес-логики.
- Будет добавлен service layer для внешней интеграции аватаров через DiceBear.
- Будут добавлены feature-тесты API и архитектурные тесты для ключевых правил проекта.
- Реализация чата будет упрощенной: без realtime, websocket и вложений.
- Сложные auth-flow, админ-панель и внешние notification providers в этот change не входят.

## Capabilities

### New Capabilities
- `dashboard-api`: агрегированный API для overview-экрана с метриками, задачами и менторами.
- `tasks-api`: API для списка задач, фильтрации, сортировки, деталей задачи и шагов выполнения.
- `mentors-api`: API для списка менторов, recent mentors и сценариев follow / unfollow.
- `conversations-api`: API для списка диалогов, просмотра сообщений и отправки нового сообщения.
- `settings-api`: API для получения и обновления пользовательских настроек.
- `api-test-suite`: набор feature и architecture tests для основных сценариев и архитектурных ограничений.

### Modified Capabilities
- Нет.

## Impact

- Будут затронуты `routes/api.php`, `app/`, `database/`, `tests/`, `config/` и `.env`.
- Проект будет использовать PostgreSQL как основную БД.
- В `composer.json` уже подключены `laravel/boost`, `pestphp/pest` и `pestphp/pest-plugin-laravel`.
- В проекте уже инициализирован OpenSpec, поэтому дальнейшая реализация будет вестись через change `backend-api-for-dashboard`.
