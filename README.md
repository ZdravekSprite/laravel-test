# laravel-test

```bash
composer global require laravel/installer
laravel new breeze-vue-ts
cd breeze-vue-ts
composer run dev
```


## Would you like to install a starter kit? [No starter kit]:
  [none     ] No starter kit
  [breeze   ] Laravel Breeze
  [jetstream] Laravel Jetstream

### breeze

Which Breeze stack would you like to install? [Blade with Alpine]:
  [blade              ] Blade with Alpine
  [livewire           ] Livewire (Volt Class API) with Alpine
  [livewire-functional] Livewire (Volt Functional API) with Alpine
  [react              ] React with Inertia
  [vue                ] Vue with Inertia
  [api                ] API only

Would you like any optional features? [None]:
  [none      ] None
  [dark      ] Dark mode
  [ssr       ] Inertia SSR
  [typescript] TypeScript

## Which testing framework do you prefer? [Pest]:
  [0] Pest
  [1] PHPUnit

## Would you like to initialize a Git repository? (yes/no) [no]:

## Which database will your application use? [SQLite]:
  [sqlite ] SQLite
  [mysql  ] MySQL
  [mariadb] MariaDB
  [pgsql  ] PostgreSQL (Missing PDO extension)
  [sqlsrv ] SQL Server (Missing PDO extension)

## Would you like to run the default database migrations? (yes/no) [yes]:

- None vs Vue

composer.json
```json
    "require": {
        "laravel/sanctum": "^4.0",
        "tightenco/ziggy": "^2.0"
    },
    "require-dev": {
        "laravel/breeze": "^2.2",
    },
```
package.json
```json
    "devDependencies": {
        "@inertiajs/vue3": "^1.0.0",
        "@tailwindcss/forms": "^0.5.3",
        "@vitejs/plugin-vue": "^5.0.0",
        "vue": "^3.4.0"
    }
```
tailwind.config.js
```js
import forms from '@tailwindcss/forms';
export default {
    content: [
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    plugins: [forms],
};
```
vite.config.js
```js
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    plugins: [
        laravel({
            input: 'resources/js/app.js',
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],
});
```
app\Http\Controllers\ProfileController.php
app\Http\Controllers\Auth
app\Http\Middleware\HandleInertiaRequests.php
app\Http\Requests\ProfileUpdateRequest.php
app\Http\Requests\Auth\LoginRequest.php
app\Providers\AppServiceProvider.php
```php
use Illuminate\Support\Facades\Vite;

    public function boot(): void
    {
        Vite::prefetch(concurrency: 3);
    }
```
bootstrap\app.php
```php
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->web(append: [
            \App\Http\Middleware\HandleInertiaRequests::class,
            \Illuminate\Http\Middleware\AddLinkHeadersForPreloadedAssets::class,
        ]);
    })
```
bootstrap\cache\packages.php*
bootstrap\cache\services.php*
node_modules*
public\build*
resources\js\app.js
```js
import '../css/app.css';

import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { createApp, h } from 'vue';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob('./Pages/**/*.vue'),
        ),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});
```
resources\js\Components
resources\js\Layouts
resources\js\Pages
resources\views\app.blade.php
resources\views\welcome.blade.php-
routes\auth.php
routes\web.php
```php
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
```
tests\Pest.php
```php
pest()->extend(Tests\TestCase::class)
    ->use(Illuminate\Foundation\Testing\RefreshDatabase::class)
    ->in('Feature');
```
tests\Feature\ProfileTest.php
tests\Feature\Auth
vendor*
