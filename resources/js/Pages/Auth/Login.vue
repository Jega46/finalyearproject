<script setup>
import Checkbox from '@/Components/Checkbox.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

defineProps({
    canResetPassword: Boolean,
    status: String,
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <GuestLayout>
        <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
            {{ status }}
        </div>
        <a-form :model="form" name="basic" :label-col="{ span: 24 }" autocomplete="off" @finish="submit"
            @finishFailed="onFinishFailed">
            <a-form-item label="Email" name="email">
                <a-input v-model:value="form.email" />
                <InputError class="mt-2" :message="form.errors.email" />
            </a-form-item>
            <a-form-item label="Password" name="password">
                <a-input-password v-model:value="form.password" />
            </a-form-item>
            <Link v-if="canResetPassword" :href="route('password.request')" style="margin: 15px 0;display: block;"
                class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            Forgot your password?
            </Link>
            <a-form-item>
                <a-button type="primary" html-type="submit" :size="'large'" :disabled="form.processing" block>Submit</a-button>
            </a-form-item>
        </a-form>
    </GuestLayout>
</template>
