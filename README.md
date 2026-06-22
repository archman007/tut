Demo is at https://tut.archman.us User demo password password

# Tutorial Library

A PHP-based tutorial management system built with an MVC architecture. Manage tutorials, videos, instructors, categories, tags, and playlists.

## Features

- **Tutorial Management**: Create, edit, view, and delete tutorials with metadata
- **Video Management**: Upload and organize instructional videos
- **Instructor Profiles**: Manage instructor information and associations
- **Category & Tag System**: Organize content with categories and tags
- **Playlists**: Group tutorials and videos into curated playlists
- **User Authentication**: Login, registration, password reset
- **Admin Dashboard**: User management and role-based access control (RBAC)

## Requirements

- PHP 8.0+
- MySQL / MariaDB
- Apache with mod_rewrite (or alternative web server)

## Installation

1. Clone the repository to your web root:
   ```bash
   git clone <repo-url> /var/www/html/tut01
   ```

2. Import the database schema:
   ```bash
   mysql -u root -p < tut.sql
   ```

3. Configure database credentials in `.env`:
   ```env
   DB_HOST="localhost"
   DB_NAME="tutorial_library"
   DB_USER="your_user"
   DB_PASS="your_password"
   ```

4. Ensure the web server's document root points to the `public/` directory.

5. Enable URL rewriting (Apache `.htaccess` is included in `public/`).

## Directory Structure

```
├── app/
│   ├── Config/         # Configuration files
│   ├── Controllers/    # Request handlers
│   ├── Models/         # Database models
│   └── Views/          # Presentation templates
├── public/
│   ├── css/            # Stylesheets
│   ├── js/             # JavaScript files
│   ├── index.php       # Application entry point & router
│   └── .htaccess       # Apache rewrite rules
├── tut/                # Submodule / external resource
├── .env                # Environment configuration
├── tut.sql             # Database schema dump
└── README.md
```

## License

MIT
