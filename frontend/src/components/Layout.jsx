import { useState } from 'react'
import { NavLink, Outlet, useNavigate } from 'react-router-dom'
import { Bars3Icon, XMarkIcon } from '@heroicons/react/24/outline'
import toast from 'react-hot-toast'
import { useAuth } from '../context/AuthContext'
import DarkModeToggle from './DarkModeToggle'

const navItems = [
  { to: '/', label: 'Dashboard' },
  { to: '/contacts', label: 'Contacts' },
  { to: '/appointments', label: 'Appointments' },
  { to: '/profile', label: 'Profile' },
]

function navLinkClasses({ isActive }) {
  return `rounded-md px-3 py-2 text-sm font-medium ${
    isActive
      ? 'bg-indigo-50 text-indigo-700 dark:bg-indigo-500/10 dark:text-indigo-300'
      : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-300 dark:hover:bg-gray-800 dark:hover:text-white'
  }`
}

export default function Layout() {
  const [menuOpen, setMenuOpen] = useState(false)
  const { logout } = useAuth()
  const navigate = useNavigate()

  async function handleLogout() {
    await logout()
    toast.success('Signed out')
    navigate('/login', { replace: true })
  }

  return (
    <div className="min-h-screen bg-gray-50 dark:bg-gray-950">
      <header className="border-b border-gray-200 bg-white dark:border-gray-800 dark:bg-gray-900">
        <nav className="mx-auto flex max-w-5xl items-center justify-between px-4 py-3">
          <span className="text-lg font-semibold text-gray-900 dark:text-gray-100">Real Estate Appointment System</span>

          <div className="hidden items-center gap-1 md:flex">
            {navItems.map((item) => (
              <NavLink key={item.to} to={item.to} className={navLinkClasses} end={item.to === '/'}>
                {item.label}
              </NavLink>
            ))}
            <DarkModeToggle />
            <button
              type="button"
              onClick={handleLogout}
              className="ml-2 rounded-md px-3 py-2 text-sm font-medium text-gray-600 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-800"
            >
              Logout
            </button>
          </div>

          <div className="flex items-center gap-1 md:hidden">
            <DarkModeToggle />
            <button
              type="button"
              onClick={() => setMenuOpen((prev) => !prev)}
              aria-label="Toggle menu"
              className="rounded-md p-2 text-gray-600 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-800"
            >
              {menuOpen ? <XMarkIcon className="h-6 w-6" /> : <Bars3Icon className="h-6 w-6" />}
            </button>
          </div>
        </nav>

        {menuOpen && (
          <div className="space-y-1 border-t border-gray-200 px-4 py-3 md:hidden dark:border-gray-800">
            {navItems.map((item) => (
              <NavLink
                key={item.to}
                to={item.to}
                onClick={() => setMenuOpen(false)}
                className={navLinkClasses}
                end={item.to === '/'}
              >
                {item.label}
              </NavLink>
            ))}
            <button
              type="button"
              onClick={handleLogout}
              className="block w-full rounded-md px-3 py-2 text-left text-sm font-medium text-gray-600 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-800"
            >
              Logout
            </button>
          </div>
        )}
      </header>

      <main className="mx-auto max-w-5xl px-4 py-6">
        <Outlet />
      </main>
    </div>
  )
}
