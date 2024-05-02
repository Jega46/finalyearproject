<template>
    <Head title="Employees" />
    <AuthenticatedLayout>
        <a-affix :offset-top="0">
            <a-page-header :ghost="false" title="Add Purchase" @back="() => $inertia.visit(route('purchase.index'))">
                <template #extra>
                    <a-button key="1" type="primary">Save</a-button>
                </template>
            </a-page-header>
        </a-affix>

    <a-row>
    <a-col :span="12" :offset="0">
        <a-card style="padding: 0px; background: #fff; minHeight: 2px; margin-top: 16px; margin-bottom: 12px; margin-left: 16px;     height: 270px;" >
        <a-form :model="formState" v-bind="layout" name="nest-messages"
                        :validate-messages="validateMessages" @finish="submit">
        <h3 :wrapper-col="{ span: 12, offset: 6 }"  style="margin-bottom: 20px;font-size: 14px;margin-top: 10px;">PARTY DETAILS</h3>
            <a-input-group size="medium">
            <a-form-item label="PO Number" name="po_number">
                <a-input  placeholder="PO Number"></a-input>
            </a-form-item>
            <a-form-item label="Add Party" name="po_number">
                <a-select placeholder="Party Name">
                    <a-select-option value="undefined" @click.stop="() => { showmodel_visible = true; }" ><PlusCircleOutlined /> Add New Party</a-select-option>
                </a-select>
            </a-form-item>
            </a-input-group>

            <a-modal title="Add New Party" :closable="true" v-model:visible="showmodel_visible" @close="showmodel_visible = false">
            <a-form :model="formParty" v-bind="layout" name="nest-messages"
                        :validate-messages="validateMessages" @finish="partySubmit">
            <a-form-item label="Party Name" name="partyname" :rules="[{ required: true }]">
            <a-input v-model:value="formParty.partyname" placeholder="Enter Party Name">
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

        </a-form>
    </a-card>
    </a-col>
    <a-col :span="12">
    <a-card style="margin-top: 16px; margin-bottom: 12px; margin-left: 12px; margin-right: 16px; padding: 0px; background: #fff; minHeight: 2px;">
        <a-form :model="formState" v-bind="layout" name="nest-messages"
                        :validate-messages="validateMessages" @finish="submit">
        <h3 :wrapper-col="{ span: 12, offset: 6 }"  style="margin-bottom: 20px;font-size: 14px;margin-top: 10px;">PURCHASE DETAILS</h3>
        <a-input-group size="medium">
            <a-form-item label="Bill Number" name="bill_no" :rules="[{ required: true }]">
                <a-input v-model:value="value" placeholder="Bill Number"></a-input>
            </a-form-item>
            <a-form-item label="Bill Date" name="date" :rules="[{ required: true }]">
                <a-date-picker value-format="YYYY-MM-DD" :style="{ 'width': '100%' }"  />
            </a-form-item>
            <a-form-item label="Delivery Date" name="date">
                <a-date-picker value-format="YYYY-MM-DD" :style="{ 'width': '100%' }"  />
            </a-form-item>
        </a-input-group>
        </a-form>
    </a-card>
    </a-col>
    </a-row>
      
        <a-layout-content :style="{ margin: '5px 16px', padding: '24px', background: '#fff', minHeight: 'calc(100vh - 115px)' }">
            <h5 :wrapper-col="{ span: 12, offset: 6 }" style="margin-bottom: 20px;font-size: 14px;margin-top: 10px;">ITEMS ON THE PURCHASE</h5>
            <a-table :columns="columns" :dataSource="dataSource"
          :pagination="pagination" :loading="loading" @change="handleTableChange" bordered>
           <template #headerCell="{ column }">
           <template v-if="column.key === 'discount'">
             <span style="margin-right: 15px;">  
             Discount
             </span>
            <EditOutlined />
            </template>
            <template v-if="column.key === 'tax'">
             <span style="margin-right: 50px;">  
             Tax
             </span>
             <EditOutlined />
            </template>
           </template>
          <template #bodyCell="{ column, text, record, index }">
            <template>
              {{ text ?? '-' }}
            </template>
            <template v-if="column.key === 'name'">
              <a-button style="margin-top: 12px;" key="1" type="primary" @click.stop="() => { invdrawer_visible = true; }">Select Items from Inventory</a-button>
            </template>
             <template v-if="column.key === 'hsn_mat'">
              {{ text }}
            </template>
            <template v-if="column.key === 'sno'">
              {{ index + 1 }}
            </template>
          </template>
        </a-table>
         <a-button class="editable-add-btn" type="primary" style="margin-top: 12px;" @click="handleAdd">Add Rows</a-button>

        <a-card style="width: 350px; float: right; margin-top: 12px;">
        <a-form :model="formState" v-bind="layout" name="nest-messages"
                        :validate-messages="validateMessages" @finish="submit">
        <a-form-item label="Sub Total" name="area_loc">
        <a-input placeholder="">
        </a-input>
        </a-form-item>
         <a-form-item label="Paid Amount" name="area_loc">
        <a-input  placeholder="">
        </a-input>
        </a-form-item>
         <a-form-item label="Grand Total" name="area_loc">
        <a-input  placeholder="">
        </a-input>
        </a-form-item>
        </a-form>
        </a-card>

  <a-drawer title="Create a new account" :width="620" :closable="true" :visible="invdrawer_visible" @close="invdrawer_visible = false" >
  <a-row type="flex" style="margin-bottom: 15px;">
    <a-col flex="auto">
    <a-input-search v-model:value="value" placeholder="Search for any items in your inventory " enter-button />
    </a-col>
    <a-col flex="45px" style="margin-left: 5px;">
    <a-button type="primary" :size="size">
    <template #icon>
     <AlignLeftOutlined />
    </template>sort
    </a-button>
    </a-col>
    </a-row>
    <a-button type="primary"   @click="isShowing ^= true" style="margin-bottom:10px;"><PlusOutlined />Add New Item</a-button>
    <a-list item-layout="horizontal" :data-source="datas">
    <template #renderItem="{ item }">
      <a-list-item>
        <a-list-item-meta>
          <template #title>
           Oil
          </template>
          <template #description>
          <a-row style="margin-top:10px;">
          <a-col :span="8"> PURCHASE PRICE</a-col>
          <a-col :span="8">STOCK</a-col>
          <a-col :span="8"><a-button type="primary" style="margin-bottom:0px;"><PlusOutlined />Add</a-button></a-col>
          </a-row>
           <a-row>
          <a-col :span="8">2</a-col>
          <a-col :span="8">2</a-col>
          </a-row>
          </template>
         
        </a-list-item-meta>
      </a-list-item>
    </template>
  </a-list>
    <a-form :model="formState" :label-col="labelCol"  v-show="isShowing" :wrapper-col="wrapperCol" :rules="rules" layout="vertical">
    <a-form-item label="Item name" style="row-gap: 0px;margin-bottom: 12px;">
      <a-input placeholder="Enter Item name here (Eg, Milk, Bulb, Mobile)" />
    </a-form-item>
      <a-row :gutter="16">
        <a-col :span="12">
          <a-form-item label="Sale price" style="row-gap: 0px;margin-bottom: 12px;">
            <a-input placeholder="Please enter sale price" />
          </a-form-item>
        </a-col>
        <a-col :span="12">
          <a-form-item label="Purchase price" style="row-gap: 0px;margin-bottom: 12px;">
            <a-input placeholder="Please enter purchase price" />
          </a-form-item>
        </a-col>
      </a-row>
      <a-row :gutter="16">
        <a-col :span="12">
          <a-form-item label="Units" style="row-gap: 0px;margin-bottom: 12px;">
            <a-select placeholder="Please select unit">
              <a-select-option value="xiao">Xiaoxiao Fu</a-select-option>
              <a-select-option value="mao">Maomao Zhou</a-select-option>
            </a-select>
          </a-form-item>
        </a-col>
        <a-col :span="12">
          <a-form-item label="Tax Included" style="row-gap: 0px;margin-bottom: 12px;">
             <a-switch v-model:checked="checked" />
          </a-form-item>
        </a-col>
      </a-row>
      <a-row :gutter="16">
        <a-col :span="12">
          <a-form-item label="Opening stock" style="row-gap: 0px;margin-bottom: 12px;">
            <a-input placeholder="Enter count"/>
          </a-form-item>
        </a-col>
        <a-col :span="12">
          <a-form-item label="Low stock" style="row-gap: 0px;margin-bottom: 12px;">
             <a-input  placeholder="Enter low count"/>
          </a-form-item>
        </a-col>
      </a-row>
       <a-row :gutter="16">
        <a-col :span="12">
          <a-form-item label="HSN Code">
            <a-input  placeholder="Enter HSN code"/>
          </a-form-item>
        </a-col>
        <a-col :span="12">
          <a-form-item label="GST %">
       <a-input placeholder="Enter GST %"  @click="gstShowing ^= true">
       <template #suffix>
        <DownOutlined style="color: rgba(0, 0, 0, 0.25); font-size: 12px;" />
        </template>
        </a-input>
          </a-form-item>
        </a-col>
      </a-row>
   
    <a-list item-layout="horizontal" :data-source="data" v-show="gstShowing" style="margin-bottom: 16px;">
    <template #renderItem="{ item }">
      <a-list-item>
        <template #actions>
          <a-radio v-model:checked="checked"></a-radio>
        </template>
        <a-list-item-meta :description="item.description">
            <template #title>{{ item.title }}</template>
        </a-list-item-meta>
      </a-list-item>
    </template>

    <p  style="margin-bottom: 20px; cursor: pointer; color: #1890ff;" @click="addcustom ^= true">
    <PlusCircleOutlined /> Add Custom Tax</p>
    <a-form :model="formState" v-bind="layout" name="nest-messages" v-show="addcustom"
                        :validate-messages="validateMessages" @finish="submit">
        <a-form-item label="CUSTOM TAX %" style="margin-bottom: 70px;">
        <a-input-group size="medium">
        <a-row :gutter="8">
        <a-col :span="8">
            <a-input  placeholder="GST"/>
        </a-col>
        <a-col :span="8">
            <a-input placeholder="CESS"/>
        </a-col>
        <a-col :span="8">
            <a-button type="primary" html-type="submit">Save</a-button>
        </a-col>
        </a-row>
        </a-input-group>
        </a-form-item>
    </a-form>
    </a-list>
   
    <a-form-item>
      <a-button type="primary">Add Item</a-button>
      <a-button style="margin-left: 10px">Cancel</a-button>
    </a-form-item>
    </a-form>
  </a-drawer>
</a-layout-content>
</AuthenticatedLayout>
</template>
<script>
import { reactive, inject } from 'vue';
import { DownOutlined, PlusOutlined, AlignLeftOutlined, EditOutlined, PlusCircleOutlined } from '@ant-design/icons-vue';
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
    title: 'Product Name',
    key: 'name',
    dataIndex: 'name',
    sorter: true,
    width: '15%',
  },
  {
    title: 'HSN or Material code',
    key: 'hsn_mat',
    dataIndex: 'hsn_mat',
    sorter: true,
    width: '15%',
  },
  {
    title: 'Quantity',
    key: 'quantity',
    dataIndex: 'quantity',
    sorter: true,
    width: '10%',
  },
  {
    title: 'Price',
    key: 'price',
    dataIndex: 'price',
    sorter: true,
    width: '10%',
  },
   {
    title: 'Discount',
    key: 'discount',
    dataIndex: 'discount',
    width: '10%',
  },
  {
    title: 'Tax',
    key: 'tax',
    dataIndex: 'tax',
    width: '10%',
  },
  {
    title: 'TOTAL',
    key: 'total',
    dataIndex: 'total',
    fixed: 'right',
    width: '10%',
  },
];
const data = [
  {
    key: '1',
    title: 'Tax Exempted',
    description: '',
    value: ''
  },
  {
    key: '2',
    title: 'GST@ 0%',
    description: '(NO GST )',
    value: 'GST@ 0%',
  },
  {
    title: 'GST@ 0.1%',
    description: '(0.05% CSGT + 0.05% SGST/UT GST ; 0.1% IGST )'
  },
  {
    title: 'GST@ 0.25%',
    description: '(0.125% CSGT + 0.125% SGST/UT GST ; 0.25% IGST )'
  },
  {
    title: 'GST@ 3%',
    description: '(1.5% CSGT + 1.5% SGST/UT GST ; 3% IGST )'
  },
  {
    title: 'GST@ 5%',
    description: '(2.5% CSGT + 2.5% SGST/UT GST ; 5% IGST )'
  },
  {
    title: 'GST@ 6%',
    description: '(3% CSGT + 3% SGST/UT GST ; 6% IGST )'
  },
  {
    title: 'GST@ 7.5%',
    description: '(3.75% CSGT + 3.75% SGST/UT GST ; 7.5% IGST )'
  },
  {
    title: 'GST@ 12%',
    description: '(6% CSGT + 6% SGST/UT GST ; 12% IGST )'
  },
  {
    title: 'GST@ 18%',
    description: '(9% CSGT + 9% SGST/UT GST ; 18% IGST )'
  },
  {
    title: 'GST@ 28%',
    description: '(14% CSGT + 14% SGST/UT GST ; 28% IGST )'
  },
];
const datas = [
  {
    key: '1',
    title: 'Tax Exempted',
    description: '',
    value: ''
  },
  ];
const dataSource = ref([
  {
    key: '1',
    sno: '0',
    name: 'Product Name',
    hsn_mat: '',
    quantity: '',
    price: '',
    discount: '',
    tax: '',
    total: '',
  },
]);
const handleAdd = () => {
      const newData = {
        key: '${count.value}',
        name: 'Product Name',
        hsn_mat: '',
        quantity: '',
        price: '',
        discount: '',
        tax: '',
        total: '',
      };
      dataSource.value.push(newData);
};
const count = computed(() => dataSource.value.length + 1);
export default defineComponent({
    inject: ['validateMessages'],
    props: {
      pagination: Object,
      errors: Object,
    },
    components: {
        AuthenticatedLayout,
        Head,
        EditOutlined,
        PlusOutlined,
        DownOutlined,
        PlusCircleOutlined,
        AlignLeftOutlined,
    },
    setup(props) {
        const layout = {
            labelCol: { span: 8 },
            wrapperCol: { span: 16 },
        };

        const checked = ref(false);
        const handleCancel = () => {
          showmodel_visible.value = false;
        };
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
        return {
            formParty,
            layout,
            handleAdd,
            handleCancel,
            columns,
            datas,
            data,
            count,
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
            invdrawer_visible: false,
            isShowing:false,
            addcustom:false,
            gstShowing:false,
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
</style>