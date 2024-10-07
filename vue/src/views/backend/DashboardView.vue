<template>
  <MasterLayout>
    <template #template>
      <div class="mx-10 h-screen">
        <form @submit.prevent="onSubmit">
          <InputFinderComponent :multiple-file="true" name="image" />

          <a-button html-type="submit" type="primary" size="large">Submit</a-button>
        </form>
      </div>
    </template>
  </MasterLayout>
</template>

<script setup>
import { MasterLayout } from '@/components/backend/';
import InputFinderComponent from '@/components/backend/includes/input/InputFinderComponent.vue';
import { useForm } from 'vee-validate';
import { onMounted } from 'vue';
const { handleSubmit } = useForm();
import pusher from '@/plugins/pusher';

onMounted(() => {
  const channel = pusher.subscribe('vouchers-created');
  channel.bind('new-voucher-created', function (data) {
    console.log('<><><><><><><><><>:', data);
  });
});

const onSubmit = handleSubmit(async (values) => {
  console.log(values);
});
</script>
