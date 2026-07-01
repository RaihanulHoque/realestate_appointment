import FormField, { SelectField } from '../../components/FormField'

export default function AppointmentForm({
  form,
  errors,
  contacts,
  onChange,
  onSubmit,
  onCancel,
  isSubmitting,
  submitLabel,
}) {
  return (
    <form onSubmit={onSubmit} className="space-y-4">
      <SelectField
        label="Contact"
        name="contact_id"
        value={form.contact_id}
        onChange={onChange}
        error={errors.contact_id?.[0]}
        required
      >
        <option value="">Select a contact…</option>
        {contacts.map((contact) => (
          <option key={contact.id} value={contact.id}>
            {contact.name} {contact.surname}
          </option>
        ))}
      </SelectField>

      <FormField
        label="Date"
        name="appointment_date"
        type="date"
        value={form.appointment_date}
        onChange={onChange}
        error={errors.appointment_date?.[0]}
        required
      />

      <FormField
        label="Start time"
        name="appointment_start_time"
        type="time"
        step="1"
        value={form.appointment_start_time}
        onChange={onChange}
        error={errors.appointment_start_time?.[0]}
        required
      />

      <FormField
        label="Appointment address"
        name="appointment_address"
        value={form.appointment_address}
        onChange={onChange}
        error={errors.appointment_address?.[0]}
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
