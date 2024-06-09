import React from 'react';
import Circle from '../Circle';


const Team = () => {
  return (
    <div className="mx-auto my-2 text-center font-righteous text-4xl text-gray-800 leading-tight">
      Nuestro equipo
      <div className="mx-auto flex justify-between w-3/5 my-6">
        {/* Círculo 1 */}
        <Circle imageUrl="https://previews.123rf.com/images/sandyche/sandyche1605/sandyche160500681/57252869-mujer-peluquera-profesional-muy-atractiva-y-con-estilo-con-tijeras-mujer-de-peluquer%C3%ADa-expresa.jpg" name="Alba Rivero" />
        {/* Círculo 2 */}
        <Circle imageUrl="https://previews.123rf.com/images/lightfieldstudios/lightfieldstudios2211/lightfieldstudios221104615/194219323-hombre-alegre-en-capa-de-peluquer%C3%ADa-sentado-cerca-de-barbero-en-barber%C3%ADa.jpg" name="Pepe Pérez"/>
        {/* Círculo 3 */}
        <Circle imageUrl="https://previews.123rf.com/images/kzenon/kzenon1411/kzenon141101926/33766087-peluquer%C3%ADa-recorte-pelo-hombre-en-la-tienda-de-peluquero.jpg" name="Juan Antonio González"/>
      </div>
    </div>
  );
};

export default Team;
