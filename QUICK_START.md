# 🚀 Quick Start - Production Build Guide

## Prerequisitos

Asegúrate de tener instalado:

```bash
node -v    # v20.0.0 o superior
pnpm -v    # v8.0.0 o superior
php -v     # 8.1 o superior
```

Si no tienes pnpm:
```bash
npm install -g pnpm@latest
```

---

## 🏗️ Build Completo (Plugin + Theme)

### 1. Instalar Dependencias

```bash
cd cloudstudioiot-wordpress-stack-v2

# Instalar todas las dependencias del monorepo
pnpm install

# Instalar dependencias PHP del plugin
cd packages/plugin && composer install && cd ../..
```

### 2. Build de Producción

```bash
# Build completo (plugin + theme + ZIPs)
pnpm build
```

Esto ejecutará:
1. ✅ Build de assets del plugin (Vite)
2. ✅ Creación del ZIP del plugin
3. ✅ Build de assets del theme (Vite)
4. ✅ Creación del ZIP del theme
5. ✅ Verificación de builds

### 3. Verificar Builds

Los ZIPs se generan en `builds/`:

```
builds/
├── cloudstudio-elementor-widgets-v2.0.0.zip
└── cloudstudio-hello-child-v2.0.0.zip
```

---

## 🔧 Builds Individuales

### Solo Plugin

```bash
pnpm build:plugin
```

### Solo Theme

```bash
pnpm build:theme
```

---

## 🧪 Modo Desarrollo

### Dev con Hot Module Replacement

```bash
# Ambos (plugin + theme) en paralelo
pnpm dev

# Solo plugin
pnpm dev:plugin

# Solo theme
pnpm dev:theme
```

En dev mode:
- ✅ HMR (Hot Module Replacement)
- ✅ Source maps
- ✅ Sin minificación
- ✅ Recarga automática

---

## ✅ Checklist Pre-Producción

Antes de generar los ZIPs finales, verifica:

### 1. Linting

```bash
# Lint todo el código
pnpm lint

# Auto-fix issues
pnpm lint:fix
```

### 2. Type Check

```bash
# Verificar TypeScript
pnpm type-check
```

### 3. Tests (cuando estén implementados)

```bash
# Unit tests
pnpm test:unit

# PHP tests
pnpm test:php
```

### 4. Clean Build

```bash
# Limpiar todo y rebuild
pnpm clean
pnpm install
pnpm build
```

---

## 📦 Estructura de los ZIPs

### Plugin ZIP (`cloudstudio-elementor-widgets-v2.0.0.zip`)

```
cloudstudio-elementor-widgets/
├── cloudstudio-elementor-widgets.php  # Main plugin file
├── composer.json
├── README.txt
├── dist/                              # Built assets
│   ├── editor.js
│   ├── frontend.js
│   ├── admin.js
│   └── css/
│       ├── editor.css
│       ├── frontend.css
│       └── admin.css
└── src/
    ├── widgets/                       # PHP widgets
    ├── components/                    # PHP components
    └── (no TypeScript source - solo PHP)
```

**Excluye automáticamente:**
- ❌ `node_modules/`
- ❌ `src/assets/` (TypeScript source)
- ❌ `tests/`
- ❌ `scripts/`
- ❌ Config files (vite.config.ts, tsconfig.json, etc.)

### Theme ZIP (`cloudstudio-hello-child-v2.0.0.zip`)

```
cloudstudio-hello-child/
├── style.css                          # Theme manifest
├── functions.php                      # Theme functions
├── screenshot.png                     # (añadir si tienes)
└── dist/                              # Built assets
    ├── main.js
    └── css/
        └── main.css
```

**Excluye automáticamente:**
- ❌ `node_modules/`
- ❌ `src/` (TypeScript/CSS source)
- ❌ `tests/`
- ❌ `scripts/`
- ❌ Config files

---

## 🚨 Troubleshooting

### Error: "Cannot find module 'vite'"

**Solución:**
```bash
pnpm install
```

### Error: "dist/ folder not found"

**Solución:**
```bash
# Build assets primero
pnpm --filter @cloudstudio/plugin build
# Luego ZIP
pnpm --filter @cloudstudio/plugin build:zip
```

O usa el comando combinado:
```bash
pnpm build:plugin
```

### Error: TypeScript errors

Los errores de TypeScript en vite.config.ts son normales antes de instalar dependencias.

**Solución:**
```bash
pnpm install
```

### Build lento

**Primera vez**: El build puede tardar 30-60 segundos (normal).

**Builds siguientes**: Vite cachea, debería ser ~5-10 segundos.

**Si es muy lento**:
```bash
# Limpiar caché
pnpm clean
rm -rf node_modules
pnpm install
pnpm build
```

---

## 📊 Tiempos Esperados

En una MacBook Pro M1/M2:

- **pnpm install**: ~30-40 segundos (primera vez)
- **pnpm build:plugin**: ~5-10 segundos
- **pnpm build:theme**: ~3-5 segundos
- **pnpm build (completo)**: ~10-15 segundos

---

## ✨ Next Steps

Una vez tengas los ZIPs:

1. **Subir a WordPress**:
   ```bash
   # Via WP-CLI
   wp plugin install builds/cloudstudio-elementor-widgets-v2.0.0.zip --activate
   wp theme install builds/cloudstudio-hello-child-v2.0.0.zip --activate
   ```

2. **O via Admin**:
   - Plugins → Add New → Upload Plugin
   - Appearance → Themes → Add New → Upload Theme

3. **Verificar**:
   - Abre Elementor editor
   - Busca widgets de "Cloud Studio" en la sidebar
   - **NO DEBERÍA HABER LOOPS INFINITOS** ✅

---

## 🆘 Soporte

Si algo falla:

1. Lee los logs del build
2. Verifica la [Migration Guide](../docs/migration/from-v1.md)
3. Revisa [Architecture Docs](../docs/architecture/README.md)
4. Contacta: dev@cloud.studio

---

**Made with 🚀 by Cloud Studio IoT**
