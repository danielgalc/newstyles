import { useState } from 'react';
import { useDispatch } from 'react-redux'; // O cualquier otro método para manejar la autenticación
import { logoutUser } from './redux/actions/authActions'; // Suponiendo que tengas acciones para manejar la autenticación

export default function LogoutButton() {
    const dispatch = useDispatch();
    const [hover, setHover] = useState(false);

    const handleLogout = (e) => {
        e.preventDefault();
        dispatch(logoutUser());
    };

    return (
        <div className={`w-full mt-auto py-2 px-4 text-red ${hover ? 'border-red-500' : 'border-red'} relative h-12 w-40 overflow-hidden bg-white px-3 text-red-500 shadow-2xl transition-all`} onMouseEnter={() => setHover(true)} onMouseLeave={() => setHover(false)}>
            <form method="POST" onSubmit={handleLogout}>
                <input type="hidden" name="_token" value={csrf_token} />
                <button type="submit" className="mt-auto text-xl relative z-10 text-red-500 hover:text-white">
                    Cerrar sesión
                </button>
            </form>
        </div>
    );
}
