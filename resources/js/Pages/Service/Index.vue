
<template>
  <Head title="Services" />
  <AuthenticatedLayout>
    <a-layout-content>
      <a-space direction="vertical" :style="{ width: '100%' }">
        <a-form name="nest-messages" :model="form" layout="inline" @finish="search">
          <a-form-item>
            <a-input placeholder="Search by service name" :allow-clear="true" v-model:value="searchform.term">
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
              Add New Service
            </a-button>
          </a-form-item>
          <a-form-item>
            <a-button type="primary" shape="round" @click="showDrawer">
              <template #icon>
                <CloudUploadOutlined />
              </template>
              Import
            </a-button>
          </a-form-item>
        </a-form>
        <a-table :columns="columns" :data-source="services" :pagination="pagination">
          <template #bodyCell="{ column, record }">
            <template v-if="column.key === 'name'">
              <a @click="showServiceDetailDrawer">
                {{ record.name }}
              </a>
            </template>
            <template v-if="column.key === 'action'">
              <a-dropdown>
                <a-button type="primary" :size="size" class="ant-dropdown-link" shape="circle">
                  <template #icon>
                    <DownCircleOutlined />
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
      <a-drawer v-model:visible="createvisible" class="custom-class" title="New Service" :size="'large'" placement="right"
        @after-visible-change="afterVisibleChange">
        <a-form :model="form" v-bind="layout" name="nest-messages" :loading="formloading"
          :validate-messages="validateMessages" @finish="submit" :label-col="{ span: 24 }">
          <h4 class="t1">Details</h4>
          <a-row :gutter="24">
            <a-col class="gutter-row" :span="12">
              <a-form-item label="Service Name" name="name" :rules="[{ required: true }]">
                <a-input placeholder="Please enter service name" />
              </a-form-item>
            </a-col>
            <a-col class="gutter-row" :span="12">
              <a-form-item label="Category" name="name" :rules="[{ required: true }]">
                <a-select show-search placeholder="Select Category" :default-active-first-option="false"
                  :not-found-content="value"></a-select>
              </a-form-item>
            </a-col>
            <a-col class="gutter-row" :span="12">
              <a-form-item label="SAC" name="sac">
                <a-input placeholder="Enter SAC" />
              </a-form-item>
            </a-col>
            <a-col class="gutter-row" :span="12">
              <a-form-item label="Unit" name="unit">
                <a-auto-complete placeholder="Select Unit" />
              </a-form-item>
            </a-col>
          </a-row>
          <h4 class="t1">Pricing & Tax</h4>
          <a-row :gutter="24">
            <a-col class="gutter-row" :span="12">
              <a-form-item label="Rate (INR)" name="rate">
                <a-input-number placeholder="Enter service rate" style="width:100%" />
              </a-form-item>
            </a-col>
            <a-col class="gutter-row" :span="12">
              <a-form-item label="Tax" name="tax">
                <a-select show-search placeholder="Tax" :default-active-first-option="false"
                  :not-found-content="value"></a-select>
              </a-form-item>
            </a-col>
          </a-row>
          <h4 class="t1">Description</h4>
          <a-form-item label="Description" name="description">
            <a-textarea placeholder="Enter Description" />
          </a-form-item>
          <a-form-item :wrapper-col="{ span: 12 }">
            <a-button type="primary" html-type="submit" :disabled="form.processing">SUBMIT</a-button>
          </a-form-item>
        </a-form>
      </a-drawer>
      <a-drawer v-model:visible="serviceDetailDrawer" class="custom-class" title="Service 1" :size="'large'"
        placement="right" @after-visible-change="afterVisibleChange">
        <a-tabs v-model:activeKey="activeKey">
          <a-tab-pane key="Overview" tab="Overview">
            <a-descriptions :size="size">
              <a-descriptions-item label="Service Name" :span="4">Service 1</a-descriptions-item>
              <a-descriptions-item label="Description">Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean
                commodo ligula eget</a-descriptions-item>
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
  UploadOutlined,
  DeleteOutlined,
  EditOutlined,
  CloudUploadOutlined
} from '@ant-design/icons-vue';
import axios from 'axios';
const columns = [
  {
    title: 'Service Name',
    key: 'name',
    dataIndex: 'name',
    width: '15%',
  },
  {
    title: 'SAC',
    key: 'sac',
    dataIndex: 'sac',
    width: '15%',
  },
  {
    title: 'Rate (INR)',
    key: 'rate',
    dataIndex: 'rate',
    width: '10%',
  },
  {
    title: 'Action',
    key: 'action',
    fixed: 'right',
    width: '2%',
  },
];
// defining services constant with sample data and pagination
const services = [
  {
    key: '1',
    name: 'John Brown',
    sac: 'FOC1400C',
    rate: 12000,
    action: '',
  },
  {
    key: '2',
    name: 'Jim Green',
    sac: 'FOC1400C',
    rate: 12000,
    action: '',
  },
  {
    key: '3',
    name: 'Joe Black',
    sac: 'FOC1400C',
    rate: 12000,
    action: '',
  },
  {
    key: '4',
    name: 'John Brown',
    sac: 'FOC1400C',
    rate: 12000,
    action: '',
  },
  {
    key: '5',
    name: 'Jim Green',
    sac: 'FOC1400C',
    rate: 12000,
    action: '',
  },
  {
    key: '6',
    name: 'Joe Black',
    sac: 'FOC1400C',
    rate: 12000,
    action: '',
  },
  {
    key: '7',
    name: 'John Brown',
    sac: 'FOC1400C',
    rate: 12000,
    action: '',
  },
  {
    key: '8',
    name: 'Jim Green',
    sac: 'FOC1400C',
    rate: 12000,
    action: '',
  },
  {
    key: '9',
    name: 'Joe Black',
    sac: 'FOC1400C',
    rate: 12000,
    action: '',
  },
  {
    key: '10',
    name: 'John Brown',
    sac: 'FOC1400C',
    rate: 12000,
    action: '',
  },
  {
    key: '11',
    name: 'Jim Green',
    sac: 'FOC1400C',
    rate: 12000,
    action: '',
  },
  {
    key: '12',
    name: 'Joe Black',
    sac: 'FOC1400C',
    rate: 12000,
    action: '',
  },
  {
    key: '13',
    name: 'John Brown',
    sac: 'FOC1400C',
    rate: 12000,
    action: '',
  },
  {
    key: '14',
    name: 'Jim Green',
    sac: 'FOC1400C',
    rate: 12000,
    action: '',
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
    title: 'Customer Name',
    key: 'customer_name',
    dataIndex: 'customer_name',
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
    customer_name: 'John',
    price: 12000,
    total: 12000,
    status: 'Open',
  },
  {
    key: '2',
    date: '10-10-2023',
    invoice_number: 'INV-0002',
    quantity_sold: 1,
    customer_name: 'John',
    price: 12000,
    total: 12000,
    status: 'Open',
  },
];

export default ({
  components: { AuthenticatedLayout, DownloadOutlined, UploadOutlined, PlusCircleOutlined, DeleteOutlined, EditOutlined, Head, Link, InputError, CloudUploadOutlined },
  props: {
  },
  setup(props) {
    return {
      columns,
      services,
      pagination,
      invoicetransactions_column,
      invoicetransactions
    };
  },
  data() {
    const searchform = useForm({
      term: '',
    });
    const layout = {
      labelCol: { span: 24 },
      wrapperCol: { span: 24 },
    };
    const form = useForm({
    });
    return {
      createvisible: false,
      layout,
      form,
      searchform,
      serviceDetailDrawer: false,
    };
  },
  methods: {
    showDrawer() {
      this.createvisible = true;
    },
    showServiceDetailDrawer() {
      this.serviceDetailDrawer = true;
    },
  }
});
</script>