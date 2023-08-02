import { usePage } from '@inertiajs/react';
import Master from '../../Layouts/Master';
import { Grid } from '../../Components/Grid';

export default function GamesList() {
  const {
    props: { data },
  } = usePage();

  return (
    <Master header="Games">
      <Master.Content>
        <Grid
          name="game"
          columns={[
            {
              column: 'name',
              avatar: 'logo',
              subtitle: 'slug',
            },
            'slug',
          ]}
          data={data}
        />
      </Master.Content>
    </Master>
  );
}
