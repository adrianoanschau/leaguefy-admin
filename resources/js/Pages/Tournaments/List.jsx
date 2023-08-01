import { usePage } from '@inertiajs/react';
import Master from '../../Layouts/Master';
import { Grid } from '../../Components/Grid';

export default function TournamentsList() {
  const { props } = usePage();

  return (
    <Master header="Tournaments">
      <Grid name="tournament" columns={props.columns} data={props.data} />
    </Master>
  );
}
