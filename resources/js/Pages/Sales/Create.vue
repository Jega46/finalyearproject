<template>
  <Head title="Employees" />
  <AuthenticatedLayout>
    <a-affix :offset-top="0">
      <a-page-header :ghost="false" title="New Sales Receipt" @back="() => $inertia.visit(route('sales.index'))">
        <template #extra>
          <a :href="route('sales.invoice')"> <a-button type="primary">Save</a-button></a>
        </template>
      </a-page-header>
    </a-affix>
    <a-row :gutter="24">
      <a-col class="gutter-row" :span="16" :offset="4">
        <a-layout-content :style="{ margin: '24px 16px', padding: '24px', background: '#fff' }">
          <a-form :model="formState" v-bind="layout" name="nest-messages" :validate-messages="validateMessages"
            @finish="submit" :label-col="{ span: 24 }">
            <a-row :gutter="24">
              <a-col class="gutter-row" :span="8">
                <a-form-item label="Customer" name="customer" :rules="[{ required: true }]">
                  <a-auto-complete v-model:value="value" :options="options" :filter-option="filterOption" />
                  <InputError class="mt-2" :message="errors.customer" />
                </a-form-item>
              </a-col>
              <a-col class="gutter-row" :span="8">
                <a-form-item label="Sales Receipt #" name="number">
                  <a-input v-model:value="formState.number" />
                  <InputError class="mt-2" :message="errors.number" />
                </a-form-item>
              </a-col>
              <a-col class="gutter-row" :span="8">
                <a-form-item label="Date" name="date" :rules="[{ required: true }]">
                  <a-input v-model:value="formState.date" />
                  <InputError class="mt-2" :message="errors.date" />
                </a-form-item>
              </a-col>
              <a-col class="gutter-row" :span="8">
                <a-form-item label="Payment Method" name="payment_method" :rules="[{ required: true }]">
                  <a-select ref="select" v-model:value="formState.payment_method">
                    <a-select-option value="jack">Jack</a-select-option>
                    <a-select-option value="lucy">Lucy</a-select-option>
                    <a-select-option value="disabled" disabled>Disabled</a-select-option>
                    <a-select-option value="Yiminghe">yiminghe</a-select-option>
                  </a-select>
                  <InputError class="mt-2" :message="errors.payment_method" />
                </a-form-item>
              </a-col>
              <a-col class="gutter-row" :span="8">
                <a-form-item label="Shipping Method" name="shipping_method" :rules="[{ required: true }]">
                  <a-select ref="select" v-model:value="formState.shipping_method">
                    <a-select-option value="jack">Jack</a-select-option>
                    <a-select-option value="lucy">Lucy</a-select-option>
                    <a-select-option value="disabled" disabled>Disabled</a-select-option>
                    <a-select-option value="Yiminghe">yiminghe</a-select-option>
                  </a-select>
                  <InputError class="mt-2" :message="errors.shipping_method" />
                </a-form-item>
              </a-col>
            </a-row>
            <br />
            <a-table :dataSource="dataSource" :columns="columns" />
            <br />
            <a-row :gutter="24">
              <a-col class="gutter-row" :span="12">
                <a-textarea v-model:value="value2" placeholder="Terms and conditions"
                  :auto-size="{ minRows: 2, maxRows: 5 }" />
                <a-textarea v-model:value="value2" placeholder="Notes" :auto-size="{ minRows: 2, maxRows: 5 }" />
              </a-col>
              <a-col class="gutter-row" :span="12">
                <a-descriptions bordered :size="'small'" :column="{ xxl: 1, xl: 1, lg: 1, md: 1, sm: 1, xs: 1 }">
                  <a-descriptions-item label="Sub Total">
                    90.00
                  </a-descriptions-item>
                  <a-descriptions-item label="Discount">
                    <a-input v-model:value="formState.date" :bordered="false" />
                  </a-descriptions-item>
                  <a-descriptions-item label="Shipping Cost">
                    <a-input v-model:value="formState.date" :bordered="false" />
                  </a-descriptions-item>
                  <a-descriptions-item label="Total Inline Discount">
                    90.00
                  </a-descriptions-item>
                  <a-descriptions-item label="Total Tax">
                    90.00
                  </a-descriptions-item>
                  <a-descriptions-item label="Total">
                    90.00
                  </a-descriptions-item>
                </a-descriptions>
              </a-col>
            </a-row>
            <br />
            <a-form-item :wrapper-col="{ span: 12 }">
              <a-button type="primary" html-type="submit">SUBMIT</a-button>
            </a-form-item>
          </a-form>
        </a-layout-content>
      </a-col>
    </a-row>
  </AuthenticatedLayout>
</template>
<script>
import { reactive, inject } from 'vue';
import { DownOutlined, PlusOutlined, AlignLeftOutlined, EditOutlined, PlusCircleOutlined } from '@ant-design/icons-vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { defineComponent, ref, computed } from 'vue';

export default defineComponent({
  inject: ['validateMessages'],
  props: {
    pagination: Object,
    errors: Object,
  },
  components: {
    AuthenticatedLayout,
    Head,
    EditOutlined,
    PlusOutlined,
    DownOutlined,
    PlusCircleOutlined,
    AlignLeftOutlined,
  },
  setup(props) {
    const layout = {
      labelCol: { span: 8 },
      wrapperCol: { span: 24 },
    };

    const checked = ref(false);
    const handleCancel = () => {
      showmodel_visible.value = false;
    };
    const formParty = useForm({
      partyname: '',
      mobile: '',
      who_r_they: '',
      gstin: '',
      flat_no: '',
      area_loc: '',
      pincode: '',
      city: '',
      state: '',
      same_ship: false,
    });
    const formState = useForm({
      valuess: '',
    });
    return {
      formParty,
      formState,
      layout,
      handleCancel,
      checked
    };
  },
  mounted() {
  },
  data() {
    return {
      showmodel_visible: false,
      menu_visible: false,
      invdrawer_visible: false,
      isShowing: false,
      addcustom: false,
      gstShowing: false,
      options: ref([{
        value: 'Burns Bay Road',
      }, {
        value: 'Downing Street',
      }, {
        value: 'Wall Street',
      }]),
      dataSource: [
      ],
      columns: [
        {
          title: 'Item',
          dataIndex: 'item',
          key: 'item',
        },
        {
          title: 'Quantity',
          dataIndex: 'quantity',
          key: 'quantity',
        },
        {
          title: 'Rate',
          dataIndex: 'rate',
          key: 'rate',
        },
        {
          title: 'Tax',
          dataIndex: 'tax',
          key: 'tax',
        },
        {
          title: 'Discount',
          dataIndex: 'discount',
          key: 'discount',
        },
        {
          title: 'Amount',
          dataIndex: 'amount',
          key: 'amount',
        }
      ],

    }
  },
  methods: {
    partySubmit() {
      this.formParty.post(this.route('purchase.store'), {
        onError: errors => { },
        onFinish: visit => {
          this.showmodel_visible = false;
        },
      });
    },
    handleTableChange(val) {
      this.$inertia.get(
        "/purchase/index",
        { page: val.current },
        { preserveState: true }
      );
    },
  },
});
</script>
<style>
.ant-menu-sub.ant-menu-inline {
  background: #ffffff;
}

.ant-menu-inline,
.ant-menu-vertical,
.ant-menu-vertical-left {
  border-right: 0px;
}

.ant-form-item-label {
  display: inline-block;
  flex-grow: 0;
  overflow: hidden;
  white-space: nowrap;
  text-align: left;
  vertical-align: middle;
}

.ant-table-pagination.ant-pagination {
  display: none;
}

.ant-modal-footer {
  display: none;
}
</style>