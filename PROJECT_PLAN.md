# IELTS Zone API Plan

## 1. Goal

Build a Laravel 11 + PostgreSQL API for the provided frontend screens:

- Overview
- Task
- Mentors
- Message
- Settings

The goal is not to implement every possible feature, but to show a clean backend architecture that covers most of the product and demonstrates:

- Repository Pattern
- Action / Command Pattern
- Service Layer Pattern

## 2. Scope

### Included

- Dashboard overview API
- Tasks listing and task details API
- Mentors listing and follow/unfollow API
- Conversations and messages API
- User settings API
- Seed data for demo

### Simplified

- Messages without realtime
- Minimal authentication approach
- No admin panel
- No file attachments
- No websocket events
- No complex notification delivery

### Excluded

- Full enterprise auth flows
- Push notifications
- Email/SMS integrations
- Real-time chat
- Advanced analytics engine

## 3. Main Domain Entities

- `users`
- `categories`
- `mentors`
- `tasks`
- `task_steps`
- `task_user`
- `mentor_followers`
- `reviews`
- `conversations`
- `conversation_participants`
- `messages`
- `user_settings`

## 4. Page-to-API Mapping

### Overview

One aggregated endpoint that returns:

- current user info
- summary metrics
- activity summary
- upcoming tasks
- task today
- monthly / recommended mentors

Suggested endpoint:

- `GET /api/overview`

### Task

Required functionality:

- list tasks
- search by title
- filter by category
- sort by deadline
- open task details
- get task checklist / steps

Suggested endpoints:

- `GET /api/tasks`
- `GET /api/tasks/{id}`
- `GET /api/tasks/{id}/steps`

### Mentors

Required functionality:

- list mentors
- recent / recommended mentors
- search mentors
- filter mentors by category
- sort mentors
- follow / unfollow mentor

Suggested endpoints:

- `GET /api/mentors`
- `GET /api/mentors/recent`
- `GET /api/mentors/{id}`
- `POST /api/mentors/{id}/follow`
- `DELETE /api/mentors/{id}/follow`

### Message

Minimal but sufficient API:

- list conversations
- open one conversation
- get messages
- send message

Suggested endpoints:

- `GET /api/conversations`
- `GET /api/conversations/{id}`
- `GET /api/conversations/{id}/messages`
- `POST /api/conversations/{id}/messages`

### Settings

Required functionality:

- get current settings
- update settings

Suggested endpoints:

- `GET /api/settings`
- `PUT /api/settings`

## 5. Database Design Direction

### users

- id
- name
- email
- avatar_url
- password
- timestamps

### categories

- id
- name
- slug
- timestamps

### mentors

- id
- category_id
- name
- role
- bio
- avatar_seed
- avatar_url
- tasks_count
- rating
- reviews_count
- is_featured
- timestamps

### tasks

- id
- category_id
- mentor_id nullable
- title
- description
- status
- progress
- deadline_at
- started_at nullable
- completed_at nullable
- is_featured
- timestamps

### task_steps

- id
- task_id
- title
- is_completed
- sort_order
- timestamps

### task_user

- id
- task_id
- user_id
- role nullable
- timestamps

### mentor_followers

- id
- mentor_id
- user_id
- timestamps

### reviews

- id
- mentor_id
- user_id
- rating
- comment nullable
- timestamps

### conversations

- id
- subject nullable
- last_message_at nullable
- timestamps

### conversation_participants

- id
- conversation_id
- user_id
- timestamps

### messages

- id
- conversation_id
- sender_id
- body
- sent_at
- read_at nullable
- timestamps

### user_settings

- id
- user_id
- language
- timezone
- time_format
- notifications_enabled
- timestamps

## 6. Architecture

### Repository Pattern

Repositories will handle all database access.

Examples:

- `TaskRepositoryInterface`
- `MentorRepositoryInterface`
- `ConversationRepositoryInterface`
- `SettingsRepositoryInterface`
- `OverviewRepositoryInterface` if needed for aggregates

Implementation examples:

- `EloquentTaskRepository`
- `EloquentMentorRepository`
- `EloquentConversationRepository`
- `EloquentSettingsRepository`

Responsibilities:

- filtering
- pagination
- finding records
- aggregate queries
- follow/unfollow persistence
- fetching task steps
- fetching conversation messages

### Action / Command Pattern

Actions will contain the main business use cases.

Examples:

- `GetOverviewAction`
- `ListTasksAction`
- `GetTaskDetailsAction`
- `ListMentorsAction`
- `GetRecentMentorsAction`
- `FollowMentorAction`
- `UnfollowMentorAction`
- `ListConversationsAction`
- `GetConversationMessagesAction`
- `SendMessageAction`
- `GetSettingsAction`
- `UpdateSettingsAction`

Responsibilities:

- orchestrate repositories
- apply business rules
- validate domain assumptions
- prepare response-ready data

### Service Layer Pattern

Services will wrap external integrations.

Recommended external service for this test task:

- `AvatarServiceInterface`
- `DiceBearAvatarService`

Reason:

- the frontend already uses external avatar URLs
- this is a real but lightweight third-party integration
- it satisfies the service layer requirement without overcomplicating the project

Optional extra service:

- `NotificationServiceInterface`
- `LogNotificationService`

This can be used later for message or follow events, but it is not required for MVP.

## 7. Recommended Project Structure

```text
app/
  Actions/
    Overview/
    Task/
    Mentor/
    Conversation/
    Settings/
  Contracts/
    Repositories/
    Services/
  DTOs/
  Http/
    Controllers/Api/
    Requests/
    Resources/
  Models/
  Repositories/
  Services/
```

## 8. API MVP Priority

### Priority 1

- overview
- tasks
- mentors
- settings

### Priority 2

- conversations
- messages

If time becomes limited, the strongest delivery is:

- complete `overview`
- complete `tasks`
- complete `mentors`
- complete `settings`
- simplified `messages`

## 9. Suggested Delivery Order

1. Create Laravel 11 project
2. Configure PostgreSQL
3. Design migrations
4. Create models and relationships
5. Seed demo data
6. Implement repositories
7. Implement actions
8. Implement services
9. Add controllers, requests, resources, routes
10. Test endpoints
11. Write README with architecture explanation

## 10. Suggested Explanation for Reviewer

This backend is intentionally scoped to cover the core product flows shown in the provided frontend while keeping implementation realistic for a test task. The solution prioritizes architectural clarity:

- repositories for database access
- actions for business use cases
- services for external integrations

The API fully covers the most important screens and keeps messaging intentionally simplified by excluding realtime behavior.

## 11. Final MVP Decision

Best final scope for the test task:

- `Overview`: full
- `Tasks`: full
- `Mentors`: full
- `Settings`: full
- `Messages`: simplified but working
- `Service Layer`: external avatar integration through DiceBear

This scope is balanced, logical, and strong enough for demonstration in an interview setting.
