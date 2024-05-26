// ServicioCard.jsx
import React from 'react';

export default function ServicioCard({ servicio }) {
    return (
        <div className="relative h-36 p-6 shadow-md rounded-md">
            <h3 className="text-3xl font-semibold mb-3">{servicio.nombre}</h3>
            <div className="absolute bottom-0 right-0 w-1/4 flex flex-col items-center justify-center p-4">
                <p className="text-3xl">{servicio.precio} &euro;</p>
                <p className="text-lg text-gray-600">Aprox. {servicio.duracion}</p>
                <a href={`/citas/${servicio.id}/create`} className="bg-teal-400 text-white font-bold text-lg w-full py-1 text-center rounded-full">Reservar</a>
            </div>
        </div>
    );
}
