<h1 align="center">Real Estate Appointment System</h1>
<p align="center">
    <a href="https://github.com/RaihanulHoque/realestate_appointment">
        <img src="https://img.shields.io/github/followers/raihanulhoque?style=plat" alt="GitHub">
    </a>
    <a href="https://github.com/RaihanulHoque/realestate_appointment">
        <img src="https://img.shields.io/github/repo-size/raihanulhoque/realestate_appointment?color=green" alt="Repo Size">
    </a>
    <a href="LICENSE">
        <img src="http://img.shields.io/badge/license-MIT-brightgreen.svg" alt="MIT License">
    </a>
    <a href="https://twitter.com/raihansabuj1">
        <img src="https://img.shields.io/twitter/follow/raihansabuj1?style=social" alt="Twitter">
    </a>
    <a href="https://www.linkedin.com/in/raihanulhoque/">
        <img src="https://img.shields.io/badge/LinkedIn-0077B5?style=for-the-badge&logo=linkedin&logoColor=white" alt="LinkedIn" style="height:20px">
    </a>
</p>

A full-stack appointment scheduling system for real estate agents. Agents register, maintain a contact list of clients/leads, and schedule appointments with automatic travel-time calculations. The system has two decoupled parts that communicate only via a REST API over CORS.

---

## Table of Contents

- [Application Features](#application-features)
- [Tech Stack](#tech-stack)
- [Project Structure](#project-structure)
- [Installation Guide](#installation-guide)
  - [Backend Setup](#backend-setup)
  - [Frontend Setup](#frontend-setup)
- [Running the App](#running-the-app)
- [API Reference](#api-reference)
  - [Authentication](#authentication)
  - [Contacts](#contacts)
  - [Appointments](#appointments)
- [Testing](#testing)
- [Further Reading](#further-reading)

---

## Application Features

- Agent registration and JWT-secured login / logout / token refresh
- Each agent manages their own private contact list (clients/leads)
- Contacts store: name, surname, email, phone (11–13 chars), and full address
- Appointments are linked to a specific contact and a location address
- When an appointment is created or its start time is updated, the system automatically calculates:
  - **Departure time** — when the agent should leave the office
  - **Appointment end time** — start time + 1 hour (default duration)
  - **Return to office time** — estimated arrival back after the appointment
- Distances and travel times currently use placeholder values pending a live Google Maps API key (the integration code is in place — see `app/Services/AppointmentSchedulingService.php`)
- Full CRUD for both contacts and appointments
- Every user's data is fully private — no user can see or edit another user's records

---

## Tech Stack

### Backend
| Layer | Technology |
|---|---|
| Framework | Laravel 8.75 |
| Language | PHP 8.x |
| Authentication | tymon/jwt-auth (JWT bearer tokens) |
| Validation | Form Requests (per-action, strict rules) |
| Authorization | Laravel Policies (ownership checks) |
| Business logic | Service class (`AppointmentSchedulingService`) |
| API responses | API Resources (`ContactResource`, `AppointmentResource`) |
| Database | MySQL |

### Frontend
| Layer | Technology |
|---|---|
| Framework | React 18 (plain JavaScript) |
| Build tool | Vite |
| Styling | Tailwind CSS v4 |
| Routing | React Router v6 |
| Data fetching | TanStack React Query v5 |
| HTTP client | axios (with JWT interceptor + auto-refresh) |
| Notifications | react-hot-toast |
| Icons | Heroicons v2 |

---

## Project Structure

```
realestate_appointment/
  app/
    Http/
      Controllers/     AuthController, ContactController, AppointmentController
      Requests/        Form Request classes for all CRUD actions
      Resources/       ContactResource, AppointmentResource
    Models/            User, Contacts, Appointments
    Policies/          ContactPolicy, AppointmentPolicy
    Services/          AppointmentSchedulingService
    Traits/            ApiResponser (shared JSON response helpers)
  database/
    migrations/        Full schema including FK constraints and index fixes
  routes/
    api.php            All REST API routes (prefix: /api/auth/...)
    web.php            GET /docs (static API reference page)
  tests/               12 PHPUnit tests (feature + unit)
  docs/
    DEVELOPER_GUIDE.md Full technical documentation with architecture diagrams
    USER_GUIDE.md      End-user documentation for agents
  frontend/            React SPA (completely separate from Laravel's asset pipeline)
    src/
      api/             axios client, auth/contacts/appointments API calls
      components/      Layout, ConfirmDialog, Skeleton, EmptyState, FormField, etc.
      context/         AuthContext (JWT token + user state)
      hooks/           useContacts, useAppointments, useDarkMode
      pages/           Login, Register, Dashboard, Profile, Contacts, Appointments
```

---

## Installation Guide

### Backend Setup

```bash
# 1. Clone and install dependencies
git clone https://github.com/RaihanulHoque/realestate_appointment.git
cd realestate_appointment
composer install

# 2. Environment
cp .env.example .env
php artisan key:generate
php artisan jwt:secret        # required — generates JWT_SECRET in .env

# 3. Configure .env — set your database credentials:
#    DB_DATABASE=your_db_name
#    DB_USERNAME=your_username
#    DB_PASSWORD=your_password
#    CORS_ALLOWED_ORIGINS=http://localhost:5173   (or your frontend URL)

# 4. Database
php artisan migrate
```

> **Note:** If you plan to run `php artisan test`, the test suite is configured to use an isolated in-memory SQLite database — it will never touch your real MySQL database.

### Frontend Setup

```bash
cd frontend
npm install

# Copy and configure the environment file:
cp .env.example .env
# Default: VITE_API_BASE_URL=http://localhost:8000/api
# Change this if your backend runs on a different port/host
```

---

## Running the App

Both servers must run simultaneously. Open two terminals:

**Terminal 1 — Backend:**
```bash
php artisan serve
# API available at http://127.0.0.1:8000
```

**Terminal 2 — Frontend:**
```bash
cd frontend
npm run dev
# App available at http://localhost:5173
```

Open **http://localhost:5173** in your browser, register an account, and log in.

The static API documentation page is available at **http://127.0.0.1:8000/docs**.

---

## API Reference

All routes are prefixed with `/api/auth/`. Protected routes require:
```
Authorization: Bearer <your_jwt_token>
```

Validation errors return `422` with the error fields directly in the response body (e.g. `{"email": ["The email field is required."]}`).

---

### Authentication

#### POST `/api/auth/register`

**Request body:**
```json
{
    "name": "Md Raihanul",
    "email": "raihan@example.com",
    "phone": "07911123456",
    "password": "secret123",
    "password_confirmation": "secret123"
}
```

**Response `201`:**
```json
{
    "message": "User successfully registered",
    "user": {
        "id": 1,
        "name": "Md Raihanul",
        "email": "raihan@example.com",
        "phone": "07911123456",
        "created_at": "2026-06-27T10:00:00.000000Z",
        "updated_at": "2026-06-27T10:00:00.000000Z"
    }
}
```

---

#### POST `/api/auth/login`

**Request body:**
```json
{
    "email": "raihan@example.com",
    "password": "secret123"
}
```

**Response `200`:**
```json
{
    "access_token": "eyJ0eXAiOiJKV1Qi...",
    "token_type": "bearer",
    "expires_in": 3600,
    "user": {
        "id": 1,
        "name": "Md Raihanul",
        "email": "raihan@example.com",
        "phone": "07911123456",
        "address": "cm27pj"
    }
}
```

---

#### POST `/api/auth/logout` *(protected)*

**Response `200`:**
```json
{
    "message": "User successfully signed out"
}
```

---

#### POST `/api/auth/refresh` *(protected)*

Issues a new access token. Response shape is identical to `/login`.

---

#### GET `/api/auth/user-profile` *(protected)*

**Response `200`:**
```json
{
    "id": 1,
    "name": "Md Raihanul",
    "email": "raihan@example.com",
    "phone": "07911123456",
    "address": "cm27pj"
}
```

---

### Contacts

#### GET `/api/auth/contacts` *(protected)*

Returns only the authenticated agent's own contacts.

**Response `200`:**
```json
{
    "data": [
        {
            "id": 1,
            "name": "James",
            "surname": "Bond",
            "email": "james@example.com",
            "phone": "07700900123",
            "address": "10 Downing Street, London",
            "created_at": "2026-06-27T12:00:00.000000Z",
            "updated_at": "2026-06-27T12:00:00.000000Z"
        }
    ]
}
```

---

#### POST `/api/auth/contacts` *(protected)*

**Request body:**
```json
{
    "name": "James",
    "surname": "Bond",
    "email": "james@example.com",
    "phone": "07700900123",
    "address": "10 Downing Street, London"
}
```

Validation: `phone` must be 11–13 characters (e.g. `07911123456` or `+447911123456`).

**Response `200`:**
```json
{
    "success": true,
    "contact": {
        "id": 1,
        "name": "James",
        "surname": "Bond",
        "email": "james@example.com",
        "phone": "07700900123",
        "address": "10 Downing Street, London",
        "created_at": "2026-06-27T12:00:00.000000Z",
        "updated_at": "2026-06-27T12:00:00.000000Z"
    }
}
```

---

#### GET `/api/auth/contact/{id}` *(protected)*

**Response `200`:**
```json
{
    "data": {
        "id": 1,
        "name": "James",
        "surname": "Bond",
        "email": "james@example.com",
        "phone": "07700900123",
        "address": "10 Downing Street, London",
        "created_at": "2026-06-27T12:00:00.000000Z",
        "updated_at": "2026-06-27T12:00:00.000000Z"
    }
}
```

---

#### PUT `/api/auth/contact/{id}` *(protected)*

All fields are optional (partial update). Sends only the fields you want to change.

**Response `200`:**
```json
{
    "success": true
}
```

---

#### DELETE `/api/auth/contact/{id}` *(protected)*

**Response `200`:**
```json
{
    "success": true
}
```

---

### Appointments

#### GET `/api/auth/appointments` *(protected)*

**Response `200`:**
```json
{
    "data": [
        {
            "id": 1,
            "contact_id": 1,
            "appointment_address": "LU1 1AA",
            "measured_distance": "2km",
            "appointment_date": "2026-07-15",
            "appointment_start_time": "10:00:00",
            "departure_time_to_site_office": "09:30:00",
            "appointment_end_time": "11:00:00",
            "arrival_time_to_agent_office": "11:40:00",
            "created_at": "2026-06-27T12:00:00.000000Z",
            "updated_at": "2026-06-27T12:00:00.000000Z"
        }
    ]
}
```

---

#### POST `/api/auth/appointments` *(protected)*

`contact_id` must be an ID from the authenticated user's own contact list.

**Request body:**
```json
{
    "contact_id": 1,
    "appointment_date": "2026-07-15",
    "appointment_start_time": "10:00:00",
    "appointment_address": "LU1 1AA"
}
```

The server automatically calculates `departure_time_to_site_office`, `appointment_end_time`, and `arrival_time_to_agent_office`.

**Response `200`:**
```json
{
    "success": true,
    "appointment": {
        "id": 1,
        "contact_id": 1,
        "appointment_address": "LU11AA",
        "measured_distance": "2km",
        "appointment_date": "2026-07-15",
        "appointment_start_time": "10:00:00",
        "departure_time_to_site_office": "09:30:00",
        "appointment_end_time": "11:00:00",
        "arrival_time_to_agent_office": "11:40:00",
        "created_at": "2026-06-27T12:00:00.000000Z",
        "updated_at": "2026-06-27T12:00:00.000000Z"
    }
}
```

---

#### GET `/api/auth/appointment/{id}` *(protected)*

**Response `200`:**
```json
{
    "data": {
        "id": 1,
        "contact_id": 1,
        "appointment_address": "LU11AA",
        "measured_distance": "2km",
        "appointment_date": "2026-07-15",
        "appointment_start_time": "10:00:00",
        "departure_time_to_site_office": "09:30:00",
        "appointment_end_time": "11:00:00",
        "arrival_time_to_agent_office": "11:40:00",
        "created_at": "2026-06-27T12:00:00.000000Z",
        "updated_at": "2026-06-27T12:00:00.000000Z"
    }
}
```

---

#### PUT `/api/auth/appointment/{id}` *(protected)*

All fields are optional. If `appointment_start_time` is included, the server automatically recalculates `departure_time_to_site_office`, `appointment_end_time`, and `arrival_time_to_agent_office`.

**Response `200`:**
```json
{
    "success": true
}
```

---

#### DELETE `/api/auth/appointment/{id}` *(protected)*

**Response `200`:**
```json
{
    "success": true
}
```

---

## Testing

The test suite runs against an isolated **in-memory SQLite database** and never touches your real MySQL database.

```bash
php artisan test
```

Expected output: **12 tests, 35 assertions** — covering auth validation, contacts CRUD, appointments CRUD, cross-user authorization, and the scheduling service.

---

## Further Reading

| Document | Contents |
|---|---|
| [`docs/DEVELOPER_GUIDE.md`](docs/DEVELOPER_GUIDE.md) | Architecture diagrams, database schema, API request lifecycle, all bugs found and fixed, full local setup |
| [`docs/USER_GUIDE.md`](docs/USER_GUIDE.md) | End-user guide for real estate agents using the application |
