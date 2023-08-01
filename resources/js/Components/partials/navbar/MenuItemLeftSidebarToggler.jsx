import { Link } from '@inertiajs/react';
import { useConfig } from '../../../hooks';

export const MenuItemLeftSidebarToggler = () => {
  const { config } = useConfig();

  return (
    <li className="nav-item">
      <Link
        className="nav-link"
        data-widget="pushmenu"
        href="#"
        data-enable-remember={config('sidebar_collapse_remember', true)}
        data-no-transition-after-reload={config(
          'sidebar_collapse_remember_no_transition',
          false,
        )}
        data-auto-collapse-size={config('sidebar_collapse_auto_size')}
      >
        <i className="fas fa-bars"></i>
        <span className="sr-only">Trocar navegação</span>
      </Link>
    </li>
  );
};
