<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import NewForm from '@/Components/NewForm.vue';
import EditForm from '@/Components/EditForm.vue';
import DeleteForm from '@/Components/DeleteForm.vue';
import { Head, usePage } from '@inertiajs/vue3';

interface User { id: number; name: string; email: string; };

defineProps<{
  users: Array<User>,
}>();

const authUser = usePage().props.auth.user;
</script>

<template>

  <Head title="Users" />

  <AuthenticatedLayout>
    <template #header>
      <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Users</h2>
        <NewForm  :storeRoute="('user.store')" :labels="[['name'],['email']]" />
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
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="u in users" :key="u.id">
                <td class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{ u.name }}</td>
                <td class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{ u.email }}</td>
                <td v-if="u.id !== authUser.id" class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                  <EditForm class="float-left"
                    :element="u"
                    :updateRoute="('user.update')"
                    :labels="['name','email']"
                  />
                  <DeleteForm class="float-right"
                    :element="u"
                    :model="('user')"
                    :question="('account')"
                    :confirm=true
                  />
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>