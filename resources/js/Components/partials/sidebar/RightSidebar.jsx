import { Accordion, Button, Form, FormGroup } from 'react-bootstrap';
import { useConfig } from '../../../hooks';

export const RightSidebar = () => {
  const { config } = useConfig();

  return (
    <aside
      className={`control-sidebar control-sidebar-${config(
        'right_sidebar_theme',
      )}`}
    >
      {config('settings.sidebar', false) && (
        <div>
          <h4 className="px-3 py-2 m-0">
            <span>Settings</span>
            <button
              className="close"
              aria-label="Close"
              data-widget="control-sidebar"
            >
              <span aria-hidden="true">&times;</span>
            </button>
          </h4>

          <hr className="mt-1 mb-2" />

          <small className="form-text text-muted text-center">
            Ao submeter alterações a página será recarregada.
          </small>

          <hr className="mt-1 mb-0" />

          <Accordion defaultActiveKey={0} flush>
            <Accordion.Item eventKey={0}>
              <Accordion.Header>Marca</Accordion.Header>
              <Accordion.Body>
                <Form>
                  <FormGroup>
                    <Form.Label>Título</Form.Label>
                    <Form.Control placeholder="Título" />
                  </FormGroup>

                  <FormGroup>
                    <Form.Label>Logo</Form.Label>
                    <Form.Control placeholder="Logo" />
                  </FormGroup>

                  <hr />

                  <Button variant="primary" size="sm" className="mb-1 w-100">
                    <i className="fas fa-fw fa-sm fa-save"></i>
                    <span>Salvar</span>
                  </Button>
                </Form>
              </Accordion.Body>
            </Accordion.Item>

            <Accordion.Item eventKey={1}>
              <Accordion.Header>Estilos</Accordion.Header>
              <Accordion.Body>
                <Form>
                  <FormGroup>
                    <Form.Label>Título</Form.Label>
                    <Form.Control placeholder="Título" />
                  </FormGroup>

                  <FormGroup>
                    <Form.Label>Logo</Form.Label>
                    <Form.Control placeholder="Logo" />
                  </FormGroup>

                  <hr />

                  <Button variant="primary" size="sm" className="mb-1 w-100">
                    <i className="fas fa-fw fa-sm fa-save"></i>
                    <span>Salvar</span>
                  </Button>
                </Form>
              </Accordion.Body>
            </Accordion.Item>

            <Accordion.Item eventKey={2}>
              <Accordion.Header>Rotas</Accordion.Header>
              <Accordion.Body>
                <Form>
                  <FormGroup>
                    <Form.Label>Título</Form.Label>
                    <Form.Control placeholder="Título" />
                  </FormGroup>

                  <FormGroup>
                    <Form.Label>Logo</Form.Label>
                    <Form.Control placeholder="Logo" />
                  </FormGroup>

                  <hr />

                  <Button variant="primary" size="sm" className="mb-1 w-100">
                    <i className="fas fa-fw fa-sm fa-save"></i>
                    <span>Salvar</span>
                  </Button>
                </Form>
              </Accordion.Body>
            </Accordion.Item>
          </Accordion>
          <hr className="mt-0 mb-1" />
        </div>
      )}
    </aside>
  );
};
