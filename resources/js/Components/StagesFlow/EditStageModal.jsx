import { useForm } from '@inertiajs/react';
import { useCallback, useEffect } from 'react';
import { Button, Card, Col, Form, Modal, Row } from 'react-bootstrap';
import { useXarrow } from 'react-xarrows';

const competitorsMinValue = {
  SINGLE: 3,
  MULTIPLE: 2,
};

export function EditStageModal({ stage, tournament, onClose }) {
  const updateXarrow = useXarrow();
  const { put, data, setData, reset } = useForm({
    name: '',
    competitors: '',
    groups: [],
  });

  const handleClose = useCallback(() => {
    reset();
    onClose();
  }, []);

  const handleEditStage = useCallback(
    (event) => {
      event.preventDefault();

      if (stage.type === 'ELIMINATION') {
        data.groups = stage.groups.length;
      }

      put(
        route('leaguefy.admin.stages.update', {
          tournament: tournament.id,
          stage: stage.id,
        }),
        {
          preserveScroll: true,
          ...data,
        },
      );

      handleClose();
      updateXarrow();
      reset();
    },
    [stage, data, tournament],
  );

  useEffect(() => {
    if (!stage) return;
    setData({
      name: stage.name,
      competitors: stage.competitors,
      groups: stage.groups,
    });
  }, [stage]);

  return (
    <Modal show={!!stage} onHide={handleClose}>
      <Form onSubmit={handleEditStage}>
        <Modal.Body>
          <Row className="mb-4">
            <Col>
              <Form.Group>
                <Form.Label htmlFor="name">Nome</Form.Label>
                <Form.Control
                  id="name"
                  placeholder="Nome"
                  value={data.name}
                  onChange={(e) => setData('name', e.target.value)}
                  autoFocus
                />
              </Form.Group>
            </Col>
          </Row>
          {['SINGLE'].includes(stage?.type) && (
            <Form.Group>
              <Form.Label htmlFor="competitors">Jogam</Form.Label>
              <Form.Control
                id="competitors"
                type="number"
                min={competitorsMinValue[stage?.type]}
                value={data.competitors}
                onChange={(e) =>
                  setData('competitors', parseInt(e.target.value, 10))
                }
              />
            </Form.Group>
          )}
          {['MULTIPLE', 'ELIMINATION'].includes(stage?.type) && (
            <Row className="mb-3">
              <Col>
                <Form.Group>
                  <Form.Label htmlFor="groups">Grupos</Form.Label>
                  <Form.Control
                    id="groups"
                    type="number"
                    min={stage?.type === 'ELIMINATION' ? 1 : 2}
                    value={data.groups.length}
                    disabled={['SINGLE', 'FINAL'].includes(stage?.type)}
                    onChange={(e) => {
                      const newValue = parseInt(e.target.value, 10);
                      let append = [];
                      if (newValue - data.groups.length > 0) {
                        append = Array(newValue - data.groups.length).fill({
                          size: 2,
                        });
                      }

                      setData(
                        'groups',
                        data.groups.slice(0, newValue).concat(append),
                      );
                    }}
                  />
                </Form.Group>
              </Col>
            </Row>
          )}
          <div className="d-flex flex-wrap">
            {['MULTIPLE'].includes(stage?.type) &&
              data.groups.map((group, key) => (
                <Card key={key} className="m-0" style={{ width: '25%' }}>
                  <Card.Header>Grupo {key + 1}</Card.Header>
                  <Card.Body>
                    <Form.Group>
                      <Form.Label htmlFor={`group-size-${key}`}>
                        Jogam
                      </Form.Label>
                      <Form.Control
                        id={`group-size-${key}`}
                        type="number"
                        min={competitorsMinValue[stage?.type]}
                        value={group.size}
                        onChange={(e) =>
                          setData(
                            'groups',
                            data.groups.map((group, gkey) => {
                              if (gkey !== key) return group;
                              return { size: parseInt(e.target.value, 10) };
                            }),
                          )
                        }
                      />
                    </Form.Group>
                  </Card.Body>
                </Card>
              ))}
          </div>
        </Modal.Body>
        <Modal.Footer>
          <Button variant="secondary" onClick={handleClose}>
            Cancelar
          </Button>
          <Button type="submit" variant="primary">
            Salvar
          </Button>
        </Modal.Footer>
      </Form>
    </Modal>
  );
}
