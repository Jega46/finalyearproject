
<template>

  <Head title="Employees" />
  <AuthenticatedLayout>
    <a-layout-content >
      <a-space direction="vertical" :style="{ width: '100%' }">
        <a-form name="nest-messages" :model="formState" layout="inline" @finish="search">
          <a-form-item>
            <a-input placeholder="Search by Name, Email, Phone..." v-model:value="formState.term">
            </a-input>
          </a-form-item>
          <a-form-item>
            <a-button type="primary" html-type="submit">
              Search
            </a-button>
          </a-form-item>
          <a-form-item>
            <Link :href="route('employees.create')">
            <a-button type="primary" shape="round">
              <template #icon>
                <plus-circle-outlined />
              </template>
              Add New Employee
            </a-button>
            </Link>
          </a-form-item>
          <a-form-item>
            <a-button type="primary" shape="round">
              <template #icon>
                <DownloadOutlined />
              </template>
              Export All
            </a-button>
          </a-form-item>
        </a-form>
        <a-table :columns="columns" :row-key="employee => employee.id" :data-source="employees.data"
          :pagination="pagination" :loading="loading" @change="handleTableChange">
          <template #bodyCell="{ column, text, record }">
            <template v-if="column.key === 'employeeid'">
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
                    <Link :href="route('employees.edit', record.id)">
                    <a-menu-item key="1">
                      Edit Employee Details
                    </a-menu-item>
                    </Link>
                    <Link :href="route('salarydetails', record.id)">
                    <a-menu-item key="2">
                      Edit Salary Details
                    </a-menu-item>
                    </Link>
                    <a-menu-item key="2">
                      View Employee Detail
                    </a-menu-item>
                    <Link :href="route('employees.attendance', record.id)">
                    <a-menu-item key="3">
                      Attendance
                    </a-menu-item>
                    </Link>
                    <a-menu-item key="4" @click="deleteEmployee(record.id)">
                      Delete Employee
                    </a-menu-item>
                    <a-menu-item key="3">
                      Deactivate Employee
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
    key: 'employeeid',
    dataIndex: 'employeeid',
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
    title: 'Mobile',
    key: 'mobile',
    dataIndex: 'mobile',
    width: '20%',
  },
  {
    title: 'Designation',
    key: 'designation',
    dataIndex: 'designation',
    width: '10%',
  },
  {
    title: 'Email',
    key: 'email',
    dataIndex: 'email',
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
  data() {
    const loading = false;
    const formState = useForm({
      term: '',
    });
    return {
      page: 1,
      pageSize: 20,
      loading,
      formState
    };
  },
  methods: {
    search() {
      this.$inertia.get("/employees", { s: this.formState.term, page: this.page, pageSize: this.pageSize }, { preserveState: true });
    },
    handleTableChange(val) {
      this.page = val.current;
      this.pageSize = val.pageSize;
      this.$inertia.get(
        "/employees",
        { s: this.formState.term, page: val.current, pageSize: val.pageSize },
        { preserveState: true }
      );
    },
    deleteEmployee(id) {
      this.$inertia.delete(route("employees.destroy", id));
    },
  }
});
</script>