import { useConfig } from '../hooks';
import { Alerts, Preloader, Toastify } from '../Components/partials/common';
import { LeftSidebar, RightSidebar } from '../Components/partials/sidebar';
import { NavBar } from '../Components/partials/navbar';
import { Footer } from '../Components/partials/footer';

export default function Master({ header, children }) {
  const { config } = useConfig();

  return (
    <>
      <div className="wrapper">
        {/* {config('preloader.enabled', false) && <Preloader />} */}
        <NavBar />
        <LeftSidebar />

        <main
          id="main"
          className={`content-wrapper ${config('classes_content_wrapper', '')}`}
        >
          {header && (
            <div className="content-header">
              <div
                className={config('classes_content_header', 'container-fluid')}
              >
                <h1>{header}</h1>
              </div>
            </div>
          )}

          <div className="border-top m-3"></div>

          <div className="content">
            <div className={config('classes_content', 'container-fluid')}>
              <Alerts />
              <div id="app">{children}</div>
            </div>
          </div>
        </main>
        <Footer />
        <Toastify />
        <RightSidebar />
      </div>
    </>
  );
}
