import { isArray, startCase } from 'lodash'
import getSingleParam from '@/Validation/Rules/Support/getSingleParam'

const crossFieldInvalidationMessageEnd = params => {
  const min = getSingleParam(params)

  return isArray(params) && params.length > 1 ? `${startCase(params[1])}(${params[0]})` : `${min}`
}

export default crossFieldInvalidationMessageEnd