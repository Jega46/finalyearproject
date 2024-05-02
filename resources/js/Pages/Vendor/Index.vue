
<template>
  <Head title="Vendors" />
  <AuthenticatedLayout>
    <a-layout-content>
      <a-space direction="vertical" :style="{ width: '100%' }">
        <a-form name="nest-messages" :model="searchformState" layout="inline" @finish="search" class="searchForm">
          <a-form-item>
            <a-input placeholder="Search by vendor name" :allow-clear="true" v-model:value="searchformState.term">
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
              Add New Vendor
            </a-button>
          </a-form-item>
        </a-form>
        <a-table :columns="columns" :data-source="vendors" :pagination="pagination">
          <template #bodyCell="{ column, record }">
            <template v-if="column.key === 'vendor_name'">
              <a href="javascript:;" @click="showVendorDetailDrawer">
                {{ record.vendor_name }}
              </a>
            </template>
            <template v-if="column.key === 'action'">
              <a-dropdown>
                <a-button type="primary" :size="size" class="ant-dropdown-link" shape="circle">
                  <template #icon>
                    <more-outlined />
                  </template>
                </a-button>
                <template #overlay>
                  <a-menu>
                    <a-menu-item>
                      <a href="javascript:;">
                        <edit-outlined />
                        Edit
                      </a>
                    </a-menu-item>
                    <a-menu-item>
                      <a href="javascript:;">
                        <delete-outlined />
                        Delete
                      </a>
                    </a-menu-item>
                  </a-menu>
                </template>
              </a-dropdown>
            </template>
          </template>
        </a-table>
      </a-space>
      <a-drawer v-model:visible="createvisible" class="custom-class" title="New Vendor" :size="'large'"
        placement="right" @after-visible-change="afterVisibleChange">
        <a-form v-bind="layout" name="nest-messages" :label-col="{ span: 24 }">
          <a-row :gutter="24">
            <a-col class="gutter-row" :span="12">
              <a-form-item label="Vendor Name" :rules="[{ required: true }]">
                <a-input placeholder="Vendor Name" />
              </a-form-item>
            </a-col>
            <a-col class="gutter-row" :span="12">
              <a-form-item label="Company Name">
                <a-input placeholder="Company Name" />
              </a-form-item>
            </a-col>
            <a-col class="gutter-row" :span="12">
              <a-form-item label="Work Phone" :rules="[{ required: true }]">
                <a-input placeholder="Work Phone" />
              </a-form-item>
            </a-col>
            <a-col class="gutter-row" :span="12">
              <a-form-item label="Mobile Number" :rules="[{ required: true }]">
                <a-input placeholder="Mobile Number" />
              </a-form-item>
            </a-col>
            <a-col class="gutter-row" :span="12">
              <a-form-item label="Email">
                <a-input placeholder="Email" />
              </a-form-item>
            </a-col>
           
            <a-col class="gutter-row" :span="12">
              <a-form-item label="GSTIN">
                <a-input placeholder="GSTIN" />
              </a-form-item>
            </a-col>
            <a-col class="gutter-row" :span="12">
              <a-form-item label="Contact Person Name">
                <a-input placeholder="Contact Person Name" />
              </a-form-item>
            </a-col>
            <a-col class="gutter-row" :span="12">
              <a-form-item label="Contact Person Mobile">
                <a-input placeholder="Contact Person Mobile" />
              </a-form-item>
            </a-col>
          </a-row>
          <h4 class="t1">Billing Address</h4>
          <a-row :gutter="24">
            <a-col class="gutter-row" :span="12">
              <a-form-item label="Address">
                <a-input placeholder="Address" />
              </a-form-item>
            </a-col>
            <a-col class="gutter-row" :span="12">
              <a-form-item label="City">
                <a-input placeholder="City" />
              </a-form-item>
            </a-col>
            <a-col class="gutter-row" :span="12">
              <a-form-item label="State">
                <a-input placeholder="State" />
              </a-form-item>
            </a-col>
            <a-col class="gutter-row" :span="12">
              <a-form-item label="Pincode">
                <a-input placeholder="Pincode" />
              </a-form-item>
            </a-col>
          </a-row>
          <h4 class="t1">Shipping Address</h4>
          <a-row :gutter="24">
            <a-col class="gutter-row" :span="12">
              <a-form-item label="Address">
                <a-input placeholder="Address" />
              </a-form-item>
            </a-col>
            <a-col class="gutter-row" :span="12">
              <a-form-item label="City">
                <a-input placeholder="City" />
              </a-form-item>
            </a-col>
            <a-col class="gutter-row" :span="12">
              <a-form-item label="State">
                <a-input placeholder="State" />
              </a-form-item>
            </a-col>
            <a-col class="gutter-row" :span="12">
              <a-form-item label="Pincode">
                <a-input placeholder="Pincode" />
              </a-form-item>
            </a-col>
          </a-row>
          <a-form-item :wrapper-col="{ span: 12 }">
            <a-button type="primary" html-type="submit">SUBMIT</a-button>
          </a-form-item>
        </a-form>
      </a-drawer>
      <a-drawer v-model:visible="showdetail" class="custom-class" title="John Brown" :size="'large'" placement="right"
        @after-visible-change="afterVisibleChange">
        <a-tabs v-model:activeKey="activeKey">
          <a-tab-pane key="Overview" tab="Overview">
            <a-descriptions :size="size">
              <a-descriptions-item label="Vendor Name" :span="4">John Brown</a-descriptions-item>
              <a-descriptions-item label="Mobile Number">+91 9876543210</a-descriptions-item>
              <a-descriptions-item label="Email ID">mona.azhagesan@gmail.com</a-descriptions-item>
            </a-descriptions>
          </a-tab-pane>
          <a-tab-pane key="Transactions" tab="Transactions" force-render>
            <a-space>
              <a-select ref="select" placeholder="Filter By">
                <a-select-option value="jack">Invoice</a-select-option>
                <a-select-option value="lucy">Sales Order</a-select-option>
                <a-select-option value="disabled">Quote</a-select-option>
                <a-select-option value="Yiminghe">Purchase Order</a-select-option>
              </a-select>
              <a-select ref="select" placeholder="Status">
                <a-select-option value="jack">All</a-select-option>
                <a-select-option value="lucy">Draft</a-select-option>
              </a-select>
            </a-space>
            <a-table :columns="invoicetransactions_column" :data-source="invoicetransactions">
            </a-table>
          </a-tab-pane>
        </a-tabs>
        <template #extra>
          <a-space>
            <a-button @click="onClose">Edit</a-button>
            <a-button type="primary" @click="onClose">Delete</a-button>
            <a-dropdown>
              <template #overlay>
                <a-menu @click="handleMenuClick">
                  <a-menu-item key="1">
                    Invoice
                  </a-menu-item>
                  <a-menu-item key="2">
                    Quote
                  </a-menu-item>
                  <a-menu-item key="3">
                    Sales Order
                  </a-menu-item>
                  <a-menu-item key="3">
                    Payment
                  </a-menu-item>
                </a-menu>
              </template>
              <a-button>
                New Transaction
                <PlusOutlined />
              </a-button>
            </a-dropdown>
          </a-space>
        </template>
      </a-drawer>
    </a-layout-content>
  </AuthenticatedLayout>
</template>

<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { usePagination } from 'vue-request';
import { computed, defineComponent } from 'vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';


import {
  DownloadOutlined,
  PlusCircleOutlined,
  MoreOutlined,
  UploadOutlined,
  PlusOutlined
} from '@ant-design/icons-vue';
import axios from 'axios';
const columns = [
  {
    title: 'Vendor Name',
    key: 'vendor_name',
    dataIndex: 'vendor_name',
    width: '5%',
  },
  {
    title: 'Company Name',
    key: 'company_name',
    dataIndex: 'company_name',
    width: '5%',
  },
  {
    title: 'Work Phone',
    key: 'work_phone',
    dataIndex: 'work_phone',
    width: '5%',
  },
  {
    title: 'Email',
    key: 'email',
    dataIndex: 'email',
    width: '5%',
  },
  {
    title: 'GSTIN',
    key: 'gstin',
    dataIndex: 'gstin',
    width: '5%',
  },
  {
    title: 'Action',
    key: 'action',
    fixed: 'right',
    width: '2%',
  },
];
// defining vendors constant with 10 sample data
const vendors = [
  {
    key: '1',
    vendor_name: 'John Brown',
    work_phone: 9876543210,
    email: 'test@gmail.com',
    company_name: 'ABC Company',
    gstin: 'GSTIN12345',
  },
  {
    key: '2',
    vendor_name: 'Jim Green',
    work_phone: 9876543210,
    email: 'test2@gmail.com',
    company_name: 'XYZ Company',
    gstin: 'GSTIN12345',
  },
  {
    key: '3',
    vendor_name: 'Joe Black',
    work_phone: 9876543210,
    email: '',
    company_name: 'ABC Company',
    gstin: 'GSTIN12345',
  },
  {
    key: '4',
    vendor_name: 'John Brown',
    work_phone: 9876543210,
    email: '',
    company_name: 'ABC Company',
    gstin: 'GSTIN12345',
  }];

// defining pagination constant
const pagination = {
  current: 1,
  pageSize: 10,
  total: 14,
  showSizeChanger: true,
  showTotal: (total, range) => `${range[0]}-${range[1]} of ${total} items`,
};

// defining invoicetransactions_column
const invoicetransactions_column = [
  {
    title: 'Date',
    key: 'date',
    dataIndex: 'date',
    width: '15%',
  },
  {
    title: 'Invoice Number',
    key: 'invoice_number',
    dataIndex: 'invoice_number',
    width: '15%',
  },
  {
    title: 'Vendor Name',
    key: 'vendor_name',
    dataIndex: 'vendor_name',
    width: '2%',
  },
  {
    title: 'Quantity Sold',
    key: 'quantity_sold',
    dataIndex: 'quantity_sold',
    width: '10%',
  },
  {
    title: 'Price',
    key: 'price',
    dataIndex: 'price',
    width: '2%',
  },
  {
    title: 'Total',
    key: 'total',
    dataIndex: 'total',
    width: '2%',
  },
  {
    title: 'Status',
    key: 'status',
    dataIndex: 'status',
    width: '2%',
  },
];
// defining invoicetransactions constant with 2 sample data
const invoicetransactions = [
  {
    key: '1',
    date: '10-10-2023',
    invoice_number: 'INV-0001',
    quantity_sold: 1,
    vendor_name: 'John',
    price: 12000,
    total: 12000,
    status: 'Open',
  },
  {
    key: '2',
    date: '10-10-2023',
    invoice_number: 'INV-0002',
    quantity_sold: 1,
    vendor_name: 'John',
    price: 12000,
    total: 12000,
    status: 'Open',
  },
];



export default ({
  components: { AuthenticatedLayout, DownloadOutlined, UploadOutlined, PlusCircleOutlined, MoreOutlined, Head, Link, InputError, PlusOutlined },
  props: {
  },
  setup(props) {
    return {
      columns,
      vendors,
      pagination,
      invoicetransactions_column,
      invoicetransactions
    };
  },
  data() {
    const loading = false;
    const searchformState = useForm({
      term: '',
    });
    const layout = {
      labelCol: { span: 8 },
      wrapperCol: { span: 24 },
    };
    const formState = useForm({
    });
    return {
      createvisible: false,
      showdetail: false,
      formState,
      layout,
      searchformState,
      loading
    };
  },
  methods: {
    showDrawer() {
      this.createvisible = true;
    },
    showVendorDetailDrawer() {
      this.showdetail = true;
    },
  }
});
</script>