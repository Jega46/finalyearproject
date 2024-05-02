
<template>
  <Head title="Products" />
  <AuthenticatedLayout>
    <a-layout-content>
      <a-space direction="vertical" :style="{ width: '100%' }">
        <a-form name="nest-messages" :model="searchform" layout="inline" @finish="search">
          <a-form-item>
            <a-input placeholder="Search by product name" :allow-clear="true" v-model:value="searchform.term">
            </a-input>
          </a-form-item>
          <a-form-item>
            <a-select placeholder="Search by Category">
            </a-select>
          </a-form-item>
          <a-form-item>
            <a-select placeholder="Search by Brand">
            </a-select>
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
              Add New Product
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
        <a-table :columns="columns" :data-source="items">
          <template #bodyCell="{ column, record }">
            <template v-if="column.key === 'image'">
              <a-image :width="30" :height="30" :src="record.image"
                fallback="data:image/png;base64,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" />
            </template>
            <template v-if="column.key === 'name'">
              <a href="javascript:;" @click="showViewDrawer">{{ record.name }}</a>
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

      <a-drawer v-model:visible="createvisible" class="custom-class" title="New Product" :size="'large'" placement="right"
        @after-visible-change="afterVisibleChange">
        <a-form :model="form" v-bind="layout" name="nest-messages" :validate-messages="validateMessages" @finish="submit"
          :label-col="{ span: 24 }">
          <a-tabs v-model:activeKey="activeKey">
            <a-tab-pane key="pc-1" tab="Basic Information">
              <h4 class="t1">Details</h4>
              <a-row :gutter="24">
                <a-col class="gutter-row" :span="12">
                  <a-form-item label="Product Name" name="name" :rules="[{ required: true }]">
                    <a-input :placeholder="'Please enter name'" />
                  </a-form-item>
                </a-col>
                <a-col class="gutter-row" :span="12">
                  <a-form-item label="Image" name="image">
                    <a-upload :before-upload="beforeUpload" @remove="handleRemove" :max-count="1">
                      <a-button>
                        <upload-outlined></upload-outlined>
                        Select File
                      </a-button>
                    </a-upload>
                  </a-form-item>
                </a-col>
                <a-col class="gutter-row" :span="12">
                  <a-form-item label="Product Category" name="category">
                    <a-auto-complete :options="categories" :placeholder="'Select Category'" />
                  </a-form-item>
                </a-col>
                <a-col class="gutter-row" :span="12">
                  <a-form-item label="Brand" name="brand">
                    <a-auto-complete :placeholder="'Select Brand'" />
                  </a-form-item>
                </a-col>
                <a-col class="gutter-row" :span="6">
                  <a-form-item label="Barcode Symbology" name="sku">
                    <a-select>
                      <a-select-option value="CODE128">CODE128</a-select-option>
                      <a-select-option value="CODE39">CODE39</a-select-option>
                    </a-select>
                  </a-form-item>
                </a-col>
                <a-col class="gutter-row" :span="18">
                  <a-form-item label="Barcode" name="sku">
                    <a-input :placeholder="'Enter Barcode'">
                      <template #addonAfter>
                        <a-button style="width: 100px">
                          <BarcodeOutlined /> Generate
                        </a-button>
                      </template>
                    </a-input>
                  </a-form-item>
                </a-col>
                <a-col class="gutter-row" :span="12">
                  <a-form-item label="HSN Code" name="hsn">
                    <a-input :placeholder="'Enter HSN Code'" />
                  </a-form-item>
                </a-col>
                <a-col class="gutter-row" :span="12">
                  <a-form-item label="Unit" name="unit">
                    <a-auto-complete :placeholder="'Select Unit'" />
                  </a-form-item>
                </a-col>
              </a-row>
              <h4 class="t1">Pricing & Tax</h4>
              <a-row :gutter="24">
                <a-col class="gutter-row" :span="12">
                  <a-form-item label="Sales Price (INR)" name="sales_price">
                    <a-input-number style="width:100%" :placeholder="'Enter sales price'">
                      <template #addonAfter>
                        <a-select style="width: 100px">
                          <a-select-option value="With Tax">With Tax</a-select-option>
                          <a-select-option value="Without Tax">Without Tax</a-select-option>
                        </a-select>
                      </template>
                    </a-input-number>
                  </a-form-item>
                </a-col>

                <a-col class="gutter-row" :span="12">
                  <a-form-item label="Purchase Price (INR)" name="purchase_price">
                    <a-input-number style="width:100%" :placeholder="'Enter purchase price'">
                      <template #addonAfter>
                        <a-select style="width: 100px">
                          <a-select-option value="With Tax">With Tax</a-select-option>
                          <a-select-option value="Without Tax">Without Tax</a-select-option>
                        </a-select>
                      </template>
                    </a-input-number>
                  </a-form-item>
                </a-col>
                <a-col class="gutter-row" :span="12">
                  <a-form-item label="Tax Rate" name="tax">
                    <a-select show-search placeholder="Tax" :default-active-first-option="false"
                      :placeholder="'Select Tax'"></a-select>
                  </a-form-item>
                </a-col>
              </a-row>
              <h4 class="t1">Description</h4>
              <a-form-item label="Description" name="description">
                <a-textarea :placeholder="'Enter Description'" />
              </a-form-item>
              <a-form-item :wrapper-col="{ span: 12 }">
                <a-button type="primary" html-type="submit" :disabled="form.processing">SUBMIT</a-button>
              </a-form-item>
            </a-tab-pane>
            <a-tab-pane key="pc-2" tab="Raw Materials (Optional)">
              <a-table :columns="[{
                title: 'Item',
                dataIndex: 'item',
                width: '60%',
              }, {
                title: 'Unit',
                dataIndex: 'unit',
              }, {
                title: 'Yield',
                dataIndex: 'yield',
              }]" :data-source="[{ item: 'Item-1', unit: 'Pcs', yield: '1' }]" :pagination="false">
                <template #bodyCell="{ column, text }">
                  <template v-if="column.dataIndex === 'item'">
                    <a-auto-complete :placeholder="'Select Item'" style="width:100%" />
                  </template>
                  <template v-if="column.dataIndex === 'unit'">
                    Pcs
                  </template>
                  <template v-if="column.dataIndex === 'yield'">
                    <a-input-number style="width:100%" :placeholder="'Enter yield'">
                    </a-input-number>
                  </template>
                </template>
              </a-table>
              <a-button type="success" :size="'small'">
                <template #icon>
                  <plus-circle-outlined />
                </template>
                Add
              </a-button>
            </a-tab-pane>
            <a-tab-pane key="pc-3" tab="Operations (Optional)">
              <a-table :columns="[{
                title: 'Machine/Operation',
                dataIndex: 'machine_operation',
                width: '60%',
              }, {
                title: 'Operation Parameters',
                dataIndex: 'operation_parameters',
              }, {
                title: 'End Machine/Operation',
                dataIndex: 'end_machine_operation',
              }]" :data-source="[
  { machine_operation: 'Cutting', operation_parameters: 'Cutting Details', end_machine_operation: 'Machine-1' },
  { machine_operation: 'Machine-2', operation_parameters: 'Operation-2', end_machine_operation: 'Machine-2' }
]" :pagination="false">
                <template #bodyCell="{ column, text }">
                  <template v-if="column.dataIndex === 'machine_operation'">
                    <a-auto-complete :placeholder="'Select Machine / Operation'" style="width:100%" :options="[
                      { value: 'Cutting' },
                      { value: 'Stiching' },
                      { value: 'Printing' },
                      { value: 'Iorning' },
                      { value: 'Packing' }
                    ]" />
                  </template>
                  <template v-if="column.dataIndex === 'operation_parameters'">
                    <a-textarea :placeholder="'Enter Operation Parameters'" />
                  </template>
                  <template v-if="column.dataIndex === 'end_machine_operation'">
                    <a-checkbox :checked="true">End</a-checkbox>
                  </template>
                </template>
              </a-table>
              <a-button type="success" :size="'small'">
                <template #icon>
                  <plus-circle-outlined />
                </template>
                Add
              </a-button>
            </a-tab-pane>
          </a-tabs>
        </a-form>
        <template #extra>
          <a-space>
            <a-button type="primary" @click="onClose">Save</a-button>
          </a-space>
        </template>
      </a-drawer>
      <a-drawer v-model:visible="showdetail" class="custom-class" title="Product 1" :size="'large'" placement="right"
        @after-visible-change="afterVisibleChange">
        <a-tabs v-model:activeKey="activeKey">
          <a-tab-pane key="Overview" tab="Overview">
            <a-descriptions :size="size">
              <a-descriptions-item label="Product Name" :span="4">Product 1</a-descriptions-item>
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
import { computed, defineComponent, ref } from 'vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';

import {
  DownloadOutlined,
  PlusCircleOutlined,
  BarcodeOutlined,
  UploadOutlined,
  DeleteOutlined,
  EditOutlined,
  DownCircleOutlined,
  CloudUploadOutlined
} from '@ant-design/icons-vue';
import axios from 'axios';
const columns = [
  {
    title: '',
    key: 'image',
    dataIndex: 'image',
    width: '1%',
  },
  {
    title: 'Product Name',
    key: 'name',
    dataIndex: 'name',
    width: '5%',
  },
  {
    title: 'Category',
    key: 'category',
    dataIndex: 'category',
    width: '5%',
  },
  {
    title: 'Brand',
    key: 'brand',
    dataIndex: 'brand',
    width: '5%',
  },
  {
    title: 'Sales Price (INR)',
    key: 'sales_price',
    dataIndex: 'sales_price',
    width: '5%',
  },
  {
    title: 'Purchase Price (INR)',
    key: 'purchase_price',
    dataIndex: 'purchase_price',
    width: '5%',
  },
  {
    title: 'Action',
    key: 'action',
    fixed: 'right',
    width: '2%',
  },
];
const items = [{
  id: '1',
  image: 'https://gw.alipayobjects.com/zos/rmsportal/KDpgvguMpGfqaHPjicRK.svg',
  name: 'Product 1',
  category: 'Category 1',
  brand: 'Brand 1',
  sales_price: '100',
  purchase_price: '50',
  action: ''
}, {
  id: '2',
  image: 'https://gw.alipayobjects.com/zos/rmsportal/KDpgvguMpGfqaHPjicRK.svg',
  name: 'Product 2',
  category: 'Category 2',
  brand: 'Brand 2',
  sales_price: '100',
  purchase_price: '50',
  action: ''
},
{
  id: '3',
  image: 'https://gw.alipayobjects.com/zos/rmsportal/KDpgvguMpGfqaHPjicRK.svg',
  name: 'Product 3',
  category: 'Category 3',
  brand: 'Brand 3',
  sales_price: '100',
  purchase_price: '50',
  action: ''
},
{
  id: '4',
  image: 'https://gw.alipayobjects.com/zos/rmsportal/KDpgvguMpGfqaHPjicRK.svg',
  name: 'Product 4',
  category: 'Category 4',
  brand: 'Brand 4',
  sales_price: '100',
  purchase_price: '50',
  action: ''
}];

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
  components: {
    AuthenticatedLayout, DownloadOutlined, UploadOutlined, PlusCircleOutlined, DeleteOutlined, BarcodeOutlined, DownCircleOutlined, CloudUploadOutlined,
    EditOutlined, Head, Link,
    InputError
  },
  props: {
  },
  setup(props) {
    return {
      columns,
      items,
      invoicetransactions_column,
      invoicetransactions
    };
  },
  data() {
    const searchform = useForm({
      term: '',
    });
    const layout = {
      labelCol: { span: 8 },
      wrapperCol: { span: 24 },
    };
    const form = useForm({
    });
    return {
      createvisible: false,
      searchform,
      form,
      layout,
      showdetail: false
    };
  },
  methods: {
    showDrawer() {
      this.createvisible = true;
    },
    showViewDrawer() {
      this.showdetail = true;
    },
  }
});
</script>