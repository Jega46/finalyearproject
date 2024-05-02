
<template>
  <Head title="Creditnotes" />
  <AuthenticatedLayout>
    <a-layout-content>
      <a-space direction="vertical" :style="{ width: '100%' }">
        <a-form name="nest-messages" :model="searchform" layout="inline" @finish="search">
          <a-form-item>
            <a-input placeholder="Search by Creditnote Number" :allow-clear="true" v-model:value="searchform.term">
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
              New Creditnote
            </a-button>
          </a-form-item>
        </a-form>
        <a-table :columns="columns" :data-source="creditnotes">
          <template #bodyCell="{ column, record }">
            <template v-if="column.key === 'creditnote_number'">
              <a @click="showDetailDrawer">
                {{ record.creditnote_number }}
              </a>
            </template>
          </template>
        </a-table>
      </a-space>
      <a-drawer v-model:visible="create_form_visible" class="sales-bill" :size="'large'" style="color: red;"
        title="New Creditnote" placement="right" @after-visible-change="afterVisibleChange">
        <a-form :model="form" v-bind="layout" name="nest-messages" :validate-messages="validateMessages" @finish="submit"
          :label-col="{ span: 24 }" style="min-height: 100%;">
          <a-row :gutter="24">
            <a-col class="gutter-row" span="8">
              <a-form-item name="name" label="Customer" :rules="[{ required: true }]">
                <a-select v-model:value="form.tax" show-search placeholder="Select Customer" style="width: 100%"
                  :default-active-first-option="false" :options="customers" :not-found-content="value"></a-select>
              </a-form-item>
            </a-col>
            <a-col class="gutter-row" span="8">
              <a-form-item name="name" label="Creditnote Number" :rules="[{ required: true }]">
                <a-input v-model:value="form.name" />
              </a-form-item>
            </a-col>
            <a-col class="gutter-row" span="8">
              <a-form-item name="name" label="Reference Number">
                <a-input v-model:value="form.name" />
              </a-form-item>
            </a-col>
            <a-col class="gutter-row" span="8">
              <a-form-item name="name" label="Creditnote Date" :rules="[{ required: true }]">
                <a-input v-model:value="form.name" />
              </a-form-item>
            </a-col>
            <a-col class="gutter-row" span="24">
              <a-form-item name="name" label="Subject" :rules="[{ required: true }]">
                <a-input v-model:value="form.name" />
              </a-form-item>
            </a-col>
          </a-row>
          <h4 class="t1">Items / Services Info</h4>
          <a-table :columns="creditnotecolumns" :data-source="createCreditnoteItems" :pagination="false">
            <template #bodyCell="{ column, record }">
              <template v-if="column.key === 'item_details'">
                <a-space direction="vertical" style="width:100%">
                  <a-input v-model:value="record.item_details" />
                  <a-textarea v-model:value="record.item_details" placeholder="Item Description" allow-clear />
                </a-space>
              </template>
              <template v-if="column.key === 'quantity'">
                <a-input v-model:value="record.quantity" />
              </template>
              <template v-if="column.key === 'rate'">
                <a-input v-model:value="record.rate" />
              </template>
              <template v-if="column.key === 'amount'">
                <a-input v-model:value="record.amount" />
              </template>
              <template v-if="column.key === 'action'">
                <a-space>
                  <a-button type="primary" :size="'small'">
                    <template #icon>
                      <CloseCircleOutlined />
                    </template>
                  </a-button>
                </a-space>
              </template>
            </template>
          </a-table>
          <br />
          <a-space>
            <a-button type="success" :size="'small'">
              <template #icon>
                <plus-circle-outlined />
              </template>
              Add Good
            </a-button>
            <a-button type="success" :size="'small'">
              <template #icon>
                <plus-circle-outlined />
              </template>
              Add Service
            </a-button>
          </a-space>
          <br />
          <br />
          <a-row :gutter="24">
            <a-col class="gutter-row" span="12">
              <a-form-item name="name" label="Customer Notes" :rules="[{ required: true }]">
                <a-textarea v-model:value="form.description" />
              </a-form-item>
              <a-form-item name="name" label="Terms & Conditions" :rules="[{ required: true }]">
                <a-textarea v-model:value="form.description" />
              </a-form-item>
            </a-col>
            <a-col class="gutter-row" span="12">
              <br />
              <a-descriptions title="" bordered :size="'small'">
                <a-descriptions-item label="Sub Total" :span="4">
                  <p class="text-right m-0">0.00</p>
                </a-descriptions-item>
                <a-descriptions-item label="Discount" :span="2"><a-input style="width:100px" /></a-descriptions-item>
                <a-descriptions-item :span="2"> 0.00</a-descriptions-item>
                <a-descriptions-item label="Tax" :span="2">
                  <a-select v-model:value="form.tax" show-search placeholder="Tax" style="width: 100px"
                    :default-active-first-option="false" :not-found-content="value">
                  </a-select>
                </a-descriptions-item>
                <a-descriptions-item :span="2"> 0.00</a-descriptions-item>
                <a-descriptions-item label="Adjustment" :span="2"> <a-input style="width:100px" /></a-descriptions-item>
                <a-descriptions-item :span="2"> 0.00</a-descriptions-item>
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
            <a-col class="gutter-row" span="8">
              <a-button type="primary" html-type="submit" :disabled="form.processing" block>SAVE & SEND (F3)</a-button>
            </a-col>
            <a-col class="gutter-row" span="8">
              <a-button type="primary" html-type="submit" :disabled="form.processing" block>SAVE & PRINT (F5)</a-button>
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
          <a-button @click="onClose">
            <PlusOutlined /> Apply to invoices
          </a-button>
          <a-button @click="onClose">
            <MailOutlined /> Send Creditnote
          </a-button>
          <a-button @click="onClose">
            <CheckOutlined /> Convert to Open
          </a-button>
        </a-space>
        <div class="quote-template">
          <table style="width:100%" class="quote-table">
            <tr>
              <td colspan="2">
                <h2>CREDIT NOTE</h2>
                <p><b>lynchpin</b></p>
                <p>Tamil Nadu </p>
                <p>India</p>
                <p>mohana.lynchpin@gmail.com</p>
              </td>
              <td colspan="2" align="right">
                <img src="/images/logo-2.png" style="max-width: 200px;" />
              </td>
            </tr>
            <tr class="highlight">
              <td colspan="2">
                <p>Creditnote Number : QT-000001</p>
                <p>Creditnote Date : 10/10/2023</p>
              </td>
              <td colspan="2" align="right">
                <h4>INR 54000.00</h4>
                <p><small>AMOUNT DUE</small></p>
              </td>
            </tr>
            <tr>
              <td colspan="4">
                <p><b>Bill To: </b></p>
                <p>Mr John Doe</p>
                <p>KK nagar</p>
                <p>+91 9876543210</p>
                <br />
              </td>
            </tr>
          </table>
          <table style="width:100%" class="quote-table border">
            <tr>
              <th align="left">Item Details</th>
              <th>Quantity</th>
              <th>Rate</th>
              <th width="100px" align="right">Amount</th>
            </tr>
            <tr>
              <td>
                item 1
                <p>shopify Application development and
                  service</p>
              </td>
              <td>1</td>
              <td>0.00</td>
              <td align="right">0.00</td>
            </tr>
            <tr>
              <td>item 2
                <p>shopify Application development and
                  service</p>
              </td>
              <td>1</td>
              <td>0.00</td>
              <td align="right">0.00</td>
            </tr>
            <tr>
              <td colspan="2">
                <div style="margin-right:20px">
                  <h5>Terms & Conditions</h5>
                  <p>1. Payment should be made within 30 days from the date of creditnote.</p>
                  <p>2. Goods once sold will not be taken back.</p>
                  <p>3. Interest @ 24% will be charged for the delay in payment.</p>
                </div>
              </td>
              <td colspan="2" style="padding:0">
                <table style="width:100%">
                  <tr>
                    <td colspan="3">Sub Total</td>
                    <td width="100px" align="right">0.00</td>
                  </tr>
                  <tr>
                    <td colspan="3">Discount</td>
                    <td align="right">0.00</td>
                  </tr>
                  <tr>
                    <td colspan="3">Tax</td>
                    <td align="right">0.00</td>
                  </tr>
                  <tr>
                    <td colspan="3">Adjustment</td>
                    <td align="right">0.00</td>
                  </tr>
                  <tr>
                    <td colspan="3">Total</td>
                    <td align="right">0.00</td>
                  </tr>
                  <tr>
                    <td colspan="4">
                      <br />
                      <br />
                      <br />
                      Authorized Signature
                    </td>
                  </tr>
                </table>
              </td>
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
    title: 'Credit note Number',
    key: 'creditnote_number',
    dataIndex: 'creditnote_number',
    width: '15%',
  },
  {
    title: 'Ref Number',
    key: 'reference_number',
    dataIndex: 'reference_number',
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
    title: 'Status',
    key: 'status',
    dataIndex: 'status',
    width: '15%',
  },
  {
    title: 'Amount',
    key: 'amount',
    dataIndex: 'amount',
    width: '15%',
  },
  {
    title: 'Balance',
    key: 'balance',
    dataIndex: 'balance',
    width: '15%',
  }
];
const creditnotes = [{
  key: '1',
  date: '10-10-2023',
  creditnote_number: 'creditnote-0001',
  invoice_number: '',
  customer_name: 'John Doe',
  status: 'Draft',
  due_date: '10-10-2023',
  amount: '1000.00',
  balance: '0.00',
},
//adding 5 more data with different creditnote_number and customer_name
{
  key: '2',
  date: '10-10-2023',
  creditnote_number: 'creditnote-0002',
  invoice_number: '',
  customer_name: 'John Doe',
  status: 'Draft',
  due_date: '10-10-2023',
  amount: '1000.00',
  balance: '0.00',
},
{
  key: '3',
  date: '10-10-2023',
  creditnote_number: 'creditnote-0003',
  invoice_number: '',
  customer_name: 'John Doe',
  status: 'Draft',
  due_date: '10-10-2023',
  amount: '1000.00',
  balance: '0.00',
},
{
  key: '4',
  date: '10-10-2023',
  creditnote_number: 'creditnote-0004',
  invoice_number: '',
  customer_name: 'John Doe',
  status: 'Draft',
  due_date: '10-10-2023',
  amount: '1000.00',
  balance: '0.00',
},
{
  key: '5',
  date: '10-10-2023',
  creditnote_number: 'creditnote-0005',
  invoice_number: '',
  customer_name: 'John Doe',
  status: 'Draft',
  due_date: '10-10-2023',
  amount: '1000.00',
  balance: '0.00',
},
{
  key: '6',
  date: '10-10-2023',
  creditnote_number: 'creditnote-0006',
  invoice_number: '',
  customer_name: 'John Doe',
  status: 'Draft',
  due_date: '10-10-2023',
  amount: '1000.00',
  balance: '0.00',
},
{
  key: '7',
  date: '10-10-2023',
  creditnote_number: 'creditnote-0007',
  invoice_number: '',
  customer_name: 'John Doe',
  status: 'Draft',
  due_date: '10-10-2023',
  amount: '1000.00',
  balance: '0.00',
},
{
  key: '8',
  date: '10-10-2023',
  creditnote_number: 'creditnote-0008',
  invoice_number: '',
  customer_name: 'John Doe',
  status: 'Draft',
  due_date: '10-10-2023',
  amount: '1000.00',
  balance: '0.00',
},
{
  key: '9',
  date: '10-10-2023',
  creditnote_number: 'creditnote-0009',
  invoice_number: '',
  customer_name: 'John Doe',
  status: 'Draft',
  due_date: '10-10-2023',
  amount: '1000.00',
  balance: '0.00',
}];
const creditnotecolumns = [{
  title: 'Item Details',
  dataIndex: 'item_details',
  key: 'item_details',
  width: '40%',
}, {
  title: 'Quantity',
  dataIndex: 'quantity',
  key: 'quantity',
  width: '10%',
}, {
  title: 'Rate',
  dataIndex: 'rate',
  key: 'rate',
  width: '10%',
}, {
  title: 'Amount',
  key: 'amount',
  dataIndex: 'amount',
  width: '10%',
}, {
  title: 'Action',
  key: 'action',
  width: '3%',
}];

// defining create creditnote items const
const createCreditnoteItems = [{
  key: '1',
  item_details: 'item 1',
  quantity: '1',
  rate: '0.00',
  amount: '1000.00',
  balance: '0.00',
  action: '',
},
{
  key: '2',
  item_details: 'item 2',
  quantity: '1',
  rate: '0.00',
  amount: '1000.00',
  balance: '0.00',
  action: '',
}];

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
      creditnotecolumns,
      creditnotes,
      createCreditnoteItems
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