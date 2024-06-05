import React from 'react';
import { usePage } from '@inertiajs/inertia-react';

const Peluqueros = ({auth}) => {
    const nombre = auth.user.name;

    return (
        <div className="min-h-screen flex items-center justify-center bg-gray-800">
            <div className="text-center space-y-4 flex flex-col items-center justify-center">
                <h1 className='text-white text-7xl font-righteous mb-4'>Bienvenido, <span className='text-teal-400 italic'>{nombre}</span> </h1>
                <a
                    href="/peluquero/citas"
                    className="block text-3xl w-2/4 text-white font-righteous bg-teal-500 hover:bg-teal-400 py-4 px-8 rounded-lg transition duration-300 transform hover:scale-105"
                >
                    Gestionar Citas
                </a>
                <a
                    href="/peluquero/horas"
                    className="block text-3xl w-2/4 text-white font-righteous bg-teal-500 hover:bg-teal-400 py-4 px-8 rounded-lg transition duration-300 transform hover:scale-105"
                >
                    Gestionar Horas
                </a>
            </div>
        </div>
    );
};

export default Peluqueros;
