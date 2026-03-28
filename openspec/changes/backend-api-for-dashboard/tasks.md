## 1. Setup and Environment

- [x] 1.1 Настроить `.env` и `.env.example` под PostgreSQL с рабочими локальными параметрами
- [x] 1.2 Проверить подключение Laravel к PostgreSQL и базовый запуск artisan-команд
- [x] 1.3 Подготовить тестовое окружение для Pest и выделить отдельную тестовую БД или тестовую схему

## 2. Data Model

- [x] 2.1 Создать миграции для `categories`, `mentors`, `tasks`, `task_steps`, `task_user`
- [x] 2.2 Создать миграции для `mentor_followers`, `reviews`, `conversations`, `conversation_participants`, `messages`, `user_settings`
- [x] 2.3 Описать Eloquent-модели и связи между сущностями
- [x] 2.4 Подготовить сиды и фабрики с demo-данными под UI тестового задания

## 3. Architecture Foundation

- [ ] 3.1 Создать контракты и реализации репозиториев для overview, tasks, mentors, conversations и settings
- [ ] 3.2 Создать action-классы для основных use case по каждому экрану
- [ ] 3.3 Создать service layer для внешней интеграции аватаров через DiceBear
- [ ] 3.4 Подключить зависимости через сервис-контейнер Laravel

## 4. API Delivery

- [ ] 4.1 Реализовать endpoint `GET /api/overview`
- [ ] 4.2 Реализовать endpoints для tasks list, task details и task steps
- [ ] 4.3 Реализовать endpoints для mentors list, recent mentors, mentor details, follow и unfollow
- [ ] 4.4 Реализовать endpoints для conversations list, conversation messages и send message
- [ ] 4.5 Реализовать endpoints для get/update settings
- [ ] 4.6 Добавить Form Requests и API Resources для стабильных контрактов ответа

## 5. Testing and Quality

- [ ] 5.1 Написать feature tests для overview, tasks, mentors, conversations и settings
- [ ] 5.2 Написать feature tests для follow / unfollow и отправки сообщения
- [ ] 5.3 Написать architecture tests на соблюдение repository, action и service layer
- [ ] 5.4 Изолировать внешнюю avatar-интеграцию в тестах через mock / fake
- [ ] 5.5 Проверить прохождение тестов, форматирование и финальную валидацию OpenSpec change

## 6. Documentation

- [ ] 6.1 Обновить README с кратким описанием архитектуры и выбранного scope
- [ ] 6.2 Подготовить краткое объяснение для проверяющего, почему realtime и сложная auth-логика вынесены за рамки MVP
