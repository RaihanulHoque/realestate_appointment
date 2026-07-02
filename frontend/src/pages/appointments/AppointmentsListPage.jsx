import { useMemo, useState } from 'react'
import { Link } from 'react-router-dom'
import { PlusIcon, CalendarDaysIcon, PencilIcon, TrashIcon } from '@heroicons/react/24/outline'
import toast from 'react-hot-toast'
import Skeleton from '../../components/Skeleton'
import EmptyState from '../../components/EmptyState'
import ConfirmDialog from '../../components/ConfirmDialog'
import Modal from '../../components/Modal'
import AppointmentForm from './AppointmentForm'
import { useAppointments, useUpdateAppointment, useDeleteAppointment } from '../../hooks/useAppointments'
import { useContacts } from '../../hooks/useContacts'
import { extractFieldErrors, extractErrorMessage } from '../../utils/errors'

export default function AppointmentsListPage() {
  const { data: appointments, isLoading, isError, refetch } = useAppointments()
  const { data: contacts } = useContacts()
  const updateAppointment = useUpdateAppointment()
  const deleteAppointment = useDeleteAppointment()

  const [editingAppointment, setEditingAppointment] = useState(null)
  const [editForm, setEditForm] = useState({})
  const [editErrors, setEditErrors] = useState({})
  const [deletingAppointment, setDeletingAppointment] = useState(null)

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

  function openEdit(appointment) {
    setEditingAppointment(appointment)
    setEditForm({
      contact_id: appointment.contact_id,
      appointment_date: appointment.appointment_date,
      appointment_start_time: appointment.appointment_start_time,
      appointment_address: appointment.appointment_address,
    })
    setEditErrors({})
  }

  function closeEdit() {
    setEditingAppointment(null)
    setEditErrors({})
  }

  function handleEditChange(e) {
    setEditForm((prev) => ({ ...prev, [e.target.name]: e.target.value }))
  }

  async function handleUpdate(e) {
    e.preventDefault()
    setEditErrors({})
    try {
      await updateAppointment.mutateAsync({ id: editingAppointment.id, payload: editForm })
      toast.success('Appointment updated')
      closeEdit()
    } catch (error) {
      if (error?.response?.status === 422) {
        setEditErrors(extractFieldErrors(error))
      } else {
        toast.error(extractErrorMessage(error))
      }
    }
  }

  async function handleDelete() {
    try {
      await deleteAppointment.mutateAsync(deletingAppointment.id)
      toast.success('Appointment deleted')
    } catch (error) {
      toast.error(extractErrorMessage(error))
    } finally {
      setDeletingAppointment(null)
    }
  }

  const deleteDescription = deletingAppointment
    ? `Appointment with ${contactsById.get(deletingAppointment.contact_id) ?? 'Unknown contact'} on ${deletingAppointment.appointment_date} will be permanently removed.`
    : ''

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
              <div
                key={appointment.id}
                className="flex items-center gap-2 px-4 py-3 hover:bg-gray-50 dark:hover:bg-gray-800"
              >
                {/* Clickable area — navigates to detail page */}
                <Link
                  to={`/appointments/${appointment.id}`}
                  className="flex flex-1 flex-col gap-0.5 sm:flex-row sm:items-center sm:justify-between"
                >
                  <div>
                    <p className="font-medium text-gray-900 dark:text-gray-100">
                      {contactsById.get(appointment.contact_id) ?? 'Unknown contact'}
                    </p>
                    <p className="text-sm text-gray-500 dark:text-gray-400">
                      {appointment.appointment_address}
                    </p>
                  </div>
                  <span className="text-sm text-gray-500 dark:text-gray-400">
                    {appointment.appointment_date} &middot; {appointment.appointment_start_time}
                  </span>
                </Link>

                {/* Action buttons */}
                <div className="flex shrink-0 gap-1">
                  <button
                    type="button"
                    onClick={() => openEdit(appointment)}
                    aria-label="Edit appointment"
                    className="rounded-md p-1.5 text-gray-400 hover:bg-indigo-50 hover:text-indigo-600 dark:hover:bg-indigo-500/10 dark:hover:text-indigo-400"
                  >
                    <PencilIcon className="h-4 w-4" />
                  </button>
                  <button
                    type="button"
                    onClick={() => setDeletingAppointment(appointment)}
                    aria-label="Delete appointment"
                    className="rounded-md p-1.5 text-gray-400 hover:bg-red-50 hover:text-red-600 dark:hover:bg-red-500/10 dark:hover:text-red-400"
                  >
                    <TrashIcon className="h-4 w-4" />
                  </button>
                </div>
              </div>
            ))}
          </div>
        )}
      </div>

      {/* Edit popup */}
      <Modal
        open={!!editingAppointment}
        title="Edit appointment"
        onClose={closeEdit}
      >
        <AppointmentForm
          form={editForm}
          errors={editErrors}
          contacts={contacts ?? []}
          onChange={handleEditChange}
          onSubmit={handleUpdate}
          onCancel={closeEdit}
          isSubmitting={updateAppointment.isPending}
          submitLabel="Save changes"
        />
      </Modal>

      {/* Delete confirmation */}
      <ConfirmDialog
        open={!!deletingAppointment}
        title="Delete this appointment?"
        description={deleteDescription}
        confirmLabel="Delete"
        isLoading={deleteAppointment.isPending}
        onConfirm={handleDelete}
        onCancel={() => setDeletingAppointment(null)}
      />
    </div>
  )
}
