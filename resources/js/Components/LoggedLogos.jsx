import React, { useState } from 'react';
import { Menu } from '@headlessui/react';
import { useForm } from '@inertiajs/react';

export default function LoggedLogos() {
    const [isOpen, setIsOpen] = useState(false);
    const { post } = useForm();

    const handleLogout = () => {
        post(route('logout'));
    };
    
    return (
        <div className="relative flex items-center gap-4">
            <a href="/carrito" className="transition-all duration-300 transform hover:text-teal-500 hover:scale-105">
                <svg className="carrito-icono w-11 h-11" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 50 50">
                    <path d="M0 2.08334H9.925L11.0604 6.25001H48.7229L41.0854 29.1667H16.2083L15.1667 33.3333H45.8333V37.5H9.83333L12.4292 27.1063L6.74167 6.25001H0V2.08334ZM16.175 25H38.0812L42.9437 10.4167H12.1979L16.175 25ZM8.33333 43.75C8.33333 42.6449 8.77232 41.5851 9.55372 40.8037C10.3351 40.0223 11.3949 39.5833 12.5 39.5833C13.6051 39.5833 14.6649 40.0223 15.4463 40.8037C16.2277 41.5851 16.6667 42.6449 16.6667 43.75C16.6667 44.8551 16.2277 45.9149 15.4463 46.6963C14.6649 47.4777 13.6051 47.9167 12.5 47.9167C11.3949 47.9167 10.3351 47.4777 9.55372 46.6963C8.77232 45.9149 8.33333 44.8551 8.33333 43.75ZM37.5 43.75C37.5 42.6449 37.939 41.5851 38.7204 40.8037C39.5018 40.0223 40.5616 39.5833 41.6667 39.5833C42.7717 39.5833 43.8315 40.0223 44.6129 40.8037C45.3943 41.5851 45.8333 42.6449 45.8333 43.75C45.8333 44.8551 45.3943 45.9149 44.6129 46.6963C43.8315 47.4777 42.7717 47.9167 41.6667 47.9167C40.5616 47.9167 39.5018 47.4777 38.7204 46.6963C37.939 45.9149 37.5 44.8551 37.5 43.75Z" fill="white" />
                </svg>
            </a>
            <div className="relative">
                <button
                    onClick={() => setIsOpen(!isOpen)}
                    className="inline-flex items-center text-center px-3 py-4 mt-1 border border-transparent leading-4 font-medium text-2xl rounded-md text-teal-300 hover:scale-105 focus:outline-none transition ease-in-out duration-150"
                >
                    <svg className="svg-icon w-8 h-8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M224 256A128 128 0 1 0 224 0a128 128 0 1 0 0 256zm-45.7 48C79.8 304 0 383.8 0 482.3C0 498.7 13.3 512 29.7 512H418.3c16.4 0 29.7-13.3 29.7-29.7C448 383.8 368.2 304 269.7 304H178.3z"/></svg>
                    <div className="ms-1">
                        <svg className="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path fillRule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clipRule="evenodd" />
                        </svg>
                    </div>
                </button>

                {isOpen && (
                    <Menu
                        as="div"
                        className="absolute right-0 mt-2 w-48 bg-white shadow-lg rounded-md overflow-hidden z-10"
                    >
                        <Menu.Item>
                            {({ active }) => (
                                <button
                                    className={`${active ? 'bg-gray-100' : ''
                                        } block px-4 py-2 text-sm text-gray-700 w-full text-left`}
                                >
                                    Perfil
                                </button>
                            )}
                        </Menu.Item>
                        <Menu.Item>
                            {({ active }) => (
                                <button
                                    className={`${active ? 'bg-gray-100' : ''
                                        } block px-4 py-2 text-sm text-gray-700 w-full text-left`}
                                >
                                    Historial de citas
                                </button>
                            )}
                        </Menu.Item>
                        <Menu.Item>
                            {({ active }) => (
                                <button
                                    className={`${active ? 'bg-gray-100' : ''
                                        } block px-4 py-2 text-sm text-gray-700 w-full text-left`}
                                >
                                    Historial de pedidos
                                </button>
                            )}
                        </Menu.Item>
                        <Menu.Item>
                        {({ active }) => (
                            <a
                                onClick={handleLogout}
                                href='/'
                                className={`${active ? 'bg-gray-100' : ''
                                    } block px-4 py-2 text-sm text-gray-700 w-full text-left`}
                            >
                                Cerrar sesión
                            </a>
                        )}
                    </Menu.Item>
                    </Menu>
                )}
            </div>
        </div>
    );
}
