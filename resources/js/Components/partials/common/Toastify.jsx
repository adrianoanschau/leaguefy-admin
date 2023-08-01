import { useEffect } from 'react';
import { ToastContainer, toast } from 'react-toastify';
import { usePage } from '@inertiajs/react';
import 'react-toastify/dist/ReactToastify.css';

export function Toastify() {
  const {
    props: { toastr },
  } = usePage();

  useEffect(() => {
    if (!toastr?.type || !toastr?.message) return;

    toast[toastr.type](toastr.message);
  }, [toastr?.type, toastr?.message]);

  return <ToastContainer />;
}
