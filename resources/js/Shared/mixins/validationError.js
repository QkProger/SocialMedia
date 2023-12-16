export default {
    methods: {
      errorFor(field) {
        return this.$page.props.errors.length && this.$page.props.errors[field]
          ? this.$page.props.errors[field]
          : null;
      },
    },
  };