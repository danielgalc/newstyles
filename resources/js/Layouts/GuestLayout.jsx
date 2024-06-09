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
                <div className='mr-8'>
                    <a href="/carrito" className="transition-all duration-300 transform hover:text-teal-500 hover:scale-105">
                        <svg className="carrito-icono w-11 h-11" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 50 50">
                            <path d="M0 2.08334H9.925L11.0604 6.25001H48.7229L41.0854 29.1667H16.2083L15.1667 33.3333H45.8333V37.5H9.83333L12.4292 27.1063L6.74167 6.25001H0V2.08334ZM16.175 25H38.0812L42.9437 10.4167H12.1979L16.175 25ZM8.33333 43.75C8.33333 42.6449 8.77232 41.5851 9.55372 40.8037C10.3351 40.0223 11.3949 39.5833 12.5 39.5833C13.6051 39.5833 14.6649 40.0223 15.4463 40.8037C16.2277 41.5851 16.6667 42.6449 16.6667 43.75C16.6667 44.8551 16.2277 45.9149 15.4463 46.6963C14.6649 47.4777 13.6051 47.9167 12.5 47.9167C11.3949 47.9167 10.3351 47.4777 9.55372 46.6963C8.77232 45.9149 8.33333 44.8551 8.33333 43.75ZM37.5 43.75C37.5 42.6449 37.939 41.5851 38.7204 40.8037C39.5018 40.0223 40.5616 39.5833 41.6667 39.5833C42.7717 39.5833 43.8315 40.0223 44.6129 40.8037C45.3943 41.5851 45.8333 42.6449 45.8333 43.75C45.8333 44.8551 45.3943 45.9149 44.6129 46.6963C43.8315 47.4777 42.7717 47.9167 41.6667 47.9167C40.5616 47.9167 39.5018 47.4777 38.7204 46.6963C37.939 45.9149 37.5 44.8551 37.5 43.75Z" fill="white" />
                        </svg>
                    </a>
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
