// Landing.js

import React from 'react';
import HeroSection from '@/Components/Landing/HeroSection';
import FeatureSection from '@/Components/Landing/FeatureSection';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import GuestLayout from '@/Layouts/GuestLayout';
import ReviewsSection from '@/Components/Landing/ReviewSection';


function App({ auth }) {
  return (
    <div className="App">
      {auth.user ? (
        <AuthenticatedLayout user={auth.user}>
          <HeroSection />
          <FeatureSection />
          <ReviewsSection />
        </AuthenticatedLayout>
      ) : (
        <GuestLayout>
          <HeroSection />
          <FeatureSection />
          <ReviewsSection />
        </GuestLayout>
      )}
    </div>
  );
}
export default App;
