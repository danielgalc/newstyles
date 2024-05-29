// ServicioCard.jsx
import React, { useState } from 'react';
import ModalReserva from './ModalReserva';
import ModalConfirmacion from './ModalConfirmacion'; // Importa el nuevo modal
import { Tooltip } from 'react-tooltip'; // Asegúrate de tener una biblioteca de tooltips instalada o usa un simple div con CSS


export default function ServicioCard({ servicio, userId, peluqueros }) {
  const [isModalOpen, setIsModalOpen] = useState(false);
  const [isConfirmModalOpen, setIsConfirmModalOpen] = useState(false); // Estado para el modal de confirmación
  const [reservaInfo, setReservaInfo] = useState(null); // Estado para la información de la reserva

  const handleReserveClick = () => {
    if (userId) {
      setIsModalOpen(true);
    }
  };

  const handleCloseModal = () => {
    setIsModalOpen(false);
  };

  const handleConfirmModalClose = () => {
    setIsConfirmModalOpen(false);
  };

  const handleReservaSuccess = (info) => {
    setReservaInfo(info);
    setIsModalOpen(false);
    setIsConfirmModalOpen(true);
  };

  return (
    <div className="relative h-36 p-6 shadow-md rounded-md">
      <h3 className="text-3xl font-semibold mb-3">{servicio.nombre}</h3>
      <div className="absolute bottom-0 right-0 w-1/4 flex flex-col items-center justify-center p-4">
        <p className="text-3xl">{servicio.precio} &euro;</p>
        <p className="text-lg text-gray-600">Aprox. {servicio.duracion}</p>
        <div className="relative group w-full">
          <button
            onClick={handleReserveClick}
            className={`bg-teal-400 text-white font-bold text-lg w-full py-1 text-center rounded-full ${!userId ? 'cursor-not-allowed' : ''}`}
            disabled={!userId}
          >
            Reservar
          </button>
          {!userId && (
            <div className="absolute bottom-full w-full mb-2 hidden group-hover:block bg-gray-700 text-white text-sm rounded py-1 px-3">
              Debes iniciar sesión para reservar
            </div>
          )}
        </div>
      </div>
      <ModalReserva
        servicio={servicio}
        isOpen={isModalOpen}
        onClose={handleCloseModal}
        onSuccess={handleReservaSuccess} // Pasa la función de éxito
        userId={userId}
        peluqueros={peluqueros}
      />
      <ModalConfirmacion
        isOpen={isConfirmModalOpen}
        onClose={handleConfirmModalClose}
        reservaInfo={reservaInfo}
      />
    </div>
  );
}