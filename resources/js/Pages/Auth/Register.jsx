import { useEffect } from 'react';
import GuestLayout from '@/Layouts/GuestLayout';
import InputError from '@/Components/InputError';
import InputLabel from '@/Components/InputLabel';
import PrimaryButton from '@/Components/PrimaryButton';
import TextInput from '@/Components/TextInput';
import { Head, Link, useForm } from '@inertiajs/react';

export default function Register() {
    const { data, setData, post, processing, errors, reset } = useForm({
        name: '',
        email: '',
        password: '',
        password_confirmation: '',
    });

    useEffect(() => {
        return () => {
            reset('password', 'password_confirmation');
        };
    }, []);

    const submit = (e) => {
        e.preventDefault();

        post(route('register'));
    };

    return (
        <div className="relative min-h-screen flex items-center justify-center bg-gray-800">
            {/* Logo del sitio web */}
            <div className="absolute top-8 mt-10">
                <Link href="/">
                    <img src="/images/Logo1Transparente.png" alt="Logo 1" className="w-44 h-30 mx-auto drop-shadow-md" />
                </Link>
            </div>

            {/* Div del registro con efecto Glassmorfismo */}
            <div className="relative backdrop-filter backdrop-blur-lg bg-white bg-opacity-10 border border-white border-opacity-20 shadow-lg rounded-lg p-8 mt-24 w-full max-w-md">
                <h2 className="text-3xl text-white text-center mb-4 font-righteous">Crear cuenta</h2>
                <p className="text-white font-semibold text-center mb-8">¡Únete a <span className='text-teal-500 font-semibold'>Newstyles</span>!</p>

                <form onSubmit={submit}>
                    {/* Input para el nombre */}
                    <div className="mb-4">
                        <InputLabel htmlFor="name" value="Nombre" className="text-white" />
                        <div className="relative">
                            <TextInput
                                id="name"
                                name="name"
                                value={data.name}
                                className="mt-1 block w-full bg-transparent text-white border border-white border-opacity-20 rounded-lg focus:ring-teal-400 focus:border-teal-400"
                                autoComplete="name"
                                isFocused={true}
                                onChange={(e) => setData('name', e.target.value)}
                                required
                            />
                        </div>
                        <InputError message={errors.name} className="mt-2 text-red-500" />
                    </div>

                    {/* Input para el correo electrónico */}
                    <div className="mb-4">
                        <InputLabel htmlFor="email" value="Correo Electrónico" className="text-white" />
                        <div className="relative">
                            <TextInput
                                id="email"
                                type="email"
                                name="email"
                                value={data.email}
                                className="mt-1 block w-full bg-transparent text-white border border-white border-opacity-20 rounded-lg focus:ring-teal-400 focus:border-teal-400"
                                autoComplete="username"
                                onChange={(e) => setData('email', e.target.value)}
                                required
                            />
                        </div>
                        <InputError message={errors.email} className="mt-2 text-red-500" />
                    </div>

                    {/* Input para la contraseña */}
                    <div className="mb-4">
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
                                required
                            />
                        </div>
                        <InputError message={errors.password} className="mt-2 text-red-500" />
                    </div>

                    {/* Input para confirmar la contraseña */}
                    <div className="mb-6">
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
                                required
                            />
                        </div>
                        <InputError message={errors.password_confirmation} className="mt-2 text-red-500" />
                    </div>

                    {/* Botón de registro */}
                    <div className="flex items-center justify-center">
                        <PrimaryButton className="w-full justify-center text-lg bg-teal-500 hover:bg-teal-400 hover:text-gray-800 text-gray-500 py-2 rounded-lg" disabled={processing}>
                            Registrarse
                        </PrimaryButton>
                    </div>
                </form>
            </div>
        </div>

    );
}
