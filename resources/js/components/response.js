export  const is404 = function(error) {
  return isErrorAndResponseAddAbsolut && 404 === error.response.status
}

export const is422 = function (error) {
  return isErrorAndResponseAddAbsolut && 422 === error.response.status
}

const isErrorAndResponseAddAbsolut = function (err) {
  return err.response && err.response.status;
}