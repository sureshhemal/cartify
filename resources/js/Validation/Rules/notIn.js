export const notIn = (input, params = []) => {
  return !params.includes(input) || `${input} is already taken`
}