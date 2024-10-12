import { startCase } from 'lodash'

export const numericRule = (input, params = [], field) => {
  const fieldName = startCase(field.field)

  // Regular expression to match only numbers and a single decimal point
  const regex = /^[0-9]*\.?[0-9]+$/

  return regex.test(input) || `${fieldName} must be a valid number.`
}