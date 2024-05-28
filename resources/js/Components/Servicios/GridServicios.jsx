import React, { useState, useEffect } from 'react';
import ServicioCard from './ServicioCard';
import { Inertia } from '@inertiajs/inertia';

export default function GridServicios({ servicios }) {
  const [filteredServicios, setFilteredServicios] = useState(servicios?.data || []);

  useEffect(() => {
    setFilteredServicios(servicios?.data || []);
  }, [servicios]);

  return (
    <div className="container mx-auto mt-8 mb-4">
      <div className="grid grid-cols-2 gap-x-8 gap-y-8 mb-4">
        {filteredServicios.map((servicio) => (
          <ServicioCard key={servicio.id} servicio={servicio} />
        ))}
      </div>
    </div>
  );
}
