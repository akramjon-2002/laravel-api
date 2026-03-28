## 1. OpenSpec and Scope

- [ ] 1.1 Архивировать предыдущий completed change и обновить main specs
- [ ] 1.2 Создать новый change под review hardening и зафиксировать scope исправлений

## 2. Authentication Hardening

- [ ] 2.1 Установить и настроить Laravel Sanctum
- [ ] 2.2 Добавить auth endpoints (`login`, `logout`, `me`)
- [ ] 2.3 Перевести dashboard API routes под `auth:sanctum`
- [ ] 2.4 Удалить demo-user fallback из runtime API flow

## 3. API Contract Cleanup

- [ ] 3.1 Убрать лишние публичные поля из user summary payloads
- [ ] 3.2 Усилить validation для settings и related requests
- [ ] 3.3 Сохранить compact JSON handling для `400/404/405/422`
- [ ] 3.4 Удалить test scaffolding / helper мусор

## 4. Task and Conversation Flow Improvements

- [ ] 4.1 Устранить лишний запрос в task steps flow
- [ ] 4.2 Перевести task status на enum и обновить связанные условия/валидацию
- [ ] 4.3 Добавить индекс на `tasks.status`
- [ ] 4.4 Убрать request attribute smuggling из conversations resource flow
- [ ] 4.5 Привести conversation/message preparation к более чистому layering

## 5. Mentor Domain Improvements

- [ ] 5.1 Пересмотреть стратегию `tasks_count`, `reviews_count`, `rating`
- [ ] 5.2 Реализовать более честное вычисление или централизованное обновление aggregate fields
- [ ] 5.3 Проверить sort/list/detail behavior после переработки metrics

## 6. Action / Repository Rebalancing

- [ ] 6.1 Перенести ключевую use-case orchestration logic из repositories в actions там, где это оправдано
- [ ] 6.2 Сохранить repositories сфокусированными на persistence/query responsibilities

## 7. Testing and Verification

- [ ] 7.1 Добавить feature tests для auth login/logout/me и protected routes
- [ ] 7.2 Перевести критичные feature tests с seed-зависимости на локальные factories/fixtures
- [ ] 7.3 Добавить regression tests под замечания review
- [ ] 7.4 Прогнать полный test suite и ручную матрицу edge cases
- [ ] 7.5 Провалидировать новый OpenSpec change
