import React, { useState, useEffect } from 'react';
import Banner from '@/Components/Banner';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import GuestLayout from '@/Layouts/GuestLayout';
import GridServicios from '@/Components/Servicios/GridServicios';
import axios from 'axios';
import debounce from 'lodash/debounce';

export default function Servicios({ auth, servicios: initialServicios, search }) {
  const [searchTerm, setSearchTerm] = useState(search || '');
  const [filteredServicios, setFilteredServicios] = useState(initialServicios);

  const fetchServicios = debounce(async (search) => {
    try {
      const response = await axios.get(route('servicios.servicios'), {
        params: { search }
      });
      setFilteredServicios(response.data);
    } catch (error) {
      console.error('Error fetching servicios:', error);
    }
  }, 300);

  useEffect(() => {
    if (searchTerm) {
      fetchServicios(searchTerm);
    } else {
      setFilteredServicios(initialServicios);
    }

    return () => {
      fetchServicios.cancel();
    };
  }, [searchTerm, initialServicios]);

  const handleSearchChange = (e) => {
    setSearchTerm(e.target.value);
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
              className="p-2 border rounded-md w-3/4"
            />
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
          </div>
          <GridServicios servicios={filteredServicios} />
        </GuestLayout>
      )}
    </div>
  );
};
