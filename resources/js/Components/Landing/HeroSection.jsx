import React from 'react';

function HeroSection() {
  return (
    <div className="relative flex flex-col items-center md:flex-row">
      <div className="h-64 md:h-96 w-full relative">
        <video src="/videos/videofinal.mp4" autoPlay loop muted className="w-full h-full object-cover"></video>
        <div className="absolute inset-0 bg-gradient-to-r from-transparent via-transparent to-white max-[400px]:hidden"></div>

        <div className="sm:hidden max-[400px]:absolute max-[400px]:inset-0 flex flex-col items-center justify-center p-4 max-[400px]:bg-black max-[400px]:bg-opacity-50">
          <p className=" text-white font-bold text-sm text-center mb-2 max-[400px]:text-xs max-[400px]:p-2">
            Descubre la experiencia de belleza en Newstyles, donde cada corte es una obra maestra. Nuestros estilistas expertos están aquí para realzar tu estilo único y dejarte sintiéndote renovado.
            <br /><br />¡Bienvenid@ a un mundo de elegancia y estilo!
          </p>
          <button className="bg-teal-500 hover:bg-teal-700 rounded-md px-4 py-2 shadow-md text-white font-bold text-sm transform transition-transform duration-300 ease-in-out hover:scale-105 max-[400px]:text-xs max-[400px]:px-2 max-[400px]:py-1">
            <a href="/servicios">¡Reserva tu cita ahora!</a>
          </button>
        </div>
      </div>

      <div className="hidden w-full md:w-2/4 p-4 md:p-8 flex-col items-center justify-center md:flex">
        <p className="text-gray-800 font-bold text-sm md:text-xl text-center mb-2 md:mb-4">
          Descubre la experiencia de belleza en Newstyles, donde cada corte es una obra maestra. Nuestros estilistas expertos están aquí para realzar tu estilo único y dejarte sintiéndote renovado.
          <br /><br />¡Bienvenid@ a un mundo de elegancia y estilo!
        </p>
        <button className="bg-teal-500 hover:bg-teal-700 rounded-md px-4 md:px-8 py-2 md:py-4 shadow-md text-white font-bold text-sm md:text-lg transform transition-transform duration-300 ease-in-out hover:scale-105">
          <a href="/servicios">¡Reserva tu cita ahora!</a>
        </button>
      </div>
    </div>
  );
}

export default HeroSection;
