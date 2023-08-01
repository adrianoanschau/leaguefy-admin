import { Link } from '@inertiajs/react';

const MenuItemLink = ({ item }) => (
  <li id={item?.id}>
    <Link
      className={`dropdown-item ${item?.class ?? ''}`}
      href={item?.href}
      target={item?.target}
      data-compiled={item['data-compiled'] ?? ''}
    >
      <i
        className={`${item?.icon ?? ''} ${
          item?.icon_color ? 'text-'.item?.icon_color : ''
        }`}
      ></i>

      <span>{item?.text}</span>

      {item?.label && (
        <span className={`badge badge-${item?.label_color ?? 'primary'} right`}>
          {item?.label}
        </span>
      )}
    </Link>
  </li>
);

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

export const DropdownItem = ({ item }) => {
  if (isSubmenu(item)) {
    return <div>Submenu</div>;
  }

  if (isLink(item)) {
    return <MenuItemLink item={item} />;
  }

  return <li>{item?.text}</li>;
};
