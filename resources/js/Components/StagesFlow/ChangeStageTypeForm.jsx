import { useCallback, useRef, useState } from 'react';
import { useForm } from '@inertiajs/react';
import {
  Button,
  ButtonGroup,
  Form,
  ListGroup,
  Overlay,
  Popover,
} from 'react-bootstrap';
import { useXarrow } from 'react-xarrows';

const types = [
  ['SINGLE', 'square', 'Grupo Único'],
  ['MULTIPLE', 'th-large', 'Múltiplos Grupos'],
  ['ELIMINATION', 'sitemap', 'Eliminatória'],
  ['FINAL', 'grip-lines', 'Final'],
];

export function ChangeStageTypeForm({ tournament, stage }) {
  const [show, setShow] = useState(false);
  const target = useRef(null);
  const updateXarrow = useXarrow();

  const { data, put, setData } = useForm({
    type: '',
  });

  const handleSubmit = useCallback(
    (event) => {
      event.preventDefault();

      if (stage.type === data.type) return;

      put(
        route('leaguefy.admin.stages.update', {
          tournament: tournament.id,
          stage: stage.id,
        }),
        {
          preserveScroll: true,
          type: data.type,
        },
      );

      updateXarrow();
      setShow(false);
    },
    [tournament, stage, data],
  );

  return (
    <>
      <ButtonGroup
        className="w-100"
        ref={target}
        onClick={() => setShow(!show)}
      >
        {types.map(([type, icon]) => (
          <Button
            key={type}
            className="rounded-0 p-1"
            variant={stage.type === type ? 'primary' : 'default'}
            size="sm"
          >
            <i className={`fas fa-fw fa-${icon}`}></i>
          </Button>
        ))}
      </ButtonGroup>

      <Overlay target={target.current} show={show} placement="bottom">
        <Popover>
          <ListGroup as={Form} onSubmit={handleSubmit}>
            {types.map(([type, icon, label]) => (
              <ListGroup.Item
                key={type}
                action
                className={stage.type === type ? 'active' : ''}
                onClick={() => setData('type', type)}
              >
                <i className={`fas fa-fw fa-${icon}`}></i>
                <span className="ms-2">{label}</span>
              </ListGroup.Item>
            ))}
          </ListGroup>
        </Popover>
      </Overlay>
    </>
  );
}
