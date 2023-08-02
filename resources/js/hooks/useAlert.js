import { useCallback } from 'react';
import Swal from 'sweetalert2';
import withReactContent from 'sweetalert2-react-content';

const Alert = withReactContent(Swal);

export function useAlert() {
  const confirm = useCallback(
    (title, text = null, icon = null, html = null) => {
      return new Promise((resolve) => {
        return Alert.fire({
          title,
          text,
          icon,
          html,
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Sim',
          cancelButtonText: 'Não',
          preConfirm: resolve,
        });
      });
    },
    [],
  );

  return { confirm };
}
