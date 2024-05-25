import TablaAdmin from '@/Components/Admin/TablaAdmin';
import React from 'react';

const Admin = ({ usuarios, citas, servicios, productos }) => (
  <div>
    <div className="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-4">
      <TablaAdmin
        titulo="Usuarios"
        subtitulo="Últimos usuarios añadidos"
        columnas={['Nombre', 'Email', 'Rol', 'Verificado', 'Última Modificación']}
        datos={usuarios.map(usuario => ({
          name: usuario.name,
          email: usuario.email,
          rol: usuario.rol,
          verificado: usuario.email_verified_at ? 'Sí' : 'No',
          updated_at: new Date(usuario.updated_at).toLocaleString('es-ES')
        }))}
        link="admin/usuarios"
      />
    </div>
    <div className="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-4">
      <TablaAdmin
        titulo="Citas"
        subtitulo="Últimas citas añadidas"
        columnas={['Cliente', 'Peluquero', 'Servicio', 'Fecha', 'Hora', 'Estado', 'Última Modificación']}
        datos={citas.map(cita => ({
          cliente: cita.user.name,
          peluquero: cita.peluquero.name,
          servicio: cita.servicio,
          fecha: cita.fecha,
          hora: cita.hora,
          estado: cita.estado,
          updated_at: new Date(cita.updated_at).toLocaleString('es-ES')
        }))}
        link="admin/citas"
      />
    </div>
    <div className="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-4">
      <TablaAdmin
        titulo="Servicios"
        subtitulo="Últimos servicios agregados"
        columnas={['Servicio', 'Precio', 'Duración', 'Clase', 'Fecha de creación', 'Última modificación']}
        datos={servicios.map(servicio => ({
          nombre: servicio.nombre,
          precio: servicio.precio,
          duracion: servicio.duracion,
          clase: servicio.clase === 'principal' ? 'Principal' : 'Secundario',
          created_at: new Date(servicio.created_at).toLocaleString('es-ES'),
          updated_at: new Date(servicio.updated_at).toLocaleString('es-ES')
        }))}
        link="admin/servicios"
      />
    </div>
    <div className="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-4">
      <TablaAdmin
        titulo="Productos"
        subtitulo="Últimos productos agregados"
        columnas={['Producto', 'Precio', 'Stock', 'Fecha de creación', 'Última modificación']}
        datos={productos.map(producto => ({
          nombre: producto.nombre,
          precio: producto.precio,
          stock: producto.stock,
          created_at: new Date(producto.created_at).toLocaleString('es-ES'),
          updated_at: new Date(producto.updated_at).toLocaleString('es-ES')
        }))}
        link="admin/productos"
      />
    </div>
  </div>
);

export default Admin;
