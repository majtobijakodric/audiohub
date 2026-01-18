# AudioHub - AI Coding Agent Instructions

## Project Overview
AudioHub is a PHP-based web application for audio file management and streaming. The project is in early development with basic authentication scaffolding.

## Architecture & Structure

### Core Components
- **Frontend**: Vanilla HTML login form in [index.html](../index.html)
- **Backend**: PHP scripts handling authentication and business logic
- **Storage**: `/storage/music/` for audio files, `/storage/logs/` for application logs (both git-ignored)
- **Database**: MySQL/MariaDB with credentials in `.env` (use [.env.example](../.env.example) as template)

### Key Files
- [login.php](../login.php): Authentication endpoint, currently echoes credentials for testing (needs secure implementation)
- [.env.example](../.env.example): Database configuration template for `audiohub` database

## Development Patterns

### Environment Setup
1. Copy `.env.example` to `.env` and configure database credentials
2. Create `storage/music/` and `storage/logs/` directories if they don't exist
3. Ensure PHP has write permissions to storage directories

### Security Conventions
- **Password Handling**: Use `password_hash()` for storing, `password_verify()` for validation (NOT plain text)
- **Input Sanitization**: Always use `htmlspecialchars()` for output, prepared statements for database queries
- **Session Management**: TODO - implement PHP sessions after database authentication is added

### Database Patterns
- Database name: `audiohub`
- Connection details loaded from `.env` file
- TODO: Schema not yet defined - needs users table, audio metadata tables

## Current Development State
⚠️ **Early Stage**: The project has minimal functionality:
- Basic login form exists but authentication logic is incomplete
- Database integration is stubbed out
- No audio upload/streaming features implemented yet
- `src/` directory is empty and awaiting modular code organization

## Next Steps for Development
1. Implement database schema (users table with hashed passwords)
2. Complete authentication logic in [login.php](../login.php) (replace echo statements with DB validation)
3. Add session management and protected routes
4. Create audio upload and management functionality
5. Organize reusable PHP code into `src/` directory (consider classes for DB, Auth, FileManager)

## Testing & Debugging
- No automated tests exist yet
- Manual testing via browser at `index.html` → `login.php` flow
- Check `storage/logs/` for application logs when logging is implemented
