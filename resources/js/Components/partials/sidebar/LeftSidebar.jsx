import { Nav } from 'react-bootstrap';
import { useConfig, useMenu } from '../../../hooks';
import { MenuItem } from './MenuItem';
import { Link } from '@inertiajs/react';

export const LeftSidebar = () => {
  const { config } = useConfig();
  const menu = useMenu();

  return (
    <aside
      className={`main-sidebar pt-3 ${config(
        'classes_sidebar',
        'sidebar-dark-primary elevation-4',
      )}`}
      style={{ top: 'unset' }}
    >
      <div className="sidebar">
        <Nav
          variant="pills"
          className={` nav-sidebar flex-column ${config(
            'classes_sidebar_nav',
            '',
          )}`}
          data-widget="treeview"
          role="menu"
        >
          {menu('sidebar').map((item) => (
            <Nav.Item key={JSON.stringify(item)}>
              <Nav.Link href={item?.href} as={Link}>
                <i className={item?.icon ?? 'far fa-fw fa-circle'}></i>
                <span className="ms-2">{item?.text}</span>
              </Nav.Link>
            </Nav.Item>
          ))}
        </Nav>
      </div>
    </aside>
  );
};
