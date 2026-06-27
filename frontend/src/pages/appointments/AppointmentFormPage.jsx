import { useState } from 'react'
import { useNavigate } from 'react-router-dom'
import toast from 'react-hot-toast'
import AppointmentForm from './AppointmentForm'
import Skeleton from '../../components/Skeleton'
import { useContacts } from '../../hooks/useContacts'
import { useCreateAppointment } from '../../hooks/useAppointments'
import { extractFieldErrors, extractErrorMessage } from '../../utils/errors'

const initialForm = {
  contact_id: '',
  appointment_date: '',
  appointment_start_time: '',
  appointment_address: '',
}

export default function AppointmentFormPage() {
  const navigate = useNavigate()
  const { data: contacts, isLoading: contactsLoading } = useContacts()
  const createAppointment = useCreateAppointment()
  const [form, setForm] = useState(initialForm)
  const [errors, setErrors] = useState({})

  function handleChange(event) {
    setForm((prev) => ({ ...prev, [event.target.name]: event.target.value }))
  }

  async function handleSubmit(event) {
    event.preventDefault()
    setErrors({})

    try {
      await createAppointment.mutateAsync(form)
      toast.success('Appointment created')
      navigate('/appointments')
    } catch (error) {
      if (error?.response?.status === 422) {
        setErrors(extractFieldErrors(error))
      } else {
        toast.error(extractErrorMessage(error))
      }
    }
  }

  return (
    <div className="max-w-md">
      <h1 className="text-xl font-semibold text-gray-900 dark:text-gray-100">New appointment</h1>
      <div className="mt-4">
        {contactsLoading ? (
          <Skeleton rows={4} />
        ) : (
          <AppointmentForm
            form={form}
            errors={errors}
            contacts={contacts ?? []}
            onChange={handleChange}
            onSubmit={handleSubmit}
            onCancel={() => navigate('/appointments')}
            isSubmitting={createAppointment.isPending}
            submitLabel="Create appointment"
          />
        )}
      </div>
    </div>
  )
}
