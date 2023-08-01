import { usePage } from '@inertiajs/react';
import Master from '../../Layouts/Master';
import { Form } from '../../Components/Form';

export default function GamesForm() {
  const { props } = usePage();

  return (
    <Master header="Games">
      <Form name="game" fields={props.fields} id={props.id} data={props.data} />
    </Master>
  );
}
