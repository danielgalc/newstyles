import { useEffect, useState } from 'react';
import GuestLayout from '@/Layouts/GuestLayout';
import InputError from '@/Components/InputError';
import InputLabel from '@/Components/InputLabel';
import PrimaryButton from '@/Components/PrimaryButton';
import TextInput from '@/Components/TextInput';
import { Head, Link, useForm } from '@inertiajs/react';

export default function ResetPassword({ token, email }) {
    const { data, setData, post, processing, errors, reset } = useForm({
        token: token,
        email: email,
        password: '',
        password_confirmation: '',
    });

    const [localErrors, setLocalErrors] = useState({});

    useEffect(() => {
        return () => {
            reset('password', 'password_confirmation');
        };
    }, []);

    const submit = (e) => {
        e.preventDefault();
        if (validateForm()) {
            post(route('password.store'));
        }
    };

    const validateForm = () => {
        const errors = {};

        if (!data.email || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(data.email)) {
            errors.email = 'Por favor, introduce una dirección de correo electrónico válida.';
        }

        if (!data.password || data.password.length < 8) {
            errors.password = 'La contraseña debe tener al menos 8 caracteres.';
        } else if (!/(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])/.test(data.password)) {
            errors.password = 'La contraseña debe tener al menos una letra mayúscula, una letra minúscula, un carácter especial y un carácter numérico.';
        }

        if (data.password !== data.password_confirmation) {
            errors.password_confirmation = 'Las contraseñas no coinciden.';
        }

        setLocalErrors(errors);
        return Object.keys(errors).length === 0;
    };

    return (
        <div>
            <Head title="Reset Password" />
            <div className="relative min-h-screen flex items-center justify-center bg-gray-800 pt-20">                
                {/* Logo del sitio web */}
                <div className="absolute top-8 mt-10">
                    <Link href="/">
                        <img src="/images/Logo1Transparente.png" alt="Logo 1" className="w-44 h-30 mx-auto drop-shadow-md" />
                    </Link>
                </div>

                {/* Div del Reset Password con efecto Glassmorfismo */}
                <div className="relative backdrop-filter backdrop-blur-lg bg-white bg-opacity-10 border border-white border-opacity-20 shadow-lg rounded-lg px-8 pt-8 pb-4 mt-10 w-full max-w-md">
                    <h2 className="text-3xl text-white text-center mb-4 font-righteous">Restablecer Contraseña</h2>
                    <p className="text-white font-semibold text-center mb-8">¡Restablece tu contraseña para <span className='text-teal-500 font-semibold'>NewStyles</span>!</p>

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
                            <InputError message={errors.email || localErrors.email} className="mt-2 text-red-500" />
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
                                    autoComplete="new-password"
                                    onChange={(e) => setData('password', e.target.value)}
                                />
                            </div>
                            <InputError message={errors.password || localErrors.password} className="mt-2 text-red-500" />
                        </div>

                        <div className="mb-2">
                            <InputLabel htmlFor="password_confirmation" value="Confirmar Contraseña" className="text-white" />
                            <div className="relative">
                                <TextInput
                                    id="password_confirmation"
                                    type="password"
                                    name="password_confirmation"
                                    value={data.password_confirmation}
                                    className="mt-1 block w-full bg-transparent text-white border border-white border-opacity-20 rounded-lg focus:ring-teal-400 focus:border-teal-400"
                                    autoComplete="new-password"
                                    onChange={(e) => setData('password_confirmation', e.target.value)}
                                />
                            </div>
                            <InputError message={errors.password_confirmation || localErrors.password_confirmation} className="mt-2 text-red-500" />
                        </div>

                        <div className="flex items-center mt-4 justify-center">
                            <PrimaryButton className="w-full justify-center text-lg bg-teal-500 hover:bg-teal-400 hover:text-gray-800 text-gray-500 py-2 rounded-lg" disabled={processing}>
                                Restablecer Contraseña
                            </PrimaryButton>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    );
}
