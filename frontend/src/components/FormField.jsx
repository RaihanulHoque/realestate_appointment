const inputClasses = (hasError) =>
  `mt-1 block w-full rounded-md border px-3 py-2 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-gray-900 dark:text-gray-100 ${
    hasError ? 'border-red-400' : 'border-gray-300 dark:border-gray-700'
  }`

export function FieldWrapper({ label, name, error, hint, children }) {
  return (
    <div>
      <label htmlFor={name} className="block text-sm font-medium text-gray-700 dark:text-gray-300">
        {label}
      </label>
      {children}
      {hint && !error && <p className="mt-1 text-xs text-gray-500 dark:text-gray-400">{hint}</p>}
      {error && <p className="mt-1 text-xs text-red-600 dark:text-red-400">{error}</p>}
    </div>
  )
}

export default function FormField({ label, name, error, hint, type = 'text', ...inputProps }) {
  return (
    <FieldWrapper label={label} name={name} error={error} hint={hint}>
      <input id={name} name={name} type={type} className={inputClasses(!!error)} {...inputProps} />
    </FieldWrapper>
  )
}

export function SelectField({ label, name, error, hint, children, ...selectProps }) {
  return (
    <FieldWrapper label={label} name={name} error={error} hint={hint}>
      <select id={name} name={name} className={inputClasses(!!error)} {...selectProps}>
        {children}
      </select>
    </FieldWrapper>
  )
}
