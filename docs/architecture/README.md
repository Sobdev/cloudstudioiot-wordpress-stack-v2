# CloudStudio WordPress Stack v2 - Architecture

## 🏗️ System Overview

```
┌─────────────────────────────────────────────────────────────┐
│                     Browser / User                          │
└────────────────────────┬────────────────────────────────────┘
                         │
                         ▼
┌─────────────────────────────────────────────────────────────┐
│                    WordPress Core                           │
│  ┌──────────────────────────────────────────────────────┐  │
│  │              Elementor Page Builder                  │  │
│  │  ┌────────────────────────────────────────────────┐ │  │
│  │  │      CloudStudio Elementor Widgets Plugin      │ │  │
│  │  │  - 9 Custom Widgets                            │ │  │
│  │  │  - Component System                            │ │  │
│  │  │  - TypeScript Assets (Vite built)              │ │  │
│  │  └────────────────────────────────────────────────┘ │  │
│  └──────────────────────────────────────────────────────┘  │
│  ┌──────────────────────────────────────────────────────┐  │
│  │         CloudStudio Hello Child Theme                │  │
│  │  - CSS Design System                                 │  │
│  │  - Dark Mode Support                                 │  │
│  │  - TypeScript Utilities (Vite built)                 │  │
│  └──────────────────────────────────────────────────────┘  │
└─────────────────────────────────────────────────────────────┘
```

## 📁 Monorepo Structure

### Why Monorepo?

- ✅ **Shared dependencies**: No duplicate packages
- ✅ **Atomic changes**: Update plugin + theme in one commit
- ✅ **Consistent tooling**: Same build system, linters, tests
- ✅ **Type safety**: Shared TypeScript types across packages

### Directory Layout

```
cloudstudioiot-wordpress-stack-v2/
├── packages/
│   ├── plugin/          # WordPress plugin
│   ├── theme/           # WordPress child theme
│   └── shared/          # Shared code (types, utils, constants)
├── scripts/             # Build orchestration
├── docs/                # Documentation
├── tests/               # Integration & E2E tests
└── .github/             # CI/CD workflows
```

## 🔧 Technology Stack

### Backend (PHP)

- **PHP 8.1+**: Modern PHP with type declarations, enums, readonly properties
- **PSR-4 Autoloading**: Namespaced classes
- **Composer**: Dependency management
- **WordPress Coding Standards**: PHPCS + PHPStan

### Frontend (TypeScript)

- **TypeScript 5.3+**: Type-safe JavaScript
- **Vite 5.0**: Build tool with HMR
- **PostCSS**: CSS processing
- **ES Modules**: Modern JavaScript modules

### Testing

- **PHPUnit**: PHP unit tests
- **Vitest**: TypeScript/JavaScript unit tests
- **Playwright**: E2E browser tests
- **wp-env**: Local WordPress environment

### CI/CD

- **GitHub Actions**: Automated workflows
- **Automated Testing**: Run on every push
- **Security Scanning**: SAST with CodeQL
- **Dependency Updates**: Dependabot

## 🎨 Plugin Architecture

### Core Components

```php
namespace CloudStudio\ElementorWidgets;

Plugin (Main class)
├── Widgets\
│   ├── Hero_Widget
│   ├── CTA_Widget
│   ├── Button_Widget
│   └── ... (9 total)
├── Components\
│   ├── Button_Component
│   ├── Media_Component
│   ├── Heading_Component
│   └── ... (reusable pieces)
└── Admin\
    └── Settings (future)
```

### Widget Lifecycle

1. **Registration**: `elementor/widgets/register` hook
2. **Controls Setup**: `register_controls()` method
3. **Render**: `render()` method (server-side)
4. **Frontend Assets**: Loaded via `get_style_depends()` / `get_script_depends()`
5. **Editor Assets**: Loaded in Elementor editor only

### Asset Pipeline

```
src/assets/
├── editor.ts        ─┐
├── frontend.ts      ─┼─ Vite Build ─> dist/
└── admin.ts         ─┘
                                       ├── editor.js
                                       ├── frontend.js
                                       ├── admin.js
                                       └── css/
                                           ├── editor.css
                                           ├── frontend.css
                                           └── admin.css
```

### Zero Infinite Loops Strategy

**Problem in v1**: Dynamic link selection triggered Elementor AI, causing infinite reloads.

**Solution in v2**:
1. No direct Elementor panel manipulation
2. Use native Elementor `URL` control
3. AJAX for dynamic content (if needed) isolated from editor
4. Proper control dependencies with `condition` clauses
5. No custom JavaScript hooks into Elementor's internal API

## 🎨 Theme Architecture

### CSS Architecture

```
src/styles/
├── variables.css      # Design tokens (colors, spacing, typography)
├── typography.css     # Type scale and font styles
├── components.css     # Reusable UI components
├── dark-mode.css      # Dark mode overrides
└── main.css          # Entry point (imports all)
```

### Design Token System

```css
:root {
  /* Primitive tokens */
  --color-blue-500: #0073aa;
  --spacing-base: 1rem;
  
  /* Semantic tokens */
  --color-primary: var(--color-blue-500);
  --button-padding: var(--spacing-base);
}
```

### Dark Mode Strategy

1. CSS variables for colors
2. Body class toggle: `.cloudstudio-dark-mode`
3. localStorage persistence
4. System preference detection
5. Customizer integration

## 🔐 Security Architecture

### Input Sanitization

```php
// All user inputs sanitized
$text = sanitize_text_field( $_POST['text'] );
$url = esc_url_raw( $_POST['url'] );
$html = wp_kses_post( $_POST['content'] );
```

### Output Escaping

```php
// All outputs escaped
echo esc_html( $text );
echo esc_url( $url );
echo wp_kses_post( $html );
```

### Nonce Verification

```php
// AJAX requests verified
if ( ! wp_verify_nonce( $_POST['nonce'], 'cloudstudio_action' ) ) {
    wp_die( 'Invalid nonce' );
}
```

### Capability Checks

```php
// Privileged actions checked
if ( ! current_user_can( 'edit_posts' ) ) {
    wp_die( 'Insufficient permissions' );
}
```

## 📊 Performance Architecture

### Asset Loading Strategy

1. **Critical CSS**: Inline above-the-fold styles
2. **Lazy Loading**: Non-critical assets deferred
3. **Code Splitting**: Vendor chunks separated
4. **Tree Shaking**: Unused code eliminated
5. **Minification**: Production assets compressed

### Caching Strategy

1. **Versioning**: Assets have version query strings
2. **Browser Cache**: Long expiry for static assets
3. **WordPress Object Cache**: Transients for expensive operations
4. **CDN Ready**: Static assets can be offloaded

### Database Optimization

1. **Prepared Statements**: SQL injection prevention + performance
2. **Indexed Queries**: Fast lookups
3. **Transients**: Cached query results
4. **Selective Loading**: Only load what's needed

## 🧪 Testing Architecture

### Test Pyramid

```
         ╱──────────╲
        ╱   E2E (5%)  ╲     ← Playwright (slow, comprehensive)
       ╱──────────────╲
      ╱  Integration   ╲    ← PHPUnit + wp-env (medium speed)
     ╱      (15%)       ╲
    ╱────────────────────╲
   ╱    Unit Tests (80%)  ╲  ← PHPUnit + Vitest (fast, focused)
  ╱──────────────────────╲
```

### Test Organization

```
tests/
├── unit/
│   ├── php/            # PHPUnit tests
│   └── ts/             # Vitest tests
├── integration/
│   └── wordpress/      # WordPress integration tests
└── e2e/
    └── playwright/     # Browser automation tests
```

## 🚀 Deployment Architecture

### CI/CD Pipeline

```
Push/PR → GitHub Actions
    ├── Lint (ESLint, PHPCS)
    ├── Type Check (TypeScript, PHPStan)
    ├── Unit Tests (Vitest, PHPUnit)
    ├── Integration Tests
    ├── Build (Vite, ZIP creation)
    └── E2E Tests (Playwright)
         │
         ├─ Success → Deploy to Staging
         └─ Manual Approval → Deploy to Production
```

### Build Process

```bash
pnpm build
├── Build plugin (Vite)
│   ├── TypeScript → JavaScript
│   ├── PostCSS → CSS
│   └── Create ZIP
└── Build theme (Vite)
    ├── TypeScript → JavaScript
    ├── PostCSS → CSS
    └── Create ZIP
```

## 📈 Scalability

### Code Organization

- **Namespaces**: Prevent naming conflicts
- **Autoloading**: No manual requires
- **Dependency Injection**: Testable, flexible
- **Interfaces**: Swappable implementations

### Extension Points

```php
// Filters for customization
apply_filters('CloudStudio\ElementorWidgets\widget_defaults', $defaults);
apply_filters('CloudStudio\ElementorWidgets\component_args', $args);

// Actions for hooks
do_action('CloudStudio\ElementorWidgets\before_render', $widget);
do_action('CloudStudio\ElementorWidgets\after_render', $widget);
```

## 🔮 Future Architecture Considerations

### Planned Improvements

1. **REST API**: Programmatic access to widgets
2. **GraphQL**: Modern data fetching
3. **Block Editor**: Gutenberg compatibility
4. **Headless Mode**: API-first architecture
5. **Micro-frontends**: Isolated widget bundles

---

## 📚 Related Documentation

- [Widget Development Guide](../development/widget-guide.md)
- [Component System](../development/components.md)
- [API Reference](../api/README.md)
- [Migration from v1](../migration/from-v1.md)

---

**Made with 🚀 by Cloud Studio IoT**
