
<template>
  <Head title="Purchase Orders" />
  <AuthenticatedLayout>
    <a-layout-content>
      <a-space direction="vertical" :style="{ width: '100%' }">
        <a-form name="nest-messages" :model="searchform" layout="inline" @finish="search">
          <a-form-item>
            <a-input placeholder="Search by Purchase Order Number" :allow-clear="true" v-model:value="searchform.term">
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
              New Purchase Order
            </a-button>
          </a-form-item>
        </a-form>
        <a-table :columns="columns" :data-source="purchase_orders">
          <template #bodyCell="{ column, record }">
            <template v-if="column.key === 'purchase_order_number'">
              <a @click="showDetailDrawer">
                {{ record.purchase_order_number }}
              </a>
            </template>
          </template>
        </a-table>
      </a-space>
      <a-drawer v-model:visible="create_form_visible" class="sales-bill" :size="'large'" style="color: red;" width="60%"
        title="New Purchase Order" placement="right" @after-visible-change="afterVisibleChange">
        <a-form :model="form" v-bind="layout" name="nest-messages" :validate-messages="validateMessages" @finish="submit"
          :label-col="{ span: 24 }" style="min-height: 100%;">
          <a-row :gutter="24">
            <a-col class="gutter-row" span="8">
              <a-form-item name="name" label="Vendor" :rules="[{ required: true }]">
                <a-select v-model:value="form.tax" show-search placeholder="Select Vendor" style="width: 100%"
                  :default-active-first-option="false" :options="customers" :not-found-content="value"></a-select>
              </a-form-item>
            </a-col>
            <a-col class="gutter-row" span="8">
              <a-form-item name="name" label="Purchase Order Number" :rules="[{ required: true }]">
                <a-input v-model:value="form.name" />
              </a-form-item>
            </a-col>
            <a-col class="gutter-row" span="8">
              <a-form-item name="name" label="Reference Number">
                <a-input v-model:value="form.name" />
              </a-form-item>
            </a-col>
            <a-col class="gutter-row" span="8">
              <a-form-item name="name" label="Date" :rules="[{ required: true }]">
                <a-input v-model:value="form.name" />
              </a-form-item>
            </a-col>
            <a-col class="gutter-row" span="8">
              <a-form-item name="name" label="Expected Delivery Date">
                <a-input v-model:value="form.name" />
              </a-form-item>
            </a-col>
            <a-col class="gutter-row" span="8">
              <a-form-item name="name" label="Payment Terms">
                <a-select v-model:value="form.tax" show-search placeholder="Payment Terms" style="width: 100%"
                  :default-active-first-option="false" :not-found-content="value">
                  <a-select-option value="1">Due on Receipt</a-select-option>
                  <a-select-option value="2">Net 15</a-select-option>
                  <a-select-option value="3">Net 30</a-select-option>
                  <a-select-option value="4">Net 45</a-select-option>
                  <a-select-option value="5">Net 60</a-select-option>
                  <a-select-option value="6">Custom</a-select-option>
                </a-select>
              </a-form-item>
            </a-col>
            <a-col class="gutter-row" span="8">
              <a-form-item name="name" label="Deliver To">
                <div>
                  <a-radio v-model:checked="checked1">Organization</a-radio>
                  <a-radio v-model:checked="checked2">Customer</a-radio>
                  <br />
                </div>
                <a-select ref="select" v-model:value="value1">
                  <a-select-option value="jack">Lynchpin, KK Nagar, Madurai</a-select-option>
                </a-select>
                <a>+ Add new address</a>
              </a-form-item>
            </a-col>
            <a-col class="gutter-row" span="8">
              <a-form-item name="name" label="Shipment Preferences">
                <a-select v-model:value="form.tax" show-search placeholder="Shipment Preferences" style="width: 100%"
                  :default-active-first-option="false" :not-found-content="value">
                </a-select>
              </a-form-item>
            </a-col>

          </a-row>
          <h4 class="t1">Items / Services Info</h4>
          <a-table :columns="purchase_ordercolumns" :data-source="createPurchaseOrderItems" :pagination="false">
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
      <a-drawer v-model:visible="showdetail" class="custom-class" title="PO-000001" :size="'large'" placement="right"
        @after-visible-change="afterVisibleChange" width="60%">
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
            <PlusOutlined /> Convert To Bill
          </a-button>
          <a-button @click="onClose">
            <MailOutlined /> Send Purchase Order
          </a-button>
          <a-button @click="onClose">
            <CheckOutlined /> Mark As Sent
          </a-button>
        </a-space>
        <div class="quote-template">
          <table style="width:100%" class="quote-table">
            <tr>
              <td colspan="2">
                <h2>PURCHASE ORDER</h2>
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
                <p>PO Number : PO-000001</p>
              </td>
              <td colspan="2" align="right">
                <p>Date : 10/10/2023</p>
              </td>
            </tr>
            <tr>
              <td colspan="2">
                <p><b>Deliver To: </b></p>
                <p>Mr John Doe</p>
                <p>KK nagar</p>
                <p>+91 9876543210</p>
                <br />
              </td>
              <td colspan="2" align="right">
                <p><b>Vendor: </b></p>
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
                  <p>1. Payment should be made within 30 days from the date of purchase_order.</p>
                  <p>2. Goods once sold will not be taken back.</p>
                  <p>3. Interest @ 24% will be charged for the delay in payment.</p>
                </div>
                <br />
                <br />
                <p>Authorized Signature </p>
                <br />
                <br />
                <hr class="signature-hr" />
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
  },
  {
    title: 'PO Number',
    key: 'purchase_order_number',
    dataIndex: 'purchase_order_number',
  },
  {
    title: 'Ref Number',
    key: 'reference_number',
    dataIndex: 'reference_number',
  },
  {
    title: 'Vendor Name',
    key: 'vendor_name',
    dataIndex: 'vendor_name',
  },
  {
    title: 'Status',
    key: 'status',
    dataIndex: 'status',
  },
  {
    title: 'Billed Status',
    key: 'billed_status',
    dataIndex: 'billed_status',
  },
  {
    title: 'Amount',
    key: 'amount',
    dataIndex: 'amount',
  },
  {
    title: 'Excepcted Delivery Date',
    key: 'expected_delivery_date',
    dataIndex: 'expected_delivery_date',
  },
];
const purchase_orders = [{
  key: '1',
  date: '10-10-2023',
  purchase_order_number: 'purchase_order-0001',
  reference_number: '',
  vendor_name: 'John Doe',
  status: 'Draft',
  due_date: '10-10-2023',
  amount: '1000.00',
  balance_due: '0.00',
},
//adding 5 more data with different purchase_order_number and vendor_name
{
  key: '2',
  date: '10-10-2023',
  purchase_order_number: 'purchase_order-0002',
  reference_number: '',
  vendor_name: 'John Doe',
  status: 'Draft',
  due_date: '10-10-2023',
  amount: '1000.00',
  balance_due: '0.00',
},
{
  key: '3',
  date: '10-10-2023',
  purchase_order_number: 'purchase_order-0003',
  reference_number: '',
  vendor_name: 'John Doe',
  status: 'Draft',
  due_date: '10-10-2023',
  amount: '1000.00',
  balance_due: '0.00',
},
{
  key: '4',
  date: '10-10-2023',
  purchase_order_number: 'purchase_order-0004',
  reference_number: '',
  vendor_name: 'John Doe',
  status: 'Draft',
  due_date: '10-10-2023',
  amount: '1000.00',
  balance_due: '0.00',
},
{
  key: '5',
  date: '10-10-2023',
  purchase_order_number: 'purchase_order-0005',
  reference_number: '',
  vendor_name: 'John Doe',
  status: 'Draft',
  due_date: '10-10-2023',
  amount: '1000.00',
  balance_due: '0.00',
},
{
  key: '6',
  date: '10-10-2023',
  purchase_order_number: 'purchase_order-0006',
  reference_number: '',
  vendor_name: 'John Doe',
  status: 'Draft',
  due_date: '10-10-2023',
  amount: '1000.00',
  balance_due: '0.00',
},
{
  key: '7',
  date: '10-10-2023',
  purchase_order_number: 'purchase_order-0007',
  reference_number: '',
  vendor_name: 'John Doe',
  status: 'Draft',
  due_date: '10-10-2023',
  amount: '1000.00',
  balance_due: '0.00',
},
{
  key: '8',
  date: '10-10-2023',
  purchase_order_number: 'purchase_order-0008',
  reference_number: '',
  vendor_name: 'John Doe',
  status: 'Draft',
  due_date: '10-10-2023',
  amount: '1000.00',
  balance_due: '0.00',
},
{
  key: '9',
  date: '10-10-2023',
  purchase_order_number: 'purchase_order-0009',
  reference_number: '',
  vendor_name: 'John Doe',
  status: 'Draft',
  due_date: '10-10-2023',
  amount: '1000.00',
  balance_due: '0.00',
}];
const purchase_ordercolumns = [{
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

// defining create purchase_order items const
const createPurchaseOrderItems = [{
  key: '1',
  item_details: 'item 1',
  quantity: '1',
  rate: '0.00',
  amount: '1000.00',
  balance_due: '0.00',
  action: '',
},
{
  key: '2',
  item_details: 'item 2',
  quantity: '1',
  rate: '0.00',
  amount: '1000.00',
  balance_due: '0.00',
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
      purchase_ordercolumns,
      purchase_orders,
      createPurchaseOrderItems
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