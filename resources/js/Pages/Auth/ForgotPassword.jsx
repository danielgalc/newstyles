import GuestLayout from '@/Layouts/GuestLayout';
import InputError from '@/Components/InputError';
import PrimaryButton from '@/Components/PrimaryButton';
import TextInput from '@/Components/TextInput';
import { Head, Link, useForm } from '@inertiajs/react';
import { useState } from 'react';

export default function ForgotPassword({ status }) {
    const { data, setData, post, processing, errors } = useForm({
        email: '',
    });

    const [localErrors, setLocalErrors] = useState({});

    const submit = (e) => {
        e.preventDefault();
        if (validateForm()) {
            post(route('password.email'));
        }
    };

    const validateForm = () => {
        const errors = {};

        if (!data.email || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(data.email)) {
            errors.email = 'Por favor, introduce una dirección de correo electrónico válida.';
        }

        setLocalErrors(errors);
        return Object.keys(errors).length === 0;
    };

    return (
        <div className='h-full'>
            <Head title="Forgot Password" />

            <div className="relative min-h-screen flex items-center justify-center bg-gray-800">
                <div className="relative backdrop-filter backdrop-blur-lg bg-white bg-opacity-10 border border-white border-opacity-20 shadow-lg rounded-lg p-8 w-full max-w-md">
                    <h2 className="text-3xl text-white text-center mb-4 font-righteous">¿Olvidaste tu contraseña?</h2>
                    <div className="w-full text-center mb-4 text-sm text-gray-300">
                        ¡A todos nos ocurre alguna vez! No te preocupes. <br /> <br />Simplemente déjanos saber tu dirección de correo electrónico y te
                        enviaremos un email con un enlace <br /> para restablecer tu contraseña.
                    </div>

                    {status && <div className="mb-4 text-center font-medium text-sm text-green-400">¡Se ha enviado un enlace para restablecer tu contraseña!
                    </div>}

                    <form onSubmit={submit}>
                        <TextInput
                            id="email"
                            type="email"
                            name="email"
                            value={data.email}
                            className="mt-1 block w-full bg-transparent text-white border border-white border-opacity-20 rounded-lg focus:ring-teal-400 focus:border-teal-400"
                            isFocused={true}
                            onChange={(e) => setData('email', e.target.value)}
                        />

                        <InputError message={errors.email || localErrors.email} className="mt-2 text-red-500" />

                        <div className="flex flex-col gap-2 items-center justify-center mt-4 text-gray-800">
                            <PrimaryButton className="bg-teal-500 text-white w-full justify-center" disabled={processing}>
                                ENVIAR CORREO DE RESTABLECIMIENTO
                            </PrimaryButton>
                            <Link
                            href={route('login')}
                            className="text-sm mt-2 -mb-3 text-center text-gray-400 underline hover:text-red-500"
                        >
                            No quiero restablecer mi contraseña ahora
                        </Link>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    );
}
