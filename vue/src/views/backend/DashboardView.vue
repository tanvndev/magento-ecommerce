<template>
  <MasterLayout>
    <template #template>
      <div class="container mx-auto h-screen">
        <form @submit.prevent="onSubmit">
          <InputFinderComponent :multiple-file="true" name="image" />

          <a-button html-type="submit" type="primary">Submit</a-button>
        </form>
      </div>
    </template>
  </MasterLayout>
</template>

<script setup>
import { MasterLayout } from '@/components/backend/';
import InputFinderComponent from '@/components/backend/includes/input/InputFinderComponent.vue';
import { useForm } from 'vee-validate';

const { handleSubmit } = useForm();

const onSubmit = handleSubmit(async (values) => {
  console.log(values);
});
</script>
