import { usePage } from '@inertiajs/react';
import { dotNotationAccessor } from '../helpers';

export function useConfig() {
  const {
    props: { config },
  } = usePage();

  return {
    config: (name, defaultValue) =>
      dotNotationAccessor(config, name) || defaultValue || '',
    has: (name) => !!dotNotationAccessor(config, name),
  };
}
