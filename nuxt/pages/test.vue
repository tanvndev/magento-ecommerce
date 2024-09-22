<template>
  <v-select
    :items="[
      'California',
      'Colorado',
      'Florida',
      'Georgia',
      'Texas',
      'Wyoming',
    ]"
    variant="outlined"
    density="comfortable"
    label="Phường / Xã *"
  ></v-select>

  <v-combobox
    clearable
    chips
    multiple
    label="Combobox"
    :items="[
      'California',
      'Colorado',
      'Florida',
      'Georgia',
      'Texas',
      'Wyoming',
    ]"
  ></v-combobox>
</template>
<div class="v-overlay-container"></div>
