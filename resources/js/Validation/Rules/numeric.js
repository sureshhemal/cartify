import { startCase } from 'lodash'
import { numeric } from '@vee-validate/rules'

export const numericRule = (input, params = [], field) => {
  const fieldName = startCase(field.field)

  return numeric(input) || `${fieldName} must be an integer`
}