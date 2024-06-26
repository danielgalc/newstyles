import React, { useEffect, useState } from 'react';
import Checkbox from '@/Components/Checkbox';
import GuestLayout from '@/Layouts/GuestLayout';
import InputError from '@/Components/InputError';
import InputLabel from '@/Components/InputLabel';
import PrimaryButton from '@/Components/PrimaryButton';
import TextInput from '@/Components/TextInput';
import { Head, Link, useForm } from '@inertiajs/react';
import axios from 'axios';

export default function Login({ status, canResetPassword }) {
    const { data, setData, post, processing, errors, reset } = useForm({
        email: '',
        password: '',
        remember: false,
    });

    const [localErrors, setLocalErrors] = useState({});

    useEffect(() => {
        return () => {
            reset('password');
        };
    }, []);

    const submit = async (e) => {
        e.preventDefault();

        const carritoLocalStorage = JSON.parse(localStorage.getItem('carrito')) || [];
        const productos = carritoLocalStorage.map(item => ({
            producto_id: item.id,
            cantidad: item.cantidad || 1,
        }));

        if (validateForm()) {
            const formData = {
                ...data,
            };

            try {
                const response = await axios.post(route('login'), formData);

                if (response.data.user) {
                    const user = response.data.user;
                    console.log('Usuario autenticado:', user);

                    await axios.post(route('carrito.migrar'), { productos });

                    localStorage.removeItem('carrito');

                    if (user.rol === 'peluquero') {
                        window.location.href = route('peluquero.peluquero');
                    } else if (user.rol === 'admin') {
                        window.location.href = route('admin');
                    } else {
                        window.location.href = route('landing');
                    }
                } else {
                    console.error('Usuario no encontrado en la respuesta:', response.data.user);
                    window.location.href = route('landing');
                }
            } catch (error) {
                console.error("Error en el inicio de sesión o migración del carrito:", error);
                if (error.response && error.response.data.errors) {
                    setLocalErrors(error.response.data.errors);
                }
            }
        }
    };

    const validateForm = () => {
        const errors = {};

        if (!data.email || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(data.email)) {
            errors.email = 'Por favor, introduce una dirección de correo electrónico válida';
        }

        if (!data.password) {
            errors.password = 'Por favor, introduce tu contraseña.';
        }

        setLocalErrors(errors);
        return Object.keys(errors).length === 0;
    };

    return (
        <div>
            <Head title="Log in" />
            <div className="relative min-h-screen flex items-center justify-center bg-gray-800 pt-20">
                <div className="absolute top-8 mt-10">
                    <Link href="/">
                        <img src="/images/Logo1Transparente.png" alt="Logo 1" className="w-44 h-30 mx-auto drop-shadow-md" />
                    </Link>
                </div>
                <div className="relative backdrop-filter backdrop-blur-lg bg-white bg-opacity-10 border border-white border-opacity-20 shadow-lg rounded-lg px-8 pt-8 pb-2 mt-10 w-full max-w-md">
                    <h2 className="text-3xl text-white text-center mb-4 font-righteous">Login</h2>
                    <p className="text-white font-semibold text-center mb-8">¡Bienvenido a <span className='text-teal-500 font-semibold'>NewStyles</span>!</p>
                    {status && <div className="mb-4 text-center font-medium text-sm text-green-600">Tu contraseña ha sido reestablecida.</div>}
                    <form onSubmit={submit}>
                        <div className="mb-2">
                            <InputLabel htmlFor="email" value="Email" className="text-white" />
                            <div className="relative">
                                <TextInput
                                    id="email"
                                    type="email"
                                    name="email"
                                    value={data.email}
                                    className="mt-1 block w-full bg-transparent text-white border border-white border-opacity-20 rounded-lg focus:ring-teal-400 focus:border-teal-400"
                                    autoComplete="username"
                                    isFocused={true}
                                    onChange={(e) => setData('email', e.target.value)}
                                />
                            </div>
                            <InputError message={errors.email || localErrors.email} className="mt-2 bg-red-600 bg-opacity-70 rounded-md shadow-lg p-2 text-white" />
                        </div>

                        <div className="mb-2">
                            <InputLabel htmlFor="password" value="Contraseña" className="text-white" />
                            <div className="relative">
                                <TextInput
                                    id="password"
                                    type="password"
                                    name="password"
                                    value={data.password}
                                    className="mt-1 block w-full bg-transparent text-white border border-white border-opacity-20 rounded-lg focus:ring-teal-400 focus:border-teal-400"
                                    autoComplete="current-password"
                                    onChange={(e) => setData('password', e.target.value)}
                                />
                            </div>
                            <InputError message={errors.password || localErrors.password} className="mt-2 bg-red-600 bg-opacity-70 rounded-md shadow-lg p-2 text-white" />
                        </div>

                        <div className="flex items-center justify-between mb-6">
                            <label className="flex items-center text-white">
                                <Checkbox
                                    name="remember"
                                    checked={data.remember}
                                    onChange={(e) => setData('remember', e.target.checked)}
                                    className="text-teal-400 focus:ring-teal-400"
                                />
                                <span className="ml-2 text-sm">Recordarme</span>
                            </label>
                            {canResetPassword && (
                                <Link
                                    href={route('password.request')}
                                    className="underline text-sm text-white hover:text-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500"
                                >
                                    ¿Olvidaste tu contraseña?
                                </Link>
                            )}
                        </div>

                        <div className="flex items-center justify-center">
                            <PrimaryButton className="w-full justify-center text-lg bg-teal-500 hover:bg-teal-400 hover:text-gray-800 text-gray-500 py-2 rounded-lg" disabled={processing}>
                                Iniciar Sesión
                            </PrimaryButton>
                        </div>
                        <div className='flex justify-center gap-1 text-sm items-center mt-4 text-gray-200'>
                            ¿No tienes cuenta? <a href="/register" className='text-teal-400'>Haz click aquí para registrarte</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    );
}
