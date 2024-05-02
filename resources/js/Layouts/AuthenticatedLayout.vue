<script setup>
import { ref } from 'vue';
import { Link } from '@inertiajs/vue3';
import FlashMessage from "@/Components/FlashMessage.vue";
import {
   UserOutlined,
   VideoCameraOutlined,
   UploadOutlined,
   MenuUnfoldOutlined,
   MenuFoldOutlined,
   AppstoreOutlined,
   LineChartOutlined,
   PieChartOutlined,
   DollarCircleOutlined,
   BoxPlotOutlined,
   SlidersOutlined
} from '@ant-design/icons-vue';

const showingNavigationDropdown = ref(false);
const collapsed = ref(false);

</script>
<template>
   <FlashMessage></FlashMessage>
   <a-layout>
      <a-layout-sider v-model:collapsed="collapsed" :trigger="null" collapsible
         :style="{ overflow: 'auto', height: '100vh', position: 'fixed', left: 0, top: 0, bottom: 0 }">
         <div class="logo">
            <img :src="'/images/logo-2.png'" class="logo1" />
            <img :src="'/images/icon mozitz-min 2.png'" class="collapsed-logo" />
         </div>
         <a-menu v-model:selectedKeys="selectedKeys" theme="dark" mode="inline">
            <Link :href="route('dashboard')">
            <a-menu-item key="dashboard">
               <line-chart-outlined />
               <span>Dashboard</span>
            </a-menu-item>
            </Link>
            <a-sub-menu key="sub5">
               <template #title>
                  <span>
                     <AppstoreOutlined />
                     <span>Items</span>
                  </span>
               </template>
               <Link :href="route('products.index')">
               <a-menu-item key="products">Goods</a-menu-item>
               </Link>
               <Link :href="route('services.index')">
               <a-menu-item key="services">Services</a-menu-item>
               </Link>
               <a-menu-item key="3">Inventory</a-menu-item>
            </a-sub-menu>
            <a-sub-menu key="sales">
               <template #title>
                  <span>
                     <SlidersOutlined />
                     <span>Sales</span>
                  </span>
               </template>
               <Link :href="route('customers.index')">
               <a-menu-item key="4">Customers</a-menu-item>
               </Link>
               <Link :href="route('quotes.index')">
               <a-menu-item key="5">Quotes</a-menu-item>
               </Link>
               <Link :href="route('invoices.index')">
               <a-menu-item key="6">Invoices</a-menu-item>
               </Link>
               <Link :href="route('payments.index')">
               <a-menu-item key="7">Payments</a-menu-item>
               </Link>
               <Link :href="route('creditnotes.index')">
               <a-menu-item key="creditnotes">Credit Notes</a-menu-item>
               </Link>
            </a-sub-menu>
            <a-sub-menu key="sub2">
               <template #title>
                  <span>
                     <BoxPlotOutlined />
                     <span>Purchase</span>
                  </span>
               </template>
               <Link :href="route('vendors.index')">
               <a-menu-item key="1">Vendors</a-menu-item>
               </Link>
               <Link :href="route('purchaseorders.index')">
               <a-menu-item key="purchaseorders3">Purchase Orders</a-menu-item>
               </Link>
               <Link :href="route('bills.index')">
               <a-menu-item key="3">Bills</a-menu-item>
               </Link>
               <Link :href="route('payments.index')">
               <a-menu-item key="payments3">Payments</a-menu-item>
               </Link>
               <Link :href="route('creditnotes.index')">
               <a-menu-item key="creditnotes3">Vendor Credits</a-menu-item>
               </Link>
            </a-sub-menu>
            <a-sub-menu key="Production">
               <template #title>
                  <span>
                     <BoxPlotOutlined />
                     <span>Production</span>
                  </span>
               </template>
               <Link :href="route('rawmaterials.index')">
               <a-menu-item key="rawmaterials">Raw materials</a-menu-item>
               </Link>
               <Link :href="route('joborders.index')">
               <a-menu-item key="joborders">Job Orders</a-menu-item>
               </Link>
               <Link :href="route('billofmaterials.index')">
               <a-menu-item key="rawmaterials">Bill of materials</a-menu-item>
               </Link>
            </a-sub-menu>
            <a-menu-item key="sub3">
               <DollarCircleOutlined />
               <span>Expenses</span>
            </a-menu-item>
            <a-menu-item key="sub4">
               <PieChartOutlined />
               <span>Reports</span>
            </a-menu-item>
         </a-menu>
      </a-layout-sider>
      <a-layout v-model:collapsed="collapsed" :style="{ marginLeft: '200px' }">
         <a-layout-header>
            <a-row type="flex">
               <a-col flex="100px"><menu-unfold-outlined v-if="collapsed" class="trigger"
                     @click="() => (collapsed = !collapsed)" />
                  <menu-fold-outlined v-else class="trigger" @click="() => (collapsed = !collapsed)" />
               </a-col>
               <a-col flex="auto">
                  <a-menu v-model:selectedKeys="selectedKeys" mode="horizontal">
                     <a-menu-item key="profile">Profile</a-menu-item>
                     <a-menu-item key="logout">Logout</a-menu-item>
                  </a-menu>
               </a-col>
            </a-row>
         </a-layout-header>
         <slot />
      </a-layout>
   </a-layout>
</template>
