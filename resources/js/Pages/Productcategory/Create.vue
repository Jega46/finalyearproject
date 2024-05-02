
<template>

    <Head title="Branches" />
    <AuthenticatedLayout>
        <a-affix :offset-top="0">
            <a-page-header :ghost="false" title="Add Branch" @back="() => $inertia.visit(route('branches.index'))">
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
                        <h3 :wrapper-col="{ span: 12, offset: 6 }">
                            Basic
                        </h3>
                        <a-form-item label="Branch Name" name="branch_name" :rules="[{ required: true }]">
                            <a-input v-model:value="formState.branch_name" />
                        </a-form-item>
                        <a-form-item label="Branch Address" name="address" :rules="[{ required: true }]">
                            <a-input v-model:value="formState.address" />
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
    setup() {
        const layout = {
            labelCol: { span: 8 },
            wrapperCol: { span: 16 },
        };
        const formState = useForm({
            branch_name: '',
            address: '',
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
            this.formState.post(route("branches.store"));
        },
    },
});
</script>