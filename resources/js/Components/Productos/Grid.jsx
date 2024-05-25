import React from 'react';
import ProductoCard from './ProductoCard';
import Paginacion from '@/Components/Paginacion';
import { Inertia } from '@inertiajs/inertia';

export default function Grid({ productos }) {
    const handlePageChange = (page) => {
        const urlParams = new URLSearchParams(window.location.search);
        const search = urlParams.get('search') || '';
        Inertia.get(`${productos.path}`, { page, search }, { preserveState: true, replace: true });
    };

    return (
        <div className='p-8'>
            <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                {productos && productos.data.map((producto) =>
                    <ProductoCard key={producto.id} producto={producto} />
                )}
            </div>
            {productos && (
                <div className='mt-4 text-center'>
                    <Paginacion paginationData={productos} onPageChange={handlePageChange} />
                </div>
            )}
        </div>
    );
}
