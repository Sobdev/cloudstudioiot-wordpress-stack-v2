# 🚀 Cloud Studio IoT - WordPress Stack v2

> **Next-generation WordPress development stack** with modern tooling, TypeScript support, and enterprise-grade architecture for Elementor Pro integration.

[![Version](https://img.shields.io/badge/version-2.0.0--alpha-blue.svg)](https://github.com/Sobdev/cloudstudioiot-wordpress-stack-v2)
[![License](https://img.shields.io/badge/license-Proprietary-red.svg)](LICENSE)
[![WordPress](https://img.shields.io/badge/WordPress-6.4%2B-blue.svg)](https://wordpress.org/)
[![Elementor Pro](https://img.shields.io/badge/Elementor%20Pro-3.18%2B-pink.svg)](https://elementor.com/)
[![TypeScript](https://img.shields.io/badge/TypeScript-5.3%2B-blue.svg)](https://www.typescriptlang.org/)
[![Vite](https://img.shields.io/badge/Vite-5.0%2B-646cff.svg)](https://vitejs.dev/)

---

## 🎯 What's New in v2

### 🏗️ Modern Architecture

- **Monorepo with pnpm Workspaces**: Efficient dependency management and shared code
- **TypeScript**: Type-safe development for JavaScript assets
- **Vite Build System**: Lightning-fast HMR and optimized production builds
- **Component-First**: Reusable, testable, maintainable code
- **PHP Modern Standards**: PSR-4 autoloading, namespaces, type declarations

### ⚡ Performance

- **Zero Runtime Loops**: Eliminated infinite loop issues from v1
- **Optimized Asset Loading**: Code splitting, lazy loading, tree shaking
- **Minimal Dependencies**: Only load what's needed
- **Caching Strategy**: Aggressive caching with smart invalidation

### 🧪 Quality Assurance

- **Unit Testing**: Vitest for JS/TS, PHPUnit for PHP
- **E2E Testing**: Playwright for browser automation
- **Linting**: ESLint + Prettier + PHPCS + PHPStan
- **CI/CD**: GitHub Actions for automated testing and deployment

### 🔐 Security

- **SAST Integration**: Automated security scanning
- **Dependency Audits**: Regular vulnerability checks
- **Sanitization First**: All inputs sanitized, all outputs escaped
- **Permission Checks**: Proper capability checks on all actions

---

## 📦 Project Structure

```
cloudstudioiot-wordpress-stack-v2/
├── packages/
│   ├── plugin/                        # CloudStudio Elementor Widgets Plugin
│   │   ├── src/
│   │   │   ├── widgets/              # Widget classes
│   │   │   ├── components/           # Reusable components
│   │   │   ├── admin/                # Admin UI
│   │   │   ├── api/                  # REST API endpoints
│   │   │   └── assets/               # TypeScript/CSS source
│   │   ├── dist/                     # Built assets (gitignored)
│   │   ├── tests/                    # PHPUnit tests
│   │   ├── vite.config.ts            # Vite configuration
│   │   ├── tsconfig.json             # TypeScript config
│   │   └── cloudstudio-elementor-widgets.php
│   │
│   ├── theme/                         # CloudStudio Child Theme
│   │   ├── src/
│   │   │   ├── styles/               # CSS modules
│   │   │   ├── scripts/              # TypeScript utilities
│   │   │   └── components/           # Theme components
│   │   ├── dist/                     # Built assets (gitignored)
│   │   ├── templates/                # PHP templates
│   │   ├── vite.config.ts
│   │   ├── tsconfig.json
│   │   ├── functions.php
│   │   └── style.css
│   │
│   └── shared/                        # Shared utilities
│       ├── types/                     # Shared TypeScript types
│       ├── constants/                 # Shared constants
│       └── utils/                     # Shared utilities
│
├── scripts/                           # Build and deployment scripts
│   ├── build.ts                       # Main build orchestrator
│   ├── dev.ts                         # Development mode
│   ├── test.ts                        # Test runner
│   └── deploy.ts                      # Deployment automation
│
├── docs/                              # Documentation
│   ├── architecture/                  # Architecture Decision Records
│   ├── api/                           # API documentation
│   ├── development/                   # Development guides
│   └── migration/                     # Migration from v1
│
├── .github/
│   └── workflows/                     # GitHub Actions CI/CD
│       ├── ci.yml                     # Continuous Integration
│       ├── deploy.yml                 # Deployment workflow
│       └── security.yml               # Security scanning
│
├── tests/
│   ├── e2e/                           # Playwright E2E tests
│   └── integration/                   # Integration tests
│
├── builds/                            # Production builds (gitignored)
│
├── pnpm-workspace.yaml                # pnpm workspace config
├── package.json                       # Root package.json
├── tsconfig.json                      # Root TypeScript config
├── vitest.config.ts                   # Vitest config
├── playwright.config.ts               # Playwright config
├── .eslintrc.cjs                      # ESLint config
├── .prettierrc                        # Prettier config
├── .editorconfig                      # Editor config
├── .gitignore
├── LICENSE
└── README.md                          # This file
```

---

## 🚀 Quick Start

### Prerequisites

- **Node.js**: 20+ (LTS)
- **pnpm**: 8.0+
- **PHP**: 8.1+
- **Composer**: 2.0+
- **WordPress**: 6.4+
- **Elementor Pro**: 3.18+

### Installation

#### 1. Clone the Repository

```bash
git clone https://github.com/Sobdev/cloudstudioiot-wordpress-stack-v2.git
cd cloudstudioiot-wordpress-stack-v2
```

#### 2. Install Dependencies

```bash
# Install Node.js dependencies
pnpm install

# Install PHP dependencies
composer install
```

#### 3. Development Mode

```bash
# Start development servers with HMR
pnpm dev

# This will:
# - Start Vite dev server for plugin assets
# - Start Vite dev server for theme assets
# - Watch for PHP file changes
# - Enable source maps
```

#### 4. Build for Production

```bash
# Build all packages
pnpm build

# This creates:
# - builds/cloudstudio-elementor-widgets-v2.0.0.zip
# - builds/cloudstudio-hello-child-v2.0.0.zip
```

#### 5. Install on WordPress

```bash
# Option A: Manual installation
# Upload the ZIP files through WordPress admin

# Option B: Automated deployment
pnpm deploy --target=production

# Option C: WP-CLI
wp plugin install builds/cloudstudio-elementor-widgets-v2.0.0.zip --activate
wp theme install builds/cloudstudio-hello-child-v2.0.0.zip --activate
```

---

## 🛠️ Development

### Available Scripts

```bash
# Development
pnpm dev                    # Start development mode (all packages)
pnpm dev:plugin            # Start plugin dev server only
pnpm dev:theme             # Start theme dev server only

# Building
pnpm build                 # Build all packages for production
pnpm build:plugin          # Build plugin only
pnpm build:theme           # Build theme only

# Testing
pnpm test                  # Run all tests
pnpm test:unit             # Run unit tests (Vitest + PHPUnit)
pnpm test:e2e              # Run E2E tests (Playwright)
pnpm test:watch            # Run tests in watch mode

# Code Quality
pnpm lint                  # Lint all code (ESLint + PHPCS)
pnpm lint:fix              # Auto-fix linting issues
pnpm format                # Format code (Prettier)
pnpm type-check            # TypeScript type checking
pnpm phpstan               # PHP static analysis

# Deployment
pnpm deploy:staging        # Deploy to staging environment
pnpm deploy:production     # Deploy to production
```

### Tech Stack

#### Frontend

- **TypeScript 5.3+**: Type-safe JavaScript
- **Vite 5.0+**: Build tool and dev server
- **PostCSS**: CSS processing with autoprefixer
- **CSS Modules**: Scoped styles

#### Backend

- **PHP 8.1+**: Modern PHP with type declarations
- **Composer**: Dependency management
- **PSR-4**: Autoloading standard
- **WordPress Coding Standards**: PHPCS rules

#### Testing

- **Vitest**: Unit testing for JS/TS
- **PHPUnit**: Unit testing for PHP
- **Playwright**: E2E testing
- **wp-env**: Local WordPress environment

#### CI/CD

- **GitHub Actions**: Automated workflows
- **SAST**: Security scanning
- **Dependency Bot**: Automated updates

---

## 📚 Documentation

- **[Architecture Overview](docs/architecture/README.md)**: System design and patterns
- **[Widget Development Guide](docs/development/widget-guide.md)**: Creating new widgets
- **[Component System](docs/development/components.md)**: Reusable components
- **[API Reference](docs/api/README.md)**: REST API documentation
- **[Migration from v1](docs/migration/from-v1.md)**: Upgrade guide
- **[Troubleshooting](docs/troubleshooting.md)**: Common issues and solutions

---

## 🎨 Key Features

### Plugin (CloudStudio Elementor Widgets v2.0.0)

#### Widgets Included

1. **Hero Widget**: Full-screen hero sections with video/image backgrounds
2. **CTA Widget**: Call-to-action blocks with animations
3. **Button Widget**: Advanced buttons with icons and effects
4. **Logo Carousel**: Responsive logo showcase with Swiper
5. **Features Card**: Feature highlighting with icons
6. **Media Widget**: Images/videos with aspect ratio control
7. **Heading Widget**: Typography-rich headings
8. **FAQ Widget**: Accordion-style FAQs
9. **Tabs Widget**: Tabbed content blocks

#### Component System

- **Button Renderer**: Unified button rendering
- **Media Component**: Responsive media handling
- **Heading Component**: Typography system
- **Icon Component**: SVG icon management
- **Animation Component**: Entrance animations
- **Background Component**: Complex backgrounds
- **Spacing Component**: Consistent spacing
- **Link Component**: Dynamic link selection (FIXED - no loops!)
- **Container Component**: Layout utilities
- **Accessibility Component**: ARIA support

#### New in v2

- ✅ **Zero Infinite Loops**: Complete rewrite of link selection
- ✅ **TypeScript Assets**: Type-safe JavaScript
- ✅ **Lazy Loading**: Performance optimization
- ✅ **Better Caching**: Intelligent cache invalidation
- ✅ **Admin UI**: Modern settings interface
- ✅ **REST API**: Programmatic access
- ✅ **Hooks System**: Extensible architecture

### Theme (CloudStudio Hello Child v2.0.0)

#### CSS Architecture

- **CSS Variables**: Design tokens system
- **CSS Modules**: Scoped component styles
- **PostCSS**: Modern CSS features
- **Dark Mode**: Built-in theme switching
- **Responsive**: Mobile-first approach
- **Typography**: Fluid type scale

#### JavaScript Utilities

- **Theme Switcher**: Dark/light mode toggle
- **Smooth Scroll**: Enhanced scrolling
- **Lazy Load**: Image/video lazy loading
- **Toast System**: Notifications
- **Form Validation**: Client-side validation
- **Analytics**: Event tracking

---

## 🔒 Security

### Security Measures

- ✅ Input sanitization on all user data
- ✅ Output escaping on all HTML
- ✅ Nonce verification on AJAX requests
- ✅ Capability checks on privileged actions
- ✅ SQL injection prevention (prepared statements)
- ✅ XSS prevention (escaping functions)
- ✅ CSRF protection (nonces)
- ✅ File upload restrictions
- ✅ Regular dependency audits

### Reporting Security Issues

Please report security vulnerabilities to: security@cloud.studio

---

## 🤝 Contributing

We welcome contributions! Please see [CONTRIBUTING.md](CONTRIBUTING.md) for guidelines.

### Development Workflow

1. Fork the repository
2. Create a feature branch: `git checkout -b feature/amazing-feature`
3. Make your changes
4. Run tests: `pnpm test`
5. Commit: `git commit -m 'Add amazing feature'`
6. Push: `git push origin feature/amazing-feature`
7. Open a Pull Request

---

## 📝 License

This project is proprietary software owned by Cloud Studio IoT SL.

**Copyright © 2025 Cloud Studio IoT SL. All rights reserved.**

See [LICENSE](LICENSE) for details.

---

## 📞 Support

- **Documentation**: [docs.cloud.studio](https://docs.cloud.studio)
- **Email**: support@cloud.studio
- **Website**: [cloud.studio](https://cloud.studio)

---

## 🗺️ Roadmap

### v2.1.0 (Q1 2026)

- [ ] Visual Builder for widgets
- [ ] Template library
- [ ] Advanced animations
- [ ] Performance dashboard

### v2.2.0 (Q2 2026)

- [ ] AI-powered content suggestions
- [ ] Advanced form builder
- [ ] E-commerce integration
- [ ] Multi-language support

### v3.0.0 (Q3 2026)

- [ ] Full-site editing support
- [ ] Block theme compatibility
- [ ] Headless WordPress mode
- [ ] Advanced API

---

## 🙏 Acknowledgments

Built with ❤️ by the Cloud Studio IoT team.

Special thanks to:
- Elementor team for the amazing page builder
- WordPress community for the robust platform
- Open source contributors for the tools we use

---

**Made with 🚀 by [Cloud Studio IoT](https://cloud.studio)**
