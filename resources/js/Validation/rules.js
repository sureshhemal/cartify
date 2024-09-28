import { defineRule } from 'vee-validate'

import { greaterThanRule } from '@/Validation/Rules/greaterThan'
import { lessThanRule } from '@/Validation/Rules/lessThan'
import { notIn } from '@/Validation/Rules/notIn'
import { requiredRule } from '@/Validation/Rules/required'
import { integerRule } from '@/Validation/Rules/integer'
import { emailRule } from '@/Validation/Rules/email'

defineRule('required', requiredRule)
defineRule('notIn', notIn)
defineRule('greaterThan', greaterThanRule)
defineRule('lessThan', lessThanRule)
defineRule('integer', integerRule)
defineRule('email', emailRule)
