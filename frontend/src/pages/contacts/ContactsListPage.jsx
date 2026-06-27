import { useMemo, useState } from 'react'
import { Link } from 'react-router-dom'
import { PlusIcon, MagnifyingGlassIcon, UsersIcon } from '@heroicons/react/24/outline'
import Skeleton from '../../components/Skeleton'
import EmptyState from '../../components/EmptyState'
import { useContacts } from '../../hooks/useContacts'

export default function ContactsListPage() {
  const { data: contacts, isLoading, isError, refetch } = useContacts()
  const [search, setSearch] = useState('')

  const filtered = useMemo(() => {
    if (!contacts) return []
    const term = search.trim().toLowerCase()
    if (!term) return contacts
    return contacts.filter((contact) =>
      `${contact.name} ${contact.surname} ${contact.email}`.toLowerCase().includes(term)
    )
  }, [contacts, search])

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
          onChange={(event) => setSearch(event.target.value)}
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
              <Link
                key={contact.id}
                to={`/contacts/${contact.id}`}
                className="flex flex-col gap-1 px-4 py-3 hover:bg-gray-50 sm:flex-row sm:items-center sm:justify-between dark:hover:bg-gray-800"
              >
                <div>
                  <p className="font-medium text-gray-900 dark:text-gray-100">
                    {contact.name} {contact.surname}
                  </p>
                  <p className="text-sm text-gray-500 dark:text-gray-400">{contact.email}</p>
                </div>
                <span className="text-sm text-gray-500 dark:text-gray-400">{contact.phone}</span>
              </Link>
            ))}
          </div>
        )}
      </div>
    </div>
  )
}
