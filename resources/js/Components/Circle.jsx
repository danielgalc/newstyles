// CircleWithImage.jsx
import React from 'react';

const Circle = ({ imageUrl, size = 64, name}) => {
  return (
    <div className="flex flex-col items-center">
      <div className={`rounded-full w-${size} h-${size} overflow-hidden teal-shadow-2`}>
        <img
          src={imageUrl}
          alt="..."
          className="object-cover w-full h-full"
        />
      </div>
      <div className="text-custom-size mt-2 text-gray-900 text-center">{name}</div>
    </div>
  );
};

export default Circle;