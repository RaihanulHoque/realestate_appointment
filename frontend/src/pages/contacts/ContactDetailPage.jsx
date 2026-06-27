import { useEffect, useState } from 'react'
import { useNavigate, useParams } from 'react-router-dom'
import toast from 'react-hot-toast'
import { PencilIcon, TrashIcon } from '@heroicons/react/24/outline'
import ContactForm from './ContactForm'
import ConfirmDialog from '../../components/ConfirmDialog'
import Skeleton from '../../components/Skeleton'
import { useContact, useUpdateContact, useDeleteContact } from '../../hooks/useContacts'
import { extractFieldErrors, extractErrorMessage } from '../../utils/errors'

export default function ContactDetailPage() {
  const { id } = useParams()
  const navigate = useNavigate()
  const { data: contact, isLoading } = useContact(id)
  const updateContact = useUpdateContact()
  const deleteContact = useDeleteContact()

  const [isEditing, setIsEditing] = useState(false)
  const [form, setForm] = useState(null)
  const [errors, setErrors] = useState({})
  const [confirmOpen, setConfirmOpen] = useState(false)

  useEffect(() => {
    if (contact) {
      setForm({
        name: contact.name,
        surname: contact.surname,
        email: contact.email,
        phone: contact.phone,
        address: contact.address,
      })
    }
  }, [contact])

  function handleChange(event) {
    setForm((prev) => ({ ...prev, [event.target.name]: event.target.value }))
  }

  async function handleSubmit(event) {
    event.preventDefault()
    setErrors({})

    try {
      await updateContact.mutateAsync({ id, payload: form })
      toast.success('Contact updated')
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
      await deleteContact.mutateAsync(id)
      toast.success('Contact deleted')
      navigate('/contacts')
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
        <h1 className="text-xl font-semibold text-gray-900 dark:text-gray-100">
          {contact.name} {contact.surname}
        </h1>
        {!isEditing && (
          <div className="flex gap-2">
            <button
              type="button"
              onClick={() => setIsEditing(true)}
              className="rounded-md p-2 text-gray-500 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-800"
              aria-label="Edit contact"
            >
              <PencilIcon className="h-5 w-5" />
            </button>
            <button
              type="button"
              onClick={() => setConfirmOpen(true)}
              className="rounded-md p-2 text-red-500 hover:bg-red-50 dark:hover:bg-red-500/10"
              aria-label="Delete contact"
            >
              <TrashIcon className="h-5 w-5" />
            </button>
          </div>
        )}
      </div>

      <div className="mt-4">
        {isEditing ? (
          <ContactForm
            form={form}
            errors={errors}
            onChange={handleChange}
            onSubmit={handleSubmit}
            onCancel={() => setIsEditing(false)}
            isSubmitting={updateContact.isPending}
            submitLabel="Save changes"
          />
        ) : (
          <div className="divide-y divide-gray-200 rounded-lg border border-gray-200 bg-white dark:divide-gray-800 dark:border-gray-800 dark:bg-gray-900">
            <Row label="Email" value={contact.email} />
            <Row label="Phone" value={contact.phone} />
            <Row label="Address" value={contact.address} />
          </div>
        )}
      </div>

      <ConfirmDialog
        open={confirmOpen}
        title="Delete this contact?"
        description="This cannot be undone."
        confirmLabel="Delete"
        isLoading={deleteContact.isPending}
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
