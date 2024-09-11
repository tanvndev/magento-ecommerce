<template>
  <div class="product-qty-form">
    <div class="input-group">
      <input
        class="quantity form-control"
        type="number"
        :value="localQuantity"
        :min="min"
        :max="max"
        @input="handleInputChange"
        @blur="validateInput"
      />
      <button
        class="quantity-plus w-icon-plus"
        @click="increaseQuantity"
      ></button>
      <button
        class="quantity-minus w-icon-minus"
        @click="decreaseQuantity"
      ></button>
    </div>
  </div>
</template>

<script setup>
import { ref, watch, defineProps, defineEmits } from 'vue'

const props = defineProps({
  oldQuantity: {
    type: Number,
    default: 1,
  },
  min: {
    type: Number,
    default: 1,
  },
  max: {
    type: Number,
    default: 10000000,
  },
})

const emits = defineEmits(['update:quantity'])

const localQuantity = ref(props.oldQuantity)

watch(
  () => props.oldQuantity,
  (newValue) => {
    localQuantity.value = newValue
  }
)

const increaseQuantity = () => {
  if (localQuantity.value < props.max) {
    localQuantity.value += 1
    emits('update:quantity', localQuantity.value)
  }
}

const decreaseQuantity = () => {
  if (localQuantity.value > props.min) {
    localQuantity.value -= 1
    emits('update:quantity', localQuantity.value)
  }
}

const handleInputChange = (event) => {
  const newValue = parseInt(event.target.value, 10)
  if (
    Number.isInteger(newValue) &&
    newValue >= props.min &&
    newValue <= props.max
  ) {
    localQuantity.value = newValue
    emits('update:quantity', localQuantity.value)
  } else if (newValue < props.min) {
    localQuantity.value = props.min
    emits('update:quantity', localQuantity.value)
  } else if (newValue > props.max) {
    localQuantity.value = props.max
    emits('update:quantity', localQuantity.value)
  }
}

const validateInput = () => {
  if (
    !Number.isInteger(localQuantity.value) ||
    localQuantity.value < props.min
  ) {
    localQuantity.value = props.min
    emits('update:quantity', localQuantity.value)
  } else if (localQuantity.value > props.max) {
    localQuantity.value = props.max
    emits('update:quantity', localQuantity.value)
  }
}
</script>
