
<template>
  <Head title="Product Categories" />
  <AuthenticatedLayout>
    <a-layout-content >
      <a-space direction="vertical" :style="{ width: '100%' }">
        <a-form name="nest-messages" :model="formState" layout="inline" @finish="search">
          <a-form-item>
            <a-input placeholder="Search by category name" :allow-clear="true" v-model:value="formState.term">
            </a-input>
          </a-form-item>
          <a-form-item>
            <a-button type="success" shape="round" html-type="submit">
              Search
            </a-button>
          </a-form-item>
          <a-form-item>
            <a-button type="success" shape="round" @click="showDrawer">
              <template #icon>
                <plus-circle-outlined />
              </template>
              Add New Category
            </a-button>
          </a-form-item>
        </a-form>
        <a-table :columns="columns" :row-key="branch => branch.id" :data-source="productcategories.data"
          :pagination="pagination" :loading="loading" @change="handleTableChange" class="ant-table-striped">
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
      <a-drawer v-model:visible="create_form_visible" class="custom-class" style="color: red" title="Add Category"
        placement="right" @after-visible-change="afterVisibleChange">
        <a-form :model="formState" v-bind="layout" name="nest-messages" :validate-messages="validateMessages"
          @finish="submit" :label-col="{ span: 24 }">
          <a-form-item label="Category Name" name="name" :rules="[{ required: true }]">
            <a-input v-model:value="formState.name" />
          </a-form-item>
          <a-form-item label="Category Description" name="description">
            <a-textarea v-model:value="formState.description" />
          </a-form-item>
          <a-form-item :wrapper-col="{ span: 12 }">
            <a-button type="primary" html-type="submit">Save</a-button>
          </a-form-item>
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
    title: 'Name',
    key: 'name',
    dataIndex: 'name',
    sorter: true,
    width: '20%',
  },
  {
    title: 'Description',
    key: 'description',
    dataIndex: 'description',
    width: '20%',
  },
  {
    title: 'No of Products',
    key: 'no_of_products',
    dataIndex: 'no_of_products',
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
    productcategories: Object,
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
      this.$inertia.get("/productcategories", { s: this.formState.term }, { preserveState: true });
    },
    handleTableChange(val) {
      this.$inertia.get(
        "/productcategories",
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