<template>
  <Head title="Purchase" />
  <AuthenticatedLayout>
    <a-layout-content >
      <a-space direction="vertical" :style="{ width: '100%' }">
       <a-form name="nest-messages" :model="formState" layout="inline" @finish="search">
          <a-form-item>
            <a-input placeholder="Search by Name, Email, Phone..." v-model:value="formState">
            </a-input>
          </a-form-item>
          <a-form-item>
            <a-button type="primary" html-type="submit">
              Search
            </a-button>
          </a-form-item>
          <a-form-item>
            <Link :href="route('purchase.create')">
            <a-button type="primary">
              <template #icon>
                <plus-circle-outlined />
              </template>
              Add Purchase
            </a-button>
            </Link>
          </a-form-item>
        </a-form>
        <a-table :columns="columns"
          :pagination="pagination" :loading="loading" @change="handleTableChange">
          <template #bodyCell="{ column, text, record }">
            <template>
              {{ text ?? '-' }}
            </template>
            <template v-if="column.key === 'name'">
              <a-avatar style="color: #f56a00; background-color: #fde3cf">{{ text[0].toUpperCase() }}</a-avatar> &nbsp;
              {{ text }}
            </template>
          </template>
        </a-table>

      </a-space>
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
    title: 'ID',
    key: '',
    dataIndex: '',
    width: '10%',
  },
  {
    title: 'DATE',
    key: '',
    dataIndex: '',
    sorter: true,
    width: '10%',
  },
  {
    title: 'INVOICE NO',
    key: '',
    dataIndex: '',
    sorter: true,
    width: '15%',
  },
  {
    title: 'PARTY NAME',
    key: '',
    dataIndex: '',
    sorter: true,
    width: '15%',
  },
  {
    title: 'PAYMENT TYPE',
    key: '',
    dataIndex: '',
    sorter: true,
    width: '15%',
  },
   {
    title: 'AMOUNT',
    key: '',
    dataIndex: '',
    sorter: true,
    width: '15%',
  },
  {
    title: 'BALANCE DUE',
    key: '',
    dataIndex: '',
    sorter: true,
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
    employees: Object,
    pagination: Object,
    errors: Object,
  },
  setup(props) {
    return {
      columns,
    };
  },
});
</script>
<style>
.ant-table-column-title {
     font-size: 12px !important;
}
</style>