<template>
    <Head title="Employees" />
    <AuthenticatedLayout>
        <a-affix :offset-top="0">
            <a-page-header :ghost="false" title="Money In" @back="() => $inertia.visit(route('cashbook.index'))">
                <template #extra>      
                  <a-button type="primary">Save</a-button>
                </template>
            </a-page-header>
        </a-affix>
  <a-row  style="padding: '24px'; background: '#fff'; margin-top: 12px; margin-bottom: 12px; margin-left: 16px; minHeight: '180px'">
      <a-col :span="24">
      <a-card style="width: 1118px">
      <a-row>
      <a-col :span="4">
      <a-form-item label="Contact(optional)">
      <a-select placeholder="Search for a Customer" style="width: 160px;">
      <a-select-option value="undefined" @click.stop="() => { showmodel_visible = true; }"><PlusCircleOutlined /> Add New Customer</a-select-option>
      </a-select>
      </a-form-item></a-col>
      <a-col :span="4">
      <a-form-item label="Paid into Bank Account">
      <a-select placeholder="Please Select" style="width: 160px;">
      <a-select-option value="undefined"></a-select-option>
      </a-select>
      </a-form-item>
      </a-col>
      <a-col :span="4">
      <a-form-item label="Method">
      <a-select placeholder="Please Select" style="width: 160px;">
      <a-select-option value="undefined"></a-select-option>
      </a-select>
      </a-form-item>
    </a-col>
    <a-col :span="4">
    <a-form-item label="Date Received">
    <a-date-picker v-model:value="date" format="DD-MM-YYYY" value-format="YYYY-MM-DD" style="width: 160px;" />
    </a-form-item>
    </a-col>
    <a-col :span="4">
    <a-form-item label="Your Reference (optional)">
    <a-input v-model:value="value" placeholder="e.g. Check number" style="width: 160px;"></a-input>
    </a-form-item>
    </a-col>
    <a-col :span="4">
    <a-form-item label="Amount Received">
    <a-input v-model:value="value" placeholder="" style="width: 160px;"></a-input>
    </a-form-item>
    </a-col>
      </a-row>
     </a-card>
    </a-col>
  </a-row>
  <a-modal title="Add New Customer" :closable="true" v-model:visible="showmodel_visible" @close="showmodel_visible = false">
            <a-form :model="formParty" v-bind="layout" name="nest-messages"
                        :validate-messages="validateMessages" @finish="partySubmit">
            <a-form-item label="Party Name" name="partyname" :rules="[{ required: true }]">
            <a-input v-model:value="formParty.partyname" placeholder="Enter Customer Name">
            </a-input>
            </a-form-item>
            <a-form-item label="Mobile Number" name="mobile">
            <a-input v-model:value="formParty.mobile" placeholder="Enter Mobile Number">
            </a-input>
            </a-form-item>
            <a-form-item label="Who are they?" name="who_r_they">
            <a-radio-group v-model:value="formParty.who_r_they">
            <a-radio value="customer">Customer</a-radio>
            <a-radio value="supplier">Supplier</a-radio>
            </a-radio-group>
            </a-form-item>
            <a-form-item label="GSTIN" name="gstin" :rules="[{ required: true }]">
            <a-input v-model:value="formParty.gstin" placeholder="Enter GSTIN">
            </a-input>
            </a-form-item>

            <a-menu id="dddddd" style="width: 100%;" mode="inline" @click.stop="() => { menu_visible = true; }" >
            <a-sub-menu key="sub1" :visible="menu_visible" @close="menu_visible = false">
            <template #title>Add GSTIN & Address (Optional)</template>
            <h5 :wrapper-col="{ span: 12, offset: 6 }" style="margin-bottom: 20px;font-size: 15px;margin-top: 20px;">Shipping Address</h5><br /><br />
            <a-form-item label="Flat / Building Number" name="flat_no">
            <a-input v-model:value="formParty.flat_no" placeholder="Enter Flat / Building Number">
            </a-input>
            </a-form-item>
            <a-form-item label="Area / Locality" name="area_loc">
            <a-input v-model:value="formParty.area_loc" placeholder="Enter Area / Locality">
            </a-input>
            </a-form-item>
            <a-form-item label="PIN Code" name="pincode">
            <a-input v-model:value="formParty.pincode" placeholder="Enter PIN Code">
            </a-input>
            </a-form-item>
            <a-form-item label="City" name="city">
            <a-input v-model:value="formParty.city" placeholder="Enter City">
            </a-input>
            </a-form-item>
            <a-form-item label="State" name="state">
            <a-input v-model:value="formParty.state" placeholder="Enter State">
            </a-input>
            </a-form-item>
            <a-form-item name="same_ship">
            <a-checkbox v-model:checked="formParty.same_ship">Shipping address same as billing address</a-checkbox>
            </a-form-item>
            </a-sub-menu>
            </a-menu>
            <a-form-item :wrapper-col="{ span: 12, offset: 6 }" style="    margin-top: 19px;
    margin-left: 100px;">
                            <a-button type="primary" html-type="submit">Save</a-button>
                        </a-form-item>
            </a-form>
            </a-modal>  

        <a-layout-content :style="{ margin: '5px 16px', padding: '24px', background: '#fff', minHeight: 'calc(100vh - 115px)' }">
            <a-table :columns="columns" :dataSource="dataSource"
          :pagination="pagination" :loading="loading" @change="handleTableChange" bordered>
           <template #headerCell="{ column }">
           <template v-if="column.key === 'discount'">
             <span style="margin-right: 15px;">  
             Discount
             </span>
            </template>
            <template v-if="column.key === 'tax'">
            </template>
           </template>
          <template #bodyCell="{ column, text, record, index }">
            <template>
              {{ text ?? '-' }}
            </template>
            <template v-if="column.key === 'category'">
            <a-form-item>
            <a-select placeholder="">
            <a-select-option value="undefined"></a-select-option>
            </a-select>
            </a-form-item>
             
            </template>
            <template v-if="column.key === 'sno'">
              {{ index + 1 }}
            </template>
          </template>
        </a-table>
        <a-row>
        <a-col :span="12">
        </a-col>
        <a-col :span="12">
        <a-card style="width: 350px; float: right; margin-top: 12px;">
        <a-form :model="formState" v-bind="layout" name="nest-messages"
                        :validate-messages="validateMessages" @finish="submit">
        <a-form-item label="Total Net">
        <a-input placeholder="" style="width: 160px;"></a-input>
        </a-form-item>
        <a-form-item label="Total Tax" name="area_loc">
        <a-input  placeholder="" style="width: 160px;"></a-input>
        </a-form-item>
        <a-form-item label="Total" name="area_loc">
        <a-input  placeholder="" style="width: 160px;"></a-input>
        </a-form-item>
        </a-form>
        </a-card>
        </a-col>
        </a-row>
        
       
</a-layout-content>
</AuthenticatedLayout>
</template>
<script>
import { reactive, inject } from 'vue';
import { DownOutlined, PlusOutlined, PlusCircleOutlined } from '@ant-design/icons-vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { defineComponent, ref, computed } from 'vue';

const columns = [
  {
    title: 'S.NO',
    key: 'sno',
    dataIndex: 'sno',
    width: '8%',
  },
  {
    title: 'Category',
    key: 'category',
    dataIndex: 'category',
    width: '15%',
  },
  {
    title: 'Details',
    key: 'details',
    dataIndex: 'details',
    width: '10%',
  },
  {
    title: 'Net',
    key: 'net',
    dataIndex: 'net',
    width: '10%',
  },
   {
    title: 'Tax Rate',
    key: 'taxrate',
    dataIndex: 'taxrate',
    width: '10%',
  },
  {
    title: 'Tax',
    key: 'tax',
    dataIndex: 'tax',
    width: '10%',
  },
  {
    title: 'Total (₹)',
    key: 'total',
    dataIndex: 'total',
    fixed: 'right',
    width: '10%',
  },
];
const dataSource = ref([
  {
    key: '1',
    sno: '0',
    category: '',
    details: '',
    net: '',
    taxrate: '',
    tax: '',
    total: '',
  },
]);
export default defineComponent({
    inject: ['validateMessages'],
    props: {
      pagination: Object,
      errors: Object,
    },
    components: {
        AuthenticatedLayout,
        Head,
        PlusOutlined,
        DownOutlined,
        PlusCircleOutlined,
    },
    setup(props) {
        const layout = {
            labelCol: { span: 8 },
            wrapperCol: { span: 16 },
        };

        const checked = ref(false);
        const formParty = useForm({
            partyname: '',
            mobile: '',
            who_r_they: '',
            gstin: '',
            flat_no: '',
            area_loc: '',
            pincode: '',
            city: '',
            state: '',
            same_ship: false,
        });
        const formState = useForm({
            valuess: '',
        });
        return {
            formParty,
            formState,
            layout,
            columns,
            checked,
            dataSource,

        };
    },
    mounted() {
    },
    data() {
        return {
            showmodel_visible: false,
            menu_visible: false,
        }
    },
    methods: {
        partySubmit() {
            this.formParty.post(this.route('purchase.store'), {
             onError: errors => {},
             onFinish: visit => {
                    this.showmodel_visible = false;
                }, 
            });
        },
        handleTableChange(val) {
            this.$inertia.get(
            "/purchase/index",
            { page: val.current },
            { preserveState: true }
            );
        },
    },
});
</script>
<style>
.ant-menu-sub.ant-menu-inline {
    background: #ffffff; 
}
.ant-menu-inline, .ant-menu-vertical, .ant-menu-vertical-left {
    border-right: 0px;
}
.ant-form-item-label {
    display: inline-block;
    flex-grow: 0;
    overflow: hidden;
    white-space: nowrap;
    text-align: left;
    vertical-align: middle;
}
.ant-table-pagination.ant-pagination {
    display: none;
}
.ant-modal-footer{
display: none;
}
.ant-table-thead > tr > th {
    background: #1890ff;
}
.ant-table-thead > tr > th {
    color: #fafafa;
}
.ant-table.ant-table-bordered > .ant-table-container > .ant-table-content > table > thead > tr > th, .ant-table.ant-table-bordered > .ant-table-container > .ant-table-header > table > thead > tr > th,  .ant-table.ant-table-bordered > .ant-table-container > .ant-table-header > table > tbody > tr > td, .ant-table.ant-table-bordered > .ant-table-container > .ant-table-header > table > tfoot > tr > th, .ant-table.ant-table-bordered > .ant-table-container > .ant-table-header > table > tfoot > tr > td {
    border-right: 0px solid #f0f0f0;
}
</style>