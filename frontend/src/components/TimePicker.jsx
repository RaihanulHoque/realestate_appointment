import { useEffect, useRef, useState } from 'react'
import { ClockIcon, XMarkIcon } from '@heroicons/react/24/outline'
import { FieldWrapper } from './FormField'

const SIZE = 224
const CX = SIZE / 2
const CY = SIZE / 2
const NUM_RADIUS = 78

function polarToXY(angleDeg, radius) {
  const rad = ((angleDeg - 90) * Math.PI) / 180
  return { x: CX + radius * Math.cos(rad), y: CY + radius * Math.sin(rad) }
}

function parseValue(value) {
  if (!value) return { hour24: 12, minute: 0 }
  const [h = '12', m = '0'] = value.split(':')
  return { hour24: parseInt(h) || 0, minute: parseInt(m) || 0 }
}

function to12h(hour24) {
  return hour24 === 0 ? 12 : hour24 > 12 ? hour24 - 12 : hour24
}

function formatDisplay(value) {
  if (!value) return ''
  const { hour24, minute } = parseValue(value)
  const h12 = to12h(hour24)
  const ap = hour24 >= 12 ? 'PM' : 'AM'
  return `${String(h12).padStart(2, '0')}:${String(minute).padStart(2, '0')} ${ap}`
}

const HOURS = Array.from({ length: 12 }, (_, i) => i + 1)
const MINUTES = Array.from({ length: 12 }, (_, i) => i * 5)

export default function TimePicker({ label, name, value, onChange, error, required }) {
  const [isOpen, setIsOpen] = useState(false)
  const [phase, setPhase] = useState('hour')
  const [hour24, setHour24] = useState(12)
  const [minute, setMinute] = useState(0)
  const [ampm, setAmpm] = useState('PM')
  const containerRef = useRef(null)

  useEffect(() => {
    if (!isOpen) return
    const { hour24: h, minute: m } = parseValue(value)
    setHour24(h)
    setMinute(m)
    setAmpm(h >= 12 ? 'PM' : 'AM')
    setPhase('hour')
  }, [isOpen]) // eslint-disable-line react-hooks/exhaustive-deps

  useEffect(() => {
    function onOutsideClick(e) {
      if (containerRef.current && !containerRef.current.contains(e.target)) {
        setIsOpen(false)
      }
    }
    if (isOpen) document.addEventListener('mousedown', onOutsideClick)
    return () => document.removeEventListener('mousedown', onOutsideClick)
  }, [isOpen])

  function selectHour(h12) {
    let h24 = h12
    if (ampm === 'PM' && h12 !== 12) h24 = h12 + 12
    if (ampm === 'AM' && h12 === 12) h24 = 0
    setHour24(h24)
    setPhase('minute')
  }

  function selectMinute(m) {
    const h = String(hour24).padStart(2, '0')
    const min = String(m).padStart(2, '0')
    onChange({ target: { name, value: `${h}:${min}:00` } })
    setIsOpen(false)
  }

  function toggleAmPm(val) {
    setAmpm(val)
    if (val === 'PM' && hour24 < 12) setHour24(hour24 + 12)
    if (val === 'AM' && hour24 >= 12) setHour24(hour24 - 12)
  }

  function clearValue(e) {
    e.stopPropagation()
    onChange({ target: { name, value: '' } })
  }

  const display12h = to12h(hour24)
  const hourAngle = display12h * 30
  const minuteAngle = minute * 6
  const handEnd = polarToXY(phase === 'hour' ? hourAngle : minuteAngle, 58)
  const handDotEnd = polarToXY(phase === 'hour' ? hourAngle : minuteAngle, NUM_RADIUS)

  const borderCls = error ? 'border-red-400' : 'border-gray-300 dark:border-gray-700'

  return (
    <FieldWrapper label={label} name={name} error={error}>
      <div ref={containerRef} className="relative">
        {/* Trigger */}
        <button
          id={name}
          type="button"
          onClick={() => setIsOpen((p) => !p)}
          aria-required={required}
          className={`mt-1 flex w-full items-center gap-2 rounded-md border px-3 py-2 text-left text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-gray-900 ${borderCls}`}
        >
          <ClockIcon className="h-4 w-4 shrink-0 text-gray-400" />
          <span className={value ? 'text-gray-900 dark:text-gray-100' : 'text-gray-400'}>
            {formatDisplay(value) || 'Select time…'}
          </span>
          {value && (
            <XMarkIcon
              className="ml-auto h-4 w-4 shrink-0 text-gray-400 hover:text-gray-600"
              onClick={clearValue}
              aria-label="Clear time"
            />
          )}
        </button>

        {/* Clock popover */}
        {isOpen && (
          <div className="absolute z-20 mt-1 w-64 rounded-2xl border border-gray-200 bg-white p-4 shadow-2xl dark:border-gray-700 dark:bg-gray-900">

            {/* Digital readout */}
            <div className="mb-1 flex items-center justify-center gap-1">
              <button
                type="button"
                onClick={() => setPhase('hour')}
                className={`rounded-lg px-2 py-0.5 text-3xl font-bold tabular-nums transition-colors ${
                  phase === 'hour'
                    ? 'bg-indigo-600 text-white'
                    : 'text-gray-700 hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-800'
                }`}
              >
                {String(display12h).padStart(2, '0')}
              </button>
              <span className="text-3xl font-bold text-gray-400">:</span>
              <button
                type="button"
                onClick={() => setPhase('minute')}
                className={`rounded-lg px-2 py-0.5 text-3xl font-bold tabular-nums transition-colors ${
                  phase === 'minute'
                    ? 'bg-indigo-600 text-white'
                    : 'text-gray-700 hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-800'
                }`}
              >
                {String(minute).padStart(2, '0')}
              </button>

              {/* AM / PM */}
              <div className="ml-1 flex flex-col gap-0.5">
                {['AM', 'PM'].map((ap) => (
                  <button
                    key={ap}
                    type="button"
                    onClick={() => toggleAmPm(ap)}
                    className={`rounded px-1.5 py-0.5 text-xs font-semibold transition-colors ${
                      ampm === ap
                        ? 'bg-indigo-600 text-white'
                        : 'text-gray-500 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-800'
                    }`}
                  >
                    {ap}
                  </button>
                ))}
              </div>
            </div>

            <p className="mb-2 text-center text-xs text-gray-400 dark:text-gray-500">
              {phase === 'hour' ? 'Tap to select hour' : 'Tap to select minute'}
            </p>

            {/* SVG clock face */}
            <svg
              width={SIZE}
              height={SIZE}
              viewBox={`0 0 ${SIZE} ${SIZE}`}
              className="mx-auto select-none"
            >
              {/* Face background */}
              <circle
                cx={CX} cy={CY} r={CX - 4}
                fill="currentColor"
                className="text-gray-100 dark:text-gray-800"
              />

              {/* Hand */}
              <line
                x1={CX} y1={CY}
                x2={handEnd.x} y2={handEnd.y}
                stroke="currentColor"
                className="text-indigo-500"
                strokeWidth="2"
                strokeLinecap="round"
              />
              {/* Hand tip circle on the number */}
              <circle
                cx={handDotEnd.x} cy={handDotEnd.y} r={18}
                fill="currentColor"
                className="text-indigo-600 opacity-20"
              />
              {/* Center dot */}
              <circle cx={CX} cy={CY} r={4} fill="currentColor" className="text-indigo-600" />

              {/* Hour numbers */}
              {phase === 'hour' &&
                HOURS.map((h) => {
                  const { x, y } = polarToXY(h * 30, NUM_RADIUS)
                  const isSelected = display12h === h
                  return (
                    <g key={h} onClick={() => selectHour(h)} style={{ cursor: 'pointer' }}>
                      <circle
                        cx={x} cy={y} r={17}
                        fill={isSelected ? '#4f46e5' : 'transparent'}
                      />
                      <circle
                        cx={x} cy={y} r={17}
                        fill="transparent"
                        className="hover:fill-indigo-100 dark:hover:fill-indigo-500/20"
                        style={{ display: isSelected ? 'none' : undefined }}
                      />
                      <text
                        x={x} y={y}
                        textAnchor="middle"
                        dominantBaseline="central"
                        fontSize="13"
                        fontWeight="500"
                        fill={isSelected ? '#ffffff' : undefined}
                        className={isSelected ? '' : 'fill-gray-700 dark:fill-gray-300'}
                      >
                        {h}
                      </text>
                    </g>
                  )
                })}

              {/* Minute numbers */}
              {phase === 'minute' &&
                MINUTES.map((m) => {
                  const { x, y } = polarToXY(m * 6, NUM_RADIUS)
                  const isSelected = minute === m
                  return (
                    <g key={m} onClick={() => selectMinute(m)} style={{ cursor: 'pointer' }}>
                      <circle
                        cx={x} cy={y} r={17}
                        fill={isSelected ? '#4f46e5' : 'transparent'}
                      />
                      <circle
                        cx={x} cy={y} r={17}
                        fill="transparent"
                        className="hover:fill-indigo-100 dark:hover:fill-indigo-500/20"
                        style={{ display: isSelected ? 'none' : undefined }}
                      />
                      <text
                        x={x} y={y}
                        textAnchor="middle"
                        dominantBaseline="central"
                        fontSize="12"
                        fontWeight="500"
                        fill={isSelected ? '#ffffff' : undefined}
                        className={isSelected ? '' : 'fill-gray-700 dark:fill-gray-300'}
                      >
                        {String(m).padStart(2, '0')}
                      </text>
                    </g>
                  )
                })}
            </svg>

            {/* Cancel */}
            <button
              type="button"
              onClick={() => setIsOpen(false)}
              className="mt-2 w-full rounded-lg py-1.5 text-sm text-gray-500 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-800"
            >
              Cancel
            </button>
          </div>
        )}
      </div>
    </FieldWrapper>
  )
}
