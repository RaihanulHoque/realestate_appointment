import client from './client'

export function fetchContacts() {
  return client.get('/auth/contacts').then((res) => res.data.data)
}

export function fetchContact(id) {
  return client.get(`/auth/contact/${id}`).then((res) => res.data.data)
}

export function createContact(payload) {
  return client.post('/auth/contacts', payload).then((res) => res.data.contact)
}

export function updateContact(id, payload) {
  return client.put(`/auth/contact/${id}`, payload).then((res) => res.data)
}

export function deleteContact(id) {
  return client.delete(`/auth/contact/${id}`).then((res) => res.data)
}
