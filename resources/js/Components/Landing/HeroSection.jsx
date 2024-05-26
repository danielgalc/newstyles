// HeroSection.js

import React from 'react';

function HeroSection() {
  return (
    <div className="flex items-center">
      <div className="h-96 w-full relative">
        <video src="/videos/videofinal.mp4" autoPlay loop muted class="w-full h-full object-cover"></video>
        <div className="absolute inset-0 bg-gradient-to-r from-transparent via-transparent to-white"></div>
      </div>

      <div className="w-2/4 p-8 flex flex-col items-center justify-center">
        <p className="text-gray-800 font-bold text-xl text-center mb-4">
          Descubre la experiencia de belleza en Newstyles, donde cada corte es una obra maestra. Nuestros estilistas expertos están aquí para realzar tu estilo único y dejarte sintiéndote renovado.
          <br /><br />¡Bienvenid@ a un mundo de elegancia y estilo!
        </p>
        <button className="bg-teal-500 hover:bg-teal-700 rounded-md px-8 py-4 shadow-md text-white font-bold text-lg transform transition-transform duration-300 ease-in-out hover:scale-105"><a href="/servicios">¡Reserva tu cita ahora!</a></button>
      </div>
    </div>
  );
}

export default HeroSection;
