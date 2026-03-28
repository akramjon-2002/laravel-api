## MODIFIED Requirements

### Requirement: API test suite SHALL cover review-sensitive regressions
Набор тестов SHALL проверять regression scenarios для auth, malformed JSON, method mismatch, resource-specific not found responses и tightened public payloads.

#### Scenario: Regression coverage after hardening
- **WHEN** разработчик запускает полный test suite
- **THEN** suite проверяет не только happy path, но и review-sensitive edge cases
