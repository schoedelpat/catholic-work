# Hostinger Enterprise Cloud Deployment Guide

## Pre-deployment Checklist

### 1. Domain and DNS Setup
- [ ] Domain registered and pointed to Hostinger nameservers
- [ ] SSL certificate configured (Hostinger provides free SSL)
- [ ] CDN enabled in Hostinger control panel

### 2. Hosting Environment Setup
- [ ] PHP version set to 8.1 or higher
- [ ] Database created in Hostinger control panel
- [ ] Database user created with full privileges
- [ ] File permissions set correctly (755 for directories, 644 for files)

### 3. WordPress Core Installation
- [ ] Download latest WordPress core files
- [ ] Upload to hosting directory
- [ ] Create wp-config.php from wp-config-sample.php
- [ ] Complete WordPress installation wizard

## Deployment Steps

### Step 1: Upload Theme and Core Files
```bash
# Upload all wp-content files to your hosting directory
# Ensure proper file permissions
find wp-content -type d -exec chmod 755 {} \;
find wp-content -type f -exec chmod 644 {} \;
```

### Step 2: Database Configuration
1. Create database in Hostinger control panel
2. Note database credentials:
   - Database name
   - Database username  
   - Database password
   - Database host (usually localhost)
3. Update wp-config.php with these credentials

### Step 3: Plugin Installation
Install plugins in this order:
1. **Security first**: Wordfence Security
2. **Core functionality**: BuddyPress, LearnDash, WooCommerce, bbPress
3. **Essential features**: Advanced Custom Fields, Yoast SEO
4. **Performance**: W3 Total Cache, Smush
5. **Additional features**: Contact Form 7, MailChimp integration

### Step 4: Theme Activation and Configuration
1. Activate the Catholic Work theme
2. Configure widget areas
3. Set up navigation menus
4. Configure theme customizer settings
5. Test all component functionality

### Step 5: Content Setup
1. Create essential pages:
   - Homepage
   - Community page
   - Learning/Courses page  
   - Shop page
   - Contact page
   - About page
   - Privacy Policy page
2. Configure WooCommerce setup wizard
3. Set up BuddyPress components
4. Create initial forum categories in bbPress

### Step 6: Security and Performance
1. Configure Wordfence Security settings
2. Set up automated backups with UpdraftPlus
3. Configure W3 Total Cache settings
4. Enable Hostinger's built-in caching
5. Test site speed and security

## Hostinger-Specific Configurations

### File Manager Access
- Use Hostinger File Manager or FTP/SFTP
- Default directory: public_html
- Ensure wp-content/uploads is writable (755)

### Database Management
- Access phpMyAdmin through Hostinger control panel
- Regular database backups recommended
- Monitor database size and optimize regularly

### Email Configuration
- Use Hostinger SMTP settings for WordPress emails
- Configure email accounts for contact forms
- Set up email forwarding if needed

### SSL and Security
- SSL automatically provided by Hostinger
- Force HTTPS in wp-config.php: `define('FORCE_SSL_ADMIN', true);`
- Use Cloudflare integration if available

### Performance Optimization
- Enable Hostinger's LiteSpeed caching
- Use Hostinger CDN for global content delivery
- Optimize images before upload
- Monitor resource usage in Hostinger dashboard

## Environment-Specific Settings

### Production Environment
```php
// wp-config.php additions for production
define('WP_DEBUG', false);
define('WP_DEBUG_LOG', false);
define('WP_DEBUG_DISPLAY', false);
define('DISALLOW_FILE_EDIT', true);
define('FORCE_SSL_ADMIN', true);
define('WP_POST_REVISIONS', 5);
```

### Staging Environment (Optional)
```php
// wp-config.php additions for staging
define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true);
define('WP_DEBUG_DISPLAY', false);
define('DISALLOW_INDEXING', true);
```

## Post-Deployment Testing

### Functionality Tests
- [ ] Homepage loads correctly
- [ ] All navigation menus work
- [ ] User registration and login
- [ ] BuddyPress community features
- [ ] LearnDash course access
- [ ] WooCommerce checkout process
- [ ] Contact forms submission
- [ ] Forum posting and replies

### Performance Tests
- [ ] Page load speed (aim for <3 seconds)
- [ ] Mobile responsiveness
- [ ] Cross-browser compatibility
- [ ] Image optimization working
- [ ] Caching functioning properly

### Security Tests
- [ ] SSL certificate active
- [ ] Admin area secured
- [ ] File permissions correct
- [ ] Backup system working
- [ ] Security scans passing

## Maintenance Schedule

### Daily
- Monitor site uptime
- Check error logs
- Review security alerts

### Weekly  
- Update plugins and themes
- Review user registrations
- Check backup status
- Monitor site performance

### Monthly
- Full security scan
- Database optimization
- Content review and updates
- Performance analysis

### Quarterly
- Full site backup download
- Plugin compatibility review
- Theme updates assessment
- Hosting plan review

## Support and Troubleshooting

### Hostinger Support
- 24/7 live chat support
- Knowledge base access
- Ticket system for complex issues

### WordPress Community Support
- WordPress.org forums
- Plugin-specific support forums
- Theme documentation

### Emergency Procedures
1. Site down: Check Hostinger status, review error logs
2. Security breach: Activate maintenance mode, contact Hostinger
3. Performance issues: Check caching, review recent changes
4. Database corruption: Restore from backup, contact support

## Backup and Recovery

### Automated Backups
- UpdraftPlus scheduled daily backups
- Hostinger automatic backups (weekly)
- Store backups in multiple locations

### Manual Backup Process
1. Export database via phpMyAdmin
2. Download all files via File Manager/FTP
3. Store securely off-site
4. Test backup restoration periodically

### Recovery Procedures
1. Identify issue scope
2. Restore from most recent clean backup
3. Review and fix underlying cause
4. Update security measures
5. Document incident for future reference