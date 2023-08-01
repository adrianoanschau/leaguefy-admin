import { usePage } from '@inertiajs/react';
import Master from '../../Layouts/Master';
import { Grid } from '../../Components/Grid';

export default function GamesList() {
  const { props } = usePage();

  return (
    <Master header="Games">
      <Grid name="game" columns={props.columns} data={props.data} />
    </Master>
  );
}
