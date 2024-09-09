# Task Management API

## Overview

The Task Management API is designed to provide a robust and flexible solution for managing tasks, assignments, and user roles in an organization. Built using the **Laravel** framework, this API offers functionality for managing tasks, assigning users to tasks, and updating the status of tasks. It also includes user management, authentication (with JWT tokens), and role-based access control.

This API can be integrated with frontend or mobile applications to handle tasks efficiently within teams, with the capability to control permissions for different user roles, including **Admin**, **Manager**, and **User**.

---

## Features

1. **Authentication and Authorization**: 
   - JWT-based authentication for secure API access.
   - Role-based access control for **Admin**, **Manager**, and **User** roles.
   
2. **Task Management**:
   - Create, read, update, and delete tasks.
   - Filter tasks by priority and status.
   - Assign tasks to specific users.
   - Update task statuses (e.g., pending, in-progress, completed).
   
3. **User Management**:
   - Create and manage users.
   - Update user details.
   - Delete users (restricted to **Admin**).
   
4. **Soft Deletes**:
   - Users and tasks are soft-deleted, allowing data to be restored or audited.

---

## Requirements

- **PHP** >= 8.0
- **Laravel** >= 9.x
- **MySQL** or any other database supported by Laravel
- **Composer** to manage dependencies

---

## Installation

1. Clone the repository:

    ```bash
    git clone https://github.com/zzeeii/task-management-api.git
    cd task-management-api
    ```

2. Install dependencies:

    ```bash
    composer install
    ```

3. Set up environment variables:
   - Copy `.env.example` to `.env`.
   
    ```bash
    cp .env.example .env
    ```

   - Configure your database settings, JWT secret, and other environment variables in the `.env` file.

    ```bash
    php artisan key:generate
    php artisan jwt:secret
    ```

4. Run migrations and seed the database:

    ```bash
    php artisan migrate --seed
    ```

5. Run the application locally:

    ```bash
    php artisan serve
    ```

---

## API Endpoints

### Authentication

1. **Login**  
   - **URL**: `/api/login`
   - **Method**: `POST`
   - **Body**:
     ```json
     {
       "email": "z@gmail.com",
       "password": "123456"
     }
     ```
   - **Response**: JWT Token and User Info

2. **Register (Admin-only)**  
   - **URL**: `/api/users`
   - **Method**: `POST`
   - **Body**:
     ```json
     {
       "name": "zein",
       "email": "zein@gmail.com",
       "password": "123456",
       "role": "user"
     }
     ```

3. **Logout**  
   - **URL**: `/api/logout`
   - **Method**: `POST`
   - **Authorization**: Bearer token

4. **Refresh Token**  
   - **URL**: `/api/refresh`
   - **Method**: `POST`
   - **Authorization**: Bearer token

---

### Tasks

1. **Get All Tasks**  
   - **URL**: `/api/tasks`
   - **Method**: `GET`
   - **Authorization**: Bearer token
   - **Query Params**: `priority`, `status` (Optional)
   - **Response**: List of tasks with users

2. **Get Single Task**  
   - **URL**: `/api/tasks/{id}`
   - **Method**: `GET`
   - **Authorization**: Bearer token
   - **Response**: Task details

3. **Create a Task**  
   - **URL**: `/api/tasks`
   - **Method**: `POST`
   - **Authorization**: Bearer token (Admin or Manager)
   - **Body**:
     ```json
     {
       "title": "New Task",
       "description": "Task description",
       "priority": "high",
       "due_date": "12-09-2024 15:00",
       "status": "pending"
     }
     ```

4. **Update a Task**  
   - **URL**: `/api/tasks/{id}`
   - **Method**: `PUT`
   - **Authorization**: Bearer token (Admin or Manager)
   - **Body**: Same as the create task body

5. **Delete a Task**  
   - **URL**: `/api/tasks/{id}`
   - **Method**: `DELETE`
   - **Authorization**: Bearer token (Admin or Manager)
   - **Response**: `204 No Content`

6. **Assign a Task to a User**  
   - **URL**: `/api/tasks/{id}/assign`
   - **Method**: `POST`
   - **Authorization**: Bearer token (Admin or Manager)
   - **Body**:
     ```json
     {
       "assigned_to": 2
     }
     ```

7. **Update Task Status**  
   - **URL**: `/api/tasks/{id}/Status`
   - **Method**: `PUT`
   - **Authorization**: Bearer token (Assigned User or Admin)
   - **Body**:
     ```json
     {
       "status": "completed"
     }
     ```

---

### Users

1. **Get All Users**  
   - **URL**: `/api/users`
   - **Method**: `GET`
   - **Authorization**: Bearer token (Admin or Manager)

2. **Update User**  
   - **URL**: `/api/users/{id}`
   - **Method**: `PUT`
   - **Authorization**: Bearer token (Admin or the user themselves)
   - **Body**: Fields to update (e.g., name, email)

3. **Delete User**  
   - **URL**: `/api/users/{id}`
   - **Method**: `DELETE`
   - **Authorization**: Bearer token (Admin)

---

## User Roles

- **Admin**:
  - Can manage all users.
  - Can create, update, delete, and assign tasks.
  
- **Manager**:
  - Can create, update, delete tasks.
  - Can assign tasks to users.
  
- **User**:
  - Can view assigned tasks.
  - Can update the status of their assigned tasks.

---

## Security

- **Authentication**: JWT Tokens are used to authenticate API requests. You need to pass the token in the `Authorization` header as `Bearer {token}`.
- **Role-Based Access**: Various functionalities are restricted based on the role of the user (e.g., only Admins can delete users).

---



