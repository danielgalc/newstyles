// GridServicios.jsx
import React, { useState } from 'react';
import { CSSTransition } from 'react-transition-group';
import ServicioCard from './ServicioCard';

export default function GridServicios({ serviciosPrincipales, serviciosSecundarios }) {
    const [showSecundarios, setShowSecundarios] = useState(false);

    return (
        <div className="container mx-auto mt-8 mb-4">
            <div className="grid grid-cols-2 gap-x-8 gap-y-8 mb-4">
                {serviciosPrincipales.map((servicio, index) => (
                    <ServicioCard key={index} servicio={servicio} />
                ))}
            </div>

            <span
                id="otrosServiciosToggle"
                className="font-righteous text-teal-400 italic mt-4 cursor-pointer text-blue-500 underline"
                onClick={() => setShowSecundarios(!showSecundarios)}
            >
                Otros Servicios
            </span>
            
            
            <CSSTransition // Importamos el componente tras instalar el paquete + aplicamos transiciones (app.css)
                in={showSecundarios}
                timeout={300}
                classNames="fade"
                unmountOnExit
            >
                <div id="otrosServiciosContainer" className="mt-4">
                    {serviciosSecundarios.length > 0 ? (
                        <div>
                            <div className="grid grid-cols-2 gap-x-8 gap-y-8">
                                {serviciosSecundarios.map((servicio, index) => (
                                    <ServicioCard key={index} servicio={servicio} />
                                ))}
                            </div>
                        </div>
                    ) : (
                        <p>No hay servicios secundarios encontrados.</p>
                    )}
                </div>
            </CSSTransition>
        </div>
    );
}
