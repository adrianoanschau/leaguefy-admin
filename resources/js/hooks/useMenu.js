import { usePage } from '@inertiajs/react';

export function useMenu() {
  const {
    props: { menu },
  } = usePage();

  return (name) => menu[name];
}
