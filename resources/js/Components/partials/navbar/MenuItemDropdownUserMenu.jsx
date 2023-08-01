import { useAuth, useConfig } from '../../../hooks';
import { DropdownItem } from './DropdownItem';

export const MenuItemDropdownUserMenu = () => {
  const { user } = useAuth();
  const { config } = useConfig();

  return (
    <li className="nav-item dropdown user-menu">
      <a href="#" className="nav-link dropdown-toggle" data-toggle="dropdown">
        {config('usermenu_image', false) && (
          <img
            src={user.image}
            alt={user.name}
            className="user-image img-circle elevation-2"
          />
        )}
        {!config('usermenu_image', false) && (
          <span className="d-none d-md-inline">{user.name}</span>
        )}
      </a>

      <ul className="dropdown-menu dropdown-menu-lg dropdown-menu-right">
        {config('usermenu_header', false) && (
          <li
            className={`user-header ${config(
              'usermenu_header_class',
              'bg-primary',
            )}`}
          >
            {config('usermenu_image') && (
              <img
                src={user.image}
                className="img-circle elevation-2"
                alt={user.name}
              />
            )}

            <p className={!config('usermenu_image') ? 'mt-0' : ''}>
              {user.name}
              {config('usermenu_desc') && <small>{user.description}</small>}
            </p>
          </li>
        )}
        <DropdownItem item={{ text: 'Profile', url: '#' }} />
        <DropdownItem item={{ text: 'Logout', url: '#' }} />
      </ul>
    </li>
  );
};
