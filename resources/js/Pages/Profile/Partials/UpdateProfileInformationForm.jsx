import InputError from '@/Components/InputError';
import InputLabel from '@/Components/InputLabel';
import PrimaryButton from '@/Components/PrimaryButton';
import TextInput from '@/Components/TextInput';
import { Link, useForm, usePage } from '@inertiajs/react';
import { Transition } from '@headlessui/react';
import { useState } from 'react';

export default function UpdateProfileInformation({ mustVerifyEmail, status, className = '' }) {
    const user = usePage().props.auth.user;

    const { data, setData, patch, errors, processing, recentlySuccessful } = useForm({
        name: user.name,
        email: user.email,
        dni: user.dni || '',
        telefono: user.telefono || '',
        direccion: user.direccion || '',
    });

    const [localErrors, setLocalErrors] = useState({});

    const submit = (e) => {
        e.preventDefault();

        if (validateForm()) {
            patch(route('profile.update'));
        }
    };

    const validateForm = () => {
        const errors = {};

        if (!data.name || data.name.length < 3) {
            errors.name = 'Nombre no válido. Introduce un nombre válido.';
        } else if (!/^[a-zA-ZáéíóúÁÉÍÓÚ\s]+$/.test(data.name)) {
            errors.name = 'Ni números ni símbolos especiales son válidos en este campo. Introduce un nombre válido, por favor.';
        }

        if (!data.email || !/^[^\s@]{5,}@[^.\s@]{4,}\.[^.\s@]{2,}$/.test(data.email)) {
            errors.email = 'Por favor, introduce una dirección de correo electrónico válida';
        }

        if (!data.dni || !/^[0-9]{8}[A-Z]$/.test(data.dni)) {
            errors.dni = 'El DNI debe estar compuesto por 8 números y una letra mayúscula.';
        }

        if (!data.telefono || !/^[0-9]{9}$/.test(data.telefono)) {
            errors.telefono = 'El teléfono debe estar compuesto por 9 números sin espacios.';
        }

        if (!data.direccion || !/^[a-zA-ZáéíóúÁÉÍÓÚ0-9\s]+$/.test(data.direccion)) {
            errors.direccion = 'La dirección no puede contener caracteres especiales.';
        }

        setLocalErrors(errors);
        return Object.keys(errors).length === 0;
    };

    return (
        <section className={className}>
            <header>
                <h2 className="text-lg font-medium text-gray-900">Datos personales</h2>

                <p className="mt-1 text-sm text-gray-600">
                    Actualiza los datos de tu cuenta y dirección de correo electrónico.
                </p>
            </header>

            <form onSubmit={submit} className="mt-6 space-y-6">
                <div>
                    <InputLabel htmlFor="name" value="Nombre" />

                    <TextInput
                        id="name"
                        className="mt-1 block w-full"
                        value={data.name}
                        onChange={(e) => setData('name', e.target.value)}
                        required
                        isFocused
                        autoComplete="name"
                    />

                    <InputError className="mt-2" message={errors.name || localErrors.name} />
                </div>

                <div>
                    <InputLabel htmlFor="email" value="Correo Electrónico" />

                    <TextInput
                        id="email"
                        type="email"
                        className="mt-1 block w-full"
                        value={data.email}
                        onChange={(e) => setData('email', e.target.value)}
                        required
                        autoComplete="username"
                    />

                    <InputError className="mt-2" message={errors.email || localErrors.email} />
                </div>

                <div>
                    <InputLabel htmlFor="dni" value="DNI" />

                    <TextInput
                        id="dni"
                        className="mt-1 block w-full"
                        value={data.dni}
                        onChange={(e) => setData('dni', e.target.value)}
                        required
                        autoComplete="dni"
                    />

                    <InputError className="mt-2" message={errors.dni || localErrors.dni} />
                </div>

                <div>
                    <InputLabel htmlFor="telefono" value="Teléfono" />

                    <TextInput
                        id="telefono"
                        className="mt-1 block w-full"
                        value={data.telefono}
                        onChange={(e) => setData('telefono', e.target.value)}
                        required
                        autoComplete="telefono"
                        onKeyPress={(e) => {
                            if (e.key === ' ') {
                                e.preventDefault();
                            }
                        }}
                    />

                    <InputError className="mt-2" message={errors.telefono || localErrors.telefono} />
                </div>

                <div>
                    <InputLabel htmlFor="direccion" value="Dirección" />

                    <TextInput
                        id="direccion"
                        className="mt-1 block w-full"
                        value={data.direccion}
                        onChange={(e) => setData('direccion', e.target.value)}
                        required
                        autoComplete="direccion"
                    />

                    <InputError className="mt-2" message={errors.direccion || localErrors.direccion} />
                </div>

                {mustVerifyEmail && user.email_verified_at === null && (
                    <div>
                        <p className="text-sm mt-2 text-gray-800">
                            Tu correo eléctronico no está verificado.
                            <Link
                                href={route('verification.send')}
                                method="post"
                                as="button"
                                className="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                            >
                                Haz click aquí para recibir un nuevo correo de verificación.
                            </Link>
                        </p>

                        {status === 'verification-link-sent' && (
                            <div className="mt-2 font-medium text-sm text-green-600">
                                Un nuevo enlace de verificación ha sido enviado a tu dirección de correo.
                            </div>
                        )}
                    </div>
                )}

                <div className="flex items-center gap-4">
                    <PrimaryButton className='bg-teal-400' disabled={processing}>Guardar</PrimaryButton>

                    <Transition
                        show={recentlySuccessful}
                        enter="transition ease-in-out"
                        enterFrom="opacity-0"
                        leave="transition ease-in-out"
                        leaveTo="opacity-0"
                    >
                        <p className="text-sm text-gray-600">Guardado.</p>
                    </Transition>
                </div>
            </form>
        </section>
    );
}
