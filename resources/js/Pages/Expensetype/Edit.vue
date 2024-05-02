<template>
    <Head title="Employees" />
    <AuthenticatedLayout>
        <a-affix :offset-top="0">
            <a-page-header :ghost="false" :title="expensetype.name" @back="() => $inertia.visit(route('expensetype.index'))">
                <template #extra>
                    <a-button key="1" type="primary" @click="triggerSubmit()">Save</a-button>
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

            <a-form-item label="Expense Type" name="expensetype" :rules="[{ required: true }]">
              <a-select v-model:value="formState.expensetype">
                <a-select-option value="Utility expenses">Utility expenses</a-select-option>
                <a-select-option value="Administration expenses">Administration expenses</a-select-option>
                <a-select-option value="IT and Internet Expense">IT and Internet Expense</a-select-option>
                <a-select-option value="Office Supplies">Office Supplies</a-select-option>
                <a-select-option value="Office Supplies">Health Care</a-select-option>
                <a-select-option value="undefined" disabled><a-button type="primary" @click="showModal">Add More</a-button></a-select-option>
              </a-select>
            </a-form-item>

             <a-form-item label="Amount" name="amount" :rules="[{ required: true }]">
            <a-input v-model:value="formState.amount">
            </a-input>
            </a-form-item>

             <a-form-item label="Method" name="method" :rules="[{ required: true }]">
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
                 <a-button ref="submitss" type="primary" html-type="submit">Save</a-button>
            </a-form-item>

             <a-modal v-model:visible="visible" title="Add Expense Type" @ok="handleOk">
            <template #footer>
           <a-button key="back" @click="handleCancel">Cancel</a-button>
           <a-button key="submit" type="primary" :loading="loading" @click="handleOk">Save</a-button>
           </template>
            <a-form-item label="Expense Type" name="expensetype" :rules="[{ required: true }]">
            <a-input v-model:value="formState.expensetype" placeholder="Enter Expense Type">
            </a-input>
            </a-form-item>
          </a-modal>

                 </a-form>
                </a-col>
            </a-row>
        </a-layout-content>
    </AuthenticatedLayout>
</template>

<script>
import { defineComponent } from 'vue';
import { reactive, inject, ref } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import dayjs, { Dayjs } from 'dayjs';


export default defineComponent({
    inject: ['validateMessages'],
    components: {
        AuthenticatedLayout,
        Head,
    },
    props: {
        expensetype: Object,
    },
    setup(props) {
    const visible = ref(false);

    const showModal = () => {
      visible.value = true;
    };

    const handleOk = e => {
      console.log(e);
      visible.value = false;
    };
    const handleCancel = () => {
      visible.value = false;
    };

        const layout = {
            labelCol: { span: 8 },
            wrapperCol: { span: 16 },
        };
        const formState = useForm({
            name: props.expensetype.name,
            expensetype: props.expensetype.expensetype,
            amount: props.expensetype.amount,
            method: props.expensetype.method,
            date: props.expensetype.date,
            description: props.expensetype.description,
        });
        return {
            formState,
            layout,
            visible,
            showModal,
            handleOk,
            handleCancel,
        };
    },
    mounted() {
    },
    methods: {
        triggerSubmit() {
            const btn = this.$refs.submitss;
            console.log(btn);
            btn.click();
        },
        submit() {
            this.formState.put(route("expensetype.update", this.expensetype.id));
        },
    },
});
</script>