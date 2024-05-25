// Navigation.jsx

import React from 'react';
import NavLink from './NavLink';
import { Dropdown } from "flowbite-react";


function Navigation({auth}) {
    return (
        <div className="min-h-screen flex flex-col bg-gray-100">
            <nav className="bg-gray-900 p-4 w-full flex items-center justify-between">
                <div className="flex items-center">
                    <Link href="/">
                        <img src="/images/Logo1Transparente.png" alt="Logo 1" className="w-40 h-20" />
                    </Link>
                </div>

                <div className="bg-gray-900 p-8 w-full flex items-center justify-between">
                    <div className="flex w-full justify-center items-center space-x-24">
                        <NavLink href="/productos">Productos</NavLink>
                        <NavLink href="/servicios">Servicios</NavLink>
                        <NavLink href="/quienes-somos">Quiénes Somos</NavLink>
                    </div>
                </div>
            </nav>

            <div className="flex flex-col items-center justify-center pt-6 pb-4">
                <Link href="/">
                    <ApplicationLogo className="w-20 h-20 fill-current text-gray-500" />
                </Link>
                <div className="w-full mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
                    {children}
                </div>
            </div>
        </div>
    );
}

function AuthenticatedLinks() {
    return (
        <>
            {isLoggedIn && <NavLink href="/carrito">Carrito</NavLink>}
            <Dropdown label="Dropdown button" dismissOnClick={false}>
                <Dropdown.Item>Dashboard</Dropdown.Item>
                <Dropdown.Item>Settings</Dropdown.Item>
                <Dropdown.Item>Earnings</Dropdown.Item>
                <Dropdown.Item>Sign out</Dropdown.Item>
            </Dropdown>
        </>
    );
}

function GuestLinks() {
    return (
        <>
            <NavLink href="/login">Iniciar sesión</NavLink>
            <NavLink href="/register">Registrarse</NavLink>
        </>
    );
}

function isLoggedIn(auth) {

    return auth && auth.user;
}

function isClient(auth) {
    return auth && auth.user && auth.user.rol === 'cliente';
}

export default Navigation;
