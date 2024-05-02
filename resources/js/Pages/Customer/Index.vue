
<template>
  <Head title="Customers" />
  <AuthenticatedLayout>
    <a-layout-content>
      <a-space direction="vertical" :style="{ width: '100%' }">
        <a-form name="nest-messages" :model="searchform" layout="inline" @finish="search" class="searchForm">
          <a-form-item>
            <a-input placeholder="Search by customer name" :allow-clear="true" v-model:value="searchform.keyword"
              @change="search">
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
              Add New Customer
            </a-button>
          </a-form-item>
        </a-form>
        <a-table :columns="columns" :data-source="customers.data" :pagination="pagination">
          <template #bodyCell="{ column, record }">
            <template v-if="column.key === 'name'">
              <a href="javascript:;" @click="showCustomerDetailDrawer(record)">
                {{ record.name }}
              </a>
            </template>
            <template v-if="column.key === 'action'">
              <a-space>
                <a-button type="primary" shape="circle" @click="editCustomer(record)">
                  <edit-outlined />
                </a-button>
                <a-popconfirm title="Are you sure to delete customer?" placement="topRight"
                  @confirm="deletecustomer(record)">
                  <a-button type="danger" shape="circle">
                    <DeleteOutlined />
                  </a-button>
                </a-popconfirm>
              </a-space>
            </template>
          </template>
        </a-table>
      </a-space>
      <a-drawer v-model:visible="createvisible" class="custom-class" title="New Customer" :size="'large'"
        placement="right" @after-visible-change="afterVisibleChange" :destroyOnClose="true">
        <CreateCustomer @hide-drawer="hideCreateDrawer()" :customer="selectedcustomer"></CreateCustomer>
      </a-drawer>
      <a-drawer v-model:visible="showdetail" class="custom-class"
        :title="(selectedcustomer && selectedcustomer.name) ?? ''" :size="'large'" placement="right"
        @after-visible-change="afterVisibleChange">
        <CustomerDetail :customer="selectedcustomer"></CustomerDetail>
        <template #extra>
          <a-space>
            <a-button type="primary" shape="circle" @click="editCustomer(selectedcustomer)">
              <edit-outlined />
            </a-button>
            <a-popconfirm title="Are you sure to delete customer?" placement="topRight"
              @confirm="deletecustomer(selectedcustomer)">
              <a-button type="danger" shape="circle">
                <DeleteOutlined />
              </a-button>
            </a-popconfirm>
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
import CreateCustomer from '@/Components/CreateCustomer.vue';
import CustomerDetail from '@/Components/CustomerDetail.vue';


import {
  DownloadOutlined,
  PlusCircleOutlined,
  EditOutlined,
  DeleteOutlined,
  UploadOutlined,
  PlusOutlined
} from '@ant-design/icons-vue';
import axios from 'axios';

export default ({
  components: { AuthenticatedLayout, DownloadOutlined, UploadOutlined, PlusCircleOutlined, EditOutlined, DeleteOutlined, Head, Link, InputError, PlusOutlined, CreateCustomer, CustomerDetail },
  props: {
    customers: Object,
    pagination: Object,
  },
  data() {
    const loading = false;
    const searchform = useForm({
      keyword: '',
    });
    const layout = {
      labelCol: { span: 8 },
      wrapperCol: { span: 24 },
    };
    const columns = [
      {
        title: 'Name',
        key: 'name',
        dataIndex: 'name',
        width: '5%',
      },
      {
        title: 'Mobile',
        key: 'mobile',
        dataIndex: 'mobile',
        width: '5%',
      },
      {
        title: 'Email',
        key: 'email',
        dataIndex: 'email',
        width: '5%',
      },
      {
        title: 'Company Name',
        key: 'company_name',
        dataIndex: 'company_name',
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
    return {
      columns,
      createvisible: false,
      showdetail: false,
      layout,
      searchform,
      loading,
      selectedcustomer: null,
    };
  },
  methods: {
    search() {
      this.$inertia.get("/customers", { s: this.searchform.keyword }, { preserveState: true });
    },
    showDrawer() {
      this.createvisible = true;
      this.selectedcustomer = {};
    },
    hideCreateDrawer() {
      this.createvisible = false;
      this.selectedcustomer = {};
    },
    hideShowDrawer() {
      this.showdetail = false;
      this.selectedcustomer = {};
    },
    showCustomerDetailDrawer(customer) {
      this.selectedcustomer = customer;
      this.showdetail = true;
    },
    editCustomer(customer) {
      this.selectedcustomer = customer;
      this.createvisible = true;
    },
    deletecustomer(customer) {
      this.$inertia.delete("/customers/" + customer.id);
      this.hideShowDrawer();
    },
  }
});
</script>