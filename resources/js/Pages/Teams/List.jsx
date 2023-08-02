import { usePage } from '@inertiajs/react';
import Master from '../../Layouts/Master';
import { Grid } from '../../Components/Grid';

export default function TeamsList() {
  const {
    props: { data },
  } = usePage();

  return (
    <Master header="Teams">
      <Master.Content>
        <Grid
          name="team"
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
