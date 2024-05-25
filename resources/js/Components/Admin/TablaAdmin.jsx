import React from 'react';

const TablaAdmin = ({ titulo, subtitulo, columnas, datos, link }) => (
  <div className="tabla-admin px-3 py-2 rounded-lg border border-gray-300 overflow-y-auto h-auto">
    <div className="flex justify-between items-center mb-4">
      <div>
        <h2 className="text-4xl font-bold">{titulo}</h2>
        <h5 className="text-md font-extralight">{subtitulo}</h5>
      </div>
      <div className="pb-10">
        <a href={link} className="text-blue-700 hover:underline">Ver todos</a>
      </div>
    </div>
    <table className="min-w-full divide-y divide-gray-200 rounded-lg overflow-hidden">
      <thead className="bg-gray-50">
        <tr>
          {columnas.map((columna, index) => (
            <th key={index} className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
              {columna}
            </th>
          ))}
        </tr>
      </thead>
      <tbody className="bg-white divide-y divide-gray-200">
        {datos.map((fila, index) => (
          <tr key={index}>
            {Object.values(fila).map((valor, i) => (
              <td key={i} className="px-6 py-4 whitespace-nowrap">
                {valor}
              </td>
            ))}
          </tr>
        ))}
      </tbody>
    </table>
  </div>
);

export default TablaAdmin;
