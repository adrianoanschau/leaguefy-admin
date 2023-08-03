import { useCallback, useMemo } from 'react';
import { Link } from '@inertiajs/react';
import { Button, Card, ButtonGroup } from 'react-bootstrap';
import { useFormData } from '../../hooks';
import { ucFirst } from '../../helpers';

function mapFields(fields) {
  return fields.map(function (field) {
    field = typeof field === 'string' ? { column: field } : field;

    return {
      label: field?.label ?? ucFirst(field?.column),
      column: field?.column,
      name: field?.name ?? field?.column,
      type: field?.type ?? 'text',
      options: field?.options ?? null,
      disabled: field?.disabled ?? false,
    };
  });
}

export const Form = ({ name, fields: originalFields, id, data }) => {
  const fields = useMemo(() => {
    return mapFields(originalFields);
  }, [originalFields]);

  const {
    data: formData,
    setData: setFormData,
    submit,
    processing,
  } = useFormData(fields, data);

  const handleSubmit = useCallback(
    (event) => {
      event.preventDefault();

      submit(
        !!id ? 'put' : 'post',
        route(`leaguefy.admin.${name}s.${!!id ? 'update' : 'store'}`, {
          [name]: id,
        }),
      );
    },
    [formData],
  );

  return (
    <Card>
      <Card.Header>
        <div className="card-tools">
          <div className="d-flex justify-content-end">
            <Button
              variant="light"
              size="sm"
              as={Link}
              href={route(`leaguefy.admin.${name}s.index`)}
            >
              <i className="fas fa-fw fa-list"></i>
              <span className="d-none d-sm-inline">Listar</span>
            </Button>
          </div>
        </div>
      </Card.Header>
      <form className="form-horizontal" onSubmit={handleSubmit}>
        <Card.Body>
          {fields.map((field) => (
            <div key={JSON.stringify(field)} className="form-group row">
              <label
                htmlFor={field?.column}
                className="col-sm-2 col-form-label"
              >
                {field?.label}
              </label>
              <div className="col-sm-10">
                {!!field?.options && (
                  <select
                    id={field.column}
                    name={field.name}
                    className="form-control"
                    disabled={field.disabled}
                    onChange={(e) => setFormData(field.name, e.target.value)}
                  >
                    <option value=""></option>
                    {Object.entries(field.options).map(([index, option]) => (
                      <option
                        key={JSON.stringify(option)}
                        value={index}
                        selected={formData[field.column] === index}
                      >
                        {option}
                      </option>
                    ))}
                  </select>
                )}
                {!field?.options && (
                  <input
                    type={field.type}
                    id={field.column}
                    name={field.name}
                    className="form-control"
                    placeholder={field.label}
                    value={formData[field.column]}
                    disabled={field.disabled}
                    onChange={(e) => setFormData(field.name, e.target.value)}
                  />
                )}
              </div>
            </div>
          ))}
        </Card.Body>
        <Card.Footer className="card-footer">
          <ButtonGroup className="float-right">
            <Button type="button" variant="warning" size="sm">
              <i className="fas fa-fw fa-broom"></i>
              Limpar
            </Button>
            <Button
              type="submit"
              variant="primary"
              size="sm"
              disabled={processing}
            >
              <i className="fas fa-fw fa-save"></i>
              {!!id ? 'Salvar' : 'Atualizar'}
            </Button>
          </ButtonGroup>
        </Card.Footer>
      </form>
    </Card>
  );
};
