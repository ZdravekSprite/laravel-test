# Components NewForm

- to-fix:
  - [ ] typescript

- resources\js\Components\NewForm.vue

```ts
<script setup>
import SecondaryButton from '@/Components/SecondaryButton.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import Modal from '@/Components/Modal.vue';
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
  storeRoute: String,
  labels: Array,
});

const confirmingStore = ref(false);

const frmObj = {};
for (let i = 0; i < props.labels.length; i++) {
  frmObj[props.labels[i][0]] = props.labels[i].length > 1 ? 1 : "" ;
}
const form = useForm(frmObj);

const confirmStore = () => {
  confirmingStore.value = true;
};

const create = () => {
  form.post(route(props.storeRoute), {
    preserveScroll: true,
    onSuccess: () => closeModal(),
    onError: () => console.log('error'),
    onFinish: () => {form.reset();form.clearErrors();},
  });
};

const closeModal = () => {
  confirmingStore.value = false;
};
</script>

<template>
  <div>
    <SecondaryButton @click="confirmStore">
      New
    </SecondaryButton>

    <Modal :show="confirmingStore" @close="closeModal">
      <div class="p-6">
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
          New?
        </h2>
        <div v-for="l in labels" :key="l" class="mt-6">
          <InputLabel :for="l[0]" :value="l[0].replace(/\b(\S)/g, (t) => { return t.toUpperCase() })" />
          <div v-if="l.length == 1">
            <TextInput :id="l[0]" v-model="form[l[0]]" type="text" class="mt-1 block w-3/4" :placeholder="l[0]" />
          </div>
          <div v-else>
            <select
              class="mt-1 block w-3/4 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
              :name="l[0]" :id="l[0]" v-model="form[l[0]]">
              <option v-for="o in l[1]" :value="o.id">{{ o.name }}</option>
            </select>
          </div>
          <InputError :message="form.errors[l[0]]" class="mt-2" />
        </div>
        <div class="mt-6 flex justify-end">
          <SecondaryButton @click="closeModal"> Cancel </SecondaryButton>
          <PrimaryButton class="ml-3" :class="{ 'opacity-25': form.processing }" :disabled="form.processing"
            @click="create">
            Create
          </PrimaryButton>
        </div>
      </div>
    </Modal>
  </div>
</template>
```

- resources\js\Pages\User\Index.vue

```ts
<script setup>
import NewForm from '@/Components/NewForm.vue';

    <template #header>
        <NewForm  :storeRoute="('user.store')" :labels="[['name'],['email']]" />
```
