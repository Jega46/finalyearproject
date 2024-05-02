<template>
  <Head title="Sales" />
  <AuthenticatedLayout>
    <a-layout-content >
 
      <a-space direction="vertical" :style="{ width: '100%' }">
       <a-form name="nest-messages" :model="formState" layout="inline" @finish="search">
          <a-form-item>
            <a-input placeholder="Search by Name, Email, Phone..." v-model:value="formState">
            </a-input>
          </a-form-item>
           <a-form-item>
            <a-date-picker v-model:value="date" format="DD-MM-YYYY" value-format="YYYY-MM-DD" />
          </a-form-item>
          <a-form-item>
            <a-button type="primary" html-type="submit">
              Search
            </a-button>
          </a-form-item>
      <a-dropdown>
      <template #overlay>
        <a-menu>
         <Link :href="route('cashbook.moneyin')">
          <a-menu-item key="1">Money In
          </a-menu-item>
           </Link>
          <Link :href="route('cashbook.moneyout')">
          <a-menu-item key="2">Money Out
          </a-menu-item>
          </Link>
        </a-menu>
      </template>
      <a-button type="primary" style="margin-left: 546px;">
        New Entry
        <DownOutlined />
      </a-button>
    </a-dropdown>
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
  DownOutlined,
  DownloadOutlined,
  PlusCircleOutlined,
  MoreOutlined
} from '@ant-design/icons-vue';
import axios from 'axios';
const columns = [
  {
    title: 'Id',
    key: '',
    dataIndex: '',
    width: '5%',
  },
  {
    title: 'Date',
    key: '',
    dataIndex: '',
    sorter: true,
    width: '10%',
  },
   {
    title: 'Name',
    key: '',
    dataIndex: '',
    sorter: true,
    width: '10%',
  },
  {
    title: 'Reference',
    key: '',
    dataIndex: '',
    sorter: true,
    width: '15%',
  },
  {
    title: 'Paid from Bank Account',
    key: '',
    dataIndex: '',
    sorter: true,
    width: '15%',
  },
  {
    title: 'Money In',
    key: '',
    dataIndex: '',
    sorter: true,
    width: '10%',
  },
   {
    title: 'Money Out',
    key: '',
    dataIndex: '',
    sorter: true,
    width: '10%',
  },
  {
    title: 'Repeat',
    key: '',
    dataIndex: '',
    sorter: true,
    width: '10%',
  },
];


export default ({
  components: { AuthenticatedLayout, DownloadOutlined, PlusCircleOutlined, MoreOutlined, Head, Link, DownOutlined }, 
  props: {
    sales: Object,
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
.ant-tabs > .ant-tabs-nav .ant-tabs-nav-list, .ant-tabs > div > .ant-tabs-nav .ant-tabs-nav-list {
    position: relative;
    display: flex;
    transition: transform 0.3s;
    margin-left: 740px;
}
</style>