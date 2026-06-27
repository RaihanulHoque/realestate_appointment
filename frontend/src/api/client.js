import axios from 'axios'
import { getToken, setToken } from './tokenStore'

const baseURL = import.meta.env.VITE_API_BASE_URL || 'http://localhost:8000/api'

const client = axios.create({
  baseURL,
  headers: { Accept: 'application/json' },
})

client.interceptors.request.use((config) => {
  const token = getToken()
  if (token) {
    config.headers.Authorization = `Bearer ${token}`
  }
  return config
})

let refreshPromise = null

function isAuthEndpoint(url = '') {
  return url.includes('/auth/login') || url.includes('/auth/register') || url.includes('/auth/refresh')
}

client.interceptors.response.use(
  (response) => response,
  async (error) => {
    const { config, response } = error

    if (response?.status !== 401 || config._retried || isAuthEndpoint(config?.url)) {
      return Promise.reject(error)
    }

    config._retried = true

    try {
      refreshPromise ||= client.post('/auth/refresh').then((res) => {
        setToken(res.data.access_token)
        return res.data.access_token
      }).finally(() => {
        refreshPromise = null
      })

      const newToken = await refreshPromise
      config.headers.Authorization = `Bearer ${newToken}`
      return client(config)
    } catch (refreshError) {
      setToken(null)
      window.location.href = '/login'
      return Promise.reject(refreshError)
    }
  }
)

export default client
