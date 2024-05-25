import React from 'react';

const Gallery = () => {
  return (
    <div className="w-full grid grid-cols-3 bg-gray-800 px-72 flex justify-between">
      <div>
        <img className="h-auto w-4/5 rounded-lg mb-8 circle-shadow" src="/images/quienes-somos/foto1.jpg" alt="" />
      </div>
      <div>
        <img className="h-auto w-4/5 rounded-lg circle-shadow" src="/images/quienes-somos/foto2.jpg" alt="" />
      </div>
      <div>
        <img className="h-auto w-4/5 rounded-lg circle-shadow" src="/images/quienes-somos/foto3.jpg" alt="" />
      </div>
      <div>
        <img className="h-auto w-4/5 rounded-lg circle-shadow" src="/images/quienes-somos/foto4.jpg" alt="" />
      </div>
      <div>
        <img className="h-auto w-4/5 rounded-lg circle-shadow" src="/images/quienes-somos/foto5.png" alt="" />
      </div>      
      <div>
        <img className="h-auto w-4/5 rounded-lg mb-20 circle-shadow" src="/images/quienes-somos/foto6.jpg" alt="" />
      </div>
    </div>
  );
};

export default Gallery;
