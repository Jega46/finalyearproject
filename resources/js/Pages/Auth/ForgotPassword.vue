<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

defineProps({
    status: String,
});

const form = useForm({
    email: '',
});

const submit = () => {
    form.post(route('password.email'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Forgot Password" />
        <div class="mb-4 text-sm text-gray-600">
            Forgot your password? No problem. Just let us know your email address and we will email you a password reset
            link that will allow you to choose a new one.
        </div>
        <br />
        <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
            {{ status }}
            <br />
        </div>
        <a-form :model="form" name="basic" :label-col="{ span: 24 }" autocomplete="off" @finish="submit"
            @finishFailed="onFinishFailed">
            <a-form-item label="Email" name="email">
                <a-input v-model:value="form.email" />
                <InputError class="mt-2" :message="form.errors.email" />
            </a-form-item>
            <Link :href="route('login')" style="margin: 15px 0;display: block;">
            <u>Back to login</u>
            </Link>
            <a-form-item>
                <a-button type="primary" html-type="submit" :size="'large'" :disabled="form.processing"
                    block>Submit</a-button>
            </a-form-item>
        </a-form>
    </GuestLayout>
</template>
