
<template>
    <Head title="Employees" />
    <AuthenticatedLayout>
        <a-affix :offset-top="0">
            <a-page-header :ghost="false" title="Add Employee" @back="() => $inertia.visit(route('employees.index'))">
                <template #extra>
                    <a-button key="1" type="primary">Save</a-button>
                </template>
            </a-page-header>
        </a-affix>
        <a-layout-content >
            <a-row>
                <a-col :span="12" :offset="6">
                    <a-form :model="formState" v-bind="layout" name="nest-messages" :validate-messages="validateMessages"
                        @finish="submit">
                        <h3 :wrapper-col="{ span: 12, offset: 6 }">
                            Basic
                        </h3>
                        <a-form-item label="Name" name="name" :rules="[{ required: true }]">
                            <a-input v-model:value="formState.name" />
                        </a-form-item>
                        <a-form-item label="Job Title" name="designation" :rules="[{ required: true }]">
                            <a-input v-model:value="formState.designation" />
                        </a-form-item>
                        <a-form-item label="Branch" :rules="[{ required: true }]">
                            <a-select placeholder="Select Branch" v-model:value="formState.branch_id" mode="multiple">
                                <a-select-option :value="branch.id" v-for="branch in branches">{{
                                    branch.branch_name
                                }}</a-select-option>
                            </a-select>
                        </a-form-item>
                        <a-form-item label="Mobile Number" name="mobile" :rules="[{ required: true }]">
                            <a-input-group compact>
                                <a-select style="width: 80px" :value="'+91'">
                                    <a-select-option value="+91">+91</a-select-option>
                                </a-select>
                                <a-input style="width: calc(100% - 80px)" v-model:value="formState.mobile" />
                            </a-input-group>
                        </a-form-item>
                        <a-form-item label="Gender" name="gender" :rules="[{ required: true }]">
                            <a-select v-model:value="formState.gender">
                                <a-select-option value="Male">Male</a-select-option>
                                <a-select-option value="Female">Female</a-select-option>
                            </a-select>
                        </a-form-item>
                        <a-form-item label="Email" name="email" :rules="[{ types: email }]">
                            <a-input v-model:value="formState.email" />
                        </a-form-item>
                        <a-form-item name="doj" label="Date of Joining">
                            <a-date-picker value-format="YYYY-MM-DD" :style="{ 'width': '100%' }"
                                v-model:value="formState.doj" />
                        </a-form-item>
                        <a-form-item label="Address" name="address">
                            <a-textarea v-model:value="formState.address" />
                        </a-form-item>
                        <h3 :wrapper-col="{ span: 12, offset: 6 }">
                            Attendance
                        </h3>
                        <a-form-item label="Working Days" name="working_days">
                            <a-checkbox-group v-model:value="formState.working_days" style="width: 100%">
                                <a-row>
                                    <a-col :span="4">
                                        <a-checkbox value="Sun">Sun</a-checkbox>
                                    </a-col>
                                    <a-col :span="4">
                                        <a-checkbox value="Mon">Mon</a-checkbox>
                                    </a-col>
                                    <a-col :span="4">
                                        <a-checkbox value="Tue">Tue</a-checkbox>
                                    </a-col>
                                    <a-col :span="4">
                                        <a-checkbox value="Wed">Wed</a-checkbox>
                                    </a-col>
                                    <a-col :span="4">
                                        <a-checkbox value="Thu">Thu</a-checkbox>
                                    </a-col>
                                    <a-col :span="4">
                                        <a-checkbox value="Fri">Fri</a-checkbox>
                                    </a-col>
                                    <a-col :span="4">
                                        <a-checkbox value="Sat">Sat</a-checkbox>
                                    </a-col>
                                </a-row>
                            </a-checkbox-group>
                        </a-form-item>
                        <a-form-item label="Timing" name="work_timing">
                            <a-time-range-picker :style="{ width: '100%' }" format="h:mm a"
                                v-model:value="formState.work_timing" />
                        </a-form-item>
                        <h3 :wrapper-col="{ span: 12, offset: 6 }">
                            Bank Account Details
                        </h3>
                        <a-form-item label="Bank Name" name="bank_name">
                            <a-input v-model:value="formState.bank_name" />
                        </a-form-item>
                        <a-form-item label="Account Number" name="account_number">
                            <a-input v-model:value="formState.account_number" />
                        </a-form-item>
                        <a-form-item label="IFSC Code" name="ifsc_code">
                            <a-input v-model:value="formState.ifsc_code" />
                        </a-form-item>
                        <a-form-item label="Account holders name" name="accountholder_name">
                            <a-input v-model:value="formState.accountholder_name" />
                        </a-form-item>
                        <h3 :wrapper-col="{ span: 12, offset: 6 }">
                            Additional Details
                        </h3>
                        <a-form-item label="Employee Id" name="employeeid">
                            <a-input v-model:value="formState.employeeid" />
                        </a-form-item>
                        <a-form-item label="Date of Birth" name="dob">
                            <a-date-picker value-format="YYYY-MM-DD" v-model:value="formState.dob"
                                :style="{ 'width': '100%' }" />
                        </a-form-item>
                        <a-form-item label="Aadhar No" name="aadhar_number" :rules="[{ required: true }]">
                            <a-input v-model:value="formState.aadhar_number" />
                        </a-form-item>
                        <a-form-item label="UAN" name="uan_number">
                            <a-input v-model:value="formState.uan_number" />
                        </a-form-item>
                        <a-form-item label="PAN" name="pan_number">
                            <a-input v-model:value="formState.pan_number" />
                        </a-form-item>
                        <a-form-item label="PF No." name="pf_number">
                            <a-input v-model:value="formState.pf_number" />
                        </a-form-item>
                        <a-form-item label="ESI No." name="esi_number">
                            <a-input v-model:value="formState.esi_number" />
                        </a-form-item>
                        <a-form-item :wrapper-col="{ span: 12, offset: 6 }">
                            <a-button type="primary" html-type="submit">Save</a-button>
                        </a-form-item>
                    </a-form>
                </a-col>
            </a-row>
        </a-layout-content>
    </AuthenticatedLayout>
</template>
<script>
import { reactive, inject } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';

export default ({
    inject: ['validateMessages'],
    components: {
        AuthenticatedLayout,
        Head,
    },
    props: {
        branches: Object,
        errors: Object,
    },
    setup() {
        const layout = {
            labelCol: { span: 8 },
            wrapperCol: { span: 16 },
        };
        const formState = useForm({
            name: '',
            designation: '',
            branch_id: [],
            mobile: '',
            gender: '',
            email: '',
            doj: '',
            address: '',
            working_days: ['Sun','Mon','Tue','Wed','Thu','Fri','Sat'],
            work_timing: '',
            bank_name: '',
            account_number: '',
            ifsc_code: '',
            accountholder_name: '',
            employeeid: '',
            dob: '',
            aadhar_number: '',
            uan_number: '',
            pan_number: '',
            pf_number: '',
            esi_number: '',
        });
        return {
            formState,
            layout,
        };
    },
    mounted() {
    },
    methods: {
        submit() {
            this.formState.post(route("employees.store"));
        },
    },
});
</script>