import React, { useState } from 'react';
import axios from 'axios';
import Zoom from 'react-medium-image-zoom';
import 'react-medium-image-zoom/dist/styles.css';

export default function ProductoCard({ producto, auth, onProductoAdded }) {
    const [successMessage, setSuccessMessage] = useState('');
    const [errorMessage, setErrorMessage] = useState('');
    const [cantidad, setCantidad] = useState(1);
    const [stock, setStock] = useState(producto.stock); // Estado para el stock

    const handleAddToCart = async () => {
        if (auth.user) {
            // Usuario autenticado
            try {
                const response = await axios.post(`/carrito/add/${producto.id}`, { cantidad });
                if (response.status === 200) {
                    onProductoAdded(response.data.producto);
                    setSuccessMessage(`¡Añadido al carrito! (${cantidad} unidad${cantidad > 1 ? 'es' : ''})`);
                    setErrorMessage('');
                    setTimeout(() => setSuccessMessage(''), 4000);
                    setStock(stock - cantidad); // Actualizar el stock localmente
                }
            } catch (error) {
                if (error.response && error.response.data && error.response.data.error) {
                    setErrorMessage(error.response.data.error);
                } else {
                    setErrorMessage('Error al añadir al carrito. ¿Has iniciado sesión?');
                }
                setTimeout(() => setErrorMessage(''), 4000);
            }
        } else {
            // Usuario no autenticado
            const carrito = JSON.parse(localStorage.getItem('carrito')) || [];
            const productoEnCarrito = carrito.find(item => item.id === producto.id);
            if (productoEnCarrito) {
                if (productoEnCarrito.cantidad + cantidad > stock) {
                    setErrorMessage('No hay suficiente stock disponible para agregar esta cantidad.');
                    setTimeout(() => setErrorMessage(''), 4000);
                    return;
                }
                productoEnCarrito.cantidad += cantidad;
            } else {
                if (cantidad > stock) {
                    setErrorMessage('No hay suficiente stock disponible para agregar esta cantidad.');
                    setTimeout(() => setErrorMessage(''), 4000);
                    return;
                }
                carrito.push({ id: producto.id, cantidad });
            }
            localStorage.setItem('carrito', JSON.stringify(carrito));
            setSuccessMessage(`¡Añadido al carrito! (${cantidad} unidad${cantidad > 1 ? 'es' : ''})`);
            setErrorMessage('');
            setTimeout(() => setSuccessMessage(''), 4000);
            setStock(stock - cantidad); // Actualizar el stock localmente
        }
    };

    const handleCantidadChange = (e) => {
        setCantidad(parseInt(e.target.value));
    };

    return (
        <div className="bg-white p-4 rounded-md shadow-md transition-all duration-300 ease-in-out transform hover:shadow-lg hover:bg-gray-900 hover:text-white hover:scale-105">
            <Zoom>
                <img
                    src={`/images/productos/${producto.imagen}`}
                    alt={producto.nombre}
                    className="w-full h-96 object-cover mb-2 rounded-md object-bottom"
                />
            </Zoom>
            <div className="text-container">
                <h3 className="text-lg font-semibold">{producto.nombre}</h3>
                <p className="text-sm italic">{producto.descripcion}</p>
                <p className="text-lg font-bold text-teal-600">{producto.precio}&euro;</p>
                <p className="">Stock: {stock}</p> {/* Mostrar el stock actualizado */}
                <div className="flex items-center mt-2">
                    <div className='flex gap-4'>
                        <button
                            onClick={handleAddToCart}
                            className={`bg-teal-700 text-white py-2 px-4 rounded hover:bg-teal-400 ${stock === 0 ? 'cursor-not-allowed' : ''}`}
                            disabled={stock === 0 || cantidad < 1}
                        >
                            {stock === 0 ? 'Sin stock' : 'Añadir al carrito'}
                        </button>
                        <input
                            type="number"
                            min="1"
                            value={cantidad}
                            onChange={handleCantidadChange}
                            className="p-2 border rounded-md w-20 mr-2 text-black"
                            disabled={stock === 0}
                        />
                    </div>
                </div>
                {successMessage && (
                    <div className="mt-2 w-full text-center text-3xs bg-green-100 text-green-800 p-2 rounded">
                        {successMessage}
                    </div>
                )}
                {errorMessage && (
                    <div className="mt-2 w-full text-center text-3xs bg-red-100 text-red-800 p-2 rounded">
                        {errorMessage}
                    </div>
                )}
            </div>
        </div>
    );
}
