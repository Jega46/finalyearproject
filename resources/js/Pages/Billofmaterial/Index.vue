
<template>
  <Head title="Bill Of Materials" />
  <AuthenticatedLayout>
    <a-layout-content>
      <a-space direction="vertical" :style="{ width: '100%' }">
        <a-form name="nest-messages" :model="searchform" layout="inline" @finish="search">
          <a-form-item>
            <a-input placeholder="Search by Job Order Number" :allow-clear="true" v-model:value="searchform.term">
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
              New BOM
            </a-button>
          </a-form-item>
        </a-form>
        <a-table :columns="[
          {
            title: 'BOM ID',
            key: 'bom_id',
            dataIndex: 'bom_id',
          },
          {
            title: 'BOM Name',
            key: 'bom_name',
            dataIndex: 'bom_name',
          },
          {
            title: 'Product Name',
            key: 'product_name',
            dataIndex: 'product_name',
          },
          {
            title: 'No of Raw Materials',
            key: 'no_of_rm',
            dataIndex: 'no_of_rm',
          },
          {
            title: 'Action',
            key: 'action',
            width: '3%',
          },
        ]" :data-source="[
  {
    key: '1',
    bom_id: 'BOM-0001',
    bom_name: 'BOM-0001',
    product_name: 'Computer',
    no_of_rm: '1',
  }
]" :pagination="false">
          <template #bodyCell="{ column, record }">
            <template v-if="column.key === 'bom_id'">
              <a @click="showDetailDrawer">
                {{ record.bom_id }}
              </a>
            </template>
          </template>
        </a-table>
      </a-space>


      <a-drawer v-model:visible="create_form_visible" class="sales-bill" :size="'large'" style="color: red;" width="75%"
        title="Add BOM" placement="right" @after-visible-change="afterVisibleChange">
        <a-form :model="form" v-bind="layout" name="nest-messages" :validate-messages="validateMessages" @finish="submit"
          :label-col="{ span: 24 }" style="min-height: 100%;">
          <a-row :gutter="24">
            <a-col class="gutter-row" span="12">
              <a-form-item name="document_name" label="Document Name" :rules="[{ required: true }]">
                <a-input v-model:value="form.document_name" />
              </a-form-item>
            </a-col>
            <a-col class="gutter-row" span="12">
              <a-form-item name="document_number" label="Document Number">
                <a-input v-model:value="form.document_number" />
              </a-form-item>
            </a-col>
            <a-col class="gutter-row" span="24">
              <a-form-item name="description" label="Description">
                <a-input v-model:value="form.description" />
              </a-form-item>
            </a-col>
          </a-row>
          <h4 class="t1">Product</h4>
          <a-row :gutter="24">
            <a-col class="gutter-row" span="12">
              <a-form-item name="product" label="Select Product" :rules="[{ required: true }]">
                <a-select v-model:value="form.tax" show-search placeholder="Select Product" style="width: 100%"
                  :default-active-first-option="false" :options="[{
                    label: 'Red color T-shirt - Md',
                    value: 'Red color T-shirt - Md',
                  }, {
                    label: 'Red color T-shirt - Lg',
                    value: 'Red color T-shirt - Lg',
                  }, {
                    label: 'Red color T-shirt - SM',
                    value: 'Red color T-shirt - SM',
                  }]" :not-found-content="value"></a-select>
              </a-form-item>
            </a-col>
            <a-col class="gutter-row" span="12">
              <a-form-item name="quantity" label="Quantity" :rules="[{ required: true }]">
                <a-input v-model:value="form.quantity" />
              </a-form-item>
            </a-col>
            <a-col class="gutter-row" span="12">
              <a-form-item name="unit" label="Unit" :rules="[{ required: true }]">
                <a-select v-model:value="form.tax" show-search placeholder="Select Unit" style="width: 100%"
                  :default-active-first-option="false" :options="[{
                    label: 'KG',
                    value: 'KG',
                  }, {
                    label: 'Ltr',
                    value: 'Ltr',
                  }, {
                    label: 'Pcs',
                    value: 'Pcs',
                  }]"></a-select>
              </a-form-item>
            </a-col>
            <a-col class="gutter-row" span="12">
              <a-form-item name="cost_allocation" label="Cost Allocation" :rules="[{ required: true }]">
                <a-input v-model:value="form.cost_allocation" />
              </a-form-item>
            </a-col>
          </a-row>
          <h4 class="t1">Raw Materials</h4>
          <a-table :columns="[
            {
              title: 'Raw Material',
              dataIndex: 'raw_material',
              key: 'raw_material',
            },
            {
              title: 'Quantity',
              dataIndex: 'quantity',
              key: 'quantity',
            },
            {
              title: 'Unit',
              dataIndex: 'unit',
              key: 'unit',
            },
            {
              title: 'Notes',
              dataIndex: 'notes',
              key: 'notes',
            },
            {
              title: 'Action',
              key: 'action',
              width: '3%',
            },
          ]" :data-source="[{}]" :pagination="false">
            <template #bodyCell="{ column, record }">
              <template v-if="column.key === 'raw_material'">
                <a-select v-model:value="form.tax" show-search placeholder="Select Product" style="width: 100%"
                  :default-active-first-option="false" :options="[{
                    label: 'Red color T-shirt - Md',
                    value: 'Red color T-shirt - Md',
                  }, {
                    label: 'Red color T-shirt - Lg',
                    value: 'Red color T-shirt - Lg',
                  }, {
                    label: 'Red color T-shirt - SM',
                    value: 'Red color T-shirt - SM',
                  }]" :not-found-content="value"></a-select>
              </template>
              <template v-if="column.key === 'quantity'">
                <a-input v-model:value="record.quantity" />
              </template>
              <template v-if="column.key === 'unit'">
                <a-select v-model:value="form.tax" show-search placeholder="Select Unit" style="width: 100%"
                  :default-active-first-option="false" :options="[{
                    label: 'Kg',
                    value: 'Kg',
                  }, {
                    label: 'Ltr',
                    value: 'Ltr',
                  }]"></a-select>
              </template>
              <template v-if="column.key === 'notes'">
                <a-textarea v-model:value="form.description" />
              </template>
              <template v-if="column.key === 'action'">
                <!--dropdown-->
                <a-dropdown-button @click="handleButtonClick">
                  <template #icon>
                    <MoreOutlined />
                  </template>
                  <template #overlay>
                    <a-menu @click="handleMenuClick">
                      <a-menu-item key="1">
                        <UserOutlined />
                        Remove
                      </a-menu-item>
                    </a-menu>
                  </template>
                </a-dropdown-button>
              </template>
            </template>
          </a-table>
          <br />
          <a-space>
            <a-button type="success" :size="'small'">
              <template #icon>
                <plus-circle-outlined />
              </template>
              Add RM
            </a-button>
          </a-space>
          <br />
          <h4 class="t1">Routing</h4>
          <a-table :columns="[
            {
              title: 'Routing',
              dataIndex: 'routing',
              key: 'routing',
            },
            {
              title: 'Comment',
              dataIndex: 'comment',
              key: 'comment',
            },
            {
              title: 'Action',
              key: 'action',
              width: '3%',
            },
          ]" :data-source="[{}]" :pagination="false">
            <template #bodyCell="{ column, record }">
              <template v-if="column.key === 'routing'">
                <a-select v-model:value="form.tax" show-search placeholder="Select Routing" style="width: 100%"
                  :default-active-first-option="false" :options="[{
                    label: 'Routing 1',
                    value: 'Routing 1',
                  }, {
                    label: 'Routing 2',
                    value: 'Routing 2',
                  }, {
                    label: 'Routing 3',
                    value: 'Routing 3',
                  }]" :not-found-content="value"></a-select>
              </template>
              <template v-if="column.key === 'comment'">
                <a-textarea v-model:value="form.description" />
              </template>
              <template v-if="column.key === 'action'">
                <!--dropdown-->
                <a-dropdown-button @click="handleButtonClick">
                  <template #icon>
                    <MoreOutlined />
                  </template>
                  <template #overlay>
                    <a-menu @click="handleMenuClick">
                      <a-menu-item key="1">
                        <UserOutlined />
                        Remove
                      </a-menu-item>
                    </a-menu>
                  </template>
                </a-dropdown-button>
              </template>
            </template>
          </a-table>
          <br />
          <a-space>
            <a-button type="success" :size="'small'">
              <template #icon>
                <plus-circle-outlined />
              </template>
              Add Routing
            </a-button>
          </a-space>
          <br />
          <h4 class="t1">Other Charges</h4>
          <a-table :columns="[
            {
              title: 'Classification',
              dataIndex: 'classification',
              key: 'classification',
            },
            {
              title: 'Amount',
              dataIndex: 'amount',
              key: 'amount',
            },
            {
              title: 'Comment',
              dataIndex: 'comment',
              key: 'comment',
            },
          ]" :data-source="[{
            key: '1',
            classification: 'Classification 1',
            amount: '0',
            comment: '',
          },
          {
            key: '1',
            classification: 'Classification 1',
            amount: '0',
            comment: '',
          },
          {
            key: '1',
            classification: 'Classification 1',
            amount: '0',
            comment: '',
          },
          {
            key: '1',
            classification: 'Classification 1',
            amount: '0',
            comment: '',
          }
          ]" :pagination="false">
            <template #bodyCell="{ column, record }">
              <template v-if="column.key === 'classification'">
                {{ record.classification }}
              </template>
              <template v-if="column.key === 'amount'">
                <a-input v-model:value="record.amount" />
              </template>
              <template v-if="column.key === 'comment'">
                <a-input v-model:value="record.comment" />
              </template>
            </template>
          </a-table>
        </a-form>
        <template #footer>
      <a-button style="margin-right: 8px" @click="onClose">Cancel</a-button>
      <a-button type="primary" @click="onClose">SAVE</a-button>
    </template>
      </a-drawer>
      <a-drawer v-model:visible="showdetail" class="custom-class" title="JO-000001" :size="'large'" placement="right"
        @after-visible-change="afterVisibleChange" width="60%">
        <a-tabs v-model:activeKey="activeKey">
          <a-tab-pane key="JO-1-1" tab="Progress">Progress
          </a-tab-pane>
          <a-tab-pane key="JO-1-2" tab="Raw Materials" force-render>
            <a-space>
              <a-button type="primary" :size="'small'">
                <template #icon>
                  <plus-circle-outlined />
                </template>
                Add Raw Material
              </a-button>
            </a-space>
            <br />
            <a-table :columns="[
              {
                title: 'Product',
                dataIndex: 'product',
                key: 'product',
              },
              {
                title: 'Quantity/order',
                dataIndex: 'quantity',
                key: 'quantity',
              },
              {
                title: 'Stock Levels',
                dataIndex: 'stock_levels',
                key: 'stock_levels',
              },
              {
                title: 'Notes',
                dataIndex: 'notes',
                key: 'notes',
              },
              {
                title: 'Action',
                key: 'action',
                width: '3%',
              },
            ]" :data-source="[
  {
    key: '1',
    product: 'Computer',
    quantity: '1',
    stock_levels: '0',
    notes: '0',
  },
  {
    key: '2',
    product: 'Computer',
    quantity: '1',
    stock_levels: '0',
    notes: '0',
  },
  {
    key: '3',
    product: 'Computer',
    quantity: '1',
    stock_levels: '0',
    notes: '0',
  },
]" :pagination="false">
              <template #bodyCell="{ column, record }">
                <template v-if="column.key === 'product'">
                  <a-select v-model:value="form.tax" show-search placeholder="Select Product" style="width: 100%"
                    :default-active-first-option="false" :options="[{
                      label: 'Red color T-shirt - Md',
                      value: 'Red color T-shirt - Md',
                    }, {
                      label: 'Red color T-shirt - Lg',
                      value: 'Red color T-shirt - Lg',
                    }, {
                      label: 'Red color T-shirt - SM',
                      value: 'Red color T-shirt - SM',
                    }]" :not-found-content="value"></a-select>
                </template>
                <template v-if="column.key === 'quantity'">
                  <a-input v-model:value="record.quantity" />
                </template>
                <template v-if="column.key === 'stock_levels'">
                  In stock: 0,00
                </template>
                <template v-if="column.key === 'notes'">
                  <a-textarea v-model:value="form.description" />
                </template>
                <template v-if="column.key === 'action'">
                  <!--dropdown-->
                  <a-dropdown-button @click="handleButtonClick">
                    <template #icon>
                      <MoreOutlined />
                    </template>
                    <template #overlay>
                      <a-menu @click="handleMenuClick">
                        <a-menu-item key="1">
                          <UserOutlined />
                          Create PO
                        </a-menu-item>
                      </a-menu>
                    </template>
                  </a-dropdown-button>
                </template>
              </template>
            </a-table>
            <h4>Summary of raw materials</h4>
            <a-table :columns="[
              {
                title: 'Product',
                dataIndex: 'product',
                key: 'product',
              },
              {
                title: 'Quantity/order',
                dataIndex: 'quantity',
                key: 'quantity',
              },
              {
                title: 'Quantity used',
                dataIndex: 'quantity_used',
                key: 'quantity_used',
              },
            ]" :data-source="[
  {
    key: '1',
    product: 'Computer',
    quantity: '1',
    quantity_used: '0',
  },
  {
    key: '2',
    product: 'Computer',
    quantity: '1',
    quantity_used: '0',
  },
  {
    key: '3',
    product: 'Computer',
    quantity: '1',
    quantity_used: '0',
  },
]" :pagination="false">
            </a-table>
          </a-tab-pane>
          <a-tab-pane key="JO-1-3" tab="Manufacturing tasks" force-render>
            <a-table :columns="[
              {
                title: 'Machine/Operation',
                dataIndex: 'operation',
                key: 'operation',
              },
              {
                title: 'Planned Start',
                dataIndex: 'planned_start',
                key: 'planned_start',
              },
              {
                title: 'Due Date',
                dataIndex: 'due_date',
                key: 'due_date',
              },
              {
                title: 'Due Date',
                dataIndex: 'due_date',
                key: 'due_date',
              },
            ]" :data-source="[]" :pagination="false"></a-table>
          </a-tab-pane>
          <a-tab-pane key="JO-1-4" tab="Operation Tasks">
            <a-space>
              <a-button type="primary" :size="'small'">
                <template #icon>
                  <plus-circle-outlined />
                </template>
                Add Operation Task
              </a-button>
            </a-space>
            <br />
            <a-table :columns="[
              {
                title: 'Machine/Operation',
                dataIndex: 'operation',
                key: 'operation',
              },
            ]" :data-source="[]" :pagination="false"></a-table>
            <a-table :columns="[
              {
                title: 'Date',
                dataIndex: 'date',
                key: 'date',
              },
              {
                title: 'Operation',
                dataIndex: 'operation',
                key: 'operation',
              },
              {
                title: 'User',
                dataIndex: 'user',
                key: 'user',
              },
              {
                title: 'Notes',
                dataIndex: 'notes',
                key: 'notes',
              },
            ]" :data-source="[]" :pagination="false">
            </a-table>
          </a-tab-pane>
          <a-tab-pane key="JO-1-5" tab="Inventory Release">Inventory Release</a-tab-pane>
        </a-tabs>
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
  MoreOutlined,
  DownCircleOutlined,
  CloseCircleOutlined,
  EditOutlined,
  DeleteOutlined,
  MailOutlined,
  CheckOutlined,
  InteractionOutlined,
  FilePdfOutlined,
  PlusOutlined
} from '@ant-design/icons-vue';
import axios from 'axios';
const columns = [
  {
    title: 'Order Number',
    key: 'job_order_number',
    dataIndex: 'job_order_number',
  },
  {
    title: 'Product',
    key: 'product',
    dataIndex: 'product',
  },
  {
    title: 'External Order ID',
    key: 'external_order_id',
    dataIndex: 'external_order_id',
  },
  {
    title: 'Due Date',
    key: 'due_date',
    dataIndex: 'due_date',
  },
  {
    title: 'Client',
    key: 'client',
    dataIndex: 'client',
  },
  {
    title: 'Status',
    key: 'status',
    dataIndex: 'status',
  }
];
const job_orders = [
  {
    key: '1',
    job_order_number: 'job_order-0001',
    product: 'Computer',
    external_order_id: '1242',
    status: 'Draft',
    due_date: '10-10-2023',
    client: 'Mona',
    status: 'New',
  },
  {
    key: '1',
    job_order_number: 'job_order-0001',
    product: 'Computer',
    external_order_id: '1242',
    status: 'Draft',
    due_date: '10-10-2023',
    client: 'Mona',
    status: 'New',
  },
  {
    key: '1',
    job_order_number: 'job_order-0001',
    product: 'Computer',
    external_order_id: '1242',
    status: 'Draft',
    due_date: '10-10-2023',
    client: 'Mona',
    status: 'PLANNED',
  },
];
const job_ordercolumns = [{
  title: 'Product',
  dataIndex: 'product',
  key: 'product',
  width: '40%',
}, {
  title: 'Quantity',
  dataIndex: 'quantity',
  key: 'quantity',
  width: '10%',
}, {
  title: 'Inventory',
  dataIndex: 'inventory',
  key: 'inventory',
  width: '10%',
}, {
  title: 'Action',
  key: 'action',
  width: '3%',
}];

// defining create job_order items const
const createPurchaseOrderItems = [{
  key: '1',
  item_details: 'item 1',
  quantity: '1',
  rate: '0.00',
  amount: '1000.00',
  balance_due: '0.00',
  action: '',
},
{
  key: '2',
  item_details: 'item 2',
  quantity: '1',
  rate: '0.00',
  amount: '1000.00',
  balance_due: '0.00',
  action: '',
}];

export default ({
  components: {
    AuthenticatedLayout, DownloadOutlined, PlusCircleOutlined, MoreOutlined, Head, Link, DownCircleOutlined, CloseCircleOutlined, EditOutlined,
    DeleteOutlined,
    MailOutlined,
    CheckOutlined,
    InteractionOutlined, FilePdfOutlined, PlusOutlined
  },
  props: {
  },
  setup(props) {
    return {
      columns,
      job_ordercolumns,
      job_orders,
      createPurchaseOrderItems
    };
  },
  data() {
    const loading = false;
    const create_form_visible = false;
    const searchform = useForm({
      term: '',
    });
    const form = useForm({
      term: '',
    });
    return {
      create_form_visible,
      loading,
      searchform,
      form,
      showdetail: false,
    };
  },
  methods: {
    showDrawer() {
      this.create_form_visible = true;
    },
    showDetailDrawer() {
      this.showdetail = true;
    },
  }
});
</script>