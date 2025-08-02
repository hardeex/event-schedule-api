# Event Scheduler API

Event Scheduler API, a  Laravel-based RESTful API designed for managing events and user authentication. This API allows users to register, log in, verify their email, manage passwords, and create or participate in events. It includes role-based access control (manager and user roles) and uses JWT for secure authentication. This README provides instructions to set up, configure, and use the API for personal or public use.

## Table of Contents

* Features
* Prerequisites
* Installation
* Configuration
* Database Setup
* Running the Application
* API Endpoints

  * Authentication Endpoints
  * Event Endpoints
* Postman Collection
* Testing
* Troubleshooting
* Contributing


---

## Features

### User Authentication:

* Register with email verification.
* Login with JWT-based authentication.
* Email verification and password reset functionality.
* Password change and confirmation.
* Logout and token invalidation.

### Event Management:

* Create,  and cancel events (manager-only).
* Register for events (users and managers).
* Check for event capacity and schedule conflicts.

### Role-Based Access Control:

* Managers can create and cancel events.
* Users can register for events.

### Other Highlights:

* Rate Limiting: Throttles login and registration attempts to prevent abuse.
* Logging: Detailed logging for debugging and monitoring.
* Validation: Robust input validation for all requests.
* Resources: Structured API responses using Laravel Resource classes.

---

## Prerequisites

Before cloning and running the project, ensure you have the following installed:

* **PHP:** Version 8.4 or higher
* **Composer:** PHP dependency manager
* **MySQL/PostgreSQL:** Supported database
* **Git:** Version control


### Laravel Requirements

Ensure PHP extensions:
`ext-curl, ext-json, ext-mbstring, ext-openssl, ext-pdo`, etc., are installed.

---

## Installation

### Clone the Repository

```bash
git clone https://github.com/hardeex/event-schedule-api
cd event-schedule-api
```

### Install PHP Dependencies

```bash
composer install
```


### Copy Environment File

```bash
cp .env.example .env
```

### Generate Application Key

```bash
php artisan key:generate
```

---

## Configuration

### Database Settings

Update your `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=event_scheduler
DB_USERNAME=root
DB_PASSWORD=your_password
```


```

### JWT Setup

```bash
php artisan jwt:secret
```

### App URL

```env
APP_URL=http://localhost:8000
```

---

## Database Setup

### Create the Database

```sql
CREATE DATABASE event-schedule-api;
```

### Run Migrations

```bash
php artisan migrate
```


---

## Running the Application

### Start Server

```bash
php artisan serve
```

Access via: `http://localhost:8000`

---

## API Endpoints

### Authentication Endpoints

| Method | Endpoint                    | Description               |
| ------ | --------------------------- | ------------------------- |
| POST   | /api/register               | Register new user         |
| POST   | /api/login                  | Login and receive JWT     |
| GET    | /api/verify/email           | Verify email token        |
| POST   | /api/email/resend           | Resend verification email |
| POST   | /api/password/confirm       | Confirm password          |
| POST   | /api/password/reset-request | Request password reset    |
| POST   | /api/password/reset         | Reset password            |
| POST   | /api/password/change        | Change password (auth)    |
| POST   | /api/logout                 | Logout user               |
| GET    | /api/me                     | Get user profile (auth)   |

### Event Endpoints

| Method | Endpoint                | Description            |
| ------ | ----------------------- | ---------------------- |
| GET    | /api/events             | List all events        |
| GET    | /api/events/{id}        | View event details     |
| POST   | /api/events/register    | Register user to event |
| POST   | /api/events             | Create event (manager) |
| DELETE | /api/events/delete/{id} | Cancel event (manager) |

---

## Example Requests

### Register

```bash
curl -X POST http://localhost:8000/api/register \
-H "Content-Type: application/json" \
-d '{"name": "John Doe", "email": "john@example.com", "password": "Password123", "password_confirmation": "Password123", "role": "user"}'
```

### Login

```bash
curl -X POST http://localhost:8000/api/login \
-H "Content-Type: application/json" \
-d '{"email": "john@example.com", "password": "Password123"}'
```

### Create Event

```bash
curl -X POST http://localhost:8000/api/events \
-H "Authorization: Bearer <JWT_TOKEN>" \
-H "Content-Type: application/json" \
-d '{"name": "Tech Meetup", "start_datetime": "2025-09-01", "end_datetime": "2025-09-01", "max_participants": 50}'
```

---

## Postman Collection

Use the pre-configured collection to test endpoints easily:
[Event Scheduler API Postman Collection](https://connectnest-hub.postman.co/workspace/connectNest-Hub-Workspace~5dfa6748-bfd1-4bdb-860c-685afa146d54/collection/37260121-02dbde0d-cb46-4f22-aca0-62ea98863ed2?action=share&creator=37260121)

---


## Troubleshooting

### Database Errors

* Ensure credentials in `.env` are correct
* Confirm the database service is running


### JWT Issues

* Run `php artisan jwt:secret`
* Check for expired/invalid tokens

### Logs

* Laravel logs can be found at `storage/logs/laravel.log`

---

## Contributing

1. Fork the repo
2. Create a branch `git checkout -b feature/your-feature`
3. Commit your changes
4. Push to your branch
5. Open a Pull Request

---


---

