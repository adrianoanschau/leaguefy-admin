import { usePage } from '@inertiajs/react';
import Master from '../../Layouts/Master';
import { Form } from '../../Components/Form';

export default function TournamentsForm() {
  const {
    props: { id, data, games },
  } = usePage();

  return (
    <Master header="Tournaments">
      <Master.Content>
        <Form
          name="tournament"
          fields={[
            { column: 'name' },
            { column: 'game.slug', label: 'Game', options: games },
          ]}
          id={id}
          data={data}
        />
      </Master.Content>
    </Master>
  );
}
