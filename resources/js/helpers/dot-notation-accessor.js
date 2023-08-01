export function dotNotationAccessor(object, name) {
  return name.split('.').reduce((o, i) => {
    if (o === undefined) return o;
    return o[i];
  }, object);
}
