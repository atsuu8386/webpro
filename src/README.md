# Laravel MPA with Vue.js 3 & Tabler UI

A modern Laravel Multi-Page Application (MPA) with progressive Vue.js 3 enhancement and Tabler UI framework.

## Tech Stack

### Backend
- **Laravel 11.x** - PHP framework
- **PostgreSQL** - Primary database
- **Redis** - Caching and sessions

### Frontend
- **Vue.js 3.5** - Progressive enhancement with Composition API
- **Bootstrap 5.3** - CSS framework (via Tabler)
- **Tabler UI 1.0.0-beta21** - Premium admin template
- **Tabler Icons** - SVG icon library
- **AlpineJS 3.14** - Lightweight JavaScript framework
- **ApexCharts 3.45** - Data visualization library

### Build Tools
- **Vite 5.4** - Frontend build tool
- **Laravel Vite Plugin** - Laravel integration
- **Sass** - CSS preprocessor

## Architecture

This project uses a **hybrid architecture**:
- Laravel Blade templates for server-side rendering
- Vue.js components for interactive UI elements (progressive enhancement)
- Tabler UI for consistent design system
- Docker containers for development environment

### Vue.js Integration Pattern

Vue components are mounted on specific DOM elements using a factory pattern:

```javascript
// Create and mount components
window.createVueApp(ComponentName, props).mount('#element-id');
```

Components are organized by type:
- **Shared Components**: `resources/js/components/` (Trending, StatsCard, ApexChart, etc.)
- **Page Scripts**: `resources/js/pages/` (dashboard.js, etc.)

## Docker Setup

Services:
- **nginx**: Web server (port 8686)
- **php-fpm**: PHP 8.2 with Laravel
- **postgres**: PostgreSQL 15
- **redis**: Redis for caching
- **node**: Node 20-alpine for Vite (port 5173)

### Build & Run

```bash
# Build containers
docker-compose build

# Install PHP dependencies
docker-compose run --rm --no-deps web composer install

# Install Node dependencies & run watch mode
docker-compose up -d

# The node service automatically runs: npm install && npm run watch
```

### Development

```bash
# Start all services
docker-compose up -d

# Watch for changes (auto-rebuild)
# Already running in node container

# Run migrations
docker-compose exec web php artisan migrate

# Clear caches
docker-compose exec web php artisan optimize:clear
```

## Project Structure

```
resources/
├── css/
│   ├── app.css           # Main stylesheet with Tabler imports
│   └── themes.css        # Tabler theme customizations
├── js/
│   ├── app.js            # Main JS entry (Vue factory, theme toggle)
│   ├── components/       # Reusable Vue components
│   │   ├── Trending.js   # Trend indicator with icons
│   │   ├── StatsCard.js  # Statistics card
│   │   └── ApexChart.js  # Chart wrapper component
│   └── pages/            # Page-specific scripts
│       └── dashboard.js  # Dashboard component initialization
└── views/
    ├── layouts/
    │   ├── base.blade.php       # HTML wrapper
    │   ├── app.blade.php        # Main authenticated layout
    │   ├── auth.blade.php       # Auth pages layout
    │   └── navigation.blade.php # Tabler navbar
    ├── auth/                    # Authentication views
    └── dashboard.blade.php      # Dashboard page
```

## Features

### Authentication
- Login / Register
- Password Reset
- Email Verification
- Password Confirmation
- Profile Management

All auth views use Tabler UI components.

### UI Components

**Trending Component**
- Shows percentage change with color-coded indicators
- Green (up), Red (down), Muted (neutral)
- SVG trend chart icons

**StatsCard Component**
- Display key metrics
- Integrated trending indicator
- Number formatting

**ApexChart Component**
- Dynamic chart rendering
- Reactive prop updates
- Lazy-loaded ApexCharts library
- Supports: line, bar, area charts

### Theme System

**Dark Mode Support**
- Toggle via navigation
- Persisted in localStorage
- Bootstrap 5 data-bs-theme attribute

**Tabler Themes** (themes.css)
- Base colors: slate, gray, zinc, neutral, stone, pink
- Primary colors: blue, azure, indigo, purple, pink, red, orange, yellow, lime, green, teal, cyan
- Border radius scales: 0, 0.5, 1, 1.5, 2
- Font themes: monospace, sans-serif, serif, comic

Apply themes via HTML attributes:
```html
<html data-bs-theme-base="slate" 
      data-bs-theme-primary="blue" 
      data-bs-theme-radius="1">
```

## Vite Configuration

Auto-discovery of page scripts using glob pattern:

```javascript
import glob from 'glob';
const pageFiles = glob.sync('resources/js/pages/**/*.js');

// Automatically includes all page/*.js files in build
```

Manual chunks for optimization:
- `vue`: Vue.js core library
- `vendor`: axios and other vendors
- `apexcharts`: ApexCharts library (code-split)

## NPM Scripts

```bash
npm run dev      # Vite dev server
npm run build    # Production build
npm run watch    # Watch mode (auto-rebuild)
```

## Access URLs

- **Web Application**: http://localhost:8686
- **Vite Dev Server**: http://localhost:5173

## Environment

Copy `.env.example` to `.env` and configure:

```env
APP_NAME="Laravel MPA"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8686

DB_CONNECTION=pgsql
DB_HOST=postgres
DB_PORT=5432
DB_DATABASE=laravel
DB_USERNAME=postgres
DB_PASSWORD=password

REDIS_HOST=redis
REDIS_PORT=6379
```

## License

This project is built on Laravel framework which is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
