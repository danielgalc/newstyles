import React from 'react';

function FeatureSection() {
  return (
    <div className="bg-white w-full flex items-center justify-center my-8">
      <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-8 sm:gap-24">
        <div className="group bg-teal-500 w-full sm:w-64 h-64 rounded-md shadow-md flex flex-col items-center justify-center text-white transition-transform duration-500 transform hover:scale-110 hover:bg-gray-900 hover:text-white">
          <img src="ruta/a/tu/logo1.png" alt="Logo 1" className="mb-2" />
          <h2 className="text-xl sm:text-2xl font-bold mb-2">+2K CLIENTES</h2>
          <p className="text-center text-sm sm:text-base">Cada vez son más los que confían en nosotros.</p>
        </div>
        <div className="group bg-white w-full sm:w-64 h-64 rounded-md shadow-md flex flex-col items-center justify-center text-black transition-transform duration-500 transform hover:scale-110 hover:bg-gray-900 hover:text-white">
          <img src="ruta/a/tu/logo2.png" alt="Logo 2" className="mb-2" />
          <h2 className="text-xl sm:text-2xl font-bold mb-2">EXPERIENCIA</h2>
          <p className="text-center text-sm sm:text-base">Más de una década en funcionamiento.</p>
        </div>
        <div className="group bg-teal-500 w-full sm:w-64 h-64 rounded-md shadow-md flex flex-col items-center justify-center text-white transition-transform duration-500 transform hover:scale-110 hover:bg-gray-900 hover:text-white">
          <img src="ruta/a/tu/logo3.png" alt="Logo 3" className="mb-2" />
          <h2 className="text-xl sm:text-2xl font-bold mb-2">SERVICIOS</h2>
          <p className="text-center text-sm sm:text-base">Disfruta de todos nuestros servicios a un precio económico.</p>
        </div>
        <div className="group bg-white w-full sm:w-64 h-64 rounded-md shadow-md flex flex-col items-center justify-center text-black transition-transform duration-500 transform hover:scale-110 hover:bg-gray-900 hover:text-white">
          <img src="ruta/a/tu/logo4.png" alt="Logo 4" className="mb-2" />
          <h2 className="text-xl sm:text-2xl font-bold mb-2">PRODUCTOS</h2>
          <p className="text-center text-sm sm:text-base">Elige entre una amplia gama de productos de alta calidad.</p>
        </div>
        <div className="group bg-teal-500 w-full sm:w-64 h-64 rounded-md shadow-md flex flex-col items-center justify-center text-white transition-transform duration-500 transform hover:scale-110 hover:bg-gray-900 hover:text-white">
          <img src="ruta/a/tu/logo5.png" alt="Logo 5" className="mb-2" />
          <h2 className="text-xl sm:text-2xl font-bold mb-2">CRECIMIENTO</h2>
          <p className="text-center text-sm sm:text-base">Evolucionamos para crecer juntos, adaptándonos a las nuevas necesidades.</p>
        </div>
      </div>
    </div>
  );
}

export default FeatureSection;
