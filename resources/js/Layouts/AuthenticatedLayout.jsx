import { useState } from 'react';
import ApplicationLogo from '@/Components/ApplicationLogo';
import NavLink from '@/Components/NavLink';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink';
import { Link } from '@inertiajs/react';
import LoggedLogos from '@/Components/LoggedLogos';

export default function Authenticated({ user, header, children }) {
    const [showingNavigationDropdown, setShowingNavigationDropdown] = useState(false);

    return (
        <div className="min-h-screen">
            <nav className="bg-gray-900 p-4 w-full flex items-center justify-between">
                <div className="flex items-center">
                    <Link href="/">
                        <ApplicationLogo className="w-44 h-30 fill-current text-gray-500" />
                    </Link>
                </div>

                <div className="bg-gray-900 p-8 w-full flex items-center justify-between font-righteous">
                    <div className="flex w-full justify-center items-center space-x-24">
                        <NavLink href="/productos">Productos</NavLink>
                        <NavLink href="/servicios">Servicios</NavLink>
                        <NavLink href="/quienes-somos">Quiénes Somos</NavLink>
                    </div>
                </div>
                <div className='flex items-center justify-between'>
                    <LoggedLogos />
                </div>
            </nav>

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
