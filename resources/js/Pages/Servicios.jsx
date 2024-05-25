// Servicios.jsx
import React from 'react';
import Banner from '@/Components/Banner';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import GuestLayout from '@/Layouts/GuestLayout';
import GridServicios from '@/Components/Servicios/GridServicios';

export default function Servicios({ auth, serviciosPrincipales, serviciosSecundarios }) {
  return (
    <div className="Servicios">
      {auth.user ? (
        <AuthenticatedLayout user={auth.user}>
          <Banner text="Listado de servicios" />
          <GridServicios 
            serviciosPrincipales={serviciosPrincipales} 
            serviciosSecundarios={serviciosSecundarios} 
          />
        </AuthenticatedLayout>
      ) : (
        <GuestLayout>
          <Banner text="Listado de servicios" />
          <GridServicios 
            serviciosPrincipales={serviciosPrincipales} 
            serviciosSecundarios={serviciosSecundarios} 
          />
        </GuestLayout>
      )}
    </div>
  );
};
