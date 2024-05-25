import React from 'react';

export default function ProductoCard({ producto }) {
    return (

        <div className="bg-white p-4 rounded-md shadow-md transition-all duration-300 ease-in-out transform hover:shadow-lg hover:bg-gray-900 hover:text-white hover:scale-105">
            <img src={`/images/productos/${producto.imagen}`} alt={producto.nombre} className="w-full h-96 object-cover mb-2 rounded-md object-bottom" />

            <div className="text-container">
                <h3 className="text-lg font-semibold">{producto.nombre}</h3>
                <p className="text-gray-400">{producto.descripcion}</p>
                <p className="text-lg font-bold text-teal-600">{producto.precio}&euro;</p>
            </div>
        </div>
    );
}
