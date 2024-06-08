import React from 'react';

function HeroSection() {
  return (
    <div className="relative w-full flex items-center justify-center sm:flex-row sm:justify-between sm:h-96">
      <div className="h-64 sm:h-96 w-full relative">
        <video src="/videos/videofinal.mp4" autoPlay loop muted className="w-full h-full object-cover"></video>
        <div className="absolute inset-0 bg-black opacity-50 sm:hidden"></div>
        <div className="absolute inset-0 bg-gradient-to-r from-transparent via-transparent to-white hidden sm:block"></div>
      </div>

      <div className="absolute inset-0 sm:relative sm:w-2/4 p-8 flex flex-col items-center justify-center text-center sm:text-left z-10">
        <p className="text-white sm:text-gray-800 font-bold text-lg sm:text-xl mb-4">
          <span className="block sm:hidden">
            Descubre la experiencia de belleza en Newstyles.
            <br /><br />¡Bienvenid@ a un mundo de elegancia y estilo!
          </span>
          <span className="hidden sm:block">
            Descubre la experiencia de belleza en Newstyles, donde cada corte es una obra maestra. Nuestros estilistas expertos están aquí para realzar tu estilo único y dejarte sintiéndote renovado.
            <br /><br />¡Bienvenid@ a un mundo de elegancia y estilo!
          </span>
        </p>
        <button className="bg-teal-500 hover:bg-teal-700 rounded-md px-4 sm:px-8 py-2 sm:py-4 shadow-md text-white font-bold text-md sm:text-lg transform transition-transform duration-300 ease-in-out hover:scale-105">
          <a href="/servicios">¡Reserva tu cita ahora!</a>
        </button>
      </div>
    </div>
  );
}

export default HeroSection;

