import React from 'react';

const Hero = ({ imageUrl }) => {
  return (
    <div className="h-96 w-full relative overflow-hidden">
      <img src={imageUrl} alt="Imagen" className="w-full h-96 object-cover bg-black" />

      <div className="absolute inset-0 bg-gradient-to-r from-transparent via-black to-transparent animate-slide-down"></div>

        <div className="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 text-white font-bold text-xl animate-fade-in">
          <p className="font-italic">¡Bienvenido a <span className="font-righteous text-teal-400">NEWSTYLES</span>, tu destino de belleza y estilo en el corazón de la ciudad! En NewStyles, nos enorgullece ofrecerte una experiencia única donde la pasión por la belleza se une con la innovación y la atención personalizada.</p>
          <br />
          <p>Nuestro equipo de expertos estilistas está dedicado a brindarte resultados excepcionales que reflejen tu estilo individual y realcen tu belleza natural. Desde cortes de pelo modernos y atrevidos hasta peinados elegantes y sofisticados, estamos aquí para ayudarte a expresar tu verdadero yo con confianza y estilo.</p>
          <br />
          <p>Además de ofrecerte servicios de peluquería de primera clase, en NewStyles también nos apasiona mantenerte al día con las últimas tendencias y técnicas de belleza. ¡No te pierdas nuestras sesiones de asesoramiento personalizado y nuestros eventos especiales para que siempre estés a la vanguardia en estilo!</p>
        </div>
      </div>
  );
};

export default Hero;
