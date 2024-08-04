<template>
  <a-space size="large">
    <div>
      <h2>Thông tin tại kho</h2>
      <ul class="list-answers mb-0 ml-10 list-disc">
        <li>
          Số dãy: <span class="ml-1 font-bold"> {{ props.record.aisles_number }}</span>
        </li>
        <li>
          Số kệ: <span class="ml-1 font-bold"> {{ props.record.racks_number }}</span>
        </li>
        <li>
          Số tầng: <span class="ml-1 font-bold"> {{ props.record.shelves_number }}</span>
        </li>
        <li>
          Số khoang:
          <span class="ml-1 font-bold"> {{ props.record.compartments_number }}</span>
        </li>
      </ul>
    </div>
  </a-space>
</template>

<script setup>
const props = defineProps({
  record: {
    type: [Object, Array],
    default: () => {}
  }
});
</script>
