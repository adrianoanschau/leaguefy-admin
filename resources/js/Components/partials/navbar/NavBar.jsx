import { Navbar, Nav, NavDropdown } from 'react-bootstrap';
import { Link } from '@inertiajs/react';
import { BrandLogo } from '../common';
import { useAuth, useConfig, useMenu } from '../../../hooks';

export const NavBar = () => {
  const { user } = useAuth();
  const { config } = useConfig();
  const menu = useMenu();

  return (
    <Navbar expand="lg" className={`${config('classes_brand', '')}`}>
      <BrandLogo />
      <Navbar.Toggle aria-controls="topbar-nav" />
      <Navbar.Collapse id="topbar-nav">
        <Nav className="me-auto">
          {menu('navbar-left').map((item) => {
            <Nav.Link key={JSON.stringify(item)} href={item?.url}>
              {item?.text}
            </Nav.Link>;
          })}
        </Nav>
        <Nav className="ms-auto">
          <NavDropdown title={user?.name} id="user-menu">
            <NavDropdown.Item
              as={Link}
              href={route(config('logout_route', '#'))}
              method="post"
            >
              <i className="fas fa-fw fa-sign-out-alt"></i>
              <span>Sair</span>
            </NavDropdown.Item>
          </NavDropdown>
          {/* <Nav.Link data-widget="control-sidebar">
            <i className="fas fa-fw fa-cogs"></i>
          </Nav.Link> */}
        </Nav>
      </Navbar.Collapse>
    </Navbar>
  );
};
