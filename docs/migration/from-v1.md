# Migration Guide: v1 to v2

This guide will help you migrate from `cloudstudioiot-wordpress-stack` (v1) to `cloudstudioiot-wordpress-stack-v2`.

## 🎯 Overview

Version 2 is a **complete rewrite** with modern architecture:

- ✅ Monorepo structure with pnpm workspaces
- ✅ TypeScript for all JavaScript assets
- ✅ Vite for lightning-fast builds
- ✅ Zero infinite loops (complete rewrite of problematic code)
- ✅ PHP 8.1+ with modern features
- ✅ Better performance and maintainability

## ⚠️ Breaking Changes

### Plugin Changes

1. **Minimum Requirements**
   - PHP: 7.4 → **8.1**
   - WordPress: 6.0 → **6.4**
   - Elementor: 3.10 → **3.10** (same)

2. **Asset Structure**
   - Old: `/assets/css/` and `/assets/js/`
   - New: `/dist/` (built from `/src/assets/`)

3. **No More Infinite Loops**
   - Dynamic select2 completely rewritten
   - Link selection now uses proper AJAX without triggering Elementor AI
   - All widget renders optimized

4. **Component System**
   - Components now use PHP 8.1 type declarations
   - Stricter type safety
   - Better error handling

### Theme Changes

1. **CSS Architecture**
   - Old: Multiple separate CSS files
   - New: Single built `main.css` from modular source

2. **JavaScript**
   - Old: Vanilla JS files
   - New: TypeScript compiled to modern ES modules

3. **Dark Mode**
   - Now built-in with localStorage persistence
   - Customizer integration

## 📋 Migration Steps

### Step 1: Backup Everything

```bash
# Backup your current installation
wp db export backup-$(date +%Y%m%d).sql
tar -czf wp-content-backup-$(date +%Y%m%d).tar.gz wp-content/
```

### Step 2: Check PHP Version

```bash
php -v
# Must be 8.1 or higher
```

If PHP < 8.1, upgrade your server first.

### Step 3: Deactivate v1 Plugin and Theme

```bash
wp plugin deactivate cloudstudio-elementor-widgets
wp theme activate hello-elementor  # Switch to parent theme temporarily
```

### Step 4: Install v2

#### Option A: Build from Source

```bash
# Clone v2 repo
git clone https://github.com/Sobdev/cloudstudioiot-wordpress-stack-v2.git
cd cloudstudioiot-wordpress-stack-v2

# Install dependencies
pnpm install
composer install

# Build
pnpm build

# Install on WordPress
wp plugin install builds/cloudstudio-elementor-widgets-v2.0.0.zip --activate
wp theme install builds/cloudstudio-hello-child-v2.0.0.zip --activate
```

#### Option B: Upload Pre-built ZIPs

1. Download latest builds from GitHub Releases
2. Upload via WordPress admin
3. Activate plugin and theme

### Step 5: Test Widgets

1. Open Elementor editor
2. Test each CloudStudio widget
3. Verify no infinite loops in sidebar
4. Check console for errors

### Step 6: Update Custom Code

If you have custom code that hooks into v1:

```php
// OLD v1 code
add_filter('cloudstudio_widget_defaults', function($defaults) {
    // ...
});

// NEW v2 code - namespace required
add_filter('CloudStudio\ElementorWidgets\widget_defaults', function($defaults) {
    // ...
});
```

### Step 7: Clear All Caches

```bash
# WordPress object cache
wp cache flush

# Elementor cache
wp elementor flush_css

# Browser cache (hard refresh)
# Ctrl+Shift+R (Windows/Linux)
# Cmd+Shift+R (Mac)
```

## 🔍 Troubleshooting

### Issue: "Plugin requires PHP 8.1"

**Solution**: Upgrade your server's PHP version to 8.1 or higher.

### Issue: "Assets not loading"

**Solution**: 
1. Check that `/dist/` folder exists in plugin/theme
2. Rebuild: `pnpm build`
3. Clear caches

### Issue: "Widgets missing in Elementor"

**Solution**:
1. Verify plugin is activated
2. Check Elementor minimum version (3.10+)
3. Regenerate Elementor files: `wp elementor flush_css`

### Issue: "Dark mode not working"

**Solution**:
1. Clear localStorage: `localStorage.removeItem('cloudstudio-dark-mode')`
2. Check customizer setting
3. Rebuild theme: `pnpm build:theme`

## 🆕 New Features to Explore

### 1. TypeScript Benefits

All JavaScript is now type-safe:

```typescript
// Example: Extending theme functionality
declare global {
  interface Window {
    cloudstudioTheme: {
      version: string;
      ajaxUrl: string;
      nonce: string;
    };
  }
}

// Now you get autocomplete!
console.log(window.cloudstudioTheme.version);
```

### 2. Vite Dev Mode

Development is now much faster:

```bash
# Start dev servers with Hot Module Replacement
pnpm dev

# Edit files and see changes instantly (no page refresh!)
```

### 3. Modern CSS

CSS now uses design tokens:

```css
/* Use predefined variables */
.my-component {
  padding: var(--spacing-4);
  color: var(--color-primary);
  border-radius: var(--border-radius-md);
}
```

### 4. Component-Based Architecture

```php
<?php
// Extend existing components easily
use CloudStudio\ElementorWidgets\Components\Button_Component;

class My_Custom_Widget extends Widget_Base {
    protected function render(): void {
        // Use built-in components
        Button_Component::render([
            'text' => 'Click me',
            'url' => 'https://example.com',
            'icon' => 'fas fa-arrow-right',
        ]);
    }
}
```

## 📚 Additional Resources

- [Architecture Overview](./architecture/README.md)
- [Widget Development Guide](./development/widget-guide.md)
- [API Reference](./api/README.md)
- [Troubleshooting Guide](./troubleshooting.md)

## 🆘 Need Help?

- **Email**: support@cloud.studio
- **Documentation**: https://docs.cloud.studio
- **GitHub Issues**: https://github.com/Sobdev/cloudstudioiot-wordpress-stack-v2/issues

---

**Made with 🚀 by Cloud Studio IoT**
