<template>
    <Head title="Employees" />
    <AuthenticatedLayout>
        <a-affix :offset-top="0">
            <a-page-header :ghost="false" title="Sales Invoice" @back="() => $inertia.visit(route('sales.create'))">
                <template #extra>      
                   <a-button type="primary">Save</a-button>
                </template>
                <template v-slot:tags>
        <a-tag color="">AWAITING PAYMENT</a-tag>
      </template> <p style="margin-left: 34px">
            View, edit or manage your Sales Invoice.
          </p>
      <a-row class="content">
        <div style="flex: 1">
         
        </div>
      </a-row>
            </a-page-header>
        </a-affix>
 <a-alert v-if="visible" message="Great! Invoice Created" type="success" closable :after-close="handleClose" :style="{ margin: '12px 12px', width: '65%' }"/>
 <a-row type="flex">
    <a-col :style="{ margin: '5px 16px', padding: '24px', background: '#fff', minHeight: 'calc(100vh - 115px)', width: '65%' }" >
<div id="element-to-convert">
<a-layout-content> 
<a-row>
<a-col :span="24">
<p><b>To:</b> uini(vgvvgvgvg123)</p>
</a-col>
</a-row>
 <a-row style="width: 500px;">
    <a-col :span="8"><b>Invoice Address</b>
    <p style="margin-bottom: 0px;">xcx</p>
    <p style="margin-bottom: 0px;">xc</p>
    <p style="margin-bottom: 0px;">xc xc 625007</p>
    <p>India</p>
    </a-col>
    <a-col :span="8"><b>Invoice Date</b>
    <p style="margin-bottom: 0px;">Feb 28,2023</p>
    </a-col>
    <a-col :span="8"><b>Due Date</b>
    <p style="margin-bottom: 0px;">Mar 30,2023</p>
    <p style="margin-bottom: 0px;">Due in 30 days</p>
    </a-col>
  </a-row>
<a-table :columns="columns" :data-source="data" bordered>
<template #name="{ text }">
<a>{{ text }}</a>
</template>
</a-table> 
<a-card style="width: 380px; float: right; margin-top: 15px;" bordered>
<a-row>
<a-col :span="12"><b>Sub Total</b></a-col>
<a-col :span="12">₹ 120.00</a-col>
</a-row>
<a-row style="margin-top: 15px; margin-bottom: 15px;">
<a-col :span="12"><b>Tax Breakdown</b>
<p style="margin-bottom: 0px;">No Tax: 120.00 @ 0.00%</p>
</a-col>
<a-col :span="12">0.00</a-col>
</a-row>
<a-divider style="height: 2px; background-color: #A9A9A9" />
<a-row>
<a-col :span="12"><b>Total</b></a-col>
<a-col :span="12"><b>₹ 120.00</b></a-col>
</a-row>
<a-divider style="height: 2px; background-color: #A9A9A9" />
</a-card>       
</a-layout-content>
</div>
</a-col>
<a-col flex="0 1 300px">
<a-card style="width: 360px; margin-top: 4px;">
<a-steps :current="1" size="small" style="margin-bottom: 42px;">
    <a-step title="Created" />
    <a-step title="Send" />
    <a-step title="Viewed" />
    <a-step title="Paid" />
  </a-steps>
<a-row style="margin-top: 20px;">
<a-col :span="12"><b>Amount Paid</b>
<p>0.00</p></a-col>
<a-col :span="12"><b>Amount Outstanding</b>
<p>0.00</p></a-col>
</a-row>
<a-button style="width: 100%; margin-top: 15px;" type="primary" @click.stop="() => { menu_visible = true; }">Record Payment</a-button>
<a-modal v-model:visible="menu_visible" @close="menu_visible = false" title="Record Payment" @ok="handleOk">
<template #footer>
<a-button key="submit" type="primary" :loading="loading" @click="handleOk">Record</a-button>
</template>
<a-card style="width: 470px; height: 140px;">
<a-row>
    <a-col :span="12"><b>Amount received</b>
    <p style="margin-bottom: 0px;">Remaining balance ₹0.00</p>
    </a-col>
    <a-col :span="12">
     <a-form-item name="area_loc">
     <a-input v-model:value="value" placeholder="" />
     </a-form-item>
    </a-col>
  </a-row>
<a-row>
    <a-col :span="12"><b>Discount</b></a-col>
    <a-col :span="12"><a-form-item name="area_loc"><a-input v-model:value="value" placeholder="" /></a-form-item></a-col>
  </a-row>
</a-card>
<a-card style="width: 470px; margin-top: 12px; height: 260px;">
<a-row>
    <a-col :span="12"><b>Payment Date</b></a-col>
    <a-col :span="12"><a-form-item name="area_loc"><a-date-picker value-format="YYYY-MM-DD" :style="{ 'width': '100%' }" \\v-model:value="formState.doj" /></a-form-item></a-col>
</a-row>
<a-row>
    <a-col :span="12"><b>Paid Into</b></a-col>
    <a-col :span="12"><a-form-item name="area_loc"><a-input v-model:value="value" placeholder="" /></a-form-item></a-col>
  </a-row>
<a-row>
    <a-col :span="12"><b>Method</b></a-col>
    <a-col :span="12">
    <a-form-item name="gender">
    <a-select  placeholder="Select Method">
    <a-select-option value="Cash">Cash</a-select-option>
    <a-select-option value="Check">Check</a-select-option>
    <a-select-option value="Electronic">Electronic</a-select-option>
    <a-select-option value="creditcard">Credit/Debit Card</a-select-option>
    </a-select>
    </a-form-item>
    </a-col>
</a-row>
<a-row>
    <a-col :span="12"><b>Reference(optional)</b></a-col>
    <a-col :span="12"><a-form-item name="area_loc"><a-input v-model:value="value" placeholder="" /></a-form-item></a-col>
  </a-row>
</a-card>
</a-modal>
</a-card>
<a-card style="width: 360px; margin-top: 4px;">
<a-row>
<a-col :span="12">
<p><MailOutlined style="margin-right: 12px;" />Email</p>
<p><EditOutlined style="margin-right: 12px;" />Edit</p>
<p><CopyOutlined style="margin-right: 12px;" />Copy</p>
<p style="cursor: pointer;" @click.stop="() => { download_visible = true; }" ><DownloadOutlined style="margin-right: 12px;"/>Download</p>
<p><DisconnectOutlined style="margin-right: 12px;" />Void</p>
</a-col>
<a-col :span="12">
<p><PrinterOutlined style="margin-right: 12px;" />Print Preview</p>
<p><ShareAltOutlined style="margin-right: 12px;" />Share Link</p>
<p><FileTextOutlined style="margin-right: 12px;" />Add Credit note</p>
<p><PaperClipOutlined style="margin-right: 12px;" />Add File</p>
</a-col>
</a-row>
</a-card>
</a-col>
</a-row>
<a-modal v-model:visible="download_visible" @close="download_visible = false" title="Sending this invoice?" @ok="handleOk">
<template #footer>
<a-button key="submit" type="primary" :loading="loading"  @click="exportToPDF">Make as sent</a-button>
<a-button key="back" @click="download_visible = false">Leave as unsent</a-button>
</template>
<p>Would you like to make this invoice as sent?</p>
</a-modal>
</AuthenticatedLayout>
</template>
<script>
import { reactive, inject } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { MailOutlined, EditOutlined, CopyOutlined, DownloadOutlined, DisconnectOutlined, ShareAltOutlined, FileTextOutlined, PaperClipOutlined, PrinterOutlined } from '@ant-design/icons-vue';
import { defineComponent, ref, computed } from 'vue';

const columns = [
  {
    title: 'Description',
    dataIndex: 'description',
    key: 'description',
    slots: {
      customRender: 'description',
    },
    width: '35%',
  },
  {
    title: 'Price/Rate',
    dataIndex: 'price',
    key: 'price',
    width: '20%',
  },
  {
    title: 'Tax',
    dataIndex: 'tax',
    key: 'tax',
    width: '16%',
  },
  {
    title: 'Subtotal',
    dataIndex: 'subtotal',
    key: 'subtotal',
    width: '30%',
  },
];
const data = [
  {
    key: '1',
    description: 'test',
    price: 120.00,
    tax: '0.00',
    subtotal: 120.00,
  },
];
export default defineComponent({
    inject: ['validateMessages'],
    props: {
      pagination: Object,
      errors: Object,
    },
    components: {
        AuthenticatedLayout,
        Head,
        MailOutlined,
        EditOutlined,
        CopyOutlined,
        DownloadOutlined,
        DisconnectOutlined,
        ShareAltOutlined,
        FileTextOutlined,
        PaperClipOutlined,
        PrinterOutlined,
    },
    setup(props) {
        const visible = ref(true);

        const handleClose = () => {
         visible.value = false;
        };

        const layout = {
            labelCol: { span: 8 },
            wrapperCol: { span: 16 },
        };

        const formState = useForm({

        });
        return {
            formState,
            layout,
            visible,
            handleClose,
            data,
            columns,

        };
    },
    mounted() {
    },
    data() {
        return {
            menu_visible: false,
            download_visible: false,
        }
    },
    methods: {
    exportToPDF() {
      html2pdf(document.getElementById("element-to-convert"), {
                margin: 1,
            filename: "invoice.pdf",
            });
    },
      
    },
});
</script>
<style>
.ant-table-pagination.ant-pagination {
    margin: 16px 0;
    display: none;
}
.ant-table-thead > tr > th {
    background: #1890ff;
}
.ant-table-thead > tr > th {
    color: #fafafa;
}
.ant-steps-small .ant-steps-item-title {
    font-size: 12px;
}
.ant-steps-item-finish .ant-steps-item-icon {
    background-color: #fff;
    border-color: #52c41a;
}
.ant-steps-item-finish .ant-steps-item-icon > .ant-steps-icon {
    color: #52c41a;
}
.ant-steps-item-process > .ant-steps-item-container > .ant-steps-item-icon {
    background: #52c41a;
}
.ant-steps-item-process .ant-steps-item-icon {
    background-color: #fff;
    border-color: #52c41a;
}
.ant-table.ant-table-bordered > .ant-table-container > .ant-table-content > table, .ant-table.ant-table-bordered > .ant-table-container > .ant-table-header > table {
    border-bottom: 2px solid #f0f0f0;
}f0f0f0
.ant-table.ant-table-bordered > .ant-table-container > .ant-table-content > table > thead > tr > th, .ant-table.ant-table-bordered > .ant-table-container > .ant-table-header > table > thead > tr > th,  .ant-table.ant-table-bordered > .ant-table-container > .ant-table-header > table > tbody > tr > td, .ant-table.ant-table-bordered > .ant-table-container > .ant-table-header > table > tfoot > tr > th, .ant-table.ant-table-bordered > .ant-table-container > .ant-table-header > table > tfoot > tr > td {
    border-right: 0px solid #f0f0f0;
}
</style>