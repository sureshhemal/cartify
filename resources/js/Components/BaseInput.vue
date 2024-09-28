<script setup>
import { onMounted, ref } from 'vue'
import { Field } from 'vee-validate'
import { uniqueId } from 'lodash'
import InputError from '@/Components/InputError.vue'

let props = defineProps({
  modelValue: {
    type: [Number, String],
    default: () => '',
  },

  disabled: {
    type: Boolean,
    default: () => false,
  },

  label: {
    type: String,
    default: () => '',
  },

  type: {
    type: String,
    default: () => 'text',
  },

  rules: {
    type: [String, Object, Function],
    default: () => '',
  },

  name: {
    type: String,
    default: () => uniqueId('input-'),
  },

  onlyError: {
    type: Boolean,
    default: () => false,
  },
})

defineEmits(['update:modelValue'])

const input = ref(null)

onMounted(() => {
  if (input.value.hasAttribute('autofocus')) {
    input.value.focus()
  }
})

defineExpose({ focus: () => input.value.focus() })
</script>

<template>
  <Field
    v-slot="{ value, errorMessage }"
    :name="name"
    :rules="rules"
    :validate-on-mount="true"
    :model-value="modelValue"
    as="div"
    class="flex flex-col"
  >
    <label
      v-if="label"
      :for="name"
      class="font-xs text-gray-700"
    >{{ label }}</label>
    <input
      :id="name"
      ref="input"
      :disabled="disabled"
      v-bind="$attrs"
      class="focus:border-earthy-100 focus:ring focus:ring-earthy-100 focus:ring-opacity-30 rounded-md shadow-sm border-earthy-100 text-xs"
      :class="{'bg-gray-100 cursor-not-allowed': disabled}"
      :value="value"
      :type="type"
      @input="$emit('update:modelValue', $event.target.value)"
    >
    <InputError :message="errorMessage" />
  </Field>
</template>
