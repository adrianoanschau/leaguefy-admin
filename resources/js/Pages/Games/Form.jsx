import { usePage } from '@inertiajs/react';
import Master from '../../Layouts/Master';
import { Form } from '../../Components/Form';

export default function GamesForm() {
  const {
    props: { id, data },
  } = usePage();

  return (
    <Master header="Games">
      <Master.Content>
        <Form name="game" fields={[{ column: 'name' }]} id={id} data={data} />
      </Master.Content>
    </Master>
  );
}
