
<template>

    <Head title="Branches" />
    <AuthenticatedLayout>
        <a-affix :offset-top="0">
            <a-page-header :ghost="false" title="Add Break" @back="() => $inertia.visit(route('companybreaks.index'))">
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
                        <a-form-item label="Break Title" name="name" :rules="[{ required: true }]">
                            <a-input v-model:value="formState.name" />
                        </a-form-item>
                        <a-form-item label="Break Time" name="minute" :rules="[{ required: true }]">
                            <a-input v-model:value="formState.minute" addon-after="/ Minute" />
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
            name: '',
            minute: '',
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
            this.formState.post(route("companybreaks.store"));
        },
    },
});
</script>