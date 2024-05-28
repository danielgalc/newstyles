// ModalReserva.jsx
import React, { useState, useEffect } from 'react';
import axios from 'axios';

export default function ModalReserva({ servicio, isOpen, onClose, userId, peluqueros }) {
  const [peluqueroId, setPeluqueroId] = useState('');
  const [fecha, setFecha] = useState('');
  const [hora, setHora] = useState('');

  const handleSubmit = async (e) => {
    e.preventDefault();
    try {
      const response = await axios.post(route('citas.store'), {
        user_id: userId,
        peluquero_id: peluqueroId,
        fecha,
        hora,
        servicio: servicio.id,
      });
      if (response.status === 200) {
        onClose();
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
          </div>
          <div className="mb-4">
            <label htmlFor="fecha" className="block text-sm font-medium text-gray-700">Fecha</label>
            <input
              type="date"
              id="fecha"
              value={fecha}
              onChange={(e) => setFecha(e.target.value)}
              className="mt-1 p-2 block w-full border border-gray-300 rounded-md"
              required
            />
          </div>
          <div className="mb-4">
            <label htmlFor="hora" className="block text-sm font-medium text-gray-700">Hora</label>
            <input
              type="time"
              id="hora"
              value={hora}
              onChange={(e) => setHora(e.target.value)}
              className="mt-1 p-2 block w-full border border-gray-300 rounded-md"
              required
            />
          </div>
          <div className="flex justify-end">
            <button type="submit" className="bg-teal-400 text-white py-2 px-4 rounded-lg">Reservar</button>
          </div>
        </form>
      </div>
    </div>
  );
}
