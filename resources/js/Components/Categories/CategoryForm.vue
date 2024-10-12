<template>
  <Form
    v-slot="{ errorBag }"
    as="div"
    class="dialog text-xs"
  >
    <div class="center rounded-lg w-1/2 h-3/4 overflow-y-scroll space-y-4">
      <div class="text-sm">
        Modify Category
      </div>

      <BaseInput
        v-model="form.code"
        label="Code"
        name="code"
        :rules="{
          required: true,
          notIn: existingCategoryCodes
        }"
      />

      <BaseInput
        v-model="form.name"
        label="Name"
        name="name"
        rules="required"
      />

      <div class="pt-4 flex space-x-2">
        <BaseButton
          :error-bag="errorBag"
          @click="submitForm"
        >
          Submit
        </BaseButton>
        <BaseButton @click="cancelForm">
          Cancel
        </BaseButton>
      </div>
    </div>
  </Form>
</template>

<script>
import BaseButton from '@/Components/BaseButton.vue'
import BaseInput from '@/Components/BaseInput.vue'
import { cloneDeep } from 'lodash'
import { closeDialog } from 'vue3-promise-dialog'
import { Form } from 'vee-validate'

export default {
  name: 'CategoryForm',

  components: {
    BaseInput,
    BaseButton,
    Form,
  },

  props: {
    category: {
      type: Object,
      required: true,
    },

    categories: {
      type: Array,
      required: true,
    },
  },

  data() {
    return {
      form: {},
    }
  },

  computed: {
    existingCategoryCodes() {
      return this.categories.map(category => category.code)
        .filter(code => this.category.code !== code)
    },
  },

  watch: {
    category: {
      deep: true,
      immediate: true,
      handler() {
        this.form = cloneDeep(this.category)
      },
    },
  },

  methods: {
    validate(values, actions) {
      console.log({ values, actions })
    },

    submitForm() {
      closeDialog({ ...this.form })
    },

    cancelForm() {
      closeDialog(false)
    },
  },
}
</script>

<style scoped>
.dialog {
  position: fixed;
  top: 0;
  left: 0;
  bottom: 0;
  right: 0;
  z-index: 99;
  background-color: rgba(0, 0, 0, 0.3);
  backdrop-filter: blur(3px); /* Add blur effect */
  -webkit-backdrop-filter: blur(3px); /* For Safari */
  overflow: scroll;
}

.center {
  position: fixed;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  background-color: white;
  padding: 20px;
}

</style>