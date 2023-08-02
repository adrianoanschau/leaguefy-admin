const hasProperty = (object, key) =>
  object ? Object.hasOwnProperty.call(object, key) : false;
const hasProps = (arg) =>
  hasProperty(arg, 'provider') && hasProperty(arg, 'props');

export const withContextProviders =
  (...providers) =>
  (Component) =>
  (props) =>
    providers.reduceRight((acc, prov) => {
      let Provider = prov;
      if (hasProps(prov)) {
        Provider = prov.context;
        const providerProps = prov.props;
        return <Provider {...providerProps}>{acc}</Provider>;
      }
      return <Provider>{acc}</Provider>;
    }, <Component {...props} />);
