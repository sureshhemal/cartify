const getSingleParam = (params, paramName) => {
  return Array.isArray(params) ? params[0] : params[paramName]
}

export default getSingleParam