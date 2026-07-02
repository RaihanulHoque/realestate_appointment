import { useEffect, useRef, useState } from 'react'
import { ChevronDownIcon, MagnifyingGlassIcon, XMarkIcon } from '@heroicons/react/24/outline'
import { FieldWrapper } from './FormField'

export default function SearchableSelect({
  label,
  name,
  value,
  onChange,
  options = [],
  placeholder = 'Search…',
  error,
  required,
}) {
  const [isOpen, setIsOpen] = useState(false)
  const [search, setSearch] = useState('')
  const containerRef = useRef(null)
  const inputRef = useRef(null)

  const selected = options.find((opt) => String(opt.value) === String(value))

  const filtered = options.filter((opt) =>
    opt.label.toLowerCase().includes(search.toLowerCase())
  )

  useEffect(() => {
    function onClickOutside(e) {
      if (containerRef.current && !containerRef.current.contains(e.target)) {
        setIsOpen(false)
        setSearch('')
      }
    }
    if (isOpen) document.addEventListener('mousedown', onClickOutside)
    return () => document.removeEventListener('mousedown', onClickOutside)
  }, [isOpen])

  useEffect(() => {
    if (isOpen) inputRef.current?.focus()
  }, [isOpen])

  function select(opt) {
    onChange({ target: { name, value: opt.value } })
    setIsOpen(false)
    setSearch('')
  }

  function clear(e) {
    e.stopPropagation()
    onChange({ target: { name, value: '' } })
  }

  function handleKeyDown(e) {
    if (e.key === 'Escape') {
      setIsOpen(false)
      setSearch('')
    }
  }

  const borderClass = error ? 'border-red-400' : 'border-gray-300 dark:border-gray-700'

  return (
    <FieldWrapper label={label} name={name} error={error}>
      <div ref={containerRef} className="relative">
        {/* Trigger */}
        <button
          id={name}
          type="button"
          onClick={() => setIsOpen((prev) => !prev)}
          className={`mt-1 flex w-full items-center justify-between rounded-md border px-3 py-2 text-left text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-gray-900 ${borderClass}`}
          aria-haspopup="listbox"
          aria-expanded={isOpen}
          aria-required={required}
        >
          <span className={selected ? 'text-gray-900 dark:text-gray-100' : 'text-gray-400'}>
            {selected ? selected.label : placeholder}
          </span>
          <span className="flex shrink-0 items-center gap-1 pl-2">
            {selected && (
              <XMarkIcon
                className="h-4 w-4 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300"
                onClick={clear}
                aria-label="Clear selection"
              />
            )}
            <ChevronDownIcon
              className={`h-4 w-4 text-gray-400 transition-transform duration-150 ${isOpen ? 'rotate-180' : ''}`}
            />
          </span>
        </button>

        {/* Dropdown */}
        {isOpen && (
          <div className="absolute z-20 mt-1 w-full overflow-hidden rounded-md border border-gray-200 bg-white shadow-lg dark:border-gray-700 dark:bg-gray-900">
            {/* Search input */}
            <div className={`relative border-b dark:border-gray-700 ${borderClass}`}>
              <MagnifyingGlassIcon className="pointer-events-none absolute left-3 top-2.5 h-4 w-4 text-gray-400" />
              <input
                ref={inputRef}
                type="text"
                value={search}
                onChange={(e) => setSearch(e.target.value)}
                onKeyDown={handleKeyDown}
                placeholder="Type to search…"
                className="w-full rounded-t-md py-2 pl-9 pr-3 text-sm focus:outline-none dark:bg-gray-900 dark:text-gray-100 dark:placeholder-gray-500"
              />
            </div>

            {/* Options */}
            <ul className="max-h-52 overflow-y-auto py-1" role="listbox">
              {filtered.length === 0 ? (
                <li className="px-3 py-2 text-sm text-gray-500 dark:text-gray-400">
                  No contacts found
                </li>
              ) : (
                filtered.map((opt) => {
                  const isSelected = String(opt.value) === String(value)
                  return (
                    <li
                      key={opt.value}
                      role="option"
                      aria-selected={isSelected}
                      onClick={() => select(opt)}
                      className={`cursor-pointer px-3 py-2 text-sm ${
                        isSelected
                          ? 'bg-indigo-50 text-indigo-700 dark:bg-indigo-500/10 dark:text-indigo-300'
                          : 'text-gray-900 hover:bg-gray-50 dark:text-gray-100 dark:hover:bg-gray-800'
                      }`}
                    >
                      {opt.label}
                    </li>
                  )
                })
              )}
            </ul>
          </div>
        )}
      </div>
    </FieldWrapper>
  )
}
