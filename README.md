# Catholic.Work WordPress Repository

This repository contains the custom WordPress plugins and themes for the Catholic.Work website, hosted on Hostinger Enterprise Cloud.

## 🎯 Purpose

This repository is designed to work with the **Gitium plugin** for seamless deployment and version control of WordPress themes and plugins between GitHub and your Hostinger hosting environment.

## 📁 Repository Structure

```
wp-content/
├── plugins/                    # Custom WordPress plugins
│   ├── catholic-work-custom/   # Sample custom plugin
│   └── README.md              # Plugin development guidelines
├── themes/                     # Custom WordPress themes  
│   ├── catholic-work-theme/    # Sample custom theme
│   └── README.md              # Theme development guidelines
└── mu-plugins/                 # Must-use plugins
    └── README.md              # Must-use plugins guidelines
```

## 🚀 Getting Started with Gitium Plugin

### Prerequisites
1. **Hostinger Enterprise Cloud** account with SSH access
2. **Gitium plugin** installed and activated on your WordPress site
3. **SSH key** configured for GitHub access
4. **GitHub repository** (this one) with proper permissions

### Setup Instructions

#### 1. Configure Gitium Plugin on WordPress
1. Log into your WordPress admin dashboard at `https://catholic.work/wp-admin`
2. Navigate to **Gitium** settings (usually under Tools or Settings)
3. Connect your GitHub repository: `schoedelpat/catholic-work`
4. Set up your SSH key for authentication
5. Configure the plugin to track the `wp-content` directory

#### 2. Initial Sync
1. In Gitium settings, perform an initial pull from this repository
2. Verify that the custom plugins and themes appear in your WordPress admin
3. Test that you can make changes and push them back to GitHub

#### 3. Development Workflow
1. **Clone this repository locally** for development:
   ```bash
   git clone git@github.com:schoedelpat/catholic-work.git
   cd catholic-work
   ```

2. **Make changes** to plugins or themes in the `wp-content` directory

3. **Test locally** (optional but recommended):
   - Set up a local WordPress development environment
   - Copy your changes to the appropriate wp-content directory
   - Test functionality

4. **Commit and push changes**:
   ```bash
   git add .
   git commit -m "Description of your changes"
   git push origin main
   ```

5. **Deploy via Gitium**:
   - The Gitium plugin will automatically detect changes
   - Pull the latest changes from GitHub through the WordPress admin
   - Changes will be live on your site

## 🔧 Development Guidelines

### For Plugins
- Create new plugins in `wp-content/plugins/your-plugin-name/`
- Follow WordPress plugin development standards
- Include proper plugin headers
- Test thoroughly before committing

### For Themes
- Create new themes in `wp-content/themes/your-theme-name/`
- Follow WordPress theme development standards
- Include proper theme headers in `style.css`
- Ensure responsive design and accessibility

### For Must-Use Plugins
- Place files directly in `wp-content/mu-plugins/`
- Use for critical functionality that should always be active
- Keep lightweight and essential

## 📋 Best Practices

1. **Always test locally** before pushing to production
2. **Use descriptive commit messages** for easy tracking
3. **Follow WordPress coding standards**
4. **Keep plugins and themes organized** in proper directories
5. **Document your code** for future maintenance
6. **Use proper version control** - commit frequently with small changes
7. **Backup before major changes** (Hostinger provides automated backups)

## 🚨 Important Notes

### What's Tracked in Git
- ✅ Custom plugins in `wp-content/plugins/`
- ✅ Custom themes in `wp-content/themes/`
- ✅ Must-use plugins in `wp-content/mu-plugins/`
- ❌ WordPress core files (handled by Hostinger)
- ❌ Uploads directory (media files)
- ❌ Cache files and temporary data

### Security Considerations
- Never commit sensitive data (passwords, API keys, etc.)
- Use environment variables for sensitive configuration
- Regularly update WordPress core through Hostinger
- Keep plugins and themes updated

## 🆘 Troubleshooting

### Common Issues

**Gitium plugin not syncing:**
1. Check SSH key configuration
2. Verify repository permissions
3. Ensure WordPress has write permissions to wp-content

**Changes not appearing on live site:**
1. Check if Gitium auto-deploy is enabled
2. Manually pull changes through Gitium interface
3. Clear any caching plugins

**Merge conflicts:**
1. Resolve conflicts in GitHub
2. Pull resolved changes through Gitium
3. Test functionality

## 📞 Support

For technical issues:
- **WordPress/Plugin Issues**: Check WordPress admin dashboard
- **Hosting Issues**: Contact Hostinger Enterprise Support
- **Repository Issues**: Create an issue in this GitHub repository

## 🤝 Contributing

1. Fork this repository
2. Create a feature branch
3. Make your changes
4. Test thoroughly
5. Submit a pull request

---

**Website**: [catholic.work](https://catholic.work)  
**Hosting**: Hostinger Enterprise Cloud  
**Repository**: [github.com/schoedelpat/catholic-work](https://github.com/schoedelpat/catholic-work)
