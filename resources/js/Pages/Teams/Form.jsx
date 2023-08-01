import { usePage } from '@inertiajs/react';
import Master from '../../Layouts/Master';
import { Form } from '../../Components/Form';

export default function TeamsForm() {
  const { props } = usePage();

  return (
    <Master header="Teams">
      <Form name="team" fields={props.fields} id={props.id} data={props.data} />
    </Master>
  );
}
