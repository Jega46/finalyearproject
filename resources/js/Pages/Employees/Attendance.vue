
<template>

    <Head title="Employees" />
    <AuthenticatedLayout>
        <a-affix :offset-top="0">
            <a-page-header :ghost="false" :title="employee.name + ' Attendance'"
                @back="() => $inertia.visit(route('employees.index'))">
            </a-page-header>
        </a-affix>
        <a-layout-content >
            <a-calendar v-model:value="value" @select="onSelect">
                <template #dateCellRender="{ current }">
                    <div v-if="attdata[current.date()]">
                        <a-button :type="attdata[current.date()].type" shape="round" size="sm">
                            {{ attdata[current.date()].status }}
                        </a-button>
                    </div>
                    <div v-else-if="current.date() <= today && current.month() + 1 == month">
                        <a-button type="primary" danger shape="round" size="sm">
                            Absent
                        </a-button>
                    </div>

                </template>
            </a-calendar>
        </a-layout-content>
        <a-drawer title="Update Attendance" placement="right" :closable="true" :visible="drawervisible"
            @close="onClose">
            <a-form :model="formState" v-bind="layout" name="nest-messages" :validate-messages="validateMessages"
                @finish="submit">
                <a-form-item label="Check In" name="checkin">
                    <a-time-picker format="hh:mm A" placeholder="Check In" value-format="HH:mm:ss"
                        v-model:value="formState.checkin" />
                </a-form-item>
                <a-form-item label="Check Out" name="checkout">
                    <a-time-picker format="hh:mm A" placeholder="Check Out" value-format="HH:mm:ss"
                        v-model:value="formState.checkout" />
                </a-form-item>
                <a-form-item label="Notes" name="notes">
                    <a-input v-model:value="formState.notes" style="width: 100%" />
                </a-form-item>
                <a-form-item label="Status" name="notes">
                    <a-select v-model:value="formState.status">
                        <a-select-option value="Present">Present</a-select-option>
                        <a-select-option value="Absent">Absent</a-select-option>
                        <a-select-option value="Paid Leave">Paid Leave</a-select-option>
                        <a-select-option value="Unpaid Leave">Unpaid Leave</a-select-option>
                    </a-select>
                </a-form-item>
                <a-form-item :wrapper-col="{ span: 12, offset: 6 }">
                    <a-button type="primary" html-type="submit">Save</a-button>
                </a-form-item>
            </a-form>
        </a-drawer>
    </AuthenticatedLayout>
</template>
<script>
import { reactive, inject, ref } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { Dayjs } from 'dayjs';

export default ({
    inject: ['validateMessages'],
    components: {
        AuthenticatedLayout,
        Head
    },
    props: {
        employee: Object,
        attdata: Object,
        errors: Object,
        today: String,
        month: String,
    },
    setup(props) {
        const layout = {
            labelCol: { span: 8 },
            wrapperCol: { span: 16 },
        };
        const formState = useForm({
            employee_id: props.employee.id,
            checkin: '',
            checkout: '',
            notes: '',
            status: ''
        });
        return {
            formState,
            layout,
        };
    },
    data() {
        return {
            drawervisible: false,
        };
    },
    methods: {
        onSelect(val) {
            this.formState.date = val.$d;
            if (this.attdata[val.date()]) {
                this.formState.checkin = this.attdata[val.date()].checkin;
                this.formState.checkout = this.attdata[val.date()].checkout;
                this.formState.notes = this.attdata[val.date()].notes;
                this.formState.status = this.attdata[val.date()].status;
            } else {
                this.formState.checkin = '';
                this.formState.checkout = '';
                this.formState.notes = '';
                this.formState.status = 'Absent';
            }
            this.showDrawer();
        },
        showDrawer() {
            this.drawervisible = true;
        },
        onClose() {
            this.drawervisible = false;
        },
        submit() {
            this.formState.post(route("attendance.update"));
        },
    }
});
</script>