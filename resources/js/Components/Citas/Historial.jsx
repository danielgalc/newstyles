import React, { useState, useEffect } from 'react';

const Historial = ({ proximaCita, citasFinalizadas, users }) => {
    const [formData, setFormData] = useState({
        peluquero_id: proximaCita?.peluquero_id || '',
        fecha: proximaCita?.fecha || '',
        hora: proximaCita?.hora || '',
    });
    const [isChanged, setIsChanged] = useState(false);
    const [isTimeRestricted, setIsTimeRestricted] = useState(false);

    useEffect(() => {
        checkTimeRestriction();
    }, [formData.fecha, formData.hora]);

    const checkTimeRestriction = () => {
        const now = new Date();
        const citaFecha = new Date(`${formData.fecha}T${formData.hora}`);
        const diff = citaFecha - now;
        const hoursDiff = diff / 1000 / 60 / 60;
        setIsTimeRestricted(hoursDiff < 24);
    };

    const handleInputChange = (e) => {
        const { name, value } = e.target;
        setFormData((prevData) => ({
            ...prevData,
            [name]: value,
        }));
        setIsChanged(true);
    };

    const handleSubmit = (e) => {
        e.preventDefault();
        // Handle form submission logic
    };

    return (
        <div>
            <div className="w-full h-24 flex items-center justify-center bg-teal-400 shadow-md">
                <h2 className="text-4xl text-gray-800 leading-tight banner-text">
                    Historial de Citas
                </h2>
            </div>
            <div className="container mx-auto mt-4">
                {proximaCita && (proximaCita.estado === 'aceptada' || proximaCita.estado === 'pendiente') ? (
                    <div className="proxima-cita bg-white p-4 rounded-md shadow-md mb-6 hover:bg-teal-100 cursor-pointer">
                        <h2 className="text-xl font-semibold text-teal-600 mb-2">Tu próxima cita es:</h2>
                        <p><strong>Servicio:</strong> {proximaCita.servicio}</p>
                        <p><strong>Fecha:</strong> {new Date(proximaCita.fecha).toLocaleDateString()}</p>
                        <p><strong>Hora:</strong> {new Date(proximaCita.hora).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })}</p>
                        <p><strong>Estado:</strong> {proximaCita.estado.charAt(0).toUpperCase() + proximaCita.estado.slice(1)}</p>
                    </div>
                ) : (
                    <p className="mb-6">No tienes citas próximas.</p>
                )}

                <h2 className="text-2xl font-semibold text-teal-600 mb-4">Citas Finalizadas</h2>
                {citasFinalizadas.length === 0 ? (
                    <p>No tienes citas finalizadas.</p>
                ) : (
                    <div className="grid grid-cols-1 md:grid-cols-3 gap-4">
                        {citasFinalizadas.map((cita) => (
                            <div key={cita.id} className="cita-finalizada bg-white p-4 rounded-md shadow-md mb-4 hover:bg-teal-100">
                                <p><strong>Servicio:</strong> {cita.servicio}</p>
                                <p><strong>Fecha:</strong> {new Date(cita.fecha).toLocaleDateString()}</p>
                                <p><strong>Hora:</strong> {new Date(cita.hora).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })}</p>
                            </div>
                        ))}
                    </div>
                )}
            </div>

            {proximaCita && (
                <div id={`edit_cita_modal_${proximaCita.id}`} className="modal">
                    <div className="modal-content">
                        <div className="modal-header">
                            <h3>Editar Cita: <span className="italic text-teal-600">#{proximaCita.id}</span></h3>
                            <button className="close-button">&times;</button>
                        </div>
                        <form onSubmit={handleSubmit} className="modal-body">
                            <div className="grid gap-4 mb-4 grid-cols-2">
                                <div className="col-span-2">
                                    <label htmlFor={`peluquero_id_${proximaCita.id}`} className="block mb-2 text-sm font-medium text-gray-900">Peluquero</label>
                                    <select
                                        name="peluquero_id"
                                        id={`peluquero_id_${proximaCita.id}`}
                                        value={formData.peluquero_id}
                                        onChange={handleInputChange}
                                        className="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5"
                                    >
                                        {users.map((user) => (
                                            <option key={user.id} value={user.id}>{user.name}</option>
                                        ))}
                                    </select>
                                </div>
                                <div className="col-span-2">
                                    <label htmlFor={`fecha_${proximaCita.id}`} className="block mb-2 text-sm font-medium text-gray-900">Fecha</label>
                                    <input
                                        id={`fecha_${proximaCita.id}`}
                                        name="fecha"
                                        type="date"
                                        value={formData.fecha}
                                        onChange={handleInputChange}
                                        className="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50"
                                    />
                                </div>
                                <div className="col-span-2">
                                    <label htmlFor={`hora_${proximaCita.id}`} className="block mb-2 text-sm font-medium text-gray-900">Hora</label>
                                    <input
                                        id={`hora_${proximaCita.id}`}
                                        name="hora"
                                        type="time"
                                        value={formData.hora}
                                        onChange={handleInputChange}
                                        className="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5"
                                        required
                                    />
                                </div>
                            </div>
                            {isChanged && !isTimeRestricted && (
                                <p className="text-red-500 text-xs italic mb-2">Has de realizar cambios para poder guardar</p>
                            )}
                            {isTimeRestricted && (
                                <p className="text-red-500 text-xs italic mb-2">No puedes hacer cambios a falta de menos de 24 horas para tu cita.</p>
                            )}
                            <div className="flex justify-between">
                                <button
                                    type="submit"
                                    className={`text-black bg-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center ${!isChanged || isTimeRestricted ? 'cursor-not-allowed' : 'bg-blue-700 hover:bg-blue-800 text-white'}`}
                                    disabled={!isChanged || isTimeRestricted}
                                >
                                    Guardar cambios
                                </button>
                                <button type="button" className="text-white bg-red-600 hover:bg-red-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                                    Cancelar cita
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            )}
        </div>
    );
};

export default Historial;
