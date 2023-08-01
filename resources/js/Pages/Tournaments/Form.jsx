import { usePage } from '@inertiajs/react';
import Master from '../../Layouts/Master';
import { Form } from '../../Components/Form';

export default function TournamentsForm() {
  const { props } = usePage();

  return (
    <Master header="Tournaments">
      <Form
        name="tournament"
        fields={props.fields}
        id={props.id}
        data={props.data}
      />
    </Master>
  );
}
