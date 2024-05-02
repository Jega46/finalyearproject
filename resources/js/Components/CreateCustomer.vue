<template>
    <a-form v-bind="layout" name="nest-messages" :label-col="{ span: 24 }" :model="form" @finish="submit">
        <a-row :gutter="24">
            <a-col class="gutter-row" :span="12">
                <a-form-item label="Customer Name" name="name" :rules="[{ required: true }]">
                    <a-input placeholder="Customer Name" v-model:value="form.name" />
                    <InputError class="mt-2" v-if="form.errors && form.errors.name" :message="form.errors.name" />
                </a-form-item>
            </a-col>
            <a-col class="gutter-row" :span="12">
                <a-form-item label="Mobile Number" name="mobile" :rules="{ required: true }">
                    <a-input placeholder="Mobile Number" v-model:value="form.mobile" />
                    <InputError class="mt-2" v-if="form.errors && form.errors.mobile" :message="form.errors.mobile" />
                </a-form-item>
            </a-col>
            <a-col class="gutter-row" :span="12">
                <a-form-item label="Email" name="email" :rules="{ required: true }">
                    <a-input placeholder="Email" v-model:value="form.email" />
                    <InputError class="mt-2" v-if="form.errors && form.errors.email" :message="form.errors.email" />
                </a-form-item>
            </a-col>
            <a-col class="gutter-row" :span="12">
                <a-form-item label="Company Name" name="company_name">
                    <a-input placeholder="Company Name" v-model:value="form.company_name" />
                </a-form-item>
            </a-col>
            <a-col class="gutter-row" :span="12">
                <a-form-item label="GSTIN" name="gstin">
                    <a-input placeholder="GSTIN" v-model:value="form.gstin" />
                </a-form-item>
            </a-col>
        </a-row>
        <h4 class="t1">Billing Address</h4>
        <a-row :gutter="24">
            <a-col class="gutter-row" :span="12">
                <a-form-item label="Address" name="billing_address">
                    <a-input placeholder="Address" v-model:value="form.billing_address" />
                </a-form-item>
            </a-col>
            <a-col class="gutter-row" :span="12">
                <a-form-item label="City" name="billing_city">
                    <a-input placeholder="City" v-model:value="form.billing_city" />
                </a-form-item>
            </a-col>
            <a-col class="gutter-row" :span="12">
                <a-form-item label="State" name="billing_state">
                    <a-input placeholder="State" v-model:value="form.billing_state" />
                </a-form-item>
            </a-col>
            <a-col class="gutter-row" :span="12">
                <a-form-item label="Pincode" name="billing_pincode">
                    <a-input placeholder="Pincode" v-model:value="form.billing_pincode" />
                </a-form-item>
            </a-col>
            <a-col class="gutter-row" :span="12">
                <a-form-item label="Country" name="billing_country">
                    <a-input placeholder="Country" v-model:value="form.billing_country" />
                </a-form-item>
            </a-col>
        </a-row>
        <h4 class="t1">Shipping Address</h4>
        <a-row :gutter="24">
            <a-col class="gutter-row" :span="12">
                <a-form-item label="Address" name="shipping_address">
                    <a-input placeholder="Address" v-model:value="form.shipping_address" />
                </a-form-item>
            </a-col>
            <a-col class="gutter-row" :span="12">
                <a-form-item label="City" name="shipping_city">
                    <a-input placeholder="City" v-model:value="form.shipping_city" />
                </a-form-item>
            </a-col>
            <a-col class="gutter-row" :span="12">
                <a-form-item label="State" name="shipping_state">
                    <a-input placeholder="State" v-model:value="form.shipping_state" />
                </a-form-item>
            </a-col>
            <a-col class="gutter-row" :span="12">
                <a-form-item label="Pincode" name="shipping_pincode">
                    <a-input placeholder="Pincode" v-model:value="form.shipping_pincode" />
                </a-form-item>
            </a-col>
            <a-col class="gutter-row" :span="12">
                <a-form-item label="Country" name="shipping_country">
                    <a-input placeholder="Country" v-model:value="form.shipping_country" />
                </a-form-item>
            </a-col>
        </a-row>
        <a-form-item :wrapper-col="{ span: 12 }">
            <a-button type="primary" html-type="submit">SUBMIT</a-button>
        </a-form-item>
    </a-form>
</template>


<script>
import { Head, Link, useForm } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';

export default ({
    components: { Head, Link, InputError },
    props: {
        errors: Object,
        customer: Object
    },
    data(props) {
        const loading = false;
        const layout = {
            labelCol: { span: 8 },
            wrapperCol: { span: 24 },
        };
        const form = useForm({
            name: (props.customer && props.customer.name) ?? '',
            mobile: (props.customer && props.customer.mobile) ?? '',
            email: (props.customer && props.customer.email) ?? '',
            company_name: (props.customer && props.customer.company_name) ?? '',
            gstin: (props.customer && props.customer.gstin) ?? '',
            billing_address: (props.customer && props.customer.billing_address) ?? '',
            billing_city: (props.customer && props.customer.billing_city) ?? '',
            billing_state: (props.customer && props.customer.billing_state) ?? '',
            billing_pincode: (props.customer && props.customer.billing_pincode) ?? '',
            billing_country: (props.customer && props.customer.billing_country) ?? '',
            shipping_address: (props.customer && props.customer.shipping_address) ?? '',
            shipping_city: (props.customer && props.customer.shipping_city) ?? '',
            shipping_state: (props.customer && props.customer.shipping_state) ?? '',
            shipping_pincode: (props.customer && props.customer.shipping_pincode) ?? '',
            shipping_country: (props.customer && props.customer.shipping_country) ?? '',
        });
        return {
            showDrawer: false,
            form,
            layout,
            loading
        };
    },
    methods: {
        reset() {
            this.form.reset();
            this.$emit('reset');
        },
        submit() {
            if (this.customer && this.customer.id) {
                this.$inertia.put(this.route('customers.update', this.customer.id), this.form, {
                    onSuccess: () => {
                        this.reset();
                        this.$emit('hide-drawer', true);
                    },
                });
            } else {
                this.form.post(route('customers.store'), {
                    onSuccess: () => {
                        this.reset();
                        this.$emit('hide-drawer', true);
                    },
                });
            }
        }
    }
});
</script>