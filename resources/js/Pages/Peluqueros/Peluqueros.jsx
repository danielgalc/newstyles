import React from 'react';

const Citas = () => {
    return (
        <div className="min-h-screen flex items-center justify-center bg-gray-800">
            <div className="text-center space-y-4">
                <a
                    href="/peluquero/citas"
                    className="block text-3xl text-white bg-teal-500 hover:bg-teal-400 py-4 px-8 rounded-lg transition duration-300 transform hover:scale-105"
                >
                    Gestionar Citas
                </a>
                <a
                    href="/peluquero/horas"
                    className="block text-3xl text-white bg-teal-500 hover:bg-teal-400 py-4 px-8 rounded-lg transition duration-300 transform hover:scale-105"
                >
                    Gestionar Horas
                </a>
            </div>
        </div>
    );
};

export default Citas;
