# WordPress Development Configuration

This file contains suggested configuration settings for local WordPress development that matches your Hostinger production environment.

## Local Development Setup

### Recommended Local Environment
- **XAMPP**, **WAMP**, **Local by Flywheel**, or **Docker**
- **PHP 8.0+** (to match Hostinger)
- **MySQL 5.7+** or **MariaDB**
- **Apache** or **Nginx**

### wp-config.php Settings for Development

Add these constants to your local `wp-config.php` file:

```php
// Enable debugging
define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true);
define('WP_DEBUG_DISPLAY', false);
define('SCRIPT_DEBUG', true);

// Memory limit
define('WP_MEMORY_LIMIT', '256M');

// Automatic updates (disable for development)
define('AUTOMATIC_UPDATER_DISABLED', true);

// File editing (disable for security)
define('DISALLOW_FILE_EDIT', true);

// SSL settings (if using https locally)
define('FORCE_SSL_ADMIN', false);
```

### Database Settings

For local development, use these settings in wp-config.php:

```php
define('DB_NAME', 'catholic_work_local');
define('DB_USER', 'root');
define('DB_PASSWORD', '');
define('DB_HOST', 'localhost');
define('DB_CHARSET', 'utf8mb4');
define('DB_COLLATE', '');
```

### Directory Structure for Local Development

Your local WordPress installation should have this structure:

```
wordpress/
├── wp-admin/
├── wp-includes/
├── wp-content/
│   ├── plugins/
│   │   ├── [standard WordPress plugins]
│   │   └── [your custom plugins from this repo]
│   ├── themes/
│   │   ├── [default WordPress themes]
│   │   └── [your custom themes from this repo]
│   ├── mu-plugins/
│   │   └── [your must-use plugins from this repo]
│   └── uploads/
├── wp-config.php
└── index.php
```

## Syncing with This Repository

### Option 1: Direct Sync (Recommended)
Create symlinks from your local wp-content directories to this repository:

```bash
# Navigate to your local WordPress installation
cd /path/to/your/local/wordpress/wp-content

# Create symlinks (Linux/Mac)
ln -s /path/to/this/repo/wp-content/plugins/catholic-work-custom plugins/catholic-work-custom
ln -s /path/to/this/repo/wp-content/themes/catholic-work-theme themes/catholic-work-theme
ln -s /path/to/this/repo/wp-content/mu-plugins/cw-security.php mu-plugins/cw-security.php

# For Windows (run as administrator)
mklink /D plugins\catholic-work-custom C:\path\to\this\repo\wp-content\plugins\catholic-work-custom
mklink /D themes\catholic-work-theme C:\path\to\this\repo\wp-content\themes\catholic-work-theme
mklink mu-plugins\cw-security.php C:\path\to\this\repo\wp-content\mu-plugins\cw-security.php
```

### Option 2: Copy and Sync Manually
Copy files from this repository to your local WordPress installation when you want to test:

```bash
# Copy custom plugin
cp -r /path/to/this/repo/wp-content/plugins/catholic-work-custom /path/to/wordpress/wp-content/plugins/

# Copy custom theme
cp -r /path/to/this/repo/wp-content/themes/catholic-work-theme /path/to/wordpress/wp-content/themes/

# Copy must-use plugins
cp /path/to/this/repo/wp-content/mu-plugins/*.php /path/to/wordpress/wp-content/mu-plugins/
```

## Testing Workflow

1. **Set up local environment** with WordPress
2. **Sync files** from this repository
3. **Activate plugins/themes** in WordPress admin
4. **Test functionality** thoroughly
5. **Make changes** in this repository
6. **Test changes** locally
7. **Commit and push** when satisfied
8. **Deploy via Gitium** to production

## Useful Development Tools

### WordPress CLI (WP-CLI)
Install WP-CLI for command-line WordPress management:
```bash
# Download and install WP-CLI
curl -O https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar
chmod +x wp-cli.phar
sudo mv wp-cli.phar /usr/local/bin/wp

# Test installation
wp --info
```

### Debugging Tools
- **Query Monitor** plugin for debugging
- **Debug Bar** plugin for development
- Browser developer tools for frontend debugging
- **Xdebug** for PHP debugging

### Code Quality Tools
- **PHP_CodeSniffer** with WordPress Coding Standards
- **ESLint** for JavaScript
- **Stylelint** for CSS

## Production Environment Notes

### Hostinger Enterprise Cloud Specifics
- **PHP Version**: 8.0+ (check your control panel)
- **Memory Limit**: Usually 256MB or higher
- **Max Execution Time**: Usually 30 seconds
- **File Upload Limit**: Check in WordPress admin > Media

### Performance Considerations
- Use caching plugins if available
- Optimize images before uploading
- Minimize HTTP requests
- Use CDN if available through Hostinger

---

Remember: Always test locally before deploying to production!