
<template>
  <Head title="Sales Receipts" />
  <AuthenticatedLayout>
    <a-layout-content >
      <a-space direction="vertical" :style="{ width: '100%' }">
        <a-form name="nest-messages" :model="formState" layout="inline" @finish="search">
          <a-form-item>
            <a-input placeholder="Search by receipt number" :allow-clear="true" v-model:value="formState.term">
            </a-input>
          </a-form-item>
          <a-form-item>
            <a-button type="primary" html-type="submit">
              Search
            </a-button>
          </a-form-item>
          <a-form-item>
            <Link :href="route('sales.create')">
            <a-button type="primary" shape="round">
              <template #icon>
                <plus-circle-outlined />
              </template>
              Create New
            </a-button>
            </Link>
          </a-form-item>
        </a-form>
        <a-table :columns="columns" :row-key="product => product.id" :data-source="sales.data" :pagination="pagination"
          :loading="loading" @change="handleTableChange">
          <template #bodyCell="{ column, text, record }">
            <template v-if="column.key === 'action'">
              <a-dropdown>
                <template #overlay>
                  <a-menu>
                    <a-menu-item key="1">
                      Edit
                    </a-menu-item>
                    <a-menu-item key="4" @click="deleteContact(record.id)">
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
  MoreOutlined,
  UploadOutlined
} from '@ant-design/icons-vue';
import axios from 'axios';
const columns = [
{
    title: 'Receipt Number',
    key: 'number',
    dataIndex: 'number',
    width: '30%',
  },
  {
    title: 'Contact Name',
    key: 'contact_name',
    dataIndex: 'contact_name',
    width: '15%',
  },
  {
    title: 'Date',
    key: 'sale_date',
    dataIndex: 'sale_date',
    width: '10%',
  },
  {
    title: 'Net Total',
    key: 'total',
    dataIndex: 'total',
    width: '10%',
  },
  {
    title: 'Action',
    key: 'action',
    fixed: 'right',
    width: '2%',
  },
];

export default ({
  components: { AuthenticatedLayout, DownloadOutlined, UploadOutlined, PlusCircleOutlined, MoreOutlined, Head, Link },
  props: {
    sales: Object,
    taxes: Object,
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
      formState,
      loading
    };
  },
  methods: {
    search() {
      this.$inertia.get("/sales", { s: this.formState.term }, { preserveState: true });
    },
    handleTableChange(val) {
      this.$inertia.get(
        "/sales",
        { page: val.current },
        { preserveState: true }
      );
    },
    deleteContact(id) {
    },
  }
});
</script>