<script>
import { message } from 'ant-design-vue';
export default {
  watch: {
    "$page.props.flash.message": {
      handler() {
        if (this.$page.props.flash.message) {
          message.success(this.$page.props.flash.message);
        }
      },
      deep: true,
    },
    "$page.props.flash.error": {
      handler() {
        if (this.$page.props.flash.error) {
          message.error(this.$page.props.flash.error);
        }
      },
      deep: true,
    },
  },
};
</script>