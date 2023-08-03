import { usePage } from '@inertiajs/react';
import Master from '../../Layouts/Master';
import { Form } from '../../Components/Form';

export default function TeamsForm() {
  const {
    props: { games, data, id },
  } = usePage();

  return (
    <Master header="Teams">
      <Master.Content>
        <Form
          name="team"
          fields={[
            { column: 'name' },
            {
              column: 'game.slug',
              name: 'game',
              label: 'Game',
              options: games,
            },
          ]}
          id={id}
          data={data}
        />
      </Master.Content>
    </Master>
  );
}
