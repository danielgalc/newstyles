import TablaAdmin from '@/Components/Admin/TablaAdmin';
import NavAdmin from '@/Layouts/NavAdmin';
import React from 'react';

const Admin = ({ auth, usuarios, citas, servicios, productos, bloqueos }) => {
  return (
    <div className="max-[400px]:p-2">
      <NavAdmin user={auth.user}>
        <h1 className="text-6xl font-bold mb-4 max-[400px]:text-3xl">
          Bienvenido, <span className="text-teal-500">{auth.user.name}</span>
        </h1>
        <div className="user-preview-container grid grid-cols-1 sm:grid-cols-1 md:grid-cols-1 gap-4 max-[400px]:gap-2">
          <TablaAdmin
            titulo="Usuarios"
            subtitulo="Últimos usuarios añadidos"
            columnas={['Nombre', 'Email', 'DNI', 'Teléfono', 'Dirección', 'Rol', 'Verificado', 'Última Modificación']}
            datos={usuarios.map((usuario) => ({
              name: usuario.name,
              email: usuario.email,
              dni: usuario.dni,
              telefono: usuario.telefono,
              direccion: usuario.direccion,
              rol: usuario.rol,
              verificado: usuario.email_verified_at ? 'Sí' : 'No',
              updated_at: new Date(usuario.updated_at).toLocaleString('es-ES'),
            }))}
            link="admin/usuarios"
          />
        </div>
        <div className="max-w-8xl mx-auto mt-4 max-[400px]:mt-2">
          <TablaAdmin
            titulo="Citas"
            subtitulo="Últimas citas añadidas"
            columnas={['Cliente', 'Peluquero', 'Servicio', 'Fecha', 'Hora', 'Estado', 'Última Modificación']}
            datos={citas.map((cita) => ({
              cliente: cita.user.name,
              peluquero: cita.peluquero.name,
              servicio: cita.servicio,
              fecha: cita.fecha,
              hora: new Date(cita.hora).toLocaleTimeString('es-ES', { hour: '2-digit', minute: '2-digit' }),
              estado: cita.estado,
              updated_at: new Date(cita.updated_at).toLocaleString('es-ES'),
            }))}
            link="admin/citas"
          />
        </div>
        <div className="max-w-8xl mx-auto mt-4 max-[400px]:mt-2">
          <TablaAdmin
            titulo="Servicios"
            subtitulo="Últimos servicios agregados"
            columnas={['Servicio', 'Precio', 'Duración', 'Clase', 'Fecha de creación', 'Última modificación']}
            datos={servicios.map((servicio) => ({
              nombre: servicio.nombre,
              precio: `${servicio.precio}€`,
              duracion: `${servicio.duracion} minutos`,
              clase: servicio.clase === 'principal' ? 'Principal' : 'Secundario',
              created_at: new Date(servicio.created_at).toLocaleString('es-ES'),
              updated_at: new Date(servicio.updated_at).toLocaleString('es-ES'),
            }))}
            link="admin/servicios"
          />
        </div>
        <div className="max-w-8xl mx-auto mt-4 max-[400px]:mt-2">
          <TablaAdmin
            titulo="Productos"
            subtitulo="Últimos productos agregados"
            columnas={['Producto', 'Precio', 'Stock', 'Categoría', 'Fecha de creación', 'Última modificación']}
            datos={productos.map((producto) => ({
              nombre: producto.nombre,
              precio: `${producto.precio}€`,
              stock: producto.stock,
              categoria: producto.categoria,
              created_at: new Date(producto.created_at).toLocaleString('es-ES'),
              updated_at: new Date(producto.updated_at).toLocaleString('es-ES'),
            }))}
            link="admin/productos"
          />
        </div>
        <div className="max-w-8xl mx-auto mt-4 max-[400px]:mt-2">
          <TablaAdmin
            titulo="Bloqueos de Peluqueros"
            subtitulo="Últimos bloqueos añadidos"
            columnas={['Peluquero', 'Fecha', 'Horas Bloqueadas']}
            datos={bloqueos.map((bloqueo) => ({
              peluquero: bloqueo.peluquero.name,
              fecha: new Date(bloqueo.fecha).toLocaleDateString('es-ES'),
              horas: bloqueo.horas.join(', '), // Las horas ya están formateadas
            }))}
            link="admin/bloqueos"
          />
        </div>
      </NavAdmin>
    </div>
  );
};

export default Admin;
