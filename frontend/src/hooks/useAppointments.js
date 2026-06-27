import { useMutation, useQuery, useQueryClient } from '@tanstack/react-query'
import * as appointmentsApi from '../api/appointments'

export function useAppointments() {
  return useQuery({ queryKey: ['appointments'], queryFn: appointmentsApi.fetchAppointments })
}

export function useAppointment(id) {
  return useQuery({
    queryKey: ['appointments', id],
    queryFn: () => appointmentsApi.fetchAppointment(id),
    enabled: !!id,
  })
}

export function useCreateAppointment() {
  const queryClient = useQueryClient()
  return useMutation({
    mutationFn: appointmentsApi.createAppointment,
    onSuccess: () => queryClient.invalidateQueries({ queryKey: ['appointments'], exact: true }),
  })
}

export function useUpdateAppointment() {
  const queryClient = useQueryClient()
  return useMutation({
    mutationFn: ({ id, payload }) => appointmentsApi.updateAppointment(id, payload),
    onSuccess: async (_data, { id }) => {
      await Promise.all([
        queryClient.invalidateQueries({ queryKey: ['appointments'], exact: true }),
        queryClient.invalidateQueries({ queryKey: ['appointments', id] }),
      ])
    },
  })
}

export function useDeleteAppointment() {
  const queryClient = useQueryClient()
  return useMutation({
    mutationFn: appointmentsApi.deleteAppointment,
    onSuccess: (_data, id) => {
      queryClient.removeQueries({ queryKey: ['appointments', id] })
      queryClient.invalidateQueries({ queryKey: ['appointments'], exact: true })
    },
  })
}
