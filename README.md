# Catholic.Work WordPress Site

This repository contains the complete WordPress website for Catholic.Work, a nonprofit organization focused on building community through faith, learning, and service.

## Overview

This WordPress site features four main components:

1. **Community Component** - Social networking and member engagement
2. **Learning Component** - Educational resources and course management  
3. **Ecommerce Component** - Donations and product sales
4. **Communications Component** - Messaging, forums, and announcements

## Site Architecture

### WordPress Theme: Catholic Work
- Custom responsive theme built with Bootstrap 5
- Integrated support for all four main components
- Accessibility-focused design
- Mobile-first responsive layout

### Core Functionality
- **BuddyPress** - Community and social features
- **LearnDash LMS** - Learning management system
- **WooCommerce** - Ecommerce and donations
- **bbPress** - Forums and discussions

## Quick Start

### For Developers

1. **Clone Repository**
   ```bash
   git clone https://github.com/schoedelpat/catholic-work.git
   cd catholic-work
   ```

2. **Set Up Local WordPress**
   - Install WordPress core files
   - Copy `wp-config-sample.php` to `wp-config.php` and configure
   - Import the custom theme from `wp-content/themes/catholic-work/`

3. **Install Required Plugins**
   See `PLUGINS.md` for complete list and installation order

4. **Activate Theme**
   - Upload theme to `wp-content/themes/`
   - Activate "Catholic Work" theme in WordPress admin

### For Site Administrators

1. **Review Documentation**
   - `DEPLOYMENT.md` - Hostinger Enterprise Cloud deployment guide
   - `PLUGINS.md` - Required and recommended plugins
   - Theme documentation in `wp-content/themes/catholic-work/`

2. **Configure Components**
   - Set up BuddyPress community features
   - Configure LearnDash for course management
   - Set up WooCommerce for donations and sales
   - Configure bbPress forums

## Site Structure

```
wp-content/
├── themes/
│   └── catholic-work/           # Custom theme
│       ├── functions.php        # Theme functionality
│       ├── header.php          # Site header
│       ├── footer.php          # Site footer
│       ├── index.php           # Main template
│       ├── sidebar.php         # Dynamic sidebar
│       ├── inc/                # Component functions
│       │   ├── community-functions.php
│       │   ├── learning-functions.php
│       │   ├── ecommerce-functions.php
│       │   └── communications-functions.php
│       └── assets/             # CSS, JS, images
│           ├── css/theme.css
│           └── js/theme.js
├── plugins/                    # WordPress plugins
├── uploads/                    # Media uploads
└── languages/                  # Translation files
```

## Component Features

### Community Component
- Member profiles and directories
- Activity streams and social interaction
- Community events management
- User groups and messaging
- Member registration and authentication

### Learning Component  
- Course creation and management
- Lesson progression tracking
- Quizzes and assessments
- Certificates and achievements
- Learning resource library

### Ecommerce Component
- Donation processing and campaigns
- Product catalog and sales
- Membership subscriptions
- Payment processing integration
- Order management and tracking

### Communications Component
- Discussion forums and topics
- Private messaging system
- Newsletter signups and management
- Announcement system
- Contact forms and inquiries

## Theme Features

### Responsive Design
- Mobile-first Bootstrap 5 framework
- Touch-friendly navigation
- Optimized for all device sizes
- High-contrast accessibility options

### Customization Options
- Custom post types for each component
- Widget areas for contextual content
- Custom navigation menus
- Color scheme customization
- Logo and branding options

### Performance Optimizations
- Minified CSS and JavaScript
- Image optimization support
- Caching compatibility
- CDN integration ready
- SEO-optimized markup

## Hosting Configuration

### Hostinger Enterprise Cloud
- PHP 8.1+ recommended
- MySQL 8.0+ database
- SSL certificate included
- CDN and caching enabled
- Daily automated backups

### Server Requirements
- PHP 8.1 or higher
- MySQL 5.7+ or MariaDB 10.3+
- 512MB+ memory limit
- mod_rewrite enabled
- SSL/HTTPS support

## Development Workflow

### Local Development
1. Use Local by Flywheel, XAMPP, or similar
2. Install WordPress core
3. Clone this repository to wp-content
4. Install and configure required plugins
5. Activate Catholic Work theme

### Staging Environment
- Test all changes on staging before production
- Use version control for theme and custom code
- Backup database before major updates
- Test plugin compatibility

### Production Deployment
- Follow deployment guide in `DEPLOYMENT.md`
- Use Hostinger Enterprise Cloud features
- Monitor performance and security
- Maintain regular backups

## Security Considerations

### WordPress Security
- Keep WordPress core updated
- Update all plugins and themes regularly
- Use strong passwords and two-factor authentication
- Install Wordfence Security plugin
- Regular security scans and monitoring

### Data Protection
- GDPR compliance for user data
- Secure payment processing
- Privacy policy and terms of service
- User consent management
- Data backup and recovery procedures

## Support and Maintenance

### Regular Updates
- WordPress core updates
- Plugin and theme updates
- Security patches and fixes
- Performance optimizations
- Content updates and improvements

### Monitoring
- Site uptime and performance
- Security threats and vulnerabilities
- User engagement and analytics
- Error logs and debugging
- Backup verification

### Support Resources
- WordPress documentation
- Plugin-specific support forums
- Hostinger support team
- Theme customization guides
- Community forums and resources

## Contributing

### For Developers
1. Fork the repository
2. Create feature branch
3. Make changes and test thoroughly
4. Submit pull request with detailed description
5. Follow WordPress coding standards

### For Content Contributors
1. Request access to WordPress admin
2. Follow content guidelines
3. Use appropriate categories and tags
4. Optimize images before upload
5. Review content before publishing

## License

This WordPress theme and associated code is licensed under GPL v2 or later, consistent with WordPress licensing.

## Contact

For technical support or questions about this implementation:
- Create an issue in this repository
- Contact the development team
- Refer to documentation in this repository

For site administration or content questions:
- Contact Catholic.Work administrators
- Use the site contact forms
- Refer to user documentation

---

**Catholic.Work** - Building community through faith, learning, and service.
