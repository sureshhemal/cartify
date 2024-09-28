import { startCase } from 'lodash'
import getSingleParam from '@/Validation/Rules/Support/getSingleParam'
import crossFieldInvalidationMessageEnd from '@/Validation/Rules/Support/crossFieldInvalidationMessageEnd'

export const greaterThanRule = (input, params, field) => {
  const fieldName = startCase(field.field)

  const min = getSingleParam(params)

  const messageEnd = crossFieldInvalidationMessageEnd(params)

  return input > min || `${fieldName} must be greater than ${messageEnd}`
}