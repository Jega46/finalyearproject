
<template>

  <Head title="Expenses" />
  <AuthenticatedLayout>
   <a-layout-content >
      <a-space direction="vertical" :style="{ width: '100%' }">
      <a-form name="customized_form_controls" layout="inline" :model="formState" @finish="onFinish">
        <a-form-item>
         <a-input v-model:value="value" placeholder="Search by Name, Email, Phone..."></a-input>
      </a-form-item>
      <a-form-item>
        <a-button type="primary" html-type="submit">Search</a-button>
      </a-form-item>
       <a-form-item>
       <Link :href="route('expensetype.create')">
         <a-button type="primary" shape="round" :size="size">
        <template #icon>
         <plus-circle-outlined />
        </template>
          Add New Expense
       </a-button>
       </Link>
       </a-form-item>
        <a-form-item>
         <a-button type="primary" shape="round" :size="size">
        <template #icon>
         <DownloadOutlined />
        </template>
         Export All
       </a-button>
       </a-form-item>
      </a-form>
       <a-table :columns="columns" :row-key="expense => expense.id" :data-source="expenses.data"
          :pagination="pagination" :loading="loading" @change="handleTableChange"> 
          <template #bodyCell="{ column, text, record }">
            <template v-if="column.key === 'expenseid'">
              {{ text ?? '-' }}
            </template>
            <template v-if="column.key === 'name'">
              <a-avatar style="color: #f56a00; background-color: #fde3cf">{{ text[0].toUpperCase() }}</a-avatar> &nbsp;
              {{ text }}
            </template>
            <template v-if="column.key === 'action'">
              <a-dropdown>
                <template #overlay>
                  <a-menu>
                   <Link :href="route('expensetype.edit', record.id)">
                    <a-menu-item key="1">
                      Edit Expenses
                    </a-menu-item>
                    </Link>
                      <a-menu-item key="2" @click="deleteExpenses(record.id)">
                      Delete Expenses
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
    </a-layout-content>
  </AuthenticatedLayout>
</template>


<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { usePagination } from 'vue-request';
import { computed, defineComponent } from 'vue';
import {  PlusCircleOutlined, DownloadOutlined,  MoreOutlined } from '@ant-design/icons-vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import axios from 'axios';

const columns = [
  {
    title: 'ID',
    key: 'id',
    dataIndex: 'id',
    width: '10%',
  },
  {
    title: 'Name',
    key: 'name',
    dataIndex: 'name',
    sorter: true,
    width: '20%',
  },
  {
    title: 'Expense Type',
    key: 'expensetype',
    dataIndex: 'expensetype',
    width: '20%',
  },
  {
    title: 'Amount',
    key: 'amount',
    dataIndex: 'amount',
    width: '10%',
  },
  {
    title: 'Date',
    key: 'date',
    dataIndex: 'date',
    width: '20%',
  },
  {
    title: 'Created Date',
    key: 'created_at',
    dataIndex: 'created_at',
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
    expenses: Object,
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
    const formState = useForm({
      term: '',
    });
    return {
      loading,
      formState
    };
  },
   methods: {
    search() {
      this.$inertia.get("/expenses", { s: this.formState.term }, { preserveState: true });
    },
    handleTableChange(val) {
      this.$inertia.get(
        "/expenses",
        { page: val.current },
        { preserveState: true }
      );
    },
    deleteExpenses(id) {
      this.$inertia.delete(route("expensetype.destroy", id));
    },
  }
 
});
</script>

<style>
.text-right {
    text-align: right !important;
}
</style>