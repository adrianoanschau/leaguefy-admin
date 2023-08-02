import { Container, ThemeProvider } from 'react-bootstrap';
import { Alerts, Toastify } from '../Components/partials/common';
import { LeftSidebar, RightSidebar } from '../Components/partials/sidebar';
import { NavBar } from '../Components/partials/navbar';
import { Footer } from '../Components/partials/footer';
import { Children } from 'react';

export default function Master({ header, children }) {
  return (
    <ThemeProvider>
      <Container className="wrapper p-0" fluid>
        <NavBar />
        <LeftSidebar />

        <main id="main" className="content-wrapper">
          {header && (
            <div className="content-header">
              <Container
                className="d-flex justify-content-between align-items-center"
                fluid
              >
                <h1>{header}</h1>
                <div className="d-flex align-items-center">
                  {Children.toArray(children).filter((child) => {
                    return child.type === Master.Actions;
                  })}
                </div>
              </Container>
            </div>
          )}

          <div className="border-top m-3"></div>

          <div className="content">
            <Container fluid>
              <Alerts />
              <div id="app">
                {Children.toArray(children).filter((child) => {
                  return child.type === Master.Content;
                })}
              </div>
            </Container>
          </div>
        </main>
        <Footer />
        <Toastify />
        <RightSidebar />
      </Container>
    </ThemeProvider>
  );
}

Master.Actions = ({ children }) => {
  return <>{children}</>;
};

Master.Content = ({ children }) => {
  return <>{children}</>;
};
