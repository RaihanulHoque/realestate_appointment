import { useMutation, useQuery, useQueryClient } from '@tanstack/react-query'
import * as contactsApi from '../api/contacts'

export function useContacts() {
  return useQuery({ queryKey: ['contacts'], queryFn: contactsApi.fetchContacts })
}

export function useContact(id) {
  return useQuery({
    queryKey: ['contacts', id],
    queryFn: () => contactsApi.fetchContact(id),
    enabled: !!id,
  })
}

export function useCreateContact() {
  const queryClient = useQueryClient()
  return useMutation({
    mutationFn: contactsApi.createContact,
    onSuccess: () => queryClient.invalidateQueries({ queryKey: ['contacts'], exact: true }),
  })
}

export function useUpdateContact() {
  const queryClient = useQueryClient()
  return useMutation({
    mutationFn: ({ id, payload }) => contactsApi.updateContact(id, payload),
    onSuccess: async (_data, { id }) => {
      await Promise.all([
        queryClient.invalidateQueries({ queryKey: ['contacts'], exact: true }),
        queryClient.invalidateQueries({ queryKey: ['contacts', id] }),
      ])
    },
  })
}

export function useDeleteContact() {
  const queryClient = useQueryClient()
  return useMutation({
    mutationFn: contactsApi.deleteContact,
    onSuccess: (_data, id) => {
      queryClient.removeQueries({ queryKey: ['contacts', id] })
      queryClient.invalidateQueries({ queryKey: ['contacts'], exact: true })
    },
  })
}
