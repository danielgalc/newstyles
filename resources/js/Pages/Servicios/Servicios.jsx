import React, { useState, useEffect } from 'react';
import Banner from '@/Components/Banner';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import GuestLayout from '@/Layouts/GuestLayout';
import GridServicios from '@/Components/Servicios/GridServicios';
import axios from 'axios';
import debounce from 'lodash/debounce';

export default function Servicios({ auth, servicios, search }) {
  const [searchTerm, setSearchTerm] = useState(search || '');
  const [sortBy, setSortBy] = useState(null); // Estado para el tipo de orden
  const [filteredServicios, setFilteredServicios] = useState(servicios);

  const fetchServicios = debounce(async (search) => {
    try {
      const response = await axios.get(route('servicios.servicios'), {
        params: { search, sortBy }
      });
      setFilteredServicios(response.data);
    } catch (error) {
      console.error('Error fetching servicios:', error);
    }
  }, 300);

  useEffect(() => {
    if (searchTerm || sortBy) {
      fetchServicios(searchTerm);
    } else {
      setFilteredServicios(servicios);
    }

    return () => {
      fetchServicios.cancel();
    };
  }, [searchTerm, sortBy, servicios]);

  const handleSearchChange = (e) => {
    setSearchTerm(e.target.value);
  };

  const handleSortChange = (e) => {
    const selectedSort = e.target.value;
    setSortBy(selectedSort); // Actualizar el estado de sortBy
  };

  return (
    <div className="Servicios">
      {auth.user ? (
        <AuthenticatedLayout user={auth.user}>
          <Banner text="Listado de servicios" />
          <div className="flex justify-center items-center my-4">
          <input
              type="text"
              value={searchTerm}
              onChange={handleSearchChange}
              placeholder="Buscar servicios..."
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
          <GridServicios servicios={filteredServicios} />
        </AuthenticatedLayout>
      ) : (
        <GuestLayout>
          <Banner text="Listado de servicios" />
          <div className="flex justify-center items-center my-4">
            <input
              type="text"
              value={searchTerm}
              onChange={handleSearchChange}
              placeholder="Buscar servicios..."
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
          <GridServicios servicios={filteredServicios} />
        </GuestLayout>
      )}
    </div>
  );
};
