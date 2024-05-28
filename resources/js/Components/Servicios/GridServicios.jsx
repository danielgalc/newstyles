import React, { useState, useEffect } from 'react';
import { CSSTransition } from 'react-transition-group';
import ServicioCard from './ServicioCard';

export default function GridServicios({ servicios }) {
    const [showSecundarios, setShowSecundarios] = useState(false);
    const [serviciosPrincipales, setServiciosPrincipales] = useState([]);
    const [serviciosSecundarios, setServiciosSecundarios] = useState([]);

    useEffect(() => {
        const principales = servicios.data.filter(servicio => servicio.clase === 'principal');
        const secundarios = servicios.data.filter(servicio => servicio.clase === 'secundario');
        setServiciosPrincipales(principales);
        setServiciosSecundarios(secundarios);
    }, [servicios]);

    const soloSecundarios = serviciosPrincipales.length === 0 && serviciosSecundarios.length > 0;

    return (
        <div className="container mx-auto mt-8 mb-4">
            {!soloSecundarios && (
                <>
                    <div className="grid grid-cols-2 gap-x-8 gap-y-8 mb-4">
                        {serviciosPrincipales.map((servicio) => (
                            <ServicioCard key={servicio.id} servicio={servicio} />
                        ))}
                    </div>

                    <span
                        id="otrosServiciosToggle"
                        className="font-righteous text-teal-400 italic mt-4 cursor-pointer text-blue-500 underline"
                        onClick={() => setShowSecundarios(!showSecundarios)}
                    >
                        Otros Servicios
                    </span>

                    <CSSTransition
                        in={showSecundarios}
                        timeout={300}
                        classNames="fade"
                        unmountOnExit
                    >
                        <div id="otrosServiciosContainer" className="mt-4">
                            {serviciosSecundarios.length > 0 ? (
                                <div className="grid grid-cols-2 gap-x-8 gap-y-8">
                                    {serviciosSecundarios.map((servicio) => (
                                        <ServicioCard key={servicio.id} servicio={servicio} />
                                    ))}
                                </div>
                            ) : (
                                <p>No hay servicios secundarios encontrados.</p>
                            )}
                        </div>
                    </CSSTransition>
                </>
            )}

            {soloSecundarios && (
                <div className="grid grid-cols-2 gap-x-8 gap-y-8 mb-4">
                    {serviciosSecundarios.map((servicio) => (
                        <ServicioCard key={servicio.id} servicio={servicio} />
                    ))}
                </div>
            )}
        </div>
    );
}
