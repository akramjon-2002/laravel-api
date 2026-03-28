## ADDED Requirements

### Requirement: Auth API SHALL issue Sanctum tokens for valid users
Система SHALL предоставлять endpoint логина, который принимает валидные учетные данные и возвращает токен доступа для API.

#### Scenario: Успешный login
- **WHEN** пользователь отправляет корректные `email` и `password`
- **THEN** система возвращает token-based auth payload

#### Scenario: Неверные credentials
- **WHEN** пользователь отправляет неверные credentials
- **THEN** система возвращает authentication error

### Requirement: Protected dashboard endpoints SHALL require authenticated user context
Система SHALL отклонять запросы к dashboard API endpoints без валидного Sanctum token.

#### Scenario: Запрос без токена
- **WHEN** клиент вызывает защищенный endpoint без токена
- **THEN** система возвращает unauthorized response

#### Scenario: Запрос с валидным токеном
- **WHEN** клиент вызывает защищенный endpoint с валидным токеном
- **THEN** система выполняет запрос в контексте authenticated user
