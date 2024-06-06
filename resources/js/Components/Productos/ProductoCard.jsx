import React, { useState } from 'react';
import axios from 'axios';

export default function ProductoCard({ producto, auth, onProductoAdded }) {
    const [successMessage, setSuccessMessage] = useState('');
    const [cantidad, setCantidad] = useState(1);

    const handleAddToCart = async () => {
        if (auth.user) {
            // Usuario autenticado
            try {
                const response = await axios.post(`/carrito/add/${producto.id}`, { cantidad });
                if (response.status === 200) {
                    onProductoAdded(response.data.producto);
                    setSuccessMessage(`¡Añadido al carrito! (${cantidad} unidad${cantidad > 1 ? 'es' : ''})`);
                    setTimeout(() => setSuccessMessage(''), 4000);
                }
            } catch (error) {
                console.error('Error adding product to cart:', error);
            }
        } else {
            // Usuario no autenticado
            const carrito = JSON.parse(localStorage.getItem('carrito')) || [];
            const productoEnCarrito = carrito.find(item => item.id === producto.id);
            if (productoEnCarrito) {
                productoEnCarrito.cantidad += cantidad;
            } else {
                carrito.push({ id: producto.id, cantidad });
            }
            localStorage.setItem('carrito', JSON.stringify(carrito));
            setSuccessMessage(`¡Añadido al carrito! (${cantidad} unidad${cantidad > 1 ? 'es' : ''})`);
            setTimeout(() => setSuccessMessage(''), 4000);
        }
    };

    const handleCantidadChange = (e) => {
        setCantidad(parseInt(e.target.value));
    };

    return (
        <div className="bg-white p-4 rounded-md shadow-md transition-all duration-300 ease-in-out transform hover:shadow-lg hover:bg-gray-900 hover:text-white hover:scale-105">
            <img src={`/images/productos/${producto.imagen}`} alt={producto.nombre} className="w-full h-96 object-cover mb-2 rounded-md object-bottom" />
            <div className="text-container">
                <h3 className="text-lg font-semibold">{producto.nombre}</h3>
                <p className="text-gray-400">{producto.descripcion}</p>
                <p className="text-lg font-bold text-teal-600">{producto.precio}&euro;</p>
                <p className="text-gray-500">Stock: {producto.stock}</p>
                <div className="flex items-center mt-2">
                    <div className='flex gap-4'>
                        <button
                            onClick={handleAddToCart}
                            className="bg-teal-500 text-white py-2 px-4 rounded hover:bg-teal-700"
                            disabled={producto.stock === 0 || cantidad < 1}
                        >
                            {producto.stock === 0 ? 'Sin stock' : 'Añadir al carrito'}
                        </button>
                        <input
                            type="number"
                            min="1"
                            value={cantidad}
                            onChange={handleCantidadChange}
                            className="p-2 border rounded-md w-20 mr-2 text-black"
                            disabled={producto.stock === 0}
                        />
                    </div>
                </div>
                {successMessage && (
                    <div className="mt-2 w-full text-center text-3xs bg-green-100 text-green-800 p-2 rounded">
                        {successMessage}
                    </div>
                )}
            </div>
        </div>
    );
}
