import FormField from '../../components/FormField'
import SearchableSelect from '../../components/SearchableSelect'
import TimePicker from '../../components/TimePicker'

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
  const contactOptions = contacts.map((c) => ({
    value: c.id,
    label: `${c.name} ${c.surname}`,
  }))

  return (
    <form onSubmit={onSubmit} className="space-y-4">
      <SearchableSelect
        label="Contact"
        name="contact_id"
        value={form.contact_id}
        onChange={onChange}
        options={contactOptions}
        placeholder="Search contacts…"
        error={errors.contact_id?.[0]}
        required
      />

      <FormField
        label="Date"
        name="appointment_date"
        type="date"
        value={form.appointment_date}
        onChange={onChange}
        error={errors.appointment_date?.[0]}
        required
      />

      <TimePicker
        label="Start time"
        name="appointment_start_time"
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
