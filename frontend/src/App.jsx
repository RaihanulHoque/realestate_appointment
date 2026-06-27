import { BrowserRouter, Routes, Route, Navigate } from 'react-router-dom'
import { QueryClient, QueryClientProvider } from '@tanstack/react-query'
import { Toaster } from 'react-hot-toast'
import { AuthProvider } from './context/AuthContext'
import ProtectedRoute from './components/ProtectedRoute'
import Layout from './components/Layout'
import Login from './pages/Login'
import Register from './pages/Register'
import Dashboard from './pages/Dashboard'
import Profile from './pages/Profile'
import ContactsListPage from './pages/contacts/ContactsListPage'
import ContactFormPage from './pages/contacts/ContactFormPage'
import ContactDetailPage from './pages/contacts/ContactDetailPage'
import AppointmentsListPage from './pages/appointments/AppointmentsListPage'
import AppointmentFormPage from './pages/appointments/AppointmentFormPage'
import AppointmentDetailPage from './pages/appointments/AppointmentDetailPage'

const queryClient = new QueryClient({
  defaultOptions: {
    queries: {
      retry: 1,
      refetchOnWindowFocus: false,
    },
  },
})

export default function App() {
  return (
    <QueryClientProvider client={queryClient}>
      <BrowserRouter>
        <AuthProvider>
          <Toaster position="top-right" />
          <Routes>
            <Route path="/login" element={<Login />} />
            <Route path="/register" element={<Register />} />

            <Route element={<ProtectedRoute />}>
              <Route element={<Layout />}>
                <Route path="/" element={<Dashboard />} />
                <Route path="/profile" element={<Profile />} />
                <Route path="/contacts" element={<ContactsListPage />} />
                <Route path="/contacts/new" element={<ContactFormPage />} />
                <Route path="/contacts/:id" element={<ContactDetailPage />} />
                <Route path="/appointments" element={<AppointmentsListPage />} />
                <Route path="/appointments/new" element={<AppointmentFormPage />} />
                <Route path="/appointments/:id" element={<AppointmentDetailPage />} />
              </Route>
            </Route>

            <Route path="*" element={<Navigate to="/" replace />} />
          </Routes>
        </AuthProvider>
      </BrowserRouter>
    </QueryClientProvider>
  )
}
