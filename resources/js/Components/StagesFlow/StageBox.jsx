import { useCallback, useState } from 'react';
import { Button, Card, Dropdown, ListGroup } from 'react-bootstrap';
import Xarrow, { useXarrow } from 'react-xarrows';
import { router } from '@inertiajs/react';
import { useAlert } from '../../hooks';
import { ChangeStageTypeForm } from './ChangeStageTypeForm';

export function StageBox({
  stage,
  tournament,
  laneKey,
  stageKey,
  lanes,
  activeConnectionLane,
  activeConnectionSide,
  onSelectStage,
  onSelectConnection,
  onMakeConnection,
}) {
  const alert = useAlert();
  const updateXarrow = useXarrow();
  const [connectionSelected, setConnectionSelected] = useState(null);

  const stageName = useCallback(() => {
    if (stage.name) return stage.name;

    const sequence = lanes
      .filter((_, key) => key < laneKey)
      .reduce((acc, lane) => acc + lane.length, 1);

    return `Etapa ${sequence + stageKey}`;
  }, [stage, lanes, laneKey, stageKey]);

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

  const handleSelectConnection = useCallback(
    (side) => {
      if (!!connectionSelected) {
        setConnectionSelected(null);
        onSelectConnection(null);
        return;
      }

      if (
        !!activeConnectionSide &&
        (activeConnectionSide === side || activeConnectionLane !== laneKey)
      )
        return;

      if (activeConnectionSide !== side && activeConnectionLane === laneKey) {
        onMakeConnection();
        return;
      }
      setConnectionSelected(side);
      onSelectConnection(side);
    },
    [connectionSelected, activeConnectionSide, activeConnectionLane, laneKey],
  );

  return (
    <>
      {stage.parents.map((parent) => (
        <Xarrow
          key={parent.id}
          start={`${stage.id}-top`}
          end={`${parent.id}-bottom`}
          path="smooth"
          strokeWidth={2}
          showHead={false}
          lineColor="gray"
          startAnchor={['middle', 'top']}
          endAnchor={['middle', 'bottom']}
          curveness={0.5}
          divContainerStyle={{
            opacity: 0.5,
          }}
        />
      ))}

      <Card
        border="secondary"
        className="m-0 position-relative"
        style={{
          width: 180,
          opacity: 1,
          zIndex:
            !!connectionSelected || activeConnectionLane === laneKey ? 101 : 1,
        }}
      >
        {laneKey > 0 && (
          <Button
            id={`${stage.id}-top`}
            className="connection-link position-absolute border px-1 pt-1 pb-0 rounded-circle rounded-bottom-0"
            type={
              !!connectionSelected && connectionSelected === 'top'
                ? 'button'
                : activeConnectionSide === 'bottom' &&
                  activeConnectionLane === laneKey
                ? 'submit'
                : 'button'
            }
            variant={
              !!connectionSelected && connectionSelected === 'top'
                ? 'primary'
                : activeConnectionSide === 'bottom' &&
                  activeConnectionLane === laneKey
                ? 'info'
                : 'light'
            }
            disabled={
              (!!connectionSelected && connectionSelected !== 'top') ||
              (activeConnectionSide === 'top' &&
                activeConnectionLane === laneKey)
            }
            size="sm"
            onClick={() => handleSelectConnection('top')}
            style={{
              width: 28,
              left: 'calc(50% - 14px)',
              top: -28,
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
                      onSelectStage({
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
                  <Dropdown.Item onClick={() => handleRemoveStage(stage.id)}>
                    <i className="fas fa-fw fa-times text-danger"></i>
                    <span className="ms-1">Remove</span>
                  </Dropdown.Item>
                </Dropdown.Menu>
              </Dropdown>
            </div>
          </Card.Title>
        </Card.Header>
        <Card.Body className="p-2">
          <small className="d-block">
            {stage.groups.length} grupo
            {stage.groups.length > 1 ? 's' : ''}
          </small>
          <small className="d-block">{stage.competitors} participantes</small>
        </Card.Body>
        <ListGroup variant="flush">
          <ListGroup.Item className="p-0">
            <ChangeStageTypeForm tournament={tournament} stage={stage} />
          </ListGroup.Item>
        </ListGroup>
        {laneKey < lanes.length - 1 && (
          <Button
            id={`${stage.id}-bottom`}
            className="connection-link position-absolute border px-1 pt-1 pb-0 rounded-circle rounded-top-0"
            type={
              !!connectionSelected && connectionSelected === 'bottom'
                ? 'button'
                : activeConnectionSide === 'top' &&
                  activeConnectionLane === laneKey
                ? 'submit'
                : 'button'
            }
            variant={
              !!connectionSelected && connectionSelected === 'bottom'
                ? 'primary'
                : activeConnectionSide === 'top' &&
                  activeConnectionLane === laneKey
                ? 'info'
                : 'light'
            }
            disabled={
              (!!connectionSelected && connectionSelected !== 'bottom') ||
              (activeConnectionSide === 'bottom' &&
                activeConnectionLane === laneKey)
            }
            size="sm"
            onClick={() => handleSelectConnection('bottom')}
            style={{
              width: 28,
              left: 'calc(50% - 14px)',
              bottom: -28,
            }}
          >
            <i className="fas fa-fw fa-link"></i>
          </Button>
        )}
      </Card>
    </>
  );
}
