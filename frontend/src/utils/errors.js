/**
 * The API has two validation-error shapes depending on the endpoint:
 * - login/register (manual Validator::make calls): the errors bag directly, e.g. {email: [...]}
 * - everything else (Form Requests): the standard Laravel shape {message, errors: {email: [...]}}
 */
export function extractFieldErrors(error) {
  const data = error?.response?.data
  if (!data) return {}
  return data.errors ?? data
}

export function extractErrorMessage(error, fallback = 'Something went wrong') {
  return error?.response?.data?.message || fallback
}
