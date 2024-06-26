import React from 'react';
import ProductoCard from './ProductoCard';
import Paginacion from '@/Components/Paginacion';
import axios from 'axios';

export default function Grid({ productos, setFilteredProductos, searchTerm, sortBy, selectedCategory, handleProductoAdded, auth }) {
    const handlePageChange = async (page) => {
        try {
            const response = await axios.get(route('productos.productos'), {
                params: { 
                    page, 
                    search: searchTerm, 
                    sortBy, 
                    category: selectedCategory 
                }
            });
            setFilteredProductos(response.data.productos || {});
        } catch (error) {
            console.error('Error fetching productos:', error);
        }
    };

    const handleProductoUpdated = (updatedProducto) => {
        setFilteredProductos((prevProductos) => {
            if (!Array.isArray(prevProductos.data)) {
                return prevProductos;
            }

            const updatedData = prevProductos.data.map((producto) =>
                producto.id === updatedProducto.id ? updatedProducto : producto
            );

            return { ...prevProductos, data: updatedData };
        });
    };

    return (
        <div className='p-8'>
            <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                {productos.data && productos.data.map((producto) =>
                    <ProductoCard key={producto.id} producto={producto} auth={auth} onProductoAdded={handleProductoUpdated} />
                )}
            </div>
            {productos && productos.data.length > 0 && (
                <div className='mt-4 text-center'>
                    <Paginacion paginationData={productos} onPageChange={handlePageChange} />
                </div>
            )}
        </div>
    );
}
