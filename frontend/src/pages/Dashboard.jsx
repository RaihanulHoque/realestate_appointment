import { Link } from 'react-router-dom'
import { UsersIcon, CalendarDaysIcon } from '@heroicons/react/24/outline'
import { useAuth } from '../context/AuthContext'
import { useContacts } from '../hooks/useContacts'
import { useAppointments } from '../hooks/useAppointments'

function StatCard({ icon: Icon, label, count, isLoading, to }) {
  return (
    <Link
      to={to}
      className="flex items-center gap-4 rounded-lg border border-gray-200 bg-white p-5 shadow-sm transition hover:shadow-md dark:border-gray-800 dark:bg-gray-900"
    >
      <div className="rounded-full bg-indigo-50 p-3 dark:bg-indigo-500/10">
        <Icon className="h-6 w-6 text-indigo-600 dark:text-indigo-400" />
      </div>
      <div>
        <p className="text-sm text-gray-500 dark:text-gray-400">{label}</p>
        <p className="text-2xl font-semibold text-gray-900 dark:text-gray-100">
          {isLoading ? '—' : count}
        </p>
      </div>
    </Link>
  )
}

export default function Dashboard() {
  const { user } = useAuth()
  const { data: contacts, isLoading: contactsLoading } = useContacts()
  const { data: appointments, isLoading: appointmentsLoading } = useAppointments()

  return (
    <div>
      <h1 className="text-xl font-semibold text-gray-900 dark:text-gray-100">
        Welcome back{user ? `, ${user.name}` : ''}
      </h1>

      <div className="mt-6 grid gap-4 sm:grid-cols-2">
        <StatCard
          icon={UsersIcon}
          label="Contacts"
          count={contacts?.length ?? 0}
          isLoading={contactsLoading}
          to="/contacts"
        />
        <StatCard
          icon={CalendarDaysIcon}
          label="Appointments"
          count={appointments?.length ?? 0}
          isLoading={appointmentsLoading}
          to="/appointments"
        />
      </div>
    </div>
  )
}
