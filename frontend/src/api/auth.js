import client from './client'

export function login(credentials) {
  return client.post('/auth/login', credentials).then((res) => res.data)
}

export function register(payload) {
  return client.post('/auth/register', payload).then((res) => res.data)
}

export function logout() {
  return client.post('/auth/logout').then((res) => res.data)
}

export function fetchProfile() {
  return client.get('/auth/user-profile').then((res) => res.data)
}
