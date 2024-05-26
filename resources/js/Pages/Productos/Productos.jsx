import React, { useState, useEffect } from 'react';
import Banner from '@/Components/Banner';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout'; 
import GuestLayout from '@/Layouts/GuestLayout';
import Grid from '@/Components/Productos/Grid';
import axios from 'axios'; // Importamos axios para hacer solicitudes HTTP
import debounce from 'lodash/debounce'; // Importamos debounce para limitar la frecuencia de las búsquedas

export default function Productos({ auth, productos, search }) {
  // useState para manejar el término de búsqueda y los productos filtrados
  const [searchTerm, setSearchTerm] = useState(search || '');
  const [filteredProductos, setFilteredProductos] = useState(productos);

  const fetchProductos = debounce(async (search) => {
    try {
      const response = await axios.get(route('productos.productos'), { params: { search } });
      setFilteredProductos(response.data.productos);
    } catch (error) {
      console.error('Error fetching productos:', error);
    }
  }, 30);

  // useEffect que se ejecuta cuando cambia el término de búsqueda (searchTerm)
  useEffect(() => {
    if (searchTerm) {
      fetchProductos(searchTerm); // Si hay un término de búsqueda, busca productos
    } else {
      setFilteredProductos(productos); // Si no hay término de búsqueda, muestra todos los productos iniciales
    }

    // Función de limpieza antes de ejecutar una nueva búsqueda
    return () => {
      fetchProductos.cancel();
    };
  }, [searchTerm]); // Dependencia en searchTerm

  // Función para manejar cambios en el campo de búsqueda
  const handleSearchChange = (e) => {
    setSearchTerm(e.target.value); // Actualizamos el término de búsqueda con el valor del input
  };

  return (
    <div className="Productos">
      {auth.user ? (
        // Si el usuario está autenticado, renderiza el layout autenticado
        <AuthenticatedLayout user={auth.user}>
          <Banner text="Catálogo de productos" />
          <div className="search-bar my-4">
            <input
              type="text"
              value={searchTerm}
              onChange={handleSearchChange}
              placeholder="Buscar productos..."
              className="p-2 border rounded-md w-3/4"
            />
          </div>
          <Grid productos={filteredProductos} /> {/* Renderiza los productos filtrados */}
        </AuthenticatedLayout>
      ) : (
        // Si el usuario no está autenticado, renderiza el layout de invitados
        <GuestLayout>
          <Banner text="Catálogo de productos" />
          <div className="flex justify-center search-bar mx-auto my-4">
            <input
              type="text"
              value={searchTerm}
              onChange={handleSearchChange}
              placeholder="Buscar productos..."
              className="p-2 border rounded-md w-1/4"
            />
          </div>
          <Grid productos={filteredProductos} /> {/* Renderiza los productos filtrados */}
        </GuestLayout>
      )}
    </div>
  );
}
