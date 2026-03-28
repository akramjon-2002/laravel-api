## 1. Security and Performance

- [x] 1.1 Добавить rate limiting для `POST /api/auth/login`
- [x] 1.2 Убрать лишний `settings` eager loading из overview flow
- [x] 1.3 Сократить repeated status count queries в overview aggregation

## 2. Mentor and Test Hardening

- [x] 2.1 Перевести mentor summary metrics на relation-backed aggregates
- [x] 2.2 Перенести mentor presentation hydration в action layer, а repository оставить query-focused
- [x] 2.3 Ослабить зависимость ключевых mentor feature tests от seeded fixtures

## 3. Verification

- [x] 3.1 Добавить regression coverage для login protection и updated mentor metrics
- [x] 3.2 Прогнать полный test suite
- [x] 3.3 Провалидировать OpenSpec change
