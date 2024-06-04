import React, { useState, useEffect } from 'react';
import { Inertia } from '@inertiajs/inertia';
import { InertiaLink, usePage } from '@inertiajs/inertia-react';

const Citas = () => {
    const { citasPendientes, citasAceptadas, errors, success } = usePage().props;
    const [fechaBloquear, setFechaBloquear] = useState('');
    const [horasBloquear, setHorasBloquear] = useState([]);
    const [fechaDesbloquear, setFechaDesbloquear] = useState('');
    const [horasDesbloquear, setHorasDesbloquear] = useState([]);

    const handleBloquearSubmit = (e) => {
        e.preventDefault();
        Inertia.post('/bloqueos', { user_id: user.id, fecha: fechaBloquear, horas: horasBloquear });
    };

    const handleDesbloquearSubmit = (e) => {
        e.preventDefault();
        Inertia.put('/bloqueos/desbloquear', { user_id: user.id, fecha: fechaDesbloquear, horas: horasDesbloquear });
    };

    useEffect(() => {
        const fetchHorasBloqueadas = async (fecha, setter) => {
            const response = await fetch(`/bloqueos/horas-bloqueadas?user_id=${user.id}&fecha=${fecha}`);
            const data = await response.json();
            setter(data);
        };

        if (fechaBloquear) fetchHorasBloqueadas(fechaBloquear, setHorasBloquear);
        if (fechaDesbloquear) fetchHorasBloqueadas(fechaDesbloquear, setHorasDesbloquear);
    }, [fechaBloquear, fechaDesbloquear]);

    return (
        <div className="min-h-screen bg-gray-800 pt-20">
            <div className="container mx-auto flex flex-col justify-center items-center mt-4 w-1/3">
                {success && <div className="bg-green-500 text-white p-4 rounded-md mb-4">{success}</div>}
                {errors && <div className="bg-red-500 text-white p-4 rounded-md mb-4"><ul>{Object.values(errors).map((error, index) => <li key={index}>{error}</li>)}</ul></div>}

                <div className="relative bg-white bg-opacity-10 border border-white border-opacity-20 shadow-lg rounded-lg px-8 pt-8 pb-2 w-full max-w-md">
                    <h2 className="text-3xl text-red-600 text-center mb-4">Bloquear Horas</h2>
                    <form onSubmit={handleBloquearSubmit}>
                        <div className="grid gap-4 mb-4 grid-cols-2">
                            <div className="col-span-2">
                                <label htmlFor="fecha_bloquear" className="block mb-2 text-sm font-medium text-gray-200">Fecha a Bloquear</label>
                                <input id="fecha_bloquear" name="fecha" type="date" value={fechaBloquear} onChange={(e) => setFechaBloquear(e.target.value)} className="block w-full text-sm text-gray-800 border border-gray-300 rounded-lg cursor-pointer bg-gray-50" min={new Date().toISOString().split('T')[0]} required />
                            </div>
                            <div className="col-span-2">
                                <label htmlFor="horas_bloquear" className="block mb-2 text-sm font-medium text-gray-200">Horas a Bloquear</label>
                                <select id="horas_bloquear" name="horas[]" value={horasBloquear} onChange={(e) => setHorasBloquear([...e.target.selectedOptions].map(o => o.value))} className="block w-full text-sm text-gray-800 border border-gray-300 rounded-lg cursor-pointer bg-gray-50" multiple>
                                    {['10:00:00', '11:00:00', '12:00:00', '13:00:00', '16:00:00', '17:00:00', '18:00:00', '19:00:00', '20:00:00'].map(hora => <option key={hora} value={hora}>{hora.slice(0, 5)}</option>)}
                                </select>
                                <small className="text-gray-500">Mantén presionada la tecla Ctrl (Windows) o Comando (Mac) para seleccionar múltiples horas.</small>
                            </div>
                        </div>
                        <button type="submit" className="text-white bg-red-600 hover:bg-red-700 inline-flex items-center font-medium rounded-lg text-sm px-5 py-2.5 text-center">Bloquear</button>
                    </form>
                </div>

                <div className="relative bg-white bg-opacity-10 border border-white border-opacity-20 shadow-lg rounded-lg px-8 pt-8 pb-2 w-full max-w-md mt-10">
                    <h2 className="text-3xl text-teal-500 text-center mb-4">Desbloquear Horas</h2>
                    <form onSubmit={handleDesbloquearSubmit}>
                        <div className="grid gap-4 mb-4 grid-cols-2">
                            <div className="col-span-2">
                                <label htmlFor="fecha_desbloquear" className="block mb-2 text-sm font-medium text-gray-200">Fecha a Desbloquear</label>
                                <input id="fecha_desbloquear" name="fecha" type="date" value={fechaDesbloquear} onChange={(e) => setFechaDesbloquear(e.target.value)} className="block w-full text-sm text-gray-800 border border-gray-300 rounded-lg cursor-pointer bg-gray-50" min={new Date().toISOString().split('T')[0]} required />
                            </div>
                            <div className="col-span-2">
                                <label htmlFor="horas_desbloquear" className="block mb-2 text-sm font-medium text-gray-200">Horas a Desbloquear</label>
                                <select id="horas_desbloquear" name="horas[]" value={horasDesbloquear} onChange={(e) => setHorasDesbloquear([...e.target.selectedOptions].map(o => o.value))} className="block w-full text-sm text-gray-800 border border-gray-300 rounded-lg cursor-pointer bg-gray-50" multiple>
                                    {horasDesbloquear.map(hora => <option key={hora} value={hora}>{hora.slice(0, 5)}</option>)}
                                </select>
                                <small className="text-gray-500">Mantén presionada la tecla Ctrl (Windows) o Comando (Mac) para seleccionar múltiples horas.</small>
                            </div>
                        </div>
                        <button type="submit" className="text-white bg-teal-500 hover:bg-teal-700 inline-flex items-center font-medium rounded-lg text-sm px-5 py-2.5 text-center">Desbloquear</button>
                    </form>
                </div>
            </div>
        </div>
    );
};

export default Citas;
