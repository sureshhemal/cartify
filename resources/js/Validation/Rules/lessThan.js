import { startCase } from 'lodash'
import getSingleParam from '@/Validation/Rules/Support/getSingleParam'
import crossFieldInvalidationMessageEnd from '@/Validation/Rules/Support/crossFieldInvalidationMessageEnd'

export const lessThanRule = (input, params, field) => {
  const fieldName = startCase(field.field)

  const max = getSingleParam(params)

  const messageEnd = crossFieldInvalidationMessageEnd(params)

  return input < max || `${fieldName} must be less than ${messageEnd}`
}