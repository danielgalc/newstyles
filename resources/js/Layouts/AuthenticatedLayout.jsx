import { useState, useEffect } from 'react';
import ApplicationLogo from '@/Components/ApplicationLogo';
import NavLink from '@/Components/NavLink';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink';
import { Link } from '@inertiajs/react';
import LoggedLogos from '@/Components/LoggedLogos';
import { useForm } from '@inertiajs/react';

export default function Authenticated({ user, header, children }) {
    const [showingNavigationDropdown, setShowingNavigationDropdown] = useState(false);
    const { post } = useForm();

    const handleLogout = () => {
        post(route('logout'));
    };

    useEffect(() => {
        function handleResize() {
            if (window.innerWidth >= 640) {
                setShowingNavigationDropdown(false);
            }
        }

        window.addEventListener('resize', handleResize);
        
        // Limpieza del evento al desmontar el componente
        return () => window.removeEventListener('resize', handleResize);
    }, []);

    return (
        <div className="relative min-h-screen">
            <nav className="bg-gray-900 py-2 pl-5 w-full flex items-center justify-between sm:justify-between">
                <div className="flex items-center sm:hidden justify-betwen w-full">
                    <Link href="/">
                        <ApplicationLogo className="fill-current text-gray-500" />
                    </Link>
                </div>

                <div className="hidden sm:flex items-center">
                    <Link href="/">
                        <ApplicationLogo className="fill-current text-gray-500" />
                    </Link>
                </div>

                <div className="bg-gray-900 p-8 w-full flex items-center justify-between font-righteous hidden sm:flex">
                    <div className="flex w-full justify-center items-center space-x-4 sm:space-x-24">
                        <NavLink href="/productos">Productos</NavLink>
                        <NavLink href="/servicios">Servicios</NavLink>
                        <NavLink href="/quienes-somos">Quiénes Somos</NavLink>
                    </div>
                </div>
                <div className='hidden sm:flex items-center justify-between'>
                    <LoggedLogos />
                </div>

                <div className="sm:hidden flex justify-end w-full px-4">
                    <button
                        onClick={() => setShowingNavigationDropdown(!showingNavigationDropdown)}
                        className="text-teal-400 focus:outline-none"
                    >
                        <svg className="w-6 h-6" fill="none" strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" viewBox="0 0 24 24" stroke="currentColor">
                            <path d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>
            </nav>

            {showingNavigationDropdown && (
                <div>
                    <div
                        className="fixed inset-0 bg-black bg-opacity-50 z-10"
                        onClick={() => setShowingNavigationDropdown(false)}
                    ></div>
                    <div className="fixed inset-y-0 left-0 bg-gray-900 p-4 z-20 transform transition-transform duration-300 ease-in-out w-64 translate-x-0">
                        <ResponsiveNavLink href="/productos" className="font-righteous text-white">Productos</ResponsiveNavLink>
                        <ResponsiveNavLink href="/servicios" className="font-righteous text-white">Servicios</ResponsiveNavLink>
                        <ResponsiveNavLink href="/quienes-somos" className="font-righteous text-white">Quiénes Somos</ResponsiveNavLink>
                        <div className='mt-4 font-righteous text-white'>
                            <a href="/carrito" className="block px-4 py-2">Carrito</a>
                            <a href="/profile" className="block px-4 py-2">Perfil</a>
                            <a href="/historial-citas" className="block px-4 py-2">Historial de citas</a>
                            <a href="/historial_pedidos" className="block px-4 py-2">Historial de pedidos</a>
                            <a onClick={handleLogout} href="/" className="block px-4 py-2 text-red-400">Cerrar sesión</a>
                        </div>
                    </div>
                </div>
            )}

            {header && (
                <header className="bg-white shadow">
                    <div className="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">{header}</div>
                </header>
            )}

            <div className="flex flex-col items-center justify-center">
                <div className="w-full bg-white overflow-hidden">
                    {children}
                </div>
            </div>
        </div>
    );
}
