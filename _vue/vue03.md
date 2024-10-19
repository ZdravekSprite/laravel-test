# Components DeleteForm

- to-fix:
  - [ ] typescript

- resources\js\Components\DeleteForm.vue

```ts
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
  element: Object,
  confirm: Boolean,
  model: String,
  question: String,
});

const confirmingElementDeletion = ref(false);
const passwordInput = ref(null);

const form = useForm({
  password: '',
  id: props.element.id,
});

const confirmElementDeletion = () => {
  confirmingElementDeletion.value = true;
  if (props.confirm) nextTick(() => passwordInput.value.focus());
};

const deleteElement = () => {
  form.delete(route(props.model + '.destroy'), {
    preserveScroll: true,
    onSuccess: () => closeModal(),
    onError: () => passwordInput.value.focus(),
    onFinish: () => form.reset(),
  });
};

const closeModal = () => {
  confirmingElementDeletion.value = false;

  form.reset();
};
</script>

<template>
  <div>
    <DangerButton @click="confirmElementDeletion">
      <Icons :icon="('trash')" class="block h-4 w-auto fill-current" />
    </DangerButton>

    <Modal :show="confirmingElementDeletion" @close="closeModal">
      <div class="p-6">
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
          Are you sure you want to delete {{ question }}?
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
          Once {{ question }} is deleted, all of its resources and data will be permanently deleted.
          <span v-if="confirm">Please enter your password to confirm you would like to permanently delete {{ question }}.</span>
        </p>

        <div v-if="confirm" class="mt-6">
          <InputLabel for="password" value="Password" class="sr-only" />

          <TextInput id="password" ref="passwordInput" v-model="form.password" type="password" class="mt-1 block w-3/4"
            placeholder="Password" @keyup.enter="deleteElement" />

          <InputError :message="form.errors.password" class="mt-2" />
        </div>

        <div class="mt-6 flex justify-end">
          <SecondaryButton @click="closeModal"> Cancel </SecondaryButton>

          <DangerButton class="ml-3" :class="{ 'opacity-25': form.processing }" :disabled="form.processing"
            @click="deleteElement">Delete {{ question }}
          </DangerButton>
        </div>
      </div>
    </Modal>
  </div>
</template>
```

- resources\js\Pages\User\Index.vue

```ts
<script setup>
import DeleteForm from '@/Components/DeleteForm.vue';

                  <DeleteForm class="float-right"
                    :element="u"
                    :model="('user')"
                    :question="('account')"
                    :confirm=true
                  />
```
