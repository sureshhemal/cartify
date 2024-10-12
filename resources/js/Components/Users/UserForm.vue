<template>
  <Form
    v-slot="{ errorBag }"
    as="div"
    class="dialog text-xs"
  >
    <div class="center rounded-lg w-1/2 h-3/4 overflow-y-scroll space-y-4">
      <div class="text-sm">
        Modify User
      </div>

      <BaseInput
        v-model="form.name"
        label="Name"
        name="name"
        rules="required"
      />
      
      <BaseInput
        v-model="form.email"
        label="Email"
        name="email"
        rules="required|email"
      />

      <SingleSelectorDropdown
        v-model="selectedRole"
        :options="roles"
        placeholder="Select Role"
        label="name"
        name="role"
        title="Role"
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
import SingleSelectorDropdown from '@/Components/SingleSelectorDropdown.vue'
import { closeDialog } from 'vue3-promise-dialog'
import { Form } from 'vee-validate'


export default {
  name: 'UserForm',
  components: {
    SingleSelectorDropdown,
    BaseInput,
    BaseButton,
    Form,
  },
  
  props: {
    user: {
      type: Object,
      required: true,
    },
    
    roles: {
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
    selectedRole: {
      get() {
        return this.form.roles[0]
      },
      set(role) {
        this.form.roles = [{ ...role }]
      },
    },
  },

  watch: {
    user: {
      deep: true,
      immediate: true,
      handler() {
        this.form = cloneDeep(this.user)
      },
    },
  },

  methods: {
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