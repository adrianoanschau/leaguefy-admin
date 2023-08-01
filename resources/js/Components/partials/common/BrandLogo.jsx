import { Navbar } from 'react-bootstrap';
import { Link } from '@inertiajs/react';
import { useConfig } from '../../../hooks';

export const BrandLogo = () => {
  const { config, has } = useConfig();

  function brandClasses() {
    const classes_brand = config('classes_brand', '');

    if (!has('topbar.color')) {
      return classes_brand;
    }

    return classes_brand
      .split(' ')
      .map((className) => {
        if (!className.includes('bg-')) return className;

        return config('topbar.color');
      })
      .join(' ');
  }

  return (
    <Navbar.Brand
      as={Link}
      href={route(config('dashboard_route'))}
      className={`brand-link ${brandClasses()}`}
    >
      <div
        className={`${config(
          'logo_img_class',
          'brand-image img-circle elevation-3',
        )} bg-light d-flex justify-content-center align-items-center`}
        style={{ width: 32, height: 32, opacity: 0.8 }}
      >
        <i className="fas fa-fw fa-trophy text-muted"></i>
      </div>
      <span
        className={`brand-text font-weight-light ${config(
          'topbar.logo_color',
          'text-dark',
        )} ${config('classes_brand_text')}`}
      >
        <strong>{config('logo', 'Leaguefy Admin')}</strong>
      </span>
    </Navbar.Brand>
  );
};
