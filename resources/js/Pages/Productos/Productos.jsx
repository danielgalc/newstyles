import React, { useState, useEffect } from 'react';
import Banner from '@/Components/Banner';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout'; 
import GuestLayout from '@/Layouts/GuestLayout';
import Grid from '@/Components/Productos/Grid';
import axios from 'axios'; 
import debounce from 'lodash/debounce'; 

export default function Productos({ auth, productos, search }) {
  const [searchTerm, setSearchTerm] = useState(search || '');
  const [filteredProductos, setFilteredProductos] = useState(productos);
  const [sortBy, setSortBy] = useState(null); // Estado para el tipo de orden

  const fetchProductos = debounce(async (search) => {
    try {
      const response = await axios.get(route('productos.productos'), { params: { search, sortBy } }); // Pasar sortBy a la solicitud
      setFilteredProductos(response.data.productos);
    } catch (error) {
      console.error('Error fetching productos:', error);
    }
  }, 30);

  useEffect(() => {
    if (searchTerm || sortBy) { // Si hay término de búsqueda o tipo de orden
      fetchProductos(searchTerm); 
    } else {
      setFilteredProductos(productos);
    }

    return () => {
      fetchProductos.cancel();
    };
  }, [searchTerm, sortBy]); // Dependencias en searchTerm y sortBy

  const handleSearchChange = (e) => {
    setSearchTerm(e.target.value); 
  };

  const handleSortChange = (e) => {
    const selectedSort = e.target.value;
    setSortBy(selectedSort); // Actualizar el estado de sortBy
  };

  return (
    <div className="Productos">
      {auth.user ? (
        <AuthenticatedLayout user={auth.user}>
          <Banner text="Catálogo de productos" />
          <div className="flex justify-between items-center my-4">
            <input
              type="text"
              value={searchTerm}
              onChange={handleSearchChange}
              placeholder="Buscar productos..."
              className="p-2 border rounded-md w-3/4"
            />
            <select onChange={handleSortChange} className="p-2 border rounded-md ml-4">
              <option value="">Ordenar por...</option>
              <option value="asc">A - Z</option>
              <option value="desc">Z - A</option>
              <option value="price_asc">Menor a mayor precio</option>
              <option value="price_desc">Mayor a menor precio</option>
            </select>
          </div>
          <Grid productos={filteredProductos} />
        </AuthenticatedLayout>
      ) : (
        <GuestLayout>
          <Banner text="Catálogo de productos" />
          <div className="flex justify-center items-center my-4">
            <input
              type="text"
              value={searchTerm}
              onChange={handleSearchChange}
              placeholder="Buscar productos..."
              className="p-2 border rounded-md w-1/4"
            />
            <select onChange={handleSortChange} className="p-2 border rounded-md ml-4 w-52">
              <option value="">Ordenar por...</option>
              <option value="asc">A - Z</option>
              <option value="desc">Z - A</option>
              <option value="price_asc">Menor a mayor precio</option>
              <option value="price_desc">Mayor a menor precio</option>
            </select>
          </div>
          <Grid productos={filteredProductos} />
        </GuestLayout>
      )}
    </div>
  );
}
