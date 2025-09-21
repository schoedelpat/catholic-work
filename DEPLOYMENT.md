# Deployment Guide for Catholic.Work

This guide explains how to deploy changes from this GitHub repository to your Hostinger-hosted WordPress site using the Gitium plugin.

## 🔄 Deployment Process Overview

1. **Local Development** → **GitHub Repository** → **Gitium Plugin** → **Live WordPress Site**

## 📋 Pre-Deployment Checklist

- [ ] Changes tested locally or in staging environment
- [ ] Code follows WordPress coding standards
- [ ] No sensitive data (passwords, API keys) included
- [ ] Proper commit messages written
- [ ] Changes documented if necessary

## 🚀 Deployment Steps

### Method 1: Automatic Deployment (Recommended)

If you have Gitium configured for automatic deployment:

1. **Push to GitHub**:
   ```bash
   git add .
   git commit -m "Your descriptive commit message"
   git push origin main
   ```

2. **Verify Deployment**:
   - Wait 1-2 minutes for automatic sync
   - Check your WordPress admin for new plugins/themes
   - Test functionality on the live site

### Method 2: Manual Deployment

If automatic deployment is disabled:

1. **Push to GitHub** (same as above)

2. **Login to WordPress Admin**:
   - Go to `https://catholic.work/wp-admin`
   - Navigate to Gitium settings

3. **Pull Changes**:
   - Click "Pull changes from repository"
   - Review the changes before applying
   - Confirm the deployment

4. **Verify Changes**:
   - Check that plugins/themes are updated
   - Test functionality

## 🔍 Post-Deployment Verification

### Plugin Deployment
- [ ] Plugin appears in WordPress admin plugins list
- [ ] Plugin can be activated without errors
- [ ] Plugin functionality works as expected
- [ ] No PHP errors in debug log

### Theme Deployment
- [ ] Theme appears in WordPress admin themes list
- [ ] Theme can be activated without errors
- [ ] Theme displays correctly on frontend
- [ ] No styling or layout issues

### Must-Use Plugin Deployment
- [ ] Plugin functionality is active immediately
- [ ] No conflicts with existing plugins
- [ ] No PHP errors in debug log

## 🚨 Rollback Procedure

If something goes wrong after deployment:

### Quick Rollback via Gitium
1. Go to Gitium settings in WordPress admin
2. View commit history
3. Revert to previous working commit
4. Pull the reverted changes

### Emergency Rollback via Hostinger
1. Access Hostinger control panel
2. Use file manager or SSH to restore from backup
3. Contact Hostinger support if needed

## 📊 Monitoring and Maintenance

### Regular Checks
- Monitor WordPress error logs after deployments
- Check website functionality weekly
- Update WordPress core through Hostinger when needed
- Keep this repository in sync with live site changes

### Performance Monitoring
- Use Hostinger's built-in performance tools
- Monitor page load times after major updates
- Check for plugin conflicts after deployments

## 🛡️ Security Best Practices

### Before Deployment
- Never commit sensitive configuration data
- Review code for security vulnerabilities
- Ensure proper input validation and sanitization

### After Deployment
- Monitor for unusual activity
- Keep WordPress core and plugins updated
- Regular security scans (if available in Hostinger)

## 📞 Support and Troubleshooting

### Common Deployment Issues

**"Permission denied" errors:**
- Check Hostinger file permissions
- Verify SSH key configuration in Gitium

**Changes not appearing:**
- Clear WordPress cache
- Check if manual pull is required
- Verify correct branch is being pulled

**Plugin/Theme activation errors:**
- Check WordPress error logs
- Verify all required files are committed
- Test in staging environment first

### Getting Help
- **Gitium Issues**: Check plugin documentation
- **Hostinger Issues**: Contact Hostinger Enterprise Support
- **Code Issues**: Review WordPress Codex and debugging guides

---

Remember: Always backup before major deployments and test thoroughly!