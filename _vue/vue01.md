# Users

```bash
php artisan make:controller UserController -mUser
```

- app\Http\Controllers\UserController.php

```php
use Inertia\Inertia;
  public function index()
  {
    return Inertia::render('User/Index', [
      'users' => User::all()->toArray(),
    ]);
  }
```

- routes\web.php

```php
use App\Http\Controllers\UserController;
Route::middleware('auth')->group(function () {
  Route::get('/users', [UserController::class, 'index'])->name('users.index');
});
```

- resources\js\Pages\User\Index.vue

```ts
<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import NewForm from '@/Components/NewForm.vue';

interface User { id: string; name: string; email: string; };

defineProps<{
  users: Array<User>,
}>();
</script>

<template>

  <Head title="Users" />

  <AuthenticatedLayout>
    <template #header>
      <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Users</h2>
      </div>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
          <table class="table-auto w-full">
            <thead class="text-lg font-medium text-gray-900 dark:text-gray-100">
              <tr>
                <th>Name</th>
                <th>Email</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="u in users" :key="u.id">
                <td class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{ u.name }}</td>
                <td class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{ u.email }}</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
```

- resources\js\Layouts\AuthenticatedLayout.vue

```ts
              <!-- Navigation Links -->
              <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                <NavLink :href="route('users.index')" :active="route().current('users.index')">
                  User
                </NavLink>
        <!-- Responsive Navigation Menu -->
        <div :class="{ block: showingNavigationDropdown, hidden: !showingNavigationDropdown }" class="sm:hidden">
          <div class="pt-2 pb-3 space-y-1">
            <ResponsiveNavLink :href="route('users.index')" :active="route().current('users.index')">
              User
            </ResponsiveNavLink>
```
