<script setup>
import DangerButton from '@/Components/DangerButton.vue';
import Icons from '@/Components/Icons.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import Modal from '@/Components/Modal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm, usePage } from '@inertiajs/vue3';
import { nextTick, ref } from 'vue';

const props = defineProps({
  user: Object,
});

const confirmingUserDeletion = ref(false);
const passwordInput = ref(null);

const authUser = usePage().props.auth.user;

const form = useForm({
  password: '',
  id: props.user.id,
});

const confirmUserDeletion = () => {
  confirmingUserDeletion.value = true;

  nextTick(() => passwordInput.value.focus());
};

const deleteUser = () => {
  form.delete(route('user.destroy'), {
    preserveScroll: true,
    onSuccess: () => closeModal(),
    onError: () => passwordInput.value.focus(),
    onFinish: () => form.reset(),
  });
};

const closeModal = () => {
  confirmingUserDeletion.value = false;

  form.reset();
};
</script>

<template>
  <div v-if="props.user.id !== authUser.id">
    <DangerButton @click="confirmUserDeletion">
      <Icons :icon="('trash')" class="block h-4 w-auto fill-current" />
    </DangerButton>

    <Modal :show="confirmingUserDeletion" @close="closeModal">
      <div class="p-6">
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
          Are you sure you want to delete account?
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
          Once account is deleted, all of its resources and data will be permanently deleted.
          Please enter your password to confirm you would like to permanently delete account.
        </p>

        <div class="mt-6">
          <InputLabel for="password" value="Password" class="sr-only" />

          <TextInput id="password" ref="passwordInput" v-model="form.password" type="password" class="mt-1 block w-3/4"
            placeholder="Password" @keyup.enter="deleteUser" />

          <InputError :message="form.errors.password" class="mt-2" />
        </div>

        <div class="mt-6 flex justify-end">
          <SecondaryButton @click="closeModal"> Cancel </SecondaryButton>

          <DangerButton class="ml-3" :class="{ 'opacity-25': form.processing }" :disabled="form.processing"
            @click="deleteUser">
            Delete Account
          </DangerButton>
        </div>
      </div>
    </Modal>
  </div>
</template>
