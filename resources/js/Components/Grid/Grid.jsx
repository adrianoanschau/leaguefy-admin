import { Children, useCallback, useMemo } from 'react';
import { Link, useForm } from '@inertiajs/react';
import { ucFirst } from '../../helpers';
import { Button, Card, Table } from 'react-bootstrap';

function mapColumns(columns) {
  return columns.map((column) => {
    column = typeof column === 'string' ? { column: column } : column;

    return {
      label: column['label'] ?? ucFirst(column['column'] ?? ''),
      column: column['column'] ?? null,
      classes: column['classes'] ?? '',
      avatar: column['avatar'] ?? null,
      subtitle: column['subtitle'] ?? null,
      link_route: column['link_route'] ?? null,
      link_icon: column['link_icon'] ?? null,
      badge: column['badge'] ?? null,
    };
  });
}

export const Grid = ({ name, columns: originalColumns, data, form }) => {
  const columns = useMemo(() => {
    return mapColumns(originalColumns);
  }, [originalColumns]);

  const { delete: destroy } = useForm();

  const handleDestroy = useCallback((id) => {
    destroy(
      route(`leaguefy.admin.${name}s.destroy`, {
        [name]: id,
      }),
    );
  }, []);

  function renderCell(row, column) {
    if (!!column?.link_route) {
      return (
        <div>
          <Link
            href={route(`leaguefy.admin.${column.link_route}.index`, {
              [name]: row.id,
            })}
            className="btn btn-sm btn-link"
          >
            <i className={`fas ${column?.link_icon}`}></i>
          </Link>
        </div>
      );
    }

    if (!!column?.avatar || !!column?.subtitle) {
      return (
        <div className="d-flex align-items-center">
          {!!column?.avatar && (
            <div
              className="bg-light rounded-full"
              style={{ width: 45, height: 45 }}
            ></div>
          )}
          {!!column?.subtitle && (
            <div className={column?.avatar ? 'ml-3' : ''}>
              <p className="fw-normal mb-1">{row[column?.column]}</p>
              <p className="text-muted mb-0">{row[column?.subtitle]}</p>
            </div>
          )}
        </div>
      );
    }

    if (!!column?.badge) {
      return (
        <span className="badge badge-{{$column['badge']}}">
          {row[column?.column]}
        </span>
      );
    }

    return row[column?.column];
  }

  return (
    <Card>
      <Card.Body className="table-responsive w-100">
        <Table hover>
          <thead>
            <tr>
              {columns.map((column) => (
                <th
                  key={JSON.stringify(column)}
                  className={`py-3 border-bottom-0 border-top-0 w-full ${column['classes']}`}
                >
                  {column?.label}
                </th>
              ))}
              <th
                className="py-3 border-bottom-0 border-top-0"
                style={{ minWidth: 100 }}
              >
                <div className="d-flex justify-content-end">
                  <Button
                    variant="success"
                    size="sm"
                    as={Link}
                    href={route(`leaguefy.admin.${name}s.create`)}
                  >
                    <i className="fas fa-fw fa-plus"></i>
                    <span className="d-none d-sm-inline">Criar</span>
                  </Button>
                </div>
              </th>
            </tr>
          </thead>
          <tbody>
            {!!form && (
              <tr>
                <td colSpan={columns.length + 1}>{form}</td>
              </tr>
            )}
            {!data.length && (
              <tr>
                <td className="bg-light p-5" colSpan={columns.length + 1}>
                  <div className="d-flex flex-column align-items-center text-black-50">
                    <i
                      className="fas fa-fw fa-inbox fa-2xl"
                      style={{ fontSize: '5rem' }}
                    ></i>
                    <span>Empty</span>
                  </div>
                </td>
              </tr>
            )}
            {data.map((row) => (
              <tr key={JSON.stringify(row)}>
                {columns.map((column) => (
                  <td
                    key={JSON.stringify(column)}
                    className={`align-middle ${column['classes']}`}
                    style={{ textWrap: 'nowrap' }}
                  >
                    {renderCell(row, column)}
                  </td>
                ))}
                <td className="align-middle" style={{ minWidth: 220 }}>
                  <div className="d-flex justify-content-end">
                    <Link
                      className="btn btn-outline-primary btn-sm border-0"
                      href={route(`leaguefy.admin.${name}s.edit`, {
                        [name]: row.id,
                      })}
                    >
                      <i className="fas fa-fw fa-pen"></i>
                      <span className="d-none d-sm-inline">Editar</span>
                    </Link>
                    <button
                      type="button"
                      className="btn btn-outline-danger btn-sm border-0"
                      data-swal-confirm="submit"
                      data-swal-target={`#delete-form-${name}${row?.id}`}
                      onClick={() => handleDestroy(row.id)}
                    >
                      <i className="fas fa-fw fa-trash"></i>
                      <span className="d-none d-sm-inline">Excluir</span>
                    </button>
                  </div>
                </td>
              </tr>
            ))}
          </tbody>
        </Table>
      </Card.Body>
    </Card>
  );
};

Grid.Form = ({ children }) => {
  return <>{children}</>;
};
