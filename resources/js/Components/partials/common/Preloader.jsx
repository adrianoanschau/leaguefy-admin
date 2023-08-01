import { useConfig } from '../../../hooks';

export const Preloader = () => {
  const { config } = useConfig();

  return (
    <div className="preloader flex-column justify-content-center align-items-center">
      <img
        src={`${config(
          'preloader.img.path',
          '/vendor/adminlte/dist/img/AdminLTELogo.png',
        )}`}
        className={`${config('preloader.img.effect', 'animation__shake')}`}
        alt={`${config('preloader.img.alt', 'AdminLTE Preloader Image')}`}
        width={`${config('preloader.img.width', 60)}`}
        height={`${config('preloader.img.height', 60)}`}
      />
    </div>
  );
};
