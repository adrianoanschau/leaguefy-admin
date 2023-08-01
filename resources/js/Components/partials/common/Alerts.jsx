import { usePage } from '@inertiajs/react';
import Alert from 'react-bootstrap/Alert';

const colors = {
  error: 'danger',
  success: 'success',
  info: 'info',
  warning: 'warning',
};

export const Alerts = () => {
  const {
    props: { alert },
  } = usePage();

  return (
    <>
      {Object.entries(alert)
        .filter(([, value]) => !!value)
        .map(([type, { title, message }]) => (
          <Alert key={type} variant={colors[type]} dismissible>
            <Alert.Heading>{title}</Alert.Heading>
            <p>{message}</p>
          </Alert>
        ))}
    </>
  );
};
