<template>

  <Head title="Expense" />
  <AuthenticatedLayout>
   <a-affix :offset-top="0">
            <a-page-header :ghost="false" title="Add Expense" @back="() => $inertia.visit(route('expensetype.index'))">
                <template #extra>
                    <a-button key="1" type="primary">Save</a-button>
                </template>
            </a-page-header>
        </a-affix>
   <a-layout-content >
      <a-row>
        <a-col :span="12" :offset="6">
         <a-form :model="formState" v-bind="layout" name="nest-messages"
                        :validate-messages="validateMessages" @finish="submit">

            <a-form-item label="Name" name="name" :rules="[{ required: true }]">
            <a-input v-model:value="formState.name" >
             <template #prefix>
            <user-outlined type="user" />
             </template>
            </a-input>
            </a-form-item>

            <a-form-item label="Expense Type">
              <a-select placeholder="Select Expense Type" v-model:value="formState.expensetype_id">
              <a-select-option :value="expensetype.id" v-for="expensetype in expensetypes">{{ expensetype.expensetype }}</a-select-option>
                <a-select-option value="" @click.stop="() => { exmodel_visible = true; }"><PlusCircleOutlined /> Add More</a-select-option>
               
              </a-select>
            </a-form-item>

             <a-form-item label="Amount" name="amount" :rules="[{ required: true }]">
            <a-input v-model:value="formState.amount">
            </a-input>
            </a-form-item>

             <a-form-item label="Payment Method" name="method" :rules="[{ required: true }]">
              <a-select v-model:value="formState.method">
                <a-select-option value="Bank Transfer">Bank Transfer</a-select-option>
                <a-select-option value="Cash Payment">Cash Payment</a-select-option>
                <a-select-option value="Cheque Payment">Cheque Payment</a-select-option>
                <a-select-option value="Online Payments">Online Payments</a-select-option>
              </a-select>
            </a-form-item>

            <a-form-item label="Date" name="date" :rules="[{ required: true }]">
                <a-date-picker value-format="YYYY-MM-DD" :style="{ 'width': '100%' }" v-model:value="formState.date" />
            </a-form-item>

             <a-form-item label="Description" name="description" :rules="[{ required: true }]">
                 <a-textarea v-model:value="formState.description" placeholder="Enter Description" :rows="4" />
            </a-form-item>

            <a-form-item :wrapper-col="{ span: 12, offset: 6 }">
                 <a-button type="primary" html-type="submit">Save</a-button>
            </a-form-item>



         </a-form>
        </a-col>
      </a-row>
    </a-layout-content>


           <a-modal :visible="exmodel_visible" title="Title" :closable="true"  
            @close="exmodel_visible = false">

        <a-form :model="ExformState" method="post" v-bind="layout" name="nest-messages"
                        :validate-messages="validateMessages" @finish="EXsubmit">
       <a-form-item label="Expense Type" name="expensetype" :rules="[{ required: true }]">
            <a-input v-model:value="ExformState.expensetype" placeholder="Enter Expense Type">
            </a-input>
            </a-form-item>
             <a-form-item :wrapper-col="{ span: 12, offset: 6 }">
                 <a-button type="primary" html-type="submit">Save</a-button>
            </a-form-item>
             </a-form>
    </a-modal>

  </AuthenticatedLayout>
</template>
<script>
import { reactive, inject } from 'vue';
import { UserOutlined, PlusCircleOutlined } from '@ant-design/icons-vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm, router } from '@inertiajs/vue3';
import { ref, defineComponent } from 'vue';

export default defineComponent({
 inject: ['validateMessages'],
    components: {
        AuthenticatedLayout,
        PlusCircleOutlined,
        UserOutlined,
        Head,
    }, 
    props: {
        expensetypes: Object,
        errors: Object,
    },
    setup(props) {
    const exmodel_visible = ref(false);
    const loading = ref(false);

        const layout = {
            labelCol: { span: 8 },
            wrapperCol: { span: 16 },
        };
        const ExformState = useForm({
            expensetype: '',
        });
        const formState = useForm({
            name: '',
            expensetype_id: [],
            amount: '',
            method: '',
            date: '',
            description: '',
        });
        return {
            ExformState,
            formState,
            loading,
            layout,
            exmodel_visible,
        };
    },

     data() {
        return {
            exmodel_visible: false,
        }
    },
    methods: {
    EXsubmit() {
    alert("sdfdsf");
            router.post(route("expensetype.update_expensetype"), this.ExformState, {
                onSuccess: page => { },
                onError: errors => { },
                onFinish: visit => {
                    this.exmodel_visible = false;
                },
            })
    },
        submit() {
            this.formState.post(route("expensetype.store"));
           
        },
    },
});
</script>
<style>
.ant-modal-footer {
    display: none;
    }
</style>