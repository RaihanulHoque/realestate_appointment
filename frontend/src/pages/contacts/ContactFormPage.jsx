import { useState } from 'react'
import { useNavigate } from 'react-router-dom'
import toast from 'react-hot-toast'
import ContactForm from './ContactForm'
import { useCreateContact } from '../../hooks/useContacts'
import { extractFieldErrors, extractErrorMessage } from '../../utils/errors'

const initialForm = { name: '', surname: '', email: '', phone: '', address: '' }

export default function ContactFormPage() {
  const navigate = useNavigate()
  const createContact = useCreateContact()
  const [form, setForm] = useState(initialForm)
  const [errors, setErrors] = useState({})

  function handleChange(event) {
    setForm((prev) => ({ ...prev, [event.target.name]: event.target.value }))
  }

  async function handleSubmit(event) {
    event.preventDefault()
    setErrors({})

    try {
      await createContact.mutateAsync(form)
      toast.success('Contact created')
      navigate('/contacts')
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
      <h1 className="text-xl font-semibold text-gray-900 dark:text-gray-100">New contact</h1>
      <div className="mt-4">
        <ContactForm
          form={form}
          errors={errors}
          onChange={handleChange}
          onSubmit={handleSubmit}
          onCancel={() => navigate('/contacts')}
          isSubmitting={createContact.isPending}
          submitLabel="Create contact"
        />
      </div>
    </div>
  )
}
