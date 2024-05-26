import React from 'react';
import Banner from '@/Components/Banner';
import Hero from '@/Components/QuienesSomos/Hero';
import Team from '@/Components/QuienesSomos/Equipo';
import Gallery from '@/Components/QuienesSomos/Gallery';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import GuestLayout from '@/Layouts/GuestLayout';

const QuienesSomos = ({ auth }) => {
  return (
    <div className="QuienesSomos">
      {auth.user ? (
        <AuthenticatedLayout user={auth.user}>
          <Banner text="¿Quiénes somos?" />
          <Hero imageUrl="images/quienes-somos-img.jpg" />
          <div>
            <h2 className="mx-auto text-center font-righteous text-4xl bg-gray-800 text-white leading-tight py-4">
              ¡Echa un vistazo a nuestro trabajo!
            </h2>
          </div>
          <Gallery />
          <Team />
        </AuthenticatedLayout>
      ) : (
        <GuestLayout>
          <Banner text="¿Quiénes somos?" />
          <Hero imageUrl="images/quienes-somos-img.jpg" />
          <div>
            <h2 className="mx-auto text-center font-righteous text-4xl bg-gray-800 text-white leading-tight py-4">
              ¡Echa un vistazo a nuestro trabajo!
            </h2>
          </div>
          <Gallery />
          <Team />
        </GuestLayout>
      )}
    </div>
  );
};

export default QuienesSomos;
