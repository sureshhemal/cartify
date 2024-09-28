import { startCase } from 'lodash'
import { email } from '@vee-validate/rules'

export const emailRule = (input, params = [], field) => {
  const fieldName = startCase(field.field)

  return email(input) || `${fieldName} must be valid email`
}