# Changelog

All notable changes to CloudStudio WordPress Stack v2 will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

## [2.0.0-alpha.1] - 2025-11-12

### 🎉 Initial v2 Release

Complete rewrite of CloudStudio WordPress Stack with modern architecture.

### ✨ Added

#### Infrastructure
- Monorepo structure with pnpm workspaces
- TypeScript support for all JavaScript assets
- Vite build system with Hot Module Replacement
- GitHub Actions CI/CD pipeline
- Comprehensive documentation
- Migration guide from v1

#### Plugin
- Modern PHP 8.1+ architecture with type declarations
- PSR-4 autoloading with namespaces
- Component-based widget system
- TypeScript-powered editor, frontend, and admin scripts
- Modular CSS with PostCSS
- Button Widget with full customization
- Zero infinite loops architecture

#### Theme
- Child theme for Hello Elementor
- CSS design token system
- Dark mode support with localStorage persistence
- Typography system with fluid scaling
- Responsive components
- TypeScript utilities (smooth scroll, lazy load, dark mode toggle)

#### Development
- ESLint + Prettier for JavaScript/TypeScript
- PHPCS + PHPStan for PHP
- Vitest for JS/TS unit tests
- PHPUnit for PHP unit tests
- Playwright for E2E tests

### 🔄 Changed

- **Minimum PHP version**: 7.4 → 8.1
- **Minimum WordPress version**: 6.0 → 6.4
- **Asset structure**: Moved from `/assets/` to `/dist/` (built from `/src/`)
- **CSS architecture**: From multiple files to single built `main.css`
- **JavaScript**: From vanilla JS to TypeScript with ES modules

### 🗑️ Removed

- Legacy jQuery dependencies where possible
- Problematic dynamic-select2.js (caused infinite loops)
- Direct Elementor panel manipulation
- Old build scripts (replaced with Vite)

### 🐛 Fixed

- **CRITICAL**: Infinite loop in Elementor editor sidebar (complete rewrite)
- **CRITICAL**: Elementor AI integration conflicts
- **CRITICAL**: Dynamic link selection issues
- Memory leaks in widget renders
- Race conditions in asset loading
- Inconsistent CSS specificity

### 🔐 Security

- Input sanitization on all user data
- Output escaping on all HTML
- Nonce verification on AJAX requests
- Capability checks on privileged actions
- SQL injection prevention with prepared statements
- XSS prevention with escaping functions
- CSRF protection with nonces

### 📚 Documentation

- Complete README with quick start guide
- Architecture overview with diagrams
- Migration guide from v1
- Widget development guide
- Component system documentation
- API reference
- Troubleshooting guide

### ⚡ Performance

- Lazy loading for non-critical assets
- Code splitting for vendor chunks
- Tree shaking to eliminate unused code
- Minification for production builds
- Optimized asset loading strategy
- Browser cache optimization

### ♿ Accessibility

- ARIA support in all widgets
- Keyboard navigation support
- Screen reader friendly markup
- Color contrast compliance
- Focus management

---

## [1.x] - Previous Version

See [cloudstudioiot-wordpress-stack](https://github.com/Sobdev/cloudstudioiot-wordpress-stack) repository for v1 changelog.

---

[Unreleased]: https://github.com/Sobdev/cloudstudioiot-wordpress-stack-v2/compare/v2.0.0-alpha.1...HEAD
[2.0.0-alpha.1]: https://github.com/Sobdev/cloudstudioiot-wordpress-stack-v2/releases/tag/v2.0.0-alpha.1
