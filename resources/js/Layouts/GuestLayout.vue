<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <a-layout>
        <a-row type="flex" justify="space-around" align="middle" style="height:100vh">
            <a-col :span="6">
                <div class="auth-box">
                    <Link href="/">
                    <ApplicationLogo class="w-20 h-20 fill-current text-gray-500" />
                    </Link>
                    <slot />
                </div>
            </a-col>
        </a-row>
    </a-layout>
</template>
