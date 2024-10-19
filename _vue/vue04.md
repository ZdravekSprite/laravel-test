# Components EditForm

- to-fix:
  - [ ] typescript

- resources\js\Components\EditForm.vue

```ts
<script setup>
import Icons from '@/Components/Icons.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import Modal from '@/Components/Modal.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
  element: Object,
  updateRoute: String,
  labels: Array,
});

const confirmingUpdate = ref(false);

const frmObj = {};
for (let i = 0; i < props.labels.length; i++) {
  frmObj[props.labels[i]] = props.element[props.labels[i]];
}
frmObj['id'] = props.element['id'];
const form = useForm(frmObj);

const confirmUpdate = () => {
  confirmingUpdate.value = true;
};

const update = () => {
  form.patch(route(props.updateRoute, props.element.id), {
    preserveScroll: true,
    onSuccess: () => closeModal(),
    onError: () => console.log('error'),
    onFinish: () => form.reset(),
  });
};

const closeModal = () => {
  confirmingUpdate.value = false;

  form.reset();
};
</script>

<template>
  <div>
    <SecondaryButton @click="confirmUpdate">
      <Icons :icon="('pen')" class="block h-4 w-auto fill-current" />
    </SecondaryButton>

    <Modal :show="confirmingUpdate" @close="closeModal">
      <div class="p-6">
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
          Edit {{ props.element.name ?? props.element.id + '. element' }}?
        </h2>
        <div v-for="l in labels" :key="l" class="mt-6">
          <InputLabel :for="l" :value="l.replace(/\b(\S)/g, (t) => { return t.toUpperCase() })" />
          <TextInput :id="l" v-model="form[l]" type="text" class="mt-1 block w-3/4"
            :placeholder="l" />
          <InputError :message="form.errors[l]" class="mt-2" />
        </div>
        <div class="mt-6 flex justify-end">
          <SecondaryButton @click="closeModal"> Cancel </SecondaryButton>
          <PrimaryButton class="ml-3" :class="{ 'opacity-25': form.processing }" :disabled="form.processing"
            @click="update">
            Update
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
import EditForm from '@/Components/EditForm.vue';

                  <EditForm class="float-left"
                    :element="u"
                    :updateRoute="('user.update')"
                    :labels="['name','email']"
                  />
```
