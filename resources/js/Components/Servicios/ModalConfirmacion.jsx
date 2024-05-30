// ModalConfirmacion.jsx
import React from 'react';

export default function ModalConfirmacion({ isOpen, onClose, reservaInfo }) {
  if (!isOpen || !reservaInfo) return null;

  const { fecha, hora, servicio } = reservaInfo;

  return (
    <div className="fixed inset-0 bg-gray-600 bg-opacity-50 flex justify-center items-center z-10">
      <div className="bg-gray-200 rounded-lg shadow-lg p-6 w-full max-w-md">
        <div className="flex justify-between items-center border-b pb-2">
          <h3 className="text-lg font-semibold">Reserva Confirmada</h3>
          <button onClick={onClose} className="text-gray-400 hover:text-gray-900">
            <svg className="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M6 18L18 6M6 6l12 12" />
            </svg>
          </button>
        </div>
        <div className="mt-4">
          <p>Su cita para el día <b>{fecha}</b> a las <b>{hora}</b> horas ha sido solicitada para el servicio: <span className='italic'><b>{servicio.nombre}</b></span></p>
          <br />
          <p>Observe el estado de su próxima cita o modifíquela en el <a href="historial-citas" className='text-teal-600'>historial de citas</a>.</p>
        </div>
        <div className="flex justify-end mt-4">
          <button onClick={onClose} className="bg-teal-400 text-white py-2 px-4 rounded-lg">Cerrar</button>
        </div>
      </div>
    </div>
  );
}