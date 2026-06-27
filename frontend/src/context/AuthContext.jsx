import { createContext, useContext, useEffect, useState, useCallback } from 'react'
import { getToken, setToken as persistToken } from '../api/tokenStore'
import {
  login as loginRequest,
  register as registerRequest,
  logout as logoutRequest,
  fetchProfile,
} from '../api/auth'

const AuthContext = createContext(null)

export function AuthProvider({ children }) {
  const [user, setUser] = useState(null)
  const [isLoading, setIsLoading] = useState(true)

  useEffect(() => {
    const token = getToken()
    if (!token) {
      setIsLoading(false)
      return
    }

    fetchProfile()
      .then(setUser)
      .catch(() => {
        persistToken(null)
        setUser(null)
      })
      .finally(() => setIsLoading(false))
  }, [])

  const login = useCallback(async (credentials) => {
    const data = await loginRequest(credentials)
    persistToken(data.access_token)
    setUser(data.user)
    return data.user
  }, [])

  const register = useCallback((payload) => registerRequest(payload), [])

  const logout = useCallback(async () => {
    try {
      await logoutRequest()
    } catch {
      // token may already be invalid/expired - clear local state regardless
    }
    persistToken(null)
    setUser(null)
  }, [])

  const value = {
    user,
    isLoading,
    isAuthenticated: !!user,
    login,
    register,
    logout,
  }

  return <AuthContext.Provider value={value}>{children}</AuthContext.Provider>
}

export function useAuth() {
  const ctx = useContext(AuthContext)
  if (!ctx) {
    throw new Error('useAuth must be used within an AuthProvider')
  }
  return ctx
}
