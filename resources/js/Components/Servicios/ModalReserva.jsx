import React, { useState, useEffect } from 'react';
import axios from 'axios';

export default function ModalReserva({ servicio, isOpen, onClose, onSuccess, userId, peluqueros }) {
  const [peluqueroId, setPeluqueroId] = useState('');
  const [fecha, setFecha] = useState('');
  const [hora, setHora] = useState('');
  const [errorMessage, setErrorMessage] = useState('');
  const [localErrors, setLocalErrors] = useState({});
  const [citas, setCitas] = useState([]);
  const [bloqueos, setBloqueos] = useState([]);

  useEffect(() => {
    if (peluqueroId && fecha) {
      const formattedFecha = new Date(fecha).toISOString().split('T')[0];
      const url = `/citas/obtenerCitas?peluquero_id=${peluqueroId}&fecha=${formattedFecha}`;
      axios.get(url)
        .then(response => {
          console.log('Citas y bloqueos obtenidos:', response.data);
          setCitas(response.data.citas);
          const flattenBloqueos = response.data.bloqueos.flatMap(bloqueo => bloqueo.horas);
          setBloqueos(flattenBloqueos);
        })
        .catch(error => console.error('Error obteniendo citas y bloqueos:', error));
    }
  }, [peluqueroId, fecha]);

  const generateTimeOptions = () => {
    const times = [];
    const timeRanges = [
      { start: 10, end: 13 },
      { start: 16, end: 20 }
    ];

    timeRanges.forEach(range => {
      for (let i = range.start; i <= range.end; i++) {
        times.push(`${String(i).padStart(2, '0')}:00:00`);
      }
    });

    return times;
  };

  const getCurrentTime = () => {
    const now = new Date();
    const hours = String(now.getHours()).padStart(2, '0');
    const minutes = String(now.getMinutes()).padStart(2, '0');
    return `${hours}:${minutes}:00`;
  };

  const getAvailableTimes = () => {
    const today = new Date().toISOString().split('T')[0];
    const currentTime = getCurrentTime();

    if (!fecha) return generateTimeOptions();

    const occupiedTimes = citas.map(cita => `${cita.hora}`);
    const blockedTimes = bloqueos;

    console.log('Horas ocupadas:', occupiedTimes);
    console.log('Horas bloqueadas:', blockedTimes);

    let availableTimes = generateTimeOptions().filter(time => !occupiedTimes.includes(time) && !blockedTimes.includes(time));

    if (fecha === today) {
      availableTimes = availableTimes.filter(time => time >= currentTime);
    }

    console.log('Longitud availableTimes:', availableTimes.length);

    return availableTimes;
  };

  useEffect(() => {
    if (fecha && peluqueroId) {
      const availableTimes = getAvailableTimes();
      if (availableTimes.length === 0) {
        setLocalErrors({ fecha: 'No hay disponibilidad para esta fecha. Por favor, elige otro día.' });
      } else {
        setLocalErrors({});
      }
    }
  }, [citas, bloqueos]);

  const handleDateChange = (e) => {
    const selectedDate = new Date(e.target.value);
    const day = selectedDate.getUTCDay();

    if (day === 6 || day === 0) {
      setLocalErrors({ fecha: 'No se pueden seleccionar fines de semana. Por favor, elige otro día.' });
      setFecha('');
    } else {
      setFecha(e.target.value);
    }
  };

  const validateForm = () => {
    const errors = {};

    if (!peluqueroId) {
      errors.peluqueroId = 'Por favor, selecciona un peluquero.';
    }

    if (!fecha) {
      errors.fecha = 'Por favor, selecciona una fecha válida.';
    } else {
      const selectedDate = new Date(fecha);
      const day = selectedDate.getUTCDay();

      if (day === 6 || day === 0) {
        errors.fecha = 'No se pueden seleccionar fines de semana. Por favor, elige otro día.';
      } else if (getAvailableTimes().length === 0) {
        errors.fecha = 'No hay disponibilidad para esta fecha. Por favor, elige otro día.';
      }
    }

    if (!hora) {
      errors.hora = 'Por favor, selecciona una hora válida.';
    }

    setLocalErrors(errors);
    return Object.keys(errors).length === 0;
  };

  const handleSubmit = async (e) => {
    e.preventDefault();

    if (!validateForm()) {
      return;
    }

    try {
      const response = await axios.post(route('citas.store'), {
        user_id: userId,
        peluquero_id: peluqueroId,
        fecha,
        hora,
        servicio: servicio.id,
      });
      if (response.status === 200) {
        onSuccess({ fecha, hora, servicio });
      }
    } catch (error) {
      console.error('Error reservando la cita:', error);
    }
  };

  if (!isOpen) return null;

  return (
    <div className="fixed inset-0 bg-gray-600 bg-opacity-50 flex justify-center items-center z-10">
      <div className="bg-white rounded-lg shadow-lg p-6 w-full max-w-md">
        <div className="flex justify-between items-center border-b pb-2">
          <h3 className="text-lg font-semibold">Reservar: {servicio.nombre}</h3>
          <button onClick={onClose} className="text-gray-400 hover:text-gray-900">
            <svg className="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M6 18L18 6M6 6l12 12" />
            </svg>
          </button>
        </div>
        <form onSubmit={handleSubmit} className="mt-4">
          <div className="mb-4">
            <label htmlFor="peluquero_id" className="block text-sm font-medium text-gray-700">Peluquero</label>
            <select
              id="peluquero_id"
              value={peluqueroId}
              onChange={(e) => setPeluqueroId(e.target.value)}
              className="mt-1 p-2 block w-full border border-gray-300 rounded-md"
              required
            >
              <option value="">Selecciona un peluquero</option>
              {peluqueros.map((peluquero) => (
                <option key={peluquero.id} value={peluquero.id}>
                  {peluquero.name}
                </option>
              ))}
            </select>
            {localErrors.peluqueroId && <span className="text-red-500 text-sm">{localErrors.peluqueroId}</span>}
          </div>
          <div className="mb-4 relative group">
            <label htmlFor="fecha" className="block text-sm font-medium text-gray-700">Fecha</label>
            <input
              type="date"
              id="fecha"
              value={fecha}
              onChange={handleDateChange}
              className={`mt-1 p-2 block w-full border border-gray-300 rounded-md ${!peluqueroId ? 'cursor-not-allowed' : ''}`}
              min={new Date().toISOString().split('T')[0]}
              required
              disabled={!peluqueroId}
            />
            {!peluqueroId && (
              <div className="absolute top-full mt-1 bg-black text-white text-xs rounded py-1 px-2 z-10 w-56 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                Has de elegir peluquero antes de seleccionar una fecha
              </div>
            )}
            {localErrors.fecha && <span className="text-red-500 text-sm">{localErrors.fecha}</span>}
          </div>
          <div className="mb-4 relative group">
            <label htmlFor="hora" className="block text-sm font-medium text-gray-700">Hora</label>
            <select
              id="hora"
              value={hora}
              onChange={(e) => setHora(e.target.value)}
              className={`mt-1 p-2 block w-full border border-gray-300 rounded-md ${!fecha ? 'cursor-not-allowed' : ''}`}
              required
              disabled={!fecha}
            >
              <option value="">Selecciona una hora</option>
              {getAvailableTimes().map((time) => (
                <option key={time} value={time}>
                  {time.slice(0, 5)}
                </option>
              ))}
            </select>
            {!fecha && (
              <div className="absolute top-full mt-1 bg-black text-white text-xs rounded py-1 px-2 z-10 w-56 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                Has de seleccionar una fecha disponible antes de seleccionar la hora
              </div>
            )}
            {localErrors.hora && <span className="text-red-500 text-sm">{localErrors.hora}</span>}
          </div>
          <div className="flex justify-end">
            <button type="submit" className="bg-teal-400 text-white py-2 px-4 rounded-lg">Reservar</button>
          </div>
        </form>
      </div>
    </div>
  );
}
