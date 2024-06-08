import ApplicationLogo from '@/Components/ApplicationLogo';
import NavLink from '@/Components/NavLink';
import { Link } from '@inertiajs/react';

export default function Guest({ children }) {
    return (
        <div className="min-h-screen">
            <nav className="bg-gray-900 py-[10px] pl-5 w-full flex items-center justify-center">
                <div className="flex items-center">
                    <Link href="/">
                        <ApplicationLogo className="fill-current text-gray-500" />
                    </Link>
                </div>

                <div className="bg-gray-900 p-8 w-full flex items-center justify-between font-righteous">
                    <div className="flex w-full justify-center items-center space-x-24 font-righteous">
                        <NavLink href="/productos">Productos</NavLink>
                        <NavLink href="/servicios">Servicios</NavLink>
                        <NavLink href="/quienes-somos">Quiénes Somos</NavLink>
                    </div>
                </div>
                <div className='flex flex-col mr-8 justify-between items-center'>
                    <NavLink href="/login">Entrar</NavLink>
                    <NavLink href="/register">Registrarse</NavLink>
                </div>
            </nav>

            <div className="flex flex-col items-center justify-center">
                <div className="w-full bg-white overflow-hidden">
                    {children}
                </div>
            </div>
        </div>
    );
}
