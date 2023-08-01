import { Link } from '@inertiajs/react';

const MenuItemHeader = ({ item }) => (
  <li id={item?.id} className={`nav-header ${item?.class}`}>
    {item?.header ?? item}
  </li>
);

const MenuItemSearchForm = ({ item }) => (
  <li>
    <form
      className="form-inline my-2"
      action={item?.href}
      method={item?.method}
    >
      <div className="input-group">
        <input
          className="form-control form-control-sidebar"
          type="search"
          id={item?.id}
          name={item?.input_name}
          placeholder={item?.text}
          aria-label={item?.text}
        />

        <div className="input-group-append">
          <button className="btn btn-sidebar" type="submit">
            <i className="fas fa-fw fa-search"></i>
          </button>
        </div>
      </div>
    </form>
  </li>
);

const MenuItemSearchMenu = ({ item }) => (
  <li>
    <div className="form-inline my-2">
      <div
        className="input-group"
        data-widget="sidebar-search"
        data-arrow-sign="&raquo;"
      >
        <input
          className="form-control form-control-sidebar"
          type="search"
          id={item?.id}
          placeholder={item?.text}
          aria-label={item?.text}
        />

        <div className="input-group-append">
          <button className="btn btn-sidebar">
            <i className="fas fa-fw fa-search"></i>
          </button>
        </div>
      </div>
    </div>
  </li>
);

const MenuItemTreeviewMenu = ({ item }) => (
  <li id={item?.id} className={`nav-item has-treeview ${item?.submenu_class}`}>
    <Link
      className={`nav-link ${item?.class} ${item?.shift}`}
      href="#"
      data-compiled={item['data-compiled'] ?? ''}
    >
      <i
        className={`${item?.icon ?? 'far fa-fw fa-circle'} ${
          item?.icon_color ? 'text-'.item?.icon_color : ''
        }`}
      ></i>

      <p>
        {item?.text}
        <i className="fas fa-angle-left right"></i>

        {item?.label && (
          <span
            className={`badge badge-${item?.label_color ?? 'primary'} right`}
          >
            {item?.label}
          </span>
        )}
      </p>
    </Link>

    <ul className="nav nav-treeview">
      {/* @each('leaguefy-admin::partials.sidebar.menu-item', $item['submenu'],
      'item') */}
    </ul>
  </li>
);

const MenuItemLink = ({ item }) => (
  <li id={item?.id} className="nav-item">
    <Link
      className={`nav-link ${item?.class ?? ''} ${item?.shift ?? ''}`}
      href={item?.href}
      target={item?.target}
      data-compiled={item['data-compiled'] ?? ''}
    >
      <i
        className={`${item?.icon ?? 'far fa-fw fa-circle'} ${
          item?.icon_color ? 'text-'.item?.icon_color : ''
        }`}
      ></i>

      <p className="ml-2">
        <span>{item?.text}</span>

        {item?.label && (
          <span
            className={`badge badge-${item?.label_color ?? 'primary'} right`}
          >
            {item?.label}
          </span>
        )}
      </p>
    </Link>
  </li>
);

function isHeader(item) {
  return typeof item === 'string' || item['header'] !== undefined;
}

function isLegacySearch(item) {
  return (
    item?.text !== undefined &&
    item?.search !== undefined &&
    item?.search === true
  );
}

function isCustomSearch(item) {
  return (
    item?.text !== undefined &&
    item?.type !== undefined &&
    item?.type === 'sidebar-custom-search'
  );
}

function isMenuSearch(item) {
  return (
    item?.text !== undefined &&
    item?.type !== undefined &&
    item?.type === 'sidebar-menu-search'
  );
}

function isSubmenu(item) {
  return (
    item?.text !== undefined &&
    item?.submenu !== undefined &&
    Array.isArray(item?.submenu)
  );
}

function isLink(item) {
  return (
    item?.text !== undefined &&
    (item?.url !== undefined || item?.route !== undefined)
  );
}

export const MenuItem = ({ item }) => {
  if (isHeader(item)) {
    return <MenuItemHeader item={item} />;
  }

  if (isLegacySearch(item) || isCustomSearch(item)) {
    return <MenuItemSearchForm item={item} />;
  }

  if (isMenuSearch(item)) {
    return <MenuItemSearchMenu item={item} />;
  }

  //   if (isSubmenu(item)) {
  //     return <MenuItemTreeviewMenu item={item} />;
  //   }

  if (isLink(item)) {
    return <MenuItemLink item={item} />;
  }

  return <div>{item}</div>;
};
