import { usePage } from '@inertiajs/react';

export function useAuth() {
  const {
    props: { auth },
  } = usePage();

  return auth;
}
