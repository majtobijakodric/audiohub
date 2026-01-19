# AudioHub - AI Coding Agent Instructions

## Project Overview
AudioHub is a PHP-based web application for audio file management and streaming. The project is in early development with basic authentication functionality implemented.

## Architecture & Structure

### Core Components
- **Frontend**: Vanilla HTML login form in [index.php](../index.php)
- **Backend**: PHP scripts handling authentication and business logic
- **Storage**: `/storage/music/` for audio files, `/storage/logs/` for application logs (both git-ignored)
- **Database**: MySQL/MariaDB with credentials in `.env` (use [.env.example](../.env.example) as template)

### Key Files
- [index.php](../index.php): Main login form (HTML only, no session needed)
- [login.php](../login.php): Authentication endpoint with database validation and session management
- [create_acc.php](../create_acc.php): User registration endpoint
- [dashboard.php](../dashboard.php): Protected page for authenticated users
- [src/database.php](../src/database.php): Singleton Database class for connection management
- [.env](../.env): Database configuration (DB_HOST, DB_NAME, DB_USER, DB_PASS)

## Development Patterns

### Environment Setup
1. Copy `.env.example` to `.env` and configure database credentials
2. Create `storage/music/` and `storage/logs/` directories if they don't exist
3. Ensure PHP has write permissions to storage directories
4. Database connection uses `utf8mb4` charset for proper international character support

### Security Conventions
- **Password Handling**: Currently using plain-text passwords for testing. Switch to `password_hash()` for storing and `password_verify()` for validation before production
- **Input Sanitization**: Always use `htmlspecialchars()` for output, prepared statements for database queries
- **Session Management**: `session_start()` required only in files that read/write `$_SESSION` data (login.php, dashboard.php, logout.php, etc.)
- **SQL Injection Prevention**: All database queries use prepared statements with `bind_param()`

### Database Patterns
- Database name: `audiohub`
- Connection details loaded from `.env` file via singleton `Database` class
- Connection uses `mysqli` with prepared statements
- Current schema: `users` table with `id`, `username`, `password` columns
- All database interactions use `$conn->prepare()` with parameter binding

### Code Organization
- **Reusable Classes**: Place in `src/` directory (e.g., `src/database.php`)
- **Entry Points**: Root-level PHP files (index.php, login.php, register.php, dashboard.php)
- **Views**: Keep HTML in separate files or at root level for simplicity
- **Include Pattern**: Use `require_once __DIR__ . '/path/to/file.php'` for file inclusion

## Current Development State
✅ **Functional Authentication**: 
- Login form submits to `login.php`
- Database validation with prepared statements
- Session storage of user credentials (`$_SESSION['user_id']`, `$_SESSION['username']`)
- Redirect to `dashboard.php` on successful login
- Plain-text password comparison (testing only - needs hashing for production)

⚠️ **Still Missing**:
- User registration form and `create_acc.php` implementation
- `dashboard.php` protected page with session validation
- Logout functionality
- Password hashing (switch from plain-text when ready)
- Audio upload/streaming features
- Error logging to `storage/logs/`

## Next Steps for Development
1. Create `register.php` form and complete `create_acc.php` registration logic
2. Build `dashboard.php` with session authentication check
3. Add logout functionality (`logout.php`)
4. Switch to hashed passwords (`password_hash()` / `password_verify()`)
5. Implement error logging to `storage/logs/error.log`
6. Add audio upload and management functionality
7. Create audio metadata tables in database schema

## Testing & Debugging
- Manual testing via browser: `index.php` → `login.php` → `dashboard.php`
- Test user exists in database (username: `maj`, password: `123`)
- No automated tests exist yet
- Use browser developer tools to inspect POST requests and redirects
- Check `storage/logs/` for application logs when logging is implemented
- For debugging database issues, verify `.env` credentials match MySQL setup

## Common Patterns

### Database Connection
```php
require_once __DIR__ . '/src/database.php';
$db = Database::getInstance();
$conn = $db->getConnection();
```

### Prepared Statement Query
```php
$stmt = $conn->prepare('SELECT id, password FROM users WHERE username = ?');
$stmt->bind_param('s', $username);
$stmt->execute();
$stmt->store_result();
if ($stmt->num_rows === 1) {
    $stmt->bind_result($user_id, $stored_password);
    $stmt->fetch();
}
$stmt->close();
```

### Session Authentication Check
```php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}
```