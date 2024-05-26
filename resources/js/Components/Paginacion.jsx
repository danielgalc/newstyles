// Paginacion.jsx
import React from 'react';

export default function Paginacion({ paginationData, onPageChange }) {
    // Función para renderizar los botones de paginación
    const renderPaginationLinks = () => {
        if (!paginationData) return null;

        let links = [];
        for (let i = 1; i <= paginationData.last_page; i++) {
            links.push(
                <button
                    key={i}
                    onClick={() => onPageChange(i)}
                    className={`px-3 py-2 border rounded-lg mx-1 ${paginationData.current_page === i ? 'bg-gray-200' : 'bg-white hover:bg-gray-200'}`}
                >
                    {i}
                </button>
            );
        }
        return links;
    };

    return (
        <div className="mt-4">
            {paginationData.prev_page_url && (
                <button
                    onClick={() => onPageChange(paginationData.current_page - 1)}
                    className="mr-2 px-4 py-2 border rounded-lg bg-gray-200 hover:bg-gray-300"
                >
                    Anterior
                </button>
            )}
            {renderPaginationLinks()}
            {paginationData.next_page_url && (
                <button
                    onClick={() => onPageChange(paginationData.current_page + 1)}
                    className="ml-2 px-4 py-2 border rounded-lg bg-gray-200 hover:bg-gray-300"
                >
                    Siguiente
                </button>
            )}
        </div>
    );
}
