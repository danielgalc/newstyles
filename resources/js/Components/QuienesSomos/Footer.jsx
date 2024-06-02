import React from 'react';

const Footer = () => {
    return (
        <footer className="w-full bg-teal-400 text-white py-12">
            <div className="container mx-auto px-6">
                <div className="text-center mb-10">
                    <h1 className="text-6xl font-righteous">CONTACTA CON NOSOTROS</h1>
                </div>
                <div className="grid grid-cols-1 sm:grid-cols-3 gap-8 text-center md:text-left">
                    <div className="bg-white bg-opacity-10 backdrop-filter backdrop-blur-lg rounded-lg p-6 shadow-lg">
                        <form className="space-y-4">
                            <div>
                                <label className="block text-sm font-medium mb-1" htmlFor="name">Nombre</label>
                                <input
                                    type="text"
                                    id="name"
                                    name="name"
                                    className="w-full px-4 py-2 bg-gray-700 bg-opacity-50 text-white border border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-teal-400"
                                    required
                                />
                            </div>
                            <div>
                                <label className="block text-sm font-medium mb-1" htmlFor="email">Correo electrónico</label>
                                <input
                                    type="email"
                                    id="email"
                                    name="email"
                                    className="w-full px-4 py-2 bg-gray-700 bg-opacity-50 text-white border border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-teal-400"
                                    required
                                />
                            </div>
                            <div>
                                <label className="block text-sm font-medium mb-1" htmlFor="message">Mensaje</label>
                                <textarea
                                    id="message"
                                    name="message"
                                    className="w-full px-4 py-2 bg-gray-700 bg-opacity-50 text-white border border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-teal-400"
                                    rows="4"
                                    required
                                ></textarea>
                            </div>
                            <button
                                type="submit"
                                className="px-6 py-2 bg-teal-500 text-gray-800 font-semibold rounded-md hover:bg-teal-300 focus:outline-none focus:ring-2 focus:ring-teal-400"
                            >
                                Enviar
                            </button>
                        </form>
                    </div>
                    <div className="flex justify-center items-center">
                        <img src="images/png/logo-black-transparente.png" alt="Logo Black" className="w-56 h-auto m-auto z-index-1 drop-shadow-lg" />
                    </div>
                    <div className='flex flex-col justify-center'>
                        <h2 className="text-2xl font-righteous mb-4">INFORMACIÓN DE CONTACTO</h2>
                        <p className="mb-4 text-lg">Dirección: Calle Falsa 123, Ciudad, País</p>
                        <p className="mb-4 text-lg">Teléfono: +1 (234) 567-8901</p>
                        <p className="mb-4 text-lg">Correo electrónico: info@newstyles.com</p>
                        <p className="mb-4 text-lg">Horario de atención: Lunes a Viernes de 9:00 AM a 6:00 PM</p>
                        <div className="flex justify-between gap-16 w-full items-center mx-auto md:justify-start space-x-4 mt-4">
                            <a href="#" className="text-gray-800 hover:text-gray-600">
                                <svg className="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M24 4.56v14.88a4.56 4.56 0 01-4.56 4.56H4.56A4.56 4.56 0 010 19.44V4.56A4.56 4.56 0 014.56 0h14.88A4.56 4.56 0 0124 4.56zM8.09 18.61h2.72V9.41H8.09zm1.36-10.43a1.6 1.6 0 11-1.6-1.6 1.6 1.6 0 011.6 1.6zm9.1 10.43h2.72v-4.58c0-2.19-.76-3.69-2.65-3.69a2.87 2.87 0 00-2.69 1.88h-.03v-.03h-2.73v6.42h2.73v-5.74c0-1.13.4-1.9 1.4-1.9s1.3.74 1.3 1.82v5.82zm-1.36 0h-2.72v-6.42h2.72z" />
                                </svg>
                            </a>
                            <a href="#" className="text-gray-800 hover:text-gray-600">
                                <svg className="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M24 4.56v14.88a4.56 4.56 0 01-4.56 4.56H4.56A4.56 4.56 0 010 19.44V4.56A4.56 4.56 0 014.56 0h14.88A4.56 4.56 0 0124 4.56zM7.44 18.61h2.72V9.41H7.44zm1.36-10.43a1.6 1.6 0 11-1.6-1.6 1.6 1.6 0 011.6 1.6zm9.1 10.43h2.72v-4.58c0-2.19-.76-3.69-2.65-3.69a2.87 2.87 0 00-2.69 1.88h-.03v-.03h-2.73v6.42h2.73v-5.74c0-1.13.4-1.9 1.4-1.9s1.3.74 1.3 1.82v5.82zm-1.36 0h-2.72v-6.42h2.72z" />
                                </svg>
                            </a>
                            <a href="#" className="text-gray-800 hover:text-gray-600">
                                <svg className="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M24 4.56v14.88a4.56 4.56 0 01-4.56 4.56H4.56A4.56 4.56 0 010 19.44V4.56A4.56 4.56 0 014.56 0h14.88A4.56 4.56 0 0124 4.56zM7.44 18.61h2.72V9.41H7.44zm1.36-10.43a1.6 1.6 0 11-1.6-1.6 1.6 1.6 0 011.6 1.6zm9.1 10.43h2.72v-4.58c0-2.19-.76-3.69-2.65-3.69a2.87 2.87 0 00-2.69 1.88h-.03v-.03h-2.73v6.42h2.73v-5.74c0-1.13.4-1.9 1.4-1.9s1.3.74 1.3 1.82v5.82zm-1.36 0h-2.72v-6.42h2.72z" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
                <div className="mt-12 text-center border-t border-gray-600 pt-4">
                    <p>&copy; 2024 NewStyles. Todos los derechos reservados.</p>
                </div>
            </div>
        </footer>
    );
};

export default Footer;
