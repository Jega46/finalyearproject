<template>
    <a-tabs v-model:activeKey="activeKey">
        <a-tab-pane key="Overview" tab="Overview">
            <a-descriptions :size="size">
                <a-descriptions-item label="Customer Name" :span="4">John Brown</a-descriptions-item>
                <a-descriptions-item label="Mobile Number">+91 9876543210</a-descriptions-item>
                <a-descriptions-item label="Email ID">mona.azhagesan@gmail.com</a-descriptions-item>
            </a-descriptions>
        </a-tab-pane>
        <a-tab-pane key="Transactions" tab="Transactions" force-render>
            <a-space>
                <a-select ref="select" placeholder="Filter By">
                    <a-select-option value="jack">Invoice</a-select-option>
                    <a-select-option value="lucy">Sales Order</a-select-option>
                    <a-select-option value="disabled">Quote</a-select-option>
                    <a-select-option value="Yiminghe">Purchase Order</a-select-option>
                </a-select>
                <a-select ref="select" placeholder="Status">
                    <a-select-option value="jack">All</a-select-option>
                    <a-select-option value="lucy">Draft</a-select-option>
                </a-select>
            </a-space>
            <a-table :columns="invoicetransactions_column" :data-source="invoicetransactions">
            </a-table>
        </a-tab-pane>
    </a-tabs>
</template>


<script>
export default ({
    components: {},
    props: {
        errors: Object,
        customer: Object
    },
    data() {
    },
    methods: {
    }
});
</script>