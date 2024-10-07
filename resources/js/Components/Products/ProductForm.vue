<template>
  <BaseModal :show="show">
    <Form
      v-slot="{ errorBag }"
      as="div"
      class="text-xs px-4 py-6"
      style="width: 50vw"
    >
      <div class="text-sm dark:text-gray-200">
        Modify Category
      </div>

      <SingleSelectorDropdown
        v-model="selectedSeller"
        :options="sellers"
        :disabled="loggedInAs('SELLER')"
        placeholder="Select Seller"
        label="name"
        name="seller"
        title="Seller"
        rules="required"
      />

      <SingleSelectorDropdown
        v-model="selectedCategory"
        :options="categories"
        placeholder="Select Category"
        label="name"
        name="category"
        title="Category"
        rules="required"
      />

      <BaseInput
        v-model="form.name"
        label="Name"
        name="name"
        rules="required"
      />

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
        v-model="form.description"
        label="Description"
        name="description"
        rules="required"
      />

      <BaseInput
        v-model="form.quantity"
        label="Quantity"
        name="quantity"
        rules="required|integer|greaterThan:0"
      />

      <BaseInput
        v-model="form.price.amount"
        label="Price"
        name="price"
        rules="required|numeric|greaterThan:0"
      />

      <Uploader
        server="file-upload"
        :media="form.media.saved"
        :max-filesize="2"
        :max="5"
        @add="addMedia"
        @remove="removeMedia"
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
    </Form>
  </BaseModal>
</template>

<script>
import BaseButton from '@/Components/BaseButton.vue'
import BaseInput from '@/Components/BaseInput.vue'
import { cloneDeep } from 'lodash'
import { closeDialog } from 'vue3-promise-dialog'
import { Form } from 'vee-validate'
import SingleSelectorDropdown from '@/Components/SingleSelectorDropdown.vue'
import Uploader from '@/Components/Uploader/Uploader.vue'
import BaseModal from '@/Components/BaseModal.vue'

export default {
  name: 'ProductForm',

  components: {
    BaseModal,
    Uploader,
    SingleSelectorDropdown,
    BaseInput,
    BaseButton,
    Form,
  },

  props: {
    product: {
      type: Object,
      required: true,
    },

    categories: {
      type: Array,
      required: true,
    },

    sellers: {
      type: Array,
      required: true,
    },
  },

  data() {
    return {
      show: true,
      form: {},
    }
  },

  computed: {
    existingCategoryCodes() {
      return this.categories.map(category => category.code)
        .filter(code => this.product.code !== code)
    },

    selectedSeller: {
      get() {
        return this.sellers.find(seller => this.form.seller_id === seller.id)
      },
      set(seller) {
        this.form.seller_id = seller.id
      },
    },

    selectedCategory: {
      get() {
        return this.categories.find(category => this.form.category_id === category.id)
      },
      set(category) {
        this.form.category_id = category.id
      },
    },
  },

  watch: {
    product: {
      deep: true,
      immediate: true,
      handler() {
        this.form = cloneDeep(this.product)
      },
    },
  },

  methods: {
    addMedia(addedImage){
      this.form.media.added.push(addedImage)
    },

    removeMedia(removedImage){
      this.form.media.added = this.form.media.added.filter(media => {
        return media.name !== removedImage.name
      })

      this.form.media.removed.push(removedImage)
    },

    submitForm() {
      this.closeModal()
      closeDialog({ ...this.form })
    },

    cancelForm() {
      this.closeModal()
      closeDialog(false)
    },

    closeModal() {
      this.show = false
    },
  },
}
</script>