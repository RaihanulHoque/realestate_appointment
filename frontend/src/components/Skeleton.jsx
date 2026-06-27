export default function Skeleton({ rows = 3 }) {
  return (
    <div className="space-y-3" role="status" aria-label="Loading">
      {Array.from({ length: rows }).map((_, index) => (
        <div
          key={index}
          className="h-14 animate-pulse rounded-lg bg-gray-200 dark:bg-gray-800"
        />
      ))}
    </div>
  )
}
