
<template>
  <Head title="Raw materials" />
  <AuthenticatedLayout>
    <a-layout-content>
      <a-space direction="vertical" :style="{ width: '100%' }">
        <a-form name="nest-messages" :model="searchform" layout="inline" @finish="search">
          <a-form-item>
            <a-input placeholder="Search" :allow-clear="true" v-model:value="searchform.term">
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
              Add
            </a-button>
          </a-form-item>
        </a-form>
        <a-table :columns="columns" :data-source="raw_materials">
        </a-table>
      </a-space>
      <a-drawer v-model:visible="create_form_visible" class="sales-bill" :size="'large'" style="color: red;" width="60%"
        title="New raw material" placement="right" @after-visible-change="afterVisibleChange">
        <a-form :model="form" v-bind="layout" name="nest-messages" :validate-messages="validateMessages" @finish="submit"
          :label-col="{ span: 24 }" style="min-height: 100%;">
          <a-row :gutter="24">
            <a-col class="gutter-row" span="12">
              <a-form-item name="name" label="Name" :rules="[{ required: true }]">
                <a-input v-model:value="form.name" />
              </a-form-item>
            </a-col>
            <a-col class="gutter-row" span="12">
              <a-form-item name="name" label="Unit" :rules="[{ required: true }]">
                <a-select v-model:value="form.unit" show-search placeholder="Unit" style="width: 100%"
                  :default-active-first-option="false" :not-found-content="value">
                </a-select>
              </a-form-item>
            </a-col>
            <a-col class="gutter-row" span="12">
              <a-form-item name="price" label="Price">
                <a-input v-model:value="form.price" />
              </a-form-item>
            </a-col>
            <a-col class="gutter-row" span="12">
              <a-form-item name="name" label="Tax rates">
                <a-select v-model:value="form.tax" show-search placeholder="Tax rates" style="width: 100%"
                  :default-active-first-option="false" :not-found-content="value">
                </a-select>
              </a-form-item>
            </a-col>
            <a-col class="gutter-row" span="12">
              <a-form-item name="name" label="Default Suppliers">
                <a-select v-model:value="form.tax" show-search placeholder="Default Suppliers" style="width: 100%"
                  :default-active-first-option="false" :not-found-content="value">
                </a-select>
              </a-form-item>
            </a-col>
            <a-col class="gutter-row" span="12">
              <a-form-item name="name" label="Default Inventory">
                <a-select v-model:value="form.tax" show-search placeholder="Default Inventory" style="width: 100%"
                  :default-active-first-option="false" :not-found-content="value">
                </a-select>
              </a-form-item>
            </a-col>
            <a-col class="gutter-row" span="12">
              <a-form-item name="name" label="EAN">
                <a-input v-model:value="form.name" />
              </a-form-item>
            </a-col>
            <a-col class="gutter-row" span="12">
              <a-form-item name="name" label="Optimal Stock Level">
                <a-input v-model:value="form.name" />
              </a-form-item>
            </a-col>
            <a-col class="gutter-row" span="12">
              <a-form-item name="name" label="Low Stock Level">
                <a-input v-model:value="form.name" />
              </a-form-item>
            </a-col>
          </a-row>
          <a-row :gutter="24">
            <a-col class="gutter-row" span="4">
              <a-button type="primary" html-type="submit" :disabled="form.processing" block>SAVE</a-button>
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
    title: 'Name',
    key: 'name',
    dataIndex: 'name',
  },
  {
    title: 'Unit',
    key: 'unit',
    dataIndex: 'unit',
  },
  {
    title: 'Price',
    key: 'price',
    dataIndex: 'price',
  },
  {
    title: 'Tax Rate',
    key: 'tax_rate',
    dataIndex: 'tax_rate',
  },
  {
    title: 'Default Supplier',
    key: 'default_supplier',
    dataIndex: 'default_supplier',
  },
  {
    title: 'Default Inventory',
    key: 'default_inventory',
    dataIndex: 'default_inventory',
  },
  {
    title: 'EAN',
    key: 'ean',
    dataIndex: 'ean',
  },
  {
    title: 'Low stock level',
    key: 'low_stock_level',
    dataIndex: 'low_stock_level',
  }
];
const raw_materials = [
  {
    key: '1',
    name: 'Raw material 1',
    unit: 'PCS',
    price: '56.00',
    tax_rate: '23%',
    default_supplier: 'Mona',
    default_inventory: 'Shop Floor',
    ean: 'BNMSGP00922',
    low_stock_level: '100',
  },
  {
    key: '1',
    name: 'Raw material 1',
    unit: 'PCS',
    price: '56.00',
    tax_rate: '23%',
    default_supplier: 'Mona',
    default_inventory: 'Shop Floor',
    ean: 'BNMSGP00922',
    low_stock_level: '100',
  },
  {
    key: '1',
    name: 'Raw material 1',
    unit: 'PCS',
    price: '56.00',
    tax_rate: '23%',
    default_supplier: 'Mona',
    default_inventory: 'Shop Floor',
    ean: 'BNMSGP00922',
    low_stock_level: '100',
  },
  {
    key: '1',
    name: 'Raw material 1',
    unit: 'PCS',
    price: '56.00',
    tax_rate: '23%',
    default_supplier: 'Mona',
    default_inventory: 'Shop Floor',
    ean: 'BNMSGP00922',
    low_stock_level: '100',
  },
  {
    key: '1',
    name: 'Raw material 1',
    unit: 'PCS',
    price: '56.00',
    tax_rate: '23%',
    default_supplier: 'Mona',
    default_inventory: 'Shop Floor',
    ean: 'BNMSGP00922',
    low_stock_level: '100',
  },
];
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
      raw_materials,
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