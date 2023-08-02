import { useCallback, useState } from 'react';
import { router, usePage } from '@inertiajs/react';
import {
  Button,
  ButtonGroup,
  Card,
  Dropdown,
  Form,
  ListGroup,
  Modal,
  Stack,
} from 'react-bootstrap';
import Xarrow, { useXarrow } from 'react-xarrows';
import Master from '../../Layouts/Master';
import { useAlert } from '../../hooks';

const types = {
  SINGLE: 'Grupo Único',
  MULTIPLE: 'Múltiplos Grupos',
  ELIMINATION: 'Eliminatória',
  FINAL: 'Final',
};

export default function StagesFlow() {
  const {
    props: { tournament, lanes },
  } = usePage();
  const alert = useAlert();
  const [stageSelected, setStageSelected] = useState(null);
  const updateXarrow = useXarrow();
  const [connectionSelected, setConnectionSelected] = useState(null);
  const [connectionLane, setConnectionLane] = useState(null);
  const [connectionStages, setConnectionStages] = useState([]);
  const [connectionSide, setConnectionSide] = useState(null);

  const stageName = useCallback(
    (name = null, stageKey, laneKey) => {
      if (name) return name;

      const sequence = lanes
        .filter((_, key) => key < laneKey)
        .reduce((acc, lane) => acc + lane.length, 1);

      return `Etapa ${sequence + stageKey}`;
    },
    [lanes],
  );

  const handleNewLane = useCallback(
    (laneInsert) => {
      router.post(
        route('leaguefy.admin.stages.store', { tournament: tournament.id }),
        {
          preserveScroll: true,
          laneInsert,
        },
      );
      updateXarrow();
    },
    [tournament],
  );

  const handleNewStage = useCallback(
    (lane, positionInsert) => {
      router.post(
        route('leaguefy.admin.stages.store', { tournament: tournament.id }),
        {
          preserveScroll: true,
          positionInsert,
          lane,
        },
      );
      updateXarrow();
    },
    [tournament],
  );

  const handleChangeType = useCallback(
    (type, stage) => {
      if (stage.type === type) return;
      router.put(
        route('leaguefy.admin.stages.update', {
          tournament: tournament.id,
          stage: stage.id,
        }),
        {
          preserveScroll: true,
          type,
        },
      );
      updateXarrow();
    },
    [tournament],
  );

  const handleEditStage = useCallback(
    (event) => {
      event.preventDefault();
      router.put(
        route('leaguefy.admin.stages.update', {
          tournament: tournament.id,
          stage: stageSelected.id,
        }),
        {
          preserveScroll: true,
          name: stageSelected.name,
        },
      );
      setStageSelected(null);
      updateXarrow();
    },
    [stageSelected],
  );

  const handleRemoveStage = useCallback(
    async (stageId) => {
      await alert.confirm(
        'Você tem certeza?',
        'Esta ação é irreversível!',
        'warning',
      );

      router.delete(
        route('leaguefy.admin.stages.destroy', {
          tournament: tournament.id,
          stage: stageId,
        }),
        {
          preserveScroll: true,
        },
      );
      updateXarrow();
    },
    [alert, tournament],
  );

  const handleMakeConnection = useCallback(
    (parent, child) => {
      console.log(parent, child);
      router.post(
        route('leaguefy.admin.stages.connect', {
          tournament: tournament.id,
        }),
        {
          preserveScroll: true,
          parent,
          child,
        },
      );
    },
    [tournament],
  );

  const handleCancelConnection = useCallback(() => {
    setConnectionSelected(null);
    setConnectionLane(null);
    setConnectionStages([]);
    setConnectionSide(null);
  }, []);

  const handleSelectConnection = useCallback(
    (event) => {
      const button =
        event.target.tagName === 'BUTTON'
          ? event.target
          : event.target.parentNode;
      if (
        button.tagName !== 'BUTTON' ||
        !button.classList.contains('connection-link')
      ) {
        handleCancelConnection();
        return;
      }

      const { stageId, side } = button.dataset;
      const laneKey = parseInt(button.dataset.laneKey, 10);
      const stages = JSON.parse(button.dataset.stages);
      console.log({ stageId, connectionSelected, side });
      if (connectionSelected) {
        handleCancelConnection();
        handleMakeConnection(
          side === 'top' ? connectionSelected : stageId,
          side === 'bottom' ? connectionSelected : stageId,
        );
        return;
      }
      setConnectionSelected(stageId);
      setConnectionLane(laneKey);
      setConnectionStages(stages);
      setConnectionSide(side);
    },
    [connectionSelected],
  );

  const connectionButton = function (
    side,
    stageId,
    connectionsLength,
    laneKey,
  ) {
    if (!connectionSelected) {
      return !!connectionsLength ? 'light' : 'info';
    }

    if (laneKey !== connectionLane || side === connectionSide) return 'light';

    return connectionStages.includes(stageId) ? 'danger' : 'success';
  };

  return (
    <Master header="Stages Flow">
      <Master.Content>
        <Stack gap={4} onClick={handleSelectConnection}>
          <Stack direction="horizontal" className="justify-content-center">
            <Button
              variant="default"
              size="sm"
              style={{ opacity: 0.25 }}
              onClick={() => handleNewLane('start')}
            >
              <i className="fas fa-fw fa-plus-circle fa-lg text-muted"></i>
            </Button>
          </Stack>

          {lanes.map((lane, laneKey) => (
            <Stack
              key={`lane-${laneKey}`}
              direction="horizontal"
              gap={2}
              className="justify-content-center align-items-center border rounded px-3 py-4 position-relative"
              style={{
                minWidth: 120 + lane.length * 190,
              }}
            >
              {!!connectionSelected && connectionLane !== laneKey && (
                <div
                  className="position-absolute"
                  style={{
                    zIndex: 10,
                    top: 0,
                    left: 0,
                    bottom: 0,
                    right: 0,
                    opacity: 0.5,
                  }}
                ></div>
              )}
              <Button
                variant="default"
                size="sm"
                className="me-3"
                style={{ opacity: 0.25 }}
                onClick={() => handleNewStage(laneKey, 'start')}
              >
                <i className="fas fa-fw fa-plus-circle fa-lg text-muted"></i>
              </Button>

              {lane.map((stage, stageKey) => (
                <div key={stage.id}>
                  {stage.parents.map((parent) => (
                    <Xarrow
                      key={parent.id}
                      start={`${stage.id}-top`}
                      end={`${parent.id}-bottom`}
                      path="smooth"
                      strokeWidth={2}
                      showHead={false}
                      lineColor={
                        !!connectionSelected &&
                        ((connectionSide === 'bottom' &&
                          connectionStages.includes(stage.id)) ||
                          (connectionSide === 'top' &&
                            connectionStages.includes(parent.id)))
                          ? 'blue'
                          : 'gray'
                      }
                      startAnchor={['middle']}
                      endAnchor={['middle']}
                      curveness={0.5}
                      divContainerStyle={{
                        opacity:
                          !!connectionSelected &&
                          ((connectionSide === 'bottom' &&
                            connectionStages.includes(stage.id)) ||
                            (connectionSide === 'top' &&
                              connectionStages.includes(parent.id)))
                            ? 1
                            : 0.5,
                      }}
                    />
                  ))}
                  <Card
                    border="secondary"
                    className="m-0"
                    style={{
                      width: 180,
                      opacity:
                        !!connectionSelected && connectionLane !== laneKey
                          ? 0.25
                          : 1,
                    }}
                  >
                    {laneKey > 0 && (
                      <Button
                        id={`${stage.id}-top`}
                        className="connection-link position-absolute border px-1 pt-1 pb-0 rounded-circle rounded-bottom-0"
                        variant={connectionButton(
                          'top',
                          stage.id,
                          stage.parents.length,
                          laneKey,
                        )}
                        disabled={
                          !!connectionSelected && connectionSide === 'top'
                        }
                        data-lane-key={laneKey - 1}
                        data-stage-id={stage.id}
                        data-stages={`["${stage.parents
                          .map(({ id }) => id)
                          .join('","')}"]`}
                        data-side="top"
                        size="sm"
                        style={{
                          width: 28,
                          left: 'calc(50% - 14px)',
                          top: -28,
                          zIndex: 10,
                        }}
                      >
                        <i className="fas fa-fw fa-link"></i>
                      </Button>
                    )}
                    <Card.Header className="py-0 ps-2 pe-0">
                      <Card.Title
                        as="p"
                        className="m-0 p-0 w-100 d-flex justify-content-between align-items-center"
                        title={stageName(stage.name, stageKey, laneKey)}
                      >
                        <div
                          style={{
                            whiteSpace: 'nowrap',
                            textOverflow: 'ellipsis',
                            overflow: 'hidden',
                          }}
                        >
                          {stageName(stage.name, stageKey, laneKey)}
                        </div>
                        <div className="card-tools">
                          <Dropdown>
                            <Dropdown.Toggle
                              variant="default"
                              className="border-0"
                            ></Dropdown.Toggle>
                            <Dropdown.Menu>
                              <Dropdown.Item
                                onClick={() =>
                                  setStageSelected({
                                    ...stage,
                                    name:
                                      stage.name ??
                                      stageName(stage.name, stageKey, laneKey),
                                  })
                                }
                              >
                                <i className="fas fa-fw fa-pen"></i>
                                <span className="ms-1">Edit</span>
                              </Dropdown.Item>
                              <Dropdown.Item
                                onClick={() => handleRemoveStage(stage.id)}
                              >
                                <i className="fas fa-fw fa-times text-danger"></i>
                                <span className="ms-1">Remove</span>
                              </Dropdown.Item>
                            </Dropdown.Menu>
                          </Dropdown>
                        </div>
                      </Card.Title>
                    </Card.Header>
                    <ListGroup variant="flush">
                      <ListGroup.Item className="p-0">
                        <ButtonGroup className="w-100">
                          <Button
                            className="rounded-0 p-1"
                            variant={
                              stage.type === 'SINGLE' ? 'primary' : 'default'
                            }
                            size="sm"
                            onClick={() => handleChangeType('SINGLE', stage)}
                          >
                            <i className="fas fa-fw fa-square"></i>
                          </Button>
                          <Button
                            className="rounded-0 p-1"
                            variant={
                              stage.type === 'MULTIPLE' ? 'primary' : 'default'
                            }
                            size="sm"
                            onClick={() => handleChangeType('MULTIPLE', stage)}
                          >
                            <i className="fas fa-fw fa-th-large"></i>
                          </Button>
                          <Button
                            className="rounded-0 p-1"
                            variant={
                              stage.type === 'ELIMINATION'
                                ? 'primary'
                                : 'default'
                            }
                            size="sm"
                            onClick={() =>
                              handleChangeType('ELIMINATION', stage)
                            }
                          >
                            <i className="fas fa-fw fa-sitemap"></i>
                          </Button>
                          <Button
                            className="rounded-0 p-1"
                            variant={
                              stage.type === 'FINAL' ? 'primary' : 'default'
                            }
                            size="sm"
                            onClick={() => handleChangeType('FINAL', stage)}
                          >
                            <i className="fas fa-fw fa-grip-lines"></i>
                          </Button>
                        </ButtonGroup>
                      </ListGroup.Item>
                    </ListGroup>
                    {laneKey < lanes.length - 1 && (
                      <Button
                        id={`${stage.id}-bottom`}
                        className="connection-link position-absolute border px-1 pt-1 pb-0 rounded-circle rounded-top-0"
                        variant={connectionButton(
                          'bottom',
                          stage.id,
                          stage.children.length,
                          laneKey,
                        )}
                        disabled={
                          !!connectionSelected && connectionSide === 'bottom'
                        }
                        size="sm"
                        data-lane-key={laneKey + 1}
                        data-stage-id={stage.id}
                        data-stages={`["${stage.children
                          .map(({ id }) => id)
                          .join('","')}"]`}
                        data-side="bottom"
                        style={{
                          width: 28,
                          left: 'calc(50% - 14px)',
                          bottom: -28,
                          zIndex: 10,
                        }}
                      >
                        {!!connectionSelected &&
                        connectionStages.includes(stage.id) ? (
                          <i className="fas fa-fw fa-times"></i>
                        ) : (
                          <i className="fas fa-fw fa-link"></i>
                        )}
                      </Button>
                    )}
                  </Card>
                </div>
              ))}

              <Button
                className="ms-3"
                variant="default"
                size="sm"
                style={{ opacity: 0.25 }}
                onClick={() => handleNewStage(laneKey, 'end')}
              >
                <i className="fas fa-fw fa-plus-circle fa-lg text-muted"></i>
              </Button>
            </Stack>
          ))}

          <Stack direction="horizontal" className="justify-content-center">
            <Button
              variant="default"
              size="sm"
              style={{ opacity: 0.25 }}
              onClick={() => handleNewLane('end')}
            >
              <i className="fas fa-fw fa-plus-circle fa-lg text-muted"></i>
            </Button>
          </Stack>
        </Stack>
        <Modal show={!!stageSelected} onHide={() => setStageSelected(null)}>
          <Form onSubmit={handleEditStage}>
            <Modal.Body>
              <Form.Group>
                <Form.Label htmlFor="name">Nome</Form.Label>
                <Form.Control
                  id="name"
                  placeholder="Nome"
                  value={stageSelected?.name ?? ''}
                  onChange={(e) =>
                    setStageSelected((prevState) => ({
                      ...prevState,
                      name: e.target.value,
                    }))
                  }
                  autoFocus
                />
              </Form.Group>
            </Modal.Body>
            <Modal.Footer>
              <Button
                variant="secondary"
                onClick={() => setStageSelected(null)}
              >
                Cancelar
              </Button>
              <Button type="submit" variant="primary">
                Salvar
              </Button>
            </Modal.Footer>
          </Form>
        </Modal>
      </Master.Content>
    </Master>
  );
}
