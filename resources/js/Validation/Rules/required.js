import { startCase } from 'lodash'
import { required } from '@vee-validate/rules'

export const requiredRule = (input, params = [], field) => {
  const fieldName = startCase(field.field)

  return required(input) || `${fieldName} is required`
}