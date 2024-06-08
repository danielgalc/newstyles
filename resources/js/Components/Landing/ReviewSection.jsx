import React from 'react';

function ReviewsSection() {
  // Datos de las reseñas (puedes reemplazar esto con datos reales)
  const reviews = [
    { id: 1, text: "¡Excelente servicio y atención al cliente!", author: "Juan Pérez" },
    { id: 2, text: "Me encantó mi experiencia en Newstyles, definitivamente volveré.", author: "María López" },
    { id: 3, text: "Los estilistas son muy talentosos y amables.", author: "Pedro Rodríguez" },
    { id: 4, text: "Recomiendo Newstyles a todos mis amigos.", author: "Ana García" },
    { id: 5, text: "El ambiente es acogedor y relajante.", author: "Luis Martínez" },
    { id: 6, text: "¡5 estrellas! No tengo nada más que elogios para este lugar.", author: "Laura Sánchez" }
  ];

  return (
    <div className="bg-teal-400 p-4 sm:p-8 min-h-full flex flex-col items-center justify-center">
      <h1 className="text-black text-2xl sm:text-4xl font-bold mb-4 sm:mb-8">¡Echa un vistazo a las reseñas de los usuarios!</h1>

      <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-16">
        {reviews.map(review => (
          <div key={review.id} className="bg-white p-4 flex flex-col justify-between rounded-lg shadow-md transform transition duration-300 ease-in-out hover:scale-105">
            <p className="text-gray-800 text-sm sm:text-base">{review.text}</p>
            <p className="text-gray-600 text-xs sm:text-sm mt-2">- {review.author}</p>
          </div>
        ))}
      </div>
    </div>
  );
}

export default ReviewsSection;
