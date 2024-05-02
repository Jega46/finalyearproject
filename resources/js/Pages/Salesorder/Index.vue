
<template>
  <Head title="Sales Orders" />
  <AuthenticatedLayout>
    <a-layout-content >
      <a-space direction="vertical" :style="{ width: '100%' }">
        <a-form name="nest-messages" :model="formState" layout="inline" @finish="search">
          <a-form-item>
            <a-input placeholder="Search by product name" :allow-clear="true" v-model:value="formState.term">
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
              New Sales Order
            </a-button>
          </a-form-item>
        </a-form>
        <a-table :columns="columns" :row-key="product => product.id" :data-source="products.data" :pagination="pagination"
          :loading="loading" @change="handleTableChange">
          <template #bodyCell="{ column, text, record }">
            <template v-if="column.key === 'action'">
              <a-dropdown>
                <template #overlay>
                  <a-menu>
                    <a-menu-item key="1">
                      Edit
                    </a-menu-item>
                    <a-menu-item key="4" @click="deleteBranch(record.id)">
                      Delete
                    </a-menu-item>
                  </a-menu>
                </template>
                <a-button>
                  <more-outlined />
                  <DownOutlined />
                </a-button>
              </a-dropdown>
            </template>
          </template>
        </a-table>
      </a-space>
      <a-drawer v-model:visible="create_form_visible" class="sales-bill" :size="'large'" style="color: red"
        title="New Sales Oerder" placement="right" @after-visible-change="afterVisibleChange">
        <a-form :model="formState" v-bind="layout" name="nest-messages" :validate-messages="validateMessages"
          @finish="submit" :label-col="{ span: 24 }">
          <div class="address">
            <a-row>
              <a-col :span="8">
                <img src="https://moziztech.com/images/logo/moziz-logo.png" style="max-width: 200px;" />
              </a-col>
              <a-col :span="16">
                <p>KK Nagar, Karthick raja complex, Madurai - 625020</p>
                <p>Email: support@moziztech.com</p>
                <p>Phone: 8072403631</p>
                <p>GSTIN: 33NN0033SSJJ933</p>
              </a-col>
            </a-row>
          </div>
          <hr />
          <a-row>
            <a-col :span="12">
              <table>
                <tr>
                  <th>Order / Bill No</th>
                  <td style="width:40px">:</td>
                  <td>12560</td>
                </tr>
              </table>
            </a-col>
            <a-col :span="12">
              <table>
                <tr>
                  <th>Date</th>
                  <td style="width:40px">:</td>
                  <td>10-10-2023</td>
                </tr>
              </table>
            </a-col>
          </a-row>
          <hr />
          <table class="products-table">
            <thead>
              <tr>
                <th>Item Name</th>
                <th>Qty</th>
                <th>Mrp</th>
                <th>Rate</th>
                <th>Amount</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>
                  <a-select v-model:value="value" show-search placeholder="Category" style="width: 100%"
                    :default-active-first-option="false" :show-arrow="true" :filter-option="false"
                    :options="[{ value: 'Mobile', label: 'Mobile' }]" :not-found-content="value" @search="handleSearch"
                    :bordered="false" @change="handleChange"></a-select>
                </td>
                <td>
                  <a-input-number v-model:value="formState.price" style="width:100%" :bordered="false" />
                </td>
                <td>
                </td>
                <td>
                </td>
                <td>
                </td>
              </tr>
              <tr>
                <td>
                  <a-select v-model:value="value" show-search placeholder="Category" style="width: 100%"
                    :default-active-first-option="false" :show-arrow="true" :filter-option="false"
                    :options="[{ value: 'Mobile', label: 'Mobile' }]" :not-found-content="value" @search="handleSearch"
                    :bordered="false" @change="handleChange"></a-select>
                </td>
                <td>
                  <a-input-number v-model:value="formState.price" style="width:100%" :bordered="false" />
                </td>
                <td>
                </td>
                <td>
                </td>
                <td>
                </td>
              </tr>
              <tr>
                <td>
                  <a-select v-model:value="value" show-search placeholder="Category" style="width: 100%"
                    :default-active-first-option="false" :show-arrow="true" :filter-option="false"
                    :options="[{ value: 'Mobile', label: 'Mobile' }]" :not-found-content="value" @search="handleSearch"
                    :bordered="false" @change="handleChange"></a-select>
                </td>
                <td>
                  <a-input-number v-model:value="formState.price" style="width:100%" :bordered="false" />
                </td>
                <td>
                </td>
                <td>
                </td>
                <td>
                </td>
              </tr>
            </tbody>
          </table>
          <hr />
          <a-row>
            <a-col :span="12">
              <table>
                <tr>
                  <th>Total Qty</th>
                  <td style="width:40px">:</td>
                  <td>3</td>
                </tr>
                <tr>
                  <th>Total Items</th>
                  <td style="width:40px">:</td>
                  <td>2</td>
                </tr>
              </table>
            </a-col>
            <a-col :span="12">
              <table>
                <tr>
                  <th>Total Amount</th>
                  <td style="width:40px">:</td>
                  <td>100.00</td>
                </tr>
                <tr>
                  <th>Disc Amount</th>
                  <td style="width:40px">:</td>
                  <td>20.00</td>
                </tr>
              </table>
            </a-col>

          </a-row>
          <hr />
          <table>
            <tr>
              <td>
                <a-select v-model:value="value" show-search placeholder="Customer" style="width: 100%"
                  class="customer-dropdown" :default-active-first-option="false" :show-arrow="true" :filter-option="false"
                  :options="[{ value: 'Mobile', label: 'Mobile' }]" :not-found-content="value" @search="handleSearch"
                  :bordered="false" @change="handleChange"></a-select>
              </td>
              <th align="right">
                <h2>Net Total: 100.00</h2>
              </th>
            </tr>
          </table>
          <br />
          <a-row>
            <a-col :span="8">
              <a-button type="primary" html-type="submit" block style="margin:0 10px;">SAVE</a-button>
            </a-col>
            <a-col :span="8">
              <a-button type="primary" html-type="submit" block style="margin:0 10px;">SAVE & PRINT</a-button>
            </a-col>
            <a-col :span="8">
              <a-button type="primary" html-type="submit" block style="margin:0 10px;">HOLD</a-button>
            </a-col>
          </a-row>
        </a-form>
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
  MoreOutlined
} from '@ant-design/icons-vue';
import axios from 'axios';
const columns = [
  {
    title: '',
    key: 'image',
    dataIndex: 'image',
    sorter: true,
    width: '5%',
  },
  {
    title: 'Name',
    key: 'name',
    dataIndex: 'name',
    width: '15%',
  },
  {
    title: 'Category',
    key: 'category',
    dataIndex: 'category',
    width: '15%',
  },
  {
    title: 'Description',
    key: 'description',
    dataIndex: 'description',
    width: '30%',
  },
  {
    title: 'Price (INR)',
    key: 'price',
    dataIndex: 'price',
    width: '10%',
  },
  {
    title: 'Inventory',
    key: 'inventory',
    dataIndex: '',
    width: '20%',
  },
  {
    title: 'Action',
    key: 'action',
    fixed: 'right',
    width: '2%',
  },
];

export default ({
  components: { AuthenticatedLayout, DownloadOutlined, PlusCircleOutlined, MoreOutlined, Head, Link },
  props: {
    products: Object,
    pagination: Object,
    errors: Object,
  },
  setup(props) {
    return {
      columns,
    };
  },
  data() {
    const loading = false;
    const create_form_visible = false;
    const formState = useForm({
      term: '',
    });
    return {
      create_form_visible,
      loading,
      formState
    };
  },
  methods: {
    search() {
      this.$inertia.get("/products", { s: this.formState.term }, { preserveState: true });
    },
    handleTableChange(val) {
      this.$inertia.get(
        "/products",
        { page: val.current },
        { preserveState: true }
      );
    },
    deleteBranch(id) {
    },
    showDrawer() {
      this.create_form_visible = true;
    }
  }
});
</script>