import { useCallback, useRef, useState } from 'react';
import { useForm, usePage, router } from '@inertiajs/react';
import { Button, Form, Stack } from 'react-bootstrap';
import { useXarrow } from 'react-xarrows';
import Master from '../../Layouts/Master';
import { StageBox, EditStageModal } from '../../Components/StagesFlow';

export default function StagesFlow() {
  const {
    props: { tournament, lanes },
  } = usePage();
  const [stageSelected, setStageSelected] = useState(null);
  const updateXarrow = useXarrow();
  const formRef = useRef(null);
  const [connectionSelected, setConnectionSelected] = useState(null);
  const { data, setData, post } = useForm({
    laneInsert: '',
    lane: '',
    positionInsert: '',
    parent: '',
    child: '',
  });

  const handleSubmit = useCallback(
    (event) => {
      event?.preventDefault();
      const routeVariant = data.parent && data.child ? 'connect' : 'store';

      post(
        route(`leaguefy.admin.stages.${routeVariant}`, {
          tournament: tournament.id,
        }),
        {
          preserveScroll: true,
          ...data,
        },
      );

      updateXarrow();
    },
    [tournament, data],
  );

  const handleSelectConnection = useCallback((stageId, laneKey, side) => {
    if (!side) {
      setConnectionSelected(null);
      return;
    }
    setConnectionSelected({
      stageId,
      side,
      lanes: [laneKey, side === 'top' ? laneKey - 1 : laneKey + 1],
    });
  }, []);

  const handleMakeConnection = useCallback(
    (stageId) => {
      if (!connectionSelected) return;
      const { side, stageId: stageConnection } = connectionSelected;

      const parent = side === 'top' ? stageId : stageConnection;
      const child = side === 'bottom' ? stageId : stageConnection;
      setData({ parent, child });
    },
    [connectionSelected, tournament],
  );

  return (
    <Master header="Stages Flow">
      <Master.Content>
        <Form ref={formRef} onSubmit={handleSubmit}>
          <Stack gap={4}>
            <Button
              type="submit"
              variant="default"
              size="sm"
              style={{ opacity: 0.25 }}
              onClick={() => setData({ laneInsert: 'start' })}
            >
              <i className="fas fa-fw fa-plus-circle fa-lg text-muted"></i>
            </Button>

            {lanes.map((lane, laneKey) => (
              <Stack
                key={`lane-${laneKey}`}
                id={`lane-${laneKey}`}
                direction="horizontal"
                gap={2}
                className="justify-content-center align-items-center border rounded px-3 py-4 position-relative"
                style={{
                  minWidth: 120 + lane.length * 190,
                  opacity: 1,
                }}
              >
                {!!connectionSelected && (
                  <div
                    className="position-absolute bg-light"
                    style={{
                      zIndex: 100,
                      top: 0,
                      left: 0,
                      bottom: 0,
                      right: 0,
                      opacity: 0.8,
                    }}
                  ></div>
                )}

                <Button
                  type="submit"
                  variant="default"
                  size="sm"
                  className="me-3"
                  style={{ opacity: 0.25 }}
                  onClick={() =>
                    setData({
                      lane: laneKey,
                      positionInsert: 'start',
                    })
                  }
                >
                  <i className="fas fa-fw fa-plus-circle fa-lg text-muted"></i>
                </Button>

                {lane.map((stage, stageKey) => (
                  <StageBox
                    key={stage.id}
                    stage={stage}
                    tournament={tournament}
                    laneKey={laneKey}
                    stageKey={stageKey}
                    lanes={lanes}
                    activeConnectionLane={
                      !!connectionSelected ? connectionSelected.lanes[1] : null
                    }
                    activeConnectionSide={
                      !!connectionSelected ? connectionSelected.side : null
                    }
                    onSelectStage={(stage) => setStageSelected(stage)}
                    onSelectConnection={(side) =>
                      handleSelectConnection(stage.id, laneKey, side)
                    }
                    onMakeConnection={() => handleMakeConnection(stage.id)}
                  />
                ))}

                <Button
                  type="submit"
                  className="ms-3"
                  variant="default"
                  size="sm"
                  style={{ opacity: 0.25 }}
                  onClick={() =>
                    setData({
                      lane: laneKey,
                      positionInsert: 'end',
                    })
                  }
                >
                  <i className="fas fa-fw fa-plus-circle fa-lg text-muted"></i>
                </Button>
              </Stack>
            ))}

            <Button
              type="submit"
              variant="default"
              size="sm"
              style={{ opacity: 0.25 }}
              onClick={() => setData({ laneInsert: 'end' })}
            >
              <i className="fas fa-fw fa-plus-circle fa-lg text-muted"></i>
            </Button>
          </Stack>
        </Form>

        <EditStageModal
          stage={stageSelected}
          tournament={tournament}
          onClose={() => setStageSelected(null)}
        />
      </Master.Content>
    </Master>
  );
}
