
<template>
  <Head title="Payments" />
  <AuthenticatedLayout>
    <a-layout-content>
      <a-space direction="vertical" :style="{ width: '100%' }">
        <a-form name="nest-messages" :model="searchform" layout="inline" @finish="search">
          <a-form-item>
            <a-input placeholder="Search by Payment Number" :allow-clear="true" v-model:value="searchform.term">
            </a-input>
          </a-form-item>
          <a-form-item>
            <a-button type="primary" html-type="submit">
              Search
            </a-button>
          </a-form-item>
          <a-form-item>
            <a-button type="primary" shape="round" @click="showDrawer">
              <template #icon>
                <plus-circle-outlined />
              </template>
              New Payment
            </a-button>
          </a-form-item>
        </a-form>
        <a-table :columns="columns" :data-source="payments">
          <template #bodyCell="{ column, record }">
            <template v-if="column.key === 'payment_number'">
              <a @click="showDetailDrawer">
                {{ record.payment_number }}
              </a>
            </template>
          </template>
        </a-table>
      </a-space>
      <a-drawer v-model:visible="create_form_visible" class="sales-bill" :size="'large'" style="color: red;"
        title="New Payment" placement="right" @after-visible-change="afterVisibleChange">
        <a-form :model="form" v-bind="layout" name="nest-messages" :validate-messages="validateMessages" @finish="submit"
          :label-col="{ span: 24 }" style="min-height: 100%;">
          <a-row :gutter="24">
            <a-col class="gutter-row" span="24">
              <a-form-item name="name" label="Customer" :rules="[{ required: true }]">
                <a-select v-model:value="form.tax" show-search placeholder="Select Customer" style="width: 100%"
                  :default-active-first-option="false" :options="customers" :not-found-content="value"></a-select>
              </a-form-item>
            </a-col>
            <a-col class="gutter-row" span="24">
              <a-form-item name="name" label="Amount Received" :rules="[{ required: true }]">
                <a-input v-model:value="form.name" />
              </a-form-item>
            </a-col>
            <a-col class="gutter-row" span="12">
              <a-form-item name="name" label="Payment Number" :rules="[{ required: true }]">
                <a-input v-model:value="form.name" />
              </a-form-item>
            </a-col>
            <a-col class="gutter-row" span="12">
              <a-form-item name="name" label="Reference Number">
                <a-input v-model:value="form.name" />
              </a-form-item>
            </a-col>
            <a-col class="gutter-row" span="12">
              <a-form-item name="name" label="Payment Date" :rules="[{ required: true }]">
                <a-input v-model:value="form.name" />
              </a-form-item>
            </a-col>
            <a-col class="gutter-row" span="12">
              <a-form-item name="name" label="Payment Mode" :rules="[{ required: true }]">
                <a-select v-model:value="form.tax" show-search placeholder="Select Payment Mode" style="width: 100%"
                  :default-active-first-option="false" :options="customers" :not-found-content="value">
                  <a-select-option value="Cash">Cash</a-select-option>
                  <a-select-option value="Cash">Bank Transfer</a-select-option>
                  <a-select-option value="Cash">Credit Card</a-select-option>
                  <a-select-option value="Cash">Cheque</a-select-option>
                </a-select>
              </a-form-item>
            </a-col>
          </a-row>
          <br/>
          <h4 class="t1">Unpaid Invoices</h4>
          <a-table :columns="unpaidinvoice_columns" :data-source="unpaidinvoices" :pagination="false" class="table-small">
            <template #bodyCell="{ column, record }">
              <template v-if="column.key === 'payment'">
                <a-input v-model:value="record.payment" />
              </template>
            </template>
          </a-table>
          <br />
         
          <a-row :gutter="24">
            <a-col class="gutter-row" span="12">
              <a-form-item name="name" label="Notes (Internal use. Not visible to customer)" :rules="[{ required: true }]">
                <a-textarea v-model:value="form.description" />
              </a-form-item>
            </a-col>
            <a-col class="gutter-row" span="12">
              <br />
              <a-descriptions title="" bordered :size="'small'">
                <a-descriptions-item label="Total" :span="4">
                  <h4 class="text-right">0.00</h4>
                </a-descriptions-item>
              </a-descriptions>
            </a-col>
          </a-row>
          <br />
          <a-row :gutter="24">
            <a-col class="gutter-row" span="8">
              <a-button type="primary" html-type="submit" :disabled="form.processing" block>SAVE (F2)</a-button>
            </a-col>
          </a-row>
        </a-form>
      </a-drawer>
      <a-drawer v-model:visible="showdetail" class="custom-class" title="QT-000001" :size="'large'" placement="right"
        @after-visible-change="afterVisibleChange">
        <a-space style="margin-bottom: 10px;">
          <a-button @click="onClose">
            <EditOutlined />
          </a-button>
          <a-button type="primary" @click="onClose">
            <DeleteOutlined />
          </a-button>
          <a-dropdown>
            <template #overlay>
              <a-menu @click="handleMenuClick">
                <a-menu-item key="1">
                  PDF
                </a-menu-item>
                <a-menu-item key="2">
                  Print
                </a-menu-item>
              </a-menu>
            </template>
            <a-button>
              <FilePdfOutlined /> PDF / Print
            </a-button>
          </a-dropdown>
        </a-space>
        <div class="quote-template">
          <table style="width:100%" class="quote-table">
            <tr>
              <td colspan="2">
                <p><b>lynchpin</b></p>
                <p>Tamil Nadu </p>
                <p>India</p>
                <p>mohana.lynchpin@gmail.com</p>
              </td>
              <td colspan="2" align="right">
                <img src="/images/logo-2.png" style="max-width: 200px;" />
              </td>
            </tr>
          </table>
          <h2 style="text-align: center;margin:15px 0">PAYMENT RECEIPT</h2>
          <table style="width:100%" class="quote-table border">
            <tr>
              <td>Payment Date</td>
              <td>10/09/2023</td>
              <td rowspan="4" class="highlight" align="center">
                <h4>INR 54000.00</h4>
                <p><small>AMOUNT RECEIVED</small></p>
              </td>
            </tr>
            <tr>
              <td>Ref Number</td>
              <td>00001</td>
            </tr>
            <tr>
              <td>Payment Mode</td>
              <td>Cash</td>
            </tr>
            <tr>
              <td>Amount Received In Words</td>
              <td>Indian Rupee One Hundred Only</td>
            </tr>
          </table>
          <br />
          <table style="width:100%" class="quote-table">
            <tr>
              <td>
                <p><b>Bill To: </b></p>
                <p>Mr John Doe</p>
                <p>KK nagar</p>
                <p>+91 9876543210</p>
                <br />
              </td>
              <td align="right">
                Authorized Signature
                <br />
                <br />
                <br />
                <hr style="border:1px solid #e2e2e2" />
                <p>lynchpin</p>
              </td>
            </tr>
          </table>
          <h4>Payment for</h4>
          <table style="width:100%" class="quote-table border">
            <tr class="highlight">
              <th align="left">Invoice Number </th>
              <th>Invoice Date </th>
              <th>Invoice Amount </th>
              <th width="100px" align="right">Payment Amount</th>
            </tr>
            <tr>
              <td>
                INV-000001
              </td>
              <td>10/09/2023 </td>
              <td>₹200.00 </td>
              <td align="right">₹100.00 </td>
            </tr>
          </table>

        </div>

      </a-drawer>
    </a-layout-content>
  </AuthenticatedLayout>
</template>

<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { usePagination } from 'vue-request';
import { computed, defineComponent } from 'vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

import {
  DownloadOutlined,
  PlusCircleOutlined,
  MoreOutlined,
  DownCircleOutlined,
  CloseCircleOutlined,
  EditOutlined,
  DeleteOutlined,
  MailOutlined,
  CheckOutlined,
  InteractionOutlined,
  FilePdfOutlined,
  PlusOutlined
} from '@ant-design/icons-vue';
import axios from 'axios';
const columns = [
  {
    title: 'Date',
    key: 'date',
    dataIndex: 'date',
    width: '15%',
  },
  {
    title: 'Payment Number',
    key: 'payment_number',
    dataIndex: 'payment_number',
    width: '15%',
  },
  {
    title: 'Ref Number',
    key: 'ref_number',
    dataIndex: 'ref_number',
    width: '15%',
  },
  {
    title: 'Customer Name',
    key: 'customer_name',
    dataIndex: 'customer_name',
    width: '15%',
  },
  {
    title: 'Invoice Number',
    key: 'invoice_number',
    dataIndex: 'invoice_number',
    width: '15%',
  },

  {
    title: 'Payment Mode',
    key: 'payment_mode',
    dataIndex: 'payment_mode',
    width: '15%',
  },
  {
    title: 'Amount',
    key: 'amount',
    dataIndex: 'amount',
    width: '15%',
  },
];


// defining payments const
const payments = [{
  key: '1',
  date: '10/10/2023',
  payment_number: '000001',
  ref_number: '',
  customer_name: 'John Doe',
  payment_mode: 'Cash',
  amount: '1000.00',
},
{
  key: '2',
  date: '10/10/2023',
  payment_number: '000002',
  ref_number: '000001',
  customer_name: 'John Doe',
  payment_mode: 'Cash',
  amount: '1000.00',
}];

const unpaidinvoice_columns = [{
  title: 'Date',
  dataIndex: 'date',
  key: 'date',
  width: '10%',
}, {
  title: 'Invoice Number',
  dataIndex: 'invoice_number',
  key: 'invoice_number',
  width: '10%',
}, {
  title: 'Invoice Amount',
  dataIndex: 'invoice_amount',
  key: 'invoice_amount',
  width: '10%',
}, {
  title: 'Amount Due',
  key: 'amount_due',
  dataIndex: 'amount_due',
  width: '10%',
}, {
  title: 'Payment',
  key: 'payment',
  width: '20%',
}];
// defining create payment items const
const unpaidinvoices = [
{
    key: '1',
    date: '10/10/2023',
    invoice_number: '000001',
    invoice_amount: '1000.00',
    amount_due: '1000.00',
    payment: '',
  }
];

export default ({
  components: {
    AuthenticatedLayout, DownloadOutlined, PlusCircleOutlined, MoreOutlined, Head, Link, DownCircleOutlined, CloseCircleOutlined, EditOutlined,
    DeleteOutlined,
    MailOutlined,
    CheckOutlined,
    InteractionOutlined, FilePdfOutlined, PlusOutlined
  },
  props: {
  },
  setup(props) {
    return {
      columns,
      payments,
      unpaidinvoice_columns,
      unpaidinvoices
    };
  },
  data() {
    const loading = false;
    const create_form_visible = false;
    const searchform = useForm({
      term: '',
    });
    const form = useForm({
      term: '',
    });
    return {
      create_form_visible,
      loading,
      searchform,
      form,
      showdetail: false,
    };
  },
  methods: {
    showDrawer() {
      this.create_form_visible = true;
    },
    showDetailDrawer() {
      this.showdetail = true;
    },
  }
});
</script>