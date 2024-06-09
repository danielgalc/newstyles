import React, { useState, useEffect } from 'react';
import { useForm, Head, usePage } from '@inertiajs/react';
import InputError from '@/Components/InputError';

const Footer = ({ auth }) => {
    const { data, setData, post, processing, reset, errors } = useForm({
        name: auth?.user?.name || '',
        email: auth?.user?.email || '',
        subject: '',
        message: ''
    });

    const [localErrors, setLocalErrors] = useState({});
    const [statusMessage, setStatusMessage] = useState(null);
    const [statusType, setStatusType] = useState(null);

    const handleChange = (e) => {
        setData(e.target.name, e.target.value);
    };

    const validateForm = () => {
        const errors = {};

        if (!data.name) {
            errors.name = 'El campo nombre es obligatorio.';
        } else if (data.name.length > 255) {
            errors.name = 'El campo nombre no puede exceder los 255 caracteres.';
        } else if (!/^[a-zA-ZáéíóúÁÉÍÓÚ\s]+$/.test(data.name)) {
            errors.name = 'El campo nombre debe ser una cadena de texto.';
        }

        if (!data.email) {
            errors.email = 'El campo correo electrónico es obligatorio.';
        } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(data.email)) {
            errors.email = 'El campo correo electrónico debe ser una dirección de correo válida.';
        } else if (data.email.length > 255) {
            errors.email = 'El campo correo electrónico no puede exceder los 255 caracteres.';
        }

        if (!data.subject) {
            errors.subject = 'El campo asunto es obligatorio.';
        } else if (data.subject.length > 255) {
            errors.subject = 'El campo asunto no puede exceder los 255 caracteres.';
        }

        if (!data.message) {
            errors.message = 'El campo mensaje es obligatorio.';
        } else if (typeof data.message !== 'string') {
            errors.message = 'El campo mensaje debe ser una cadena de texto.';
        }

        setLocalErrors(errors);
        return Object.keys(errors).length === 0;
    };

    const submit = (e) => {
        e.preventDefault();
        if (validateForm()) {
            post(route('contact.send'), {
                onSuccess: () => {
                    setStatusMessage('¡Mensaje enviado con éxito!');
                    setStatusType('success');
                    reset();
                },
                onError: () => {
                    setStatusMessage('No se pudo enviar el mensaje. Por favor, inténtelo de nuevo.');
                    setStatusType('error');
                }
            });
        }
    };

    return (
        <footer className="w-full bg-gradient-to-b from-teal-500 to-teal-400 text-white py-12">
            <div className="container mx-auto px-6">
                <div className="text-center mb-10">
                    <h1 className="text-6xl font-righteous">CONTACTA CON NOSOTROS</h1>
                </div>
                <div className="grid grid-cols-1 sm:grid-cols-3 gap-8 text-center md:text-left">
                    <div className="bg-black bg-opacity-5 backdrop-filter backdrop-blur-lg rounded-lg p-6 shadow-lg">
                        <form className="space-y-4" onSubmit={submit}>
                            <div>
                                <label className="block text-sm font-medium mb-1" htmlFor="name">Nombre</label>
                                <input
                                    type="text"
                                    id="name"
                                    name="name"
                                    value={data.name}
                                    onChange={handleChange}
                                    readOnly={!!auth?.user?.name}
                                    className="w-full px-4 py-2 bg-gray-700 bg-opacity-50 text-white border border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-teal-400"
                                    required
                                />
                                <InputError message={errors.name || localErrors.name} className="mt-2" />
                            </div>
                            <div>
                                <label className="block text-sm font-medium mb-1" htmlFor="email">Correo electrónico</label>
                                <input
                                    type="email"
                                    id="email"
                                    name="email"
                                    value={data.email}
                                    onChange={handleChange}
                                    readOnly={!!auth?.user?.email}
                                    className="w-full px-4 py-2 bg-gray-700 bg-opacity-50 text-white border border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-teal-400"
                                    required
                                />
                                <InputError message={errors.email || localErrors.email} className="mt-2" />
                            </div>
                            <div>
                                <label className="block text-sm font-medium mb-1" htmlFor="subject">Asunto</label>
                                <input
                                    type="text"
                                    id="subject"
                                    name="subject"
                                    value={data.subject}
                                    onChange={handleChange}
                                    className="w-full px-4 py-2 bg-gray-700 bg-opacity-50 text-white border border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-teal-400"
                                    required
                                />
                                <InputError message={errors.subject || localErrors.subject} className="mt-2" />
                            </div>
                            <div>
                                <label className="block text-sm font-medium mb-1" htmlFor="message">Mensaje</label>
                                <textarea
                                    id="message"
                                    name="message"
                                    value={data.message}
                                    onChange={handleChange}
                                    className="w-full px-4 py-2 bg-gray-700 bg-opacity-50 text-white border border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-teal-400"
                                    rows="4"
                                    required
                                ></textarea>
                                <InputError message={errors.message || localErrors.message} className="mt-2" />
                            </div>
                            <div className="flex items-center space-x-4">
                                <button
                                    type="submit"
                                    className="px-6 py-2 bg-teal-100 text-gray-800 font-semibold rounded-md hover:bg-teal-800 hover:text-white focus:outline-none focus:ring-2 focus:ring-teal-400"
                                    disabled={processing}
                                >
                                    Enviar
                                </button>
                                {statusMessage && (
                                    <span className={`text-sm font-medium p-2 bg-white bg-opacity-40 backdrop-filter backdrop-blur-lg rounded-lg ${statusType === 'success' ? 'text-green-600' : 'text-red-500'}`}>
                                        {statusMessage}
                                    </span>
                                )}
                            </div>
                        </form>
                    </div>
                    <div className="flex justify-center items-center">
                        <img src="images/png/logo-black-transparente.png" alt="Logo Black" className="w-56 h-auto m-auto z-index-1 drop-shadow-lg" />
                    </div>
                    <div className='flex flex-col justify-center bg-black text-center bg-opacity-5 backdrop-filter backdrop-blur-lg rounded-lg shadow-lg'>
                        <div className='text-start mx-auto'>
                        <h2 className="text-2xl font-righteous mb-4">INFORMACIÓN DE CONTACTO</h2>
                        <p className="mb-4 text-lg"><strong>Dirección:</strong><span className='italic'> Calle Falsa 123, Ciudad, País</span></p>
                        <p className="mb-4 text-lg"><strong>Teléfono:</strong><span className='italic'> +1 (234) 567-8901 </span></p>
                        <p className="mb-4 text-lg"><strong>Correo electrónico:</strong><span className='italic'> info@newstyles.com </span></p>
                        <p className="mb-4 text-lg"><strong>Horario de atención:</strong><span className='italic'> Lunes a Viernes - 10h a 18h </span></p>
                        </div>
                        <div className="flex justify-between gap-16 w-full items-center mx-auto md:justify-center space-x-4 mt-4">
                            <a href="#" className="text-gray-800 hover:text-gray-600">
                                <div className="w-8 h-8 rounded-full bg-cover bg-center" style={{ backgroundImage: 'url(https://graffica.ams3.digitaloceanspaces.com/2023/07/F1ySdm9WYAIbjHo-1024x1024.jpeg)' }}>
                                </div>
                            </a>
                            <a href="https://www.facebook.com/" target="_blank" className="text-gray-800 hover:text-gray-600">
                                <div className="w-8 h-8 rounded-full bg-cover bg-center" style={{ backgroundImage: 'url(https://cdn.pixabay.com/photo/2021/06/15/12/51/facebook-6338507_1280.png)' }}>
                                </div>
                            </a>
                            <a href="https://www.instagram.com/" target="_blank" className="text-gray-800 hover:text-gray-600">
                                <div className="w-8 h-8 rounded-full bg-cover bg-center" style={{ backgroundImage: 'url(https://upload.wikimedia.org/wikipedia/commons/thumb/9/95/Instagram_logo_2022.svg/1000px-Instagram_logo_2022.svg.png)' }}>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <div className="text-black font-righteous mt-12 text-center border-t border-gray-600 pt-4">
                    <p>&copy; 2024 NewStyles. Todos los derechos reservados.</p>
                </div>
            </div>
        </footer>
    );
};

export default Footer;
