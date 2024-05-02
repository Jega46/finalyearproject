
<template>

  <Head title="Branches" />
  <AuthenticatedLayout>
    <a-layout-content >
      <a-space direction="vertical" :style="{ width: '100%' }">
        <a-form name="nest-messages" :model="formState" layout="inline" @finish="search">
          <a-form-item>
            <a-input placeholder="Search by Name, Address..." v-model:value="formState.term">
            </a-input>
          </a-form-item>
          <a-form-item>
            <a-button type="primary" html-type="submit">
              Search
            </a-button>
          </a-form-item>
          <a-form-item>
            <Link :href="route('branches.create')">
            <a-button type="primary" shape="round">
              <template #icon>
                <plus-circle-outlined />
              </template>
              Add New Branch
            </a-button>
            </Link>
          </a-form-item>
        </a-form>
        <a-table :columns="columns" :row-key="branch => branch.id" :data-source="branches.data"
          :pagination="pagination" :loading="loading" @change="handleTableChange">
          <template #bodyCell="{ column, text, record }">
            <template v-if="column.key === 'action'">
              <a-dropdown>
                <template #overlay>
                  <a-menu>
                    <Link :href="route('branches.edit', record.id)">
                    <a-menu-item key="1">
                      Edit
                    </a-menu-item>
                    </Link>
                    <a-menu-item key="4" @click="deleteBranch(record.id)">
                      Delete Branch
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
    title: 'Name',
    key: 'branch_name',
    dataIndex: 'branch_name',
    sorter: true,
    width: '20%',
  },
  {
    title: 'Address',
    key: 'address',
    dataIndex: 'address',
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
    branches: Object,
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
      this.$inertia.get("/branches", { s: this.formState.term }, { preserveState: true });
    },
    handleTableChange(val) {
      this.$inertia.get(
        "/branches",
        { page: val.current },
        { preserveState: true }
      );
    },
    deleteBranch(id) {
      this.$inertia.delete(route("branches.destroy", id));
    },
  }
});
</script>