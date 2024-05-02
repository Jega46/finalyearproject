
<template>

    <Head title="Branches" />
    <AuthenticatedLayout>
        <a-affix :offset-top="0">
            <a-page-header :ghost="false" :title="branch.branch_name" @back="() => $inertia.visit(route('branches.index'))">
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
                        <h3 :wrapper-col="{ span: 12, offset: 6 }">
                            Basic
                        </h3>
                        <a-form-item label="Branch Name" name="branch_name" :rules="[{ required: true }]">
                            <a-input v-model:value="formState.branch_name" />
                        </a-form-item>
                        <a-form-item label="Address" name="address" :rules="[{ required: true }]">
                            <a-input v-model:value="formState.address" />
                        </a-form-item>
                        <a-form-item :wrapper-col="{ span: 12, offset: 6 }">
                            <a-button ref="submitss" type="primary" html-type="submit">Save</a-button>
                        </a-form-item>
                    </a-form>
                </a-col>
            </a-row>
        </a-layout-content>
    </AuthenticatedLayout>
</template>
<script>
import { reactive, inject, ref } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import dayjs, { Dayjs } from 'dayjs';


export default ({
    inject: ['validateMessages'],
    components: {
        AuthenticatedLayout,
        Head,
    },
    props: {
        branch: Object,
        errors: Object,
    },
    setup(props) {

        const layout = {
            labelCol: { span: 8 },
            wrapperCol: { span: 16 },
        };
        const formState = useForm({
            branch_name: props.branch.branch_name,
            address: props.branch.address,
        });
        return {
            formState,
            layout,
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
            this.formState.put(route("branches.update", this.branch.id));
        },
    },
});
</script>