import { usePage } from '@inertiajs/react';
import Master from '../../Layouts/Master';
import { Grid } from '../../Components/Grid';

export default function TeamsList() {
  const { props } = usePage();

  return (
    <Master header="Teams">
      <Grid name="team" columns={props.columns} data={props.data} />
    </Master>
  );
}
