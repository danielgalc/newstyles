import React, { useState, useEffect } from 'react';
import Banner from '@/Components/Banner';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import GuestLayout from '@/Layouts/GuestLayout';
import Grid from '@/Components/Productos/Grid';
import axios from 'axios';
import debounce from 'lodash/debounce';

export default function Productos({ auth, productos, search }) {
    const [searchTerm, setSearchTerm] = useState(search || '');
    const [filteredProductos, setFilteredProductos] = useState(productos || { data: [] });
    const [sortBy, setSortBy] = useState(null);
    const [selectedCategory, setSelectedCategory] = useState('');
    const [categorias, setCategorias] = useState([]);
    const [flashMessage, setFlashMessage] = useState('');

    useEffect(() => {
        const fetchCategorias = async () => {
            try {
                const response = await axios.get(route('categorias'));
                setCategorias(response.data);
            } catch (error) {
                console.error('Error fetching categorias:', error);
            }
        };

        fetchCategorias();
    }, []);

    const fetchProductos = debounce(async (search) => {
        try {
            const response = await axios.get(route('productos.productos'), {
                params: { search, sortBy, category: selectedCategory }
            });
            setFilteredProductos(response.data.productos || { data: [] });
        } catch (error) {
            console.error('Error fetching productos:', error);
        }
    }, 300);

    useEffect(() => {
        if (searchTerm || sortBy || selectedCategory) {
            fetchProductos(searchTerm);
        } else {
            setFilteredProductos(productos || { data: [] });
        }

        return () => {
            fetchProductos.cancel();
        };
    }, [searchTerm, sortBy, selectedCategory]);

    const handleSearchChange = (e) => {
        setSearchTerm(e.target.value);
    };

    const handleSortChange = (e) => {
        const selectedSort = e.target.value;
        setSortBy(selectedSort);
    };

    const handleCategoryChange = (e) => {
        const selectedCategory = e.target.value;
        setSelectedCategory(selectedCategory);
    };

    const handleProductoAdded = (productoId) => {
        setFilteredProductos((prevProductos) => {
            if (!Array.isArray(prevProductos.data)) {
                return prevProductos;
            }

            const updatedData = prevProductos.data.map((producto) =>
                producto.id === productoId
                    ? { ...producto, stock: producto.stock - 1 }
                    : producto
            );

            return { ...prevProductos, data: updatedData };
        });
        setFlashMessage('¡Producto añadido al carrito!');
        setTimeout(() => setFlashMessage(''), 4000); // Clear message after 4 seconds
    };

    return (
        <div className="Productos">
            {auth.user ? (
                <AuthenticatedLayout user={auth.user}>
                    <Banner text="Catálogo de productos" />
                    {flashMessage && (
                        <div className="bg-green-100 text-green-800 p-4 rounded mb-4">
                            {flashMessage}
                        </div>
                    )}
                    <div className="flex justify-center items-center my-4">
                        <input
                            type="text"
                            value={searchTerm}
                            onChange={handleSearchChange}
                            placeholder="Buscar productos..."
                            className="p-2 border rounded-md w-1/4"
                        />
                        <select onChange={handleSortChange} className="p-2 border rounded-md ml-4 w-52">
                            <option value="">Ordenar por...</option>
                            <option value="asc">A - Z</option>
                            <option value="desc">Z - A</option>
                            <option value="price_asc">Menor a mayor precio</option>
                            <option value="price_desc">Mayor a menor precio</option>
                        </select>
                        <select onChange={handleCategoryChange} className="p-2 border rounded-md ml-4 w-52">
                            <option value="">Seleccionar categoría...</option>
                            {categorias.map((categoria, index) => (
                                <option key={index} value={categoria}>{categoria}</option>
                            ))}
                        </select>
                    </div>
                    <Grid
                        productos={filteredProductos}
                        setFilteredProductos={setFilteredProductos}
                        searchTerm={searchTerm}
                        sortBy={sortBy}
                        selectedCategory={selectedCategory}
                        handleProductoAdded={handleProductoAdded}
                        auth={auth} // Pasar auth aquí
                    />
                </AuthenticatedLayout>
            ) : (
                <GuestLayout>
                    <Banner text="Catálogo de productos" />
                    {flashMessage && (
                        <div className="bg-green-100 text-green-800 p-4 rounded mb-4">
                            {flashMessage}
                        </div>
                    )}
                    <div className="flex justify-center items-center my-4">
                        <input
                            type="text"
                            value={searchTerm}
                            onChange={handleSearchChange}
                            placeholder="Buscar productos..."
                            className="p-2 border rounded-md w-1/4"
                        />
                        <select onChange={handleSortChange} className="p-2 border rounded-md ml-4 w-52">
                            <option value="">Ordenar por...</option>
                            <option value="asc">A - Z</option>
                            <option value="desc">Z - A</option>
                            <option value="price_asc">Menor a mayor precio</option>
                            <option value="price_desc">Mayor a menor precio</option>
                        </select>
                        <select onChange={handleCategoryChange} className="p-2 border rounded-md ml-4 w-52">
                            <option value="">Seleccionar categoría...</option>
                            {categorias.map((categoria, index) => (
                                <option key={index} value={categoria}>{categoria}</option>
                            ))}
                        </select>
                    </div>
                    <Grid
                        productos={filteredProductos}
                        setFilteredProductos={setFilteredProductos}
                        searchTerm={searchTerm}
                        sortBy={sortBy}
                        selectedCategory={selectedCategory}
                        handleProductoAdded={handleProductoAdded}
                        auth={auth} // Pasar auth aquí
                    />
                </GuestLayout>
            )}
        </div>
    );
}
