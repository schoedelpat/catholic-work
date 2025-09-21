# Must-Use Plugins Directory

This directory contains must-use (mu-plugins) for the Catholic.Work website.
These plugins are automatically activated and cannot be deactivated from the WordPress admin.

## Purpose
Must-use plugins are ideal for:
- Critical functionality that should always be active
- Site-specific customizations
- Core functionality that shouldn't be accidentally deactivated

## Structure
- Each plugin file should be placed directly in this directory
- Files in subdirectories will not be automatically loaded
- Follow WordPress plugin development standards

## Development Guidelines
- Keep mu-plugins lightweight and essential
- Use proper WordPress hooks and filters
- Follow WordPress Coding Standards
- Include proper documentation
- Test thoroughly as these cannot be easily deactivated