import React from 'react';
import axios from 'axios';

export default function ProductoCard({ producto, onProductoAdded }) {
    const handleAddToCart = async () => {
        try {
            const response = await axios.post(`/carrito/add/${producto.id}`);
            if (response.status === 200) {
                onProductoAdded(response.data.producto);
            }
        } catch (error) {
            console.error('Error adding product to cart:', error);
        }
    };

    return (
        <div className="bg-white p-4 rounded-md shadow-md transition-all duration-300 ease-in-out transform hover:shadow-lg hover:bg-gray-900 hover:text-white hover:scale-105">
            <img src={`/images/productos/${producto.imagen}`} alt={producto.nombre} className="w-full h-96 object-cover mb-2 rounded-md object-bottom" />
            <div className="text-container">
                <h3 className="text-lg font-semibold">{producto.nombre}</h3>
                <p className="text-gray-400">{producto.descripcion}</p>
                <p className="text-lg font-bold text-teal-600">{producto.precio}&euro;</p>
                <p className="text-gray-500">Stock: {producto.stock}</p>
                <button 
                    onClick={handleAddToCart} 
                    className="mt-2 bg-teal-500 text-white py-2 px-4 rounded hover:bg-teal-700"
                    disabled={producto.stock === 0}
                >
                    {producto.stock === 0 ? 'Sin stock' : 'Añadir al carrito'}
                </button>
            </div>
        </div>
    );
}
