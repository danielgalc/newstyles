import React from 'react';

const Banner = ({ text }) => {
    return (
        <div className="w-full h-24 flex items-center justify-center bg-teal-400 shadow-md">
            <h2 className="banner-text text-4xl text-gray-800 leading-tight">
                {text}
            </h2>
        </div>
    );
};

export default Banner;
