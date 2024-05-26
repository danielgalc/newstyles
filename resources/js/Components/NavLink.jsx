import React from 'react';
import { Link } from '@inertiajs/react';

function NavLink({ active = false, children, ...props }) {
  return (
    <Link
      {...props}
      className={
        'text-white text-3xl font-custom font-semibold transition-all duration-300 transform hover:text-teal-500 hover:scale-105 ' +
        (active
          ? 'text-teal-500 scale-105 '
          : 'hover:text-teal-500 hover:scale-105 ')
      }
    >
      {children}
    </Link>
  );
}

export default NavLink;
