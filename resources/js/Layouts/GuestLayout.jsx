import NavLink from '@/Components/NavLink';
import { Link } from '@inertiajs/react';

export default function Guest({ children }) {
    return (
        <div className="min-h-screen flex flex-col">
            <nav className="bg-gray-900 p-4 w-full flex items-center justify-between">
                <div className="flex items-center">
                    <Link href="/">
                        <img src="/images/Logo1Transparente.png" alt="Logo 1" className="w-44 h-30" />
                    </Link>
                </div>

                <div className="bg-gray-900 p-8 w-full flex items-center justify-between">
                    <div className="flex w-full justify-center items-center space-x-24 font-righteous">
                        <NavLink href="/productos">Productos</NavLink>
                        <NavLink href="/servicios">Servicios</NavLink>
                        <NavLink href="/quienes-somos">Quiénes Somos</NavLink>
                    </div>
                    <div className='flex flex-col w-1/4 gap-4 -mr-16 justify-between items-center'>
                        <NavLink href="/login">Iniciar sesión</NavLink>
                        <NavLink href="/register">Registrarse</NavLink>
                    </div>
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
