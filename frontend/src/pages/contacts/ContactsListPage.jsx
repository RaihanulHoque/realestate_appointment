import { useMemo, useState } from 'react'
import { Link } from 'react-router-dom'
import { PlusIcon, MagnifyingGlassIcon, UsersIcon, PencilIcon, TrashIcon } from '@heroicons/react/24/outline'
import toast from 'react-hot-toast'
import Skeleton from '../../components/Skeleton'
import EmptyState from '../../components/EmptyState'
import ConfirmDialog from '../../components/ConfirmDialog'
import Modal from '../../components/Modal'
import ContactForm from './ContactForm'
import { useContacts, useUpdateContact, useDeleteContact } from '../../hooks/useContacts'
import { extractFieldErrors, extractErrorMessage } from '../../utils/errors'

export default function ContactsListPage() {
  const { data: contacts, isLoading, isError, refetch } = useContacts()
  const updateContact = useUpdateContact()
  const deleteContact = useDeleteContact()

  const [search, setSearch] = useState('')
  const [editingContact, setEditingContact] = useState(null)
  const [editForm, setEditForm] = useState({})
  const [editErrors, setEditErrors] = useState({})
  const [deletingContact, setDeletingContact] = useState(null)

  const filtered = useMemo(() => {
    if (!contacts) return []
    const term = search.trim().toLowerCase()
    if (!term) return contacts
    return contacts.filter((c) =>
      `${c.name} ${c.surname} ${c.email}`.toLowerCase().includes(term)
    )
  }, [contacts, search])

  function openEdit(contact) {
    setEditingContact(contact)
    setEditForm({
      name: contact.name,
      surname: contact.surname,
      email: contact.email,
      phone: contact.phone,
      address: contact.address,
    })
    setEditErrors({})
  }

  function closeEdit() {
    setEditingContact(null)
    setEditErrors({})
  }

  function handleEditChange(e) {
    setEditForm((prev) => ({ ...prev, [e.target.name]: e.target.value }))
  }

  async function handleUpdate(e) {
    e.preventDefault()
    setEditErrors({})
    try {
      await updateContact.mutateAsync({ id: editingContact.id, payload: editForm })
      toast.success('Contact updated')
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
      await deleteContact.mutateAsync(deletingContact.id)
      toast.success('Contact deleted')
    } catch (error) {
      toast.error(extractErrorMessage(error))
    } finally {
      setDeletingContact(null)
    }
  }

  return (
    <div>
      <div className="flex items-center justify-between">
        <h1 className="text-xl font-semibold text-gray-900 dark:text-gray-100">Contacts</h1>
        <Link
          to="/contacts/new"
          className="inline-flex items-center gap-1 rounded-md bg-indigo-600 px-3 py-2 text-sm font-medium text-white hover:bg-indigo-700"
        >
          <PlusIcon className="h-4 w-4" />
          New contact
        </Link>
      </div>

      <div className="relative mt-4">
        <MagnifyingGlassIcon className="pointer-events-none absolute left-3 top-2.5 h-4 w-4 text-gray-400" />
        <input
          type="search"
          placeholder="Search contacts…"
          value={search}
          onChange={(e) => setSearch(e.target.value)}
          className="w-full rounded-md border border-gray-300 py-2 pl-9 pr-3 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100"
        />
      </div>

      <div className="mt-4">
        {isLoading && <Skeleton rows={4} />}

        {isError && (
          <div className="rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700 dark:border-red-900 dark:bg-red-500/10 dark:text-red-400">
            Couldn&rsquo;t load contacts.{' '}
            <button type="button" onClick={() => refetch()} className="font-medium underline">
              Try again
            </button>
          </div>
        )}

        {!isLoading && !isError && filtered.length === 0 && (
          <EmptyState
            icon={UsersIcon}
            title={contacts?.length ? 'No matching contacts' : 'No contacts yet'}
            description={
              contacts?.length ? 'Try a different search.' : 'Add your first contact to get started.'
            }
            action={
              !contacts?.length && (
                <Link
                  to="/contacts/new"
                  className="inline-flex items-center gap-1 rounded-md bg-indigo-600 px-3 py-2 text-sm font-medium text-white hover:bg-indigo-700"
                >
                  Add contact
                </Link>
              )
            }
          />
        )}

        {!isLoading && !isError && filtered.length > 0 && (
          <div className="divide-y divide-gray-200 rounded-lg border border-gray-200 bg-white dark:divide-gray-800 dark:border-gray-800 dark:bg-gray-900">
            {filtered.map((contact) => (
              <div
                key={contact.id}
                className="flex items-center gap-2 px-4 py-3 hover:bg-gray-50 dark:hover:bg-gray-800"
              >
                {/* Clickable area — navigates to detail page */}
                <Link
                  to={`/contacts/${contact.id}`}
                  className="flex flex-1 flex-col gap-0.5 sm:flex-row sm:items-center sm:justify-between"
                >
                  <div>
                    <p className="font-medium text-gray-900 dark:text-gray-100">
                      {contact.name} {contact.surname}
                    </p>
                    <p className="text-sm text-gray-500 dark:text-gray-400">{contact.email}</p>
                  </div>
                  <span className="text-sm text-gray-500 dark:text-gray-400">{contact.phone}</span>
                </Link>

                {/* Action buttons */}
                <div className="flex shrink-0 gap-1">
                  <button
                    type="button"
                    onClick={() => openEdit(contact)}
                    aria-label={`Edit ${contact.name}`}
                    className="rounded-md p-1.5 text-gray-400 hover:bg-indigo-50 hover:text-indigo-600 dark:hover:bg-indigo-500/10 dark:hover:text-indigo-400"
                  >
                    <PencilIcon className="h-4 w-4" />
                  </button>
                  <button
                    type="button"
                    onClick={() => setDeletingContact(contact)}
                    aria-label={`Delete ${contact.name}`}
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
        open={!!editingContact}
        title={editingContact ? `Edit — ${editingContact.name} ${editingContact.surname}` : ''}
        onClose={closeEdit}
      >
        <ContactForm
          form={editForm}
          errors={editErrors}
          onChange={handleEditChange}
          onSubmit={handleUpdate}
          onCancel={closeEdit}
          isSubmitting={updateContact.isPending}
          submitLabel="Save changes"
        />
      </Modal>

      {/* Delete confirmation */}
      <ConfirmDialog
        open={!!deletingContact}
        title="Delete this contact?"
        description={
          deletingContact
            ? `${deletingContact.name} ${deletingContact.surname} and all their appointments will be permanently removed.`
            : ''
        }
        confirmLabel="Delete"
        isLoading={deleteContact.isPending}
        onConfirm={handleDelete}
        onCancel={() => setDeletingContact(null)}
      />
    </div>
  )
}
