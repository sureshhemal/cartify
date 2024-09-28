import { startCase } from 'lodash'
import { integer } from '@vee-validate/rules'

export const integerRule = (input, params = [], field) => {
  const fieldName = startCase(field.field)

  return integer(input) || `${fieldName} must be an integer`
}