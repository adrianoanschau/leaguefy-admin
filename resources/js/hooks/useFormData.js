import { useForm } from '@inertiajs/react';
import { dotNotationAccessor } from '../helpers';

export const useFormData = (fields, data) => {
  const formData = fields.reduce((acc, field) => {
    acc[field.column] = !!data ? dotNotationAccessor(data, field.column) : '';

    return acc;
  }, {});

  return useForm(formData);
};
