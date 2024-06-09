import GuestLayout from '@/Layouts/GuestLayout';
import PrimaryButton from '@/Components/PrimaryButton';
import { Head, Link, useForm } from '@inertiajs/react';

export default function VerifyEmail({ status }) {
    const { post, processing } = useForm({});

    const submit = (e) => {
        e.preventDefault();

        post(route('verification.send'));
    };

    return (
        <div>
            <Head title="Email Verification" />
            <div className="relative min-h-screen flex items-center justify-center bg-gray-800">
            <div className="absolute top-36 drop-shadow-md">
                    <Link href="/">
                        <img src="/images/Logo1Transparente.png" alt="Logo 1" className="w-44 h-30 mx-auto drop-shadow-md" />
                    </Link>
                </div>
                <div className="relative backdrop-filter backdrop-blur-lg bg-white bg-opacity-10 border border-white border-opacity-20 shadow-lg rounded-lg px-8 pt-8 pb-2 w-full max-w-md">
                    <h2 className="text-2xl text-white text-center mb-4 font-righteous">Verificación de correo electrónico
                    </h2>

                    <div className="mb-4 text-sm text-gray-300 text-center">
                    ¡Gracias por registrarte! Antes de comenzar, ¿podrías verificar tu dirección de correo electrónico haciendo clic en el enlace que acabamos de enviarte por correo electrónico? Si no recibiste el correo electrónico, con gusto te enviaremos otro.
                    </div>

                    {status === 'verification-link-sent' && (
                        <div className="mb-4 text-center font-medium text-sm text-green-400">
                            ¡Un nuevo enlace de verificación ha sido enviado!
                        </div>
                    )}

                    <form onSubmit={submit}>
                        <div className="mt-4 flex flex-col gap-2 items-center justify-between">
                            <PrimaryButton className='hover:bg-teal-500' disabled={processing}>Reenviar Correo de Verificación</PrimaryButton>

                            <Link
                                href={route('landing')}
                                className="text-sm text-gray-400 underline hover:text-red-500"
                            >
                                No quiero confirmar mi correo electrónico ahora
                            </Link>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    );
}
