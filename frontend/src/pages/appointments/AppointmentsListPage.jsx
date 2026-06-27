import { useMemo } from 'react'
import { Link } from 'react-router-dom'
import { PlusIcon, CalendarDaysIcon } from '@heroicons/react/24/outline'
import Skeleton from '../../components/Skeleton'
import EmptyState from '../../components/EmptyState'
import { useAppointments } from '../../hooks/useAppointments'
import { useContacts } from '../../hooks/useContacts'

export default function AppointmentsListPage() {
  const { data: appointments, isLoading, isError, refetch } = useAppointments()
  const { data: contacts } = useContacts()

  const contactsById = useMemo(() => {
    const map = new Map()
    for (const contact of contacts ?? []) {
      map.set(contact.id, `${contact.name} ${contact.surname}`)
    }
    return map
  }, [contacts])

  const sorted = useMemo(() => {
    if (!appointments) return []
    return [...appointments].sort((a, b) => {
      const aKey = `${a.appointment_date} ${a.appointment_start_time}`
      const bKey = `${b.appointment_date} ${b.appointment_start_time}`
      return aKey.localeCompare(bKey)
    })
  }, [appointments])

  return (
    <div>
      <div className="flex items-center justify-between">
        <h1 className="text-xl font-semibold text-gray-900 dark:text-gray-100">Appointments</h1>
        <Link
          to="/appointments/new"
          className="inline-flex items-center gap-1 rounded-md bg-indigo-600 px-3 py-2 text-sm font-medium text-white hover:bg-indigo-700"
        >
          <PlusIcon className="h-4 w-4" />
          New appointment
        </Link>
      </div>

      <div className="mt-4">
        {isLoading && <Skeleton rows={4} />}

        {isError && (
          <div className="rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700 dark:border-red-900 dark:bg-red-500/10 dark:text-red-400">
            Couldn&rsquo;t load appointments.{' '}
            <button type="button" onClick={() => refetch()} className="font-medium underline">
              Try again
            </button>
          </div>
        )}

        {!isLoading && !isError && sorted.length === 0 && (
          <EmptyState
            icon={CalendarDaysIcon}
            title="No appointments yet"
            description="Schedule your first appointment with a contact."
            action={
              <Link
                to="/appointments/new"
                className="inline-flex items-center gap-1 rounded-md bg-indigo-600 px-3 py-2 text-sm font-medium text-white hover:bg-indigo-700"
              >
                Add appointment
              </Link>
            }
          />
        )}

        {!isLoading && !isError && sorted.length > 0 && (
          <div className="divide-y divide-gray-200 rounded-lg border border-gray-200 bg-white dark:divide-gray-800 dark:border-gray-800 dark:bg-gray-900">
            {sorted.map((appointment) => (
              <Link
                key={appointment.id}
                to={`/appointments/${appointment.id}`}
                className="flex flex-col gap-1 px-4 py-3 hover:bg-gray-50 sm:flex-row sm:items-center sm:justify-between dark:hover:bg-gray-800"
              >
                <div>
                  <p className="font-medium text-gray-900 dark:text-gray-100">
                    {contactsById.get(appointment.contact_id) ?? 'Unknown contact'}
                  </p>
                  <p className="text-sm text-gray-500 dark:text-gray-400">{appointment.appointment_address}</p>
                </div>
                <span className="text-sm text-gray-500 dark:text-gray-400">
                  {appointment.appointment_date} &middot; {appointment.appointment_start_time}
                </span>
              </Link>
            ))}
          </div>
        )}
      </div>
    </div>
  )
}
