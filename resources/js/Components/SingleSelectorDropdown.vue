<template>
  <Field
    v-slot="{ value, errorMessage }"
    style="min-width: 90px; width: auto"
    :name="name"
    :rules="rules"
    :validate-on-mount="true"
    :model-value="modelValue"
  >
    <Listbox
      v-slot="{ open }"
      :model-value="value"
    >
      <div class="relative mt-1">
        <label
          class="block text-xs font-medium text-gray-700 dark:text-gray-200"
        >
          {{ title }}
        </label>
        <ListboxButton
          :disabled="disabled"
          class="relative w-full rounded-md pl-3 pr-10 text-left shadow-md sm:text-xs dark:bg-gray-700 dark:text-white"
          :class="[disabled ? 'cursor-not-allowed bg-gray-200 dark:bg-gray-500 dark:text-white' : 'cursor-pointer bg-white']"
          style="min-height: 30px"
        >
          <span
            v-if="modelValue"
            class="block truncate text-xs"
          >{{ modelValue[label] }}</span>
          <span
            v-else
            class="text-gray-500"
          >{{ placeholder }} </span>
          <span
            class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-2"
          >
            <ChevronUpIcon
              v-if="open"
              class="h-5 w-5 text-gray-400"
              aria-hidden="true"
            />
            <ChevronDownIcon
              v-else
              class="h-5 w-5 text-gray-400"
              aria-hidden="true"
            />
          </span>
        </ListboxButton>

        <transition
          leave-active-class="transition duration-100 ease-in"
          leave-from-class="opacity-100"
          leave-to-class="opacity-0"
        >
          <div v-show="open">
            <ListboxOptions
              class="absolute mt-1 z-10 max-h-60 w-full overflow-auto rounded-md bg-white py-1 text-xs shadow-lg sm:text-xs dark:bg-gray-700"
            >
              <ListboxOption
                v-for="option in options"
                v-slot="{ active }"
                :key="option?.label"
                :value="option[trackBy]"
                as="template"
                @click="emitSelection(option)"
              >
                <li
                  :class="[
                    active || option[trackBy] === modelValue?.[trackBy] ? 'bg-earthy-200 text-white font-semibold' : 'text-gray-900 dark:text-white',
                    'cursor-pointer py-2 px-2 block truncate text-xs text-left',
                  ]"
                >
                  {{ option[label] }}
                </li>
              </ListboxOption>
            </ListboxOptions>
          </div>
        </transition>
      </div>
    </Listbox>
    <InputError :message="errorMessage" />
  </Field>
</template>

<script>
import {
  Listbox,
  ListboxButton,
  ListboxOptions,
  ListboxOption,
} from '@headlessui/vue'
import { uniqueId } from 'lodash'
import { ChevronUpIcon, ChevronDownIcon } from '@heroicons/vue/24/outline/index.js'
import { Field } from 'vee-validate'
import InputError from '@/Components/InputError.vue'

export default {
  name: 'SingleSelectorDropdown',

  components: {
    InputError,
    Field,
    Listbox,
    ListboxButton,
    ListboxOptions,
    ListboxOption,
    ChevronUpIcon,
    ChevronDownIcon,
  },

  props: {
    options: {
      type: Array,
      default: () => [],
    },
    modelValue:{
      type: Object,
      default: () => null,
    } ,
    placeholder: {
      type: String,
      default: () => null,
    },
    label: {
      type: String,
      required: true,
    },
    trackBy: {
      type: String,
      default: () => 'id',
    },
    disabled: {
      type: Boolean,
      default: () => false,
    },
    title: {
      type: String,
      default: () => null,
    },
    rules: {
      type: [String, Object, Function],
      default: () => '',
    },
    name: {
      type: String,
      default: () => uniqueId('selector-'),
    },
  },

  methods: {
    emitSelection(item) {
      this.$emit('update:modelValue', { ...item })

      this.$emit('change', { ...item })
    },
  },
}
</script>
