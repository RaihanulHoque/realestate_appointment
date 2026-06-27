import { useEffect, useState } from 'react'
import { useNavigate, useParams } from 'react-router-dom'
import toast from 'react-hot-toast'
import { PencilIcon, TrashIcon } from '@heroicons/react/24/outline'
import AppointmentForm from './AppointmentForm'
import ConfirmDialog from '../../components/ConfirmDialog'
import Skeleton from '../../components/Skeleton'
import { useContacts } from '../../hooks/useContacts'
import { useAppointment, useUpdateAppointment, useDeleteAppointment } from '../../hooks/useAppointments'
import { extractFieldErrors, extractErrorMessage } from '../../utils/errors'

export default function AppointmentDetailPage() {
  const { id } = useParams()
  const navigate = useNavigate()
  const { data: appointment, isLoading } = useAppointment(id)
  const { data: contacts, isLoading: contactsLoading } = useContacts()
  const updateAppointment = useUpdateAppointment()
  const deleteAppointment = useDeleteAppointment()

  const [isEditing, setIsEditing] = useState(false)
  const [form, setForm] = useState(null)
  const [errors, setErrors] = useState({})
  const [confirmOpen, setConfirmOpen] = useState(false)

  useEffect(() => {
    if (appointment) {
      setForm({
        contact_id: appointment.contact_id,
        appointment_date: appointment.appointment_date,
        appointment_start_time: appointment.appointment_start_time,
        appointment_address: appointment.appointment_address,
      })
    }
  }, [appointment])

  function handleChange(event) {
    setForm((prev) => ({ ...prev, [event.target.name]: event.target.value }))
  }

  async function handleSubmit(event) {
    event.preventDefault()
    setErrors({})

    try {
      await updateAppointment.mutateAsync({ id, payload: form })
      toast.success('Appointment updated')
      setIsEditing(false)
    } catch (error) {
      if (error?.response?.status === 422) {
        setErrors(extractFieldErrors(error))
      } else {
        toast.error(extractErrorMessage(error))
      }
    }
  }

  async function handleDelete() {
    try {
      await deleteAppointment.mutateAsync(id)
      toast.success('Appointment deleted')
      navigate('/appointments')
    } catch (error) {
      toast.error(extractErrorMessage(error))
    } finally {
      setConfirmOpen(false)
    }
  }

  if (isLoading || !form) {
    return <Skeleton rows={5} />
  }

  return (
    <div className="max-w-md">
      <div className="flex items-center justify-between">
        <h1 className="text-xl font-semibold text-gray-900 dark:text-gray-100">Appointment</h1>
        {!isEditing && (
          <div className="flex gap-2">
            <button
              type="button"
              onClick={() => setIsEditing(true)}
              className="rounded-md p-2 text-gray-500 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-800"
              aria-label="Edit appointment"
            >
              <PencilIcon className="h-5 w-5" />
            </button>
            <button
              type="button"
              onClick={() => setConfirmOpen(true)}
              className="rounded-md p-2 text-red-500 hover:bg-red-50 dark:hover:bg-red-500/10"
              aria-label="Delete appointment"
            >
              <TrashIcon className="h-5 w-5" />
            </button>
          </div>
        )}
      </div>

      <div className="mt-4">
        {isEditing ? (
          contactsLoading ? (
            <Skeleton rows={4} />
          ) : (
            <AppointmentForm
              form={form}
              errors={errors}
              contacts={contacts ?? []}
              onChange={handleChange}
              onSubmit={handleSubmit}
              onCancel={() => setIsEditing(false)}
              isSubmitting={updateAppointment.isPending}
              submitLabel="Save changes"
            />
          )
        ) : (
          <div className="divide-y divide-gray-200 rounded-lg border border-gray-200 bg-white dark:divide-gray-800 dark:border-gray-800 dark:bg-gray-900">
            <Row label="Date" value={appointment.appointment_date} />
            <Row label="Start time" value={appointment.appointment_start_time} />
            <Row label="Address" value={appointment.appointment_address} />
            <Row label="Estimated distance" value={appointment.measured_distance} />
            <Row label="Depart for site" value={appointment.departure_time_to_site_office} />
            <Row label="Appointment ends" value={appointment.appointment_end_time} />
            <Row label="Back at office" value={appointment.arrival_time_to_agent_office} />
          </div>
        )}
      </div>

      <ConfirmDialog
        open={confirmOpen}
        title="Delete this appointment?"
        description="This cannot be undone."
        confirmLabel="Delete"
        isLoading={deleteAppointment.isPending}
        onConfirm={handleDelete}
        onCancel={() => setConfirmOpen(false)}
      />
    </div>
  )
}

function Row({ label, value }) {
  return (
    <div className="flex justify-between px-4 py-3 text-sm">
      <span className="text-gray-500 dark:text-gray-400">{label}</span>
      <span className="font-medium text-gray-900 dark:text-gray-100">{value}</span>
    </div>
  )
}
