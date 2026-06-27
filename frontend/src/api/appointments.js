import client from './client'

export function fetchAppointments() {
  return client.get('/auth/appointments').then((res) => res.data.data)
}

export function fetchAppointment(id) {
  return client.get(`/auth/appointment/${id}`).then((res) => res.data.data)
}

export function createAppointment(payload) {
  return client.post('/auth/appointments', payload).then((res) => res.data.appointment)
}

export function updateAppointment(id, payload) {
  return client.put(`/auth/appointment/${id}`, payload).then((res) => res.data)
}

export function deleteAppointment(id) {
  return client.delete(`/auth/appointment/${id}`).then((res) => res.data)
}
