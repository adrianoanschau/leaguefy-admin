import { usePage } from '@inertiajs/react';
import Master from '../../Layouts/Master';
import { Grid } from '../../Components/Grid';

export default function TournamentsList() {
  const {
    props: { data },
  } = usePage();

  return (
    <Master header="Tournaments">
      <Master.Content>
        <Grid
          name="tournament"
          columns={[
            {
              column: 'name',
              avatar: 'logo',
              subtitle: 'slug',
            },
            'slug',
            {
              column: 'status',
              badge: 'primary',
            },
            {
              label: 'Stages',
              classes: 'text-center',
              link_route: 'stages',
              link_icon: 'fa-sitemap',
            },
          ]}
          data={data}
        />
      </Master.Content>
    </Master>
  );
}
