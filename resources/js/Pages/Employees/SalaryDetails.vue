
<template>
    <Head title="Employees" />
    <AuthenticatedLayout>
        <a-affix :offset-top="0">
            <a-page-header :ghost="false" :title="employee.name + ' Salary Info'"
                @back="() => $inertia.visit(route('employees.index'))">
                <template #extra>
                    <h4>Total CTC: <span class="currency">₹</span> {{ this.formState.ctc }}</h4>
                    <a-button key="1" type="primary" @click.stop="() => { otdrawer_visible = true; }">OT settings</a-button>
                    <a-button key="1" type="primary" @click.stop="() => { latedrawer_visible = true; }">Late Penalty Settings</a-button>
                </template>
            </a-page-header>
        </a-affix>
        <a-layout-content >
            <a-row>
                <a-col :span="12" :offset="5">
                    <a-form :model="formState" v-bind="layout" name="nest-messages" :validate-messages="validateMessages"
                        @finish="submit">
                        <a-form-item label="Salary Type" name="salary_type" :rules="[{ required: true }]">
                            <a-select placeholder="Select Salary Type" v-model:value="formState.salary_type"
                                @change="calcCTC()">
                                <a-select-option value="Month">Per Month</a-select-option>
                                <a-select-option value="Day">Per Day</a-select-option>
                                <a-select-option value="Hour">Per Hour</a-select-option>
                            </a-select>
                        </a-form-item>
                        <a-form-item label="Salary Amount" v-if="formState.salary_type == 'Day'" name="salary_amount"
                            :rules="[{ required: true }]">
                            <a-input-number prefix="₹" addon-after="/ Day" :style="{ width: '100%' }"
                                v-model:value="formState.salary_amount" @keyup="calcCTC()" />
                        </a-form-item>
                        <a-form-item label="Salary Amount" v-if="formState.salary_type == 'Hour'" name="salary_amount"
                            :rules="[{ required: true }]">
                            <a-input-number prefix="₹" addon-after="/ Hour" :style="{ width: '100%' }"
                                v-model:value="formState.salary_amount" @keyup="calcCTC()" />
                        </a-form-item>
                        <div v-if="formState.salary_type == 'Month'">
                            <a-form-item label="Basic" name="salary_amount" :rules="[{ required: true }]">
                                <a-input-number prefix="₹" :style="{ width: '100%' }"
                                    v-model:value="formState.salary_amount" @keyup="calcCTC()" />
                            </a-form-item>
                            <a-form-item v-for="(allowance, index) in formState.allowances" :label="index" :name="index">
                                <a-row type="flex">
                                    <a-col flex="auto"> <a-input-number prefix="₹" :style="{ width: '100%' }"
                                            v-model:value="formState.allowances[index]" @keyup="calcCTC()" /></a-col>
                                    <a-col flex="80px" style="text-align:right"><a
                                            @click="removeAllowance(index)">Remove</a></a-col>
                                </a-row>

                            </a-form-item>
                            <a-form-item :wrapper-col="{ span: 12, offset: 6 }">
                                <a-dropdown :trigger="['click']">
                                    <a class="ant-dropdown-link" @click.prevent>
                                        + Add Allowance
                                        <DownOutlined />
                                    </a>
                                    <template #overlay>
                                        <a-menu>
                                            <a-menu-item key="0" v-if="!('HRA' in formState.allowances)">
                                                <a @click="addAllowances('HRA')">HRA</a>
                                            </a-menu-item>
                                            <a-menu-item key="1" v-if="!('Dearness Allowance' in formState.allowances)">
                                                <a @click="addAllowances('Dearness Allowance')">Dearness Allowance</a>
                                            </a-menu-item>
                                            <a-menu-item key="2" v-if="!('Travel Allowance' in formState.allowances)">
                                                <a @click="addAllowances('Travel Allowance')">Travel Allowance</a>
                                            </a-menu-item>
                                            <a-menu-item key="3" v-if="!('Meal Allowance' in formState.allowances)">
                                                <a @click="addAllowances('Meal Allowance')">Meal Allowance</a>
                                            </a-menu-item>
                                            <a-menu-item key="4" v-if="!('Medical Allowance' in formState.allowances)">
                                                <a @click="addAllowances('Medical Allowance')">Medical Allowance</a>
                                            </a-menu-item>
                                            <a-menu-item key="5" v-if="!('Special Allowance' in formState.allowances)">
                                                <a @click="addAllowances('Special Allowance')">Special Allowance</a>
                                            </a-menu-item>
                                        </a-menu>
                                    </template>
                                </a-dropdown>
                            </a-form-item>
                            <a-form-item label="Employee PF" name="pf_detail">
                                <a-row type="flex">
                                    <a-col flex="auto">
                                        <a-select placeholder="Select Salary Type" @change="calcCTC()"
                                            v-model:value="formState.pf_detail" style="width:100%">
                                            <a-select-option value="0">None</a-select-option>
                                            <a-select-option value="1">1800 Limit</a-select-option>
                                            <a-select-option value="2">12%</a-select-option>
                                        </a-select>
                                    </a-col>
                                    <a-col flex="80px" style="text-align:right">
                                        <span>₹ {{ this.formState.pf_amount }}</span>
                                    </a-col>
                                </a-row>
                            </a-form-item>
                            <a-form-item label="Employee ESI" name="esi_detail">
                                <a-row type="flex">
                                    <a-col flex="auto">
                                        <a-select placeholder="Select Salary Type" @change="calcCTC()"
                                            v-model:value="formState.esi_detail" style="width:100%">
                                            <a-select-option value="0">None</a-select-option>
                                            <a-select-option value="1">0.75%</a-select-option>
                                        </a-select>
                                    </a-col>
                                    <a-col flex="80px" style="text-align:right">
                                        <span>₹ {{ this.formState.esi_amount }}</span>
                                    </a-col>
                                </a-row>
                            </a-form-item>
                        </div>
                        <a-form-item :wrapper-col="{ span: 12, offset: 6 }">
                            <a-button type="primary" html-type="submit">Save</a-button>
                        </a-form-item>
                    </a-form>
                </a-col>
            </a-row>
        </a-layout-content>
        <a-drawer :width="600" title="OT Settings" placement="right" :closable="true" :visible="otdrawer_visible"
            @close="otdrawer_visible = false">
            <a-form :model="OtformState" v-bind="layout" name="nest-messages" :validate-messages="validateMessages"
                @finish="OTsubmit">
                <a-form-item label="Week off Pay" :labelCol="{ span: 8 }" name="weekoff_pay" :rules="[{ required: true }]">
                    <a-input v-model:value="OtformState.weekoff_pay" prefix="₹" />
                </a-form-item>
                <a-form-item label="Public Holiday Pay" :labelCol="{ span: 8 }" name="publicholiday_pay"
                    :rules="[{ required: true }]">
                    <a-input v-model:value="OtformState.publicholiday_pay" prefix="₹" />
                </a-form-item>
                <a-form-item label="Extra Hours Pay" :labelCol="{ span: 8 }" name="extra_hours_pay"
                    :rules="[{ required: true }]">
                    <a-input v-model:value="OtformState.extra_hours_pay" prefix="₹" />
                </a-form-item>
                <a-form-item label="Grace Period" name="grace_period" :rules="[{ required: true }]">
                    <a-input v-model:value="OtformState.grace_period" addon-after="Minutes" />
                </a-form-item>
                <a-form-item :wrapper-col="{ span: 12, offset: 6 }">
                    <a-button type="primary" html-type="submit">Save</a-button>
                </a-form-item>s
            </a-form>

        </a-drawer>
        <a-drawer :width="600" title="Late Penalty Settings" placement="right" :closable="true" :visible="latedrawer_visible"
            @close="latedrawer_visible = false">
            <a-form :model="LateformState" v-bind="layout" name="nest-messages" :validate-messages="validateMessages"
                @finish="lateSubmit">
                <a-form-item label="Allowed Days" :labelCol="{ span: 8 }" name="allowed_days" :rules="[{ required: true }]">
                    <a-input-number v-model:value="LateformState.allowed_days"  />
                </a-form-item>
                <a-form-item label="Grace Period" name="grace_period" :rules="[{ required: true }]">
                    <a-input v-model:value="LateformState.grace_period" addon-after="Minutes" />
                </a-form-item>
                <a-form-item label="Deduction Type" name="deduction_type" :rules="[{ required: true }]">
                <a-radio-group v-model:value="LateformState.deduction_type" name="deduction_type">
                    <a-radio value="Day">Day</a-radio>
                    <a-radio value="Hour">Hour</a-radio>
                </a-radio-group>
                </a-form-item>
                <a-form-item label="Deductin Rate" :labelCol="{ span: 8 }" name="deduction_rate"
                    :rules="[{ required: true }]">
                    <a-input-number v-model:value="LateformState.deduction_rate" prefix="₹" />
                </a-form-item>
                <a-form-item :wrapper-col="{ span: 12, offset: 6 }">
                    <a-button type="primary" html-type="submit">Save</a-button>
                </a-form-item>s
            </a-form>

        </a-drawer>
    </AuthenticatedLayout>
</template>
<script>
import { reactive, inject } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm, router } from '@inertiajs/vue3';

export default ({
    inject: ['validateMessages'],
    components: {
        AuthenticatedLayout,
        Head
    },
    props: {
        employee: Object,
        errors: Object,
    },
    setup(props) {
        const layout = {
            labelCol: { span: 8 },
            wrapperCol: { span: 16 },
        };

        const formState = useForm({
            salary_type: (props.employee.salarydetail != null) ? props.employee.salarydetail.salary_type : 'Month',
            salary_amount: (props.employee.salarydetail != null) ? props.employee.salarydetail.salary_amount : '',
            allowances: (props.employee.salarydetail != null) ? props.employee.salarydetail.allowances : {},
            pf_detail: (props.employee.salarydetail != null) ? props.employee.salarydetail.pf_detail : '',
            esi_detail: (props.employee.salarydetail != null) ? props.employee.salarydetail.esi_detail : '',
            pf_amount: (props.employee.salarydetail != null) ? props.employee.salarydetail.pf_amount : '',
            esi_amount: (props.employee.salarydetail != null) ? props.employee.salarydetail.esi_amount : '',
            ctc: (props.employee.salarydetail != null) ? props.employee.salarydetail.ctc : '',
        });
        const OtformState = useForm({
            weekoff_pay: (props.employee.otsettings != null) ? props.employee.otsettings.weekoff_pay : '0',
            publicholiday_pay: (props.employee.otsettings != null) ? props.employee.otsettings.publicholiday_pay : '0',
            extra_hours_pay: (props.employee.otsettings != null) ? props.employee.otsettings.extra_hours_pay : '0',
            grace_period: (props.employee.otsettings != null) ? props.employee.otsettings.grace_period : '',
        });
        const LateformState = useForm({
            allowed_days: (props.employee.latepenalty_setting != null) ? props.employee.latepenalty_setting.allowed_days : '',
            grace_period: (props.employee.latepenalty_setting != null) ? props.employee.latepenalty_setting.grace_period : '',
            deduction_type: (props.employee.latepenalty_setting != null) ? props.employee.latepenalty_setting.deduction_type : '',
            deduction_rate: (props.employee.latepenalty_setting != null) ? props.employee.latepenalty_setting.deduction_rate : '',
        });
        return {
            formState,
            OtformState,
            LateformState,
            layout,
        };
    },
    data() {
        return {
            otdrawer_visible: false,
            latedrawer_visible: false
        }
    },
    methods: {
        addAllowances(label) {
            this.formState.allowances[label] = '';
        },
        removeAllowance(label) {
            delete this.formState.allowances[label];
        },
        submit() {
            this.formState.post(route("employees.update_salary_info", this.employee.id));
        },
        calcCTC() {
            if (this.formState.salary_type == 'Day' || this.formState.salary_type == 'Hour') {
                this.formState.ctc = this.formState.salary_amount;
            } else {
                var ctc = 0;
                var pf_amount = 0;
                var esi_amount = 0;
                ctc += parseInt(this.formState.salary_amount);
                var allowances_sum = Object.values(this.formState.allowances).reduce((a, b) => (b == '') ? a : parseInt(a) + parseInt(b), 0);
                ctc += parseInt(allowances_sum);
                if (this.formState.pf_detail == '2') {
                    pf_amount = (this.formState.salary_amount) * (12 / 100);
                } else if (this.formState.pf_detail == '1') {
                    pf_amount = (this.formState.salary_amount) * (12 / 100);
                    pf_amount = (pf_amount <= 1800) ? pf_amount : 1800;
                }
                ctc -= parseInt(pf_amount);
                if (this.formState.esi_detail == '1') {
                    esi_amount = (this.formState.salary_amount) * (0.75 / 100);
                }
                ctc -= parseInt(esi_amount);
                this.formState.pf_amount = Math.round(pf_amount);
                this.formState.esi_amount = Math.round(esi_amount);
                this.formState.ctc = Math.round(ctc);
            }
        },
        OTsubmit() {
            router.post(route("employees.update_ot_info", this.employee.id), this.OtformState, {
                onSuccess: page => { },
                onError: errors => { },
                onFinish: visit => {
                    this.otdrawer_visible = false;
                },
            })
        },
        lateSubmit() {
            router.post(route("employees.update_latepenalty_info", this.employee.id), this.LateformState, {
                onSuccess: page => { },
                onError: errors => { },
                onFinish: visit => {
                    this.latedrawer_visible = false;
                },
            })
        },
    }
});
</script>