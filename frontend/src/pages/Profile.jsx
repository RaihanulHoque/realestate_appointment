import { useAuth } from '../context/AuthContext'

export default function Profile() {
  const { user } = useAuth()

  if (!user) return null

  const fields = [
    { label: 'Name', value: user.name },
    { label: 'Email', value: user.email },
    { label: 'Phone', value: user.phone },
    { label: 'Address', value: user.address },
  ]

  return (
    <div className="max-w-md">
      <h1 className="text-xl font-semibold text-gray-900 dark:text-gray-100">Profile</h1>
      <div className="mt-4 divide-y divide-gray-200 rounded-lg border border-gray-200 bg-white dark:divide-gray-800 dark:border-gray-800 dark:bg-gray-900">
        {fields.map((field) => (
          <div key={field.label} className="flex justify-between px-4 py-3 text-sm">
            <span className="text-gray-500 dark:text-gray-400">{field.label}</span>
            <span className="font-medium text-gray-900 dark:text-gray-100">{field.value}</span>
          </div>
        ))}
      </div>
    </div>
  )
}
