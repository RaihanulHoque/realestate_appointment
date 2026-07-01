import FormField from '../../components/FormField'

export default function ContactForm({ form, errors, onChange, onSubmit, onCancel, isSubmitting, submitLabel }) {
  return (
    <form onSubmit={onSubmit} className="space-y-4">
      <FormField label="Name" name="name" value={form.name} onChange={onChange} error={errors.name?.[0]} required />
      <FormField
        label="Surname"
        name="surname"
        value={form.surname}
        onChange={onChange}
        error={errors.surname?.[0]}
        required
      />
      <FormField
        label="Email"
        name="email"
        type="email"
        value={form.email}
        onChange={onChange}
        error={errors.email?.[0]}
        required
      />
      <FormField
        label="Phone"
        name="phone"
        value={form.phone}
        onChange={onChange}
        error={errors.phone?.[0]}
        maxLength={13}
        minLength={11}
        hint="Max 13 characters (e.g. +447911123456) & Min 11 characters (e.g. 07911123456)"
        required
      />
      <FormField
        label="Address"
        name="address"
        value={form.address}
        onChange={onChange}
        error={errors.address?.[0]}
        required
      />
      <div className="flex gap-3">
        <button
          type="submit"
          disabled={isSubmitting}
          className="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700 disabled:opacity-60"
        >
          {isSubmitting ? 'Saving…' : submitLabel}
        </button>
        {onCancel && (
          <button
            type="button"
            onClick={onCancel}
            className="rounded-md px-4 py-2 text-sm font-medium text-gray-600 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-800"
          >
            Cancel
          </button>
        )}
      </div>
    </form>
  )
}
