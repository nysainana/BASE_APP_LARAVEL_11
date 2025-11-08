<script setup>
import {defineProps, ref} from 'vue';
import {Link} from '@inertiajs/vue3';
import Layout from "@/Layouts/Layout.vue";
import SideBar from "@/Layouts/Partials/SideBar.vue";

const sidebarCollapsed = ref(false);
const breadcrumb = ref([]);

const props = defineProps({
    title: String,
    icon: {
        type: String,
        default: () => "fa-solid fa-circle",
    },
    selectedMenu: {
        type: String,
        default: () => ''
    },
})

</script>

<template>
    <Layout :title="title">
        <a-layout
            id="content"
            class="min-h-screen bg-dots-darker bg-gray-100 bg-fixed"
        >

            <side-bar
                :selected-menu="selectedMenu"
                v-model:collapsed="sidebarCollapsed"
                @update:breadcrumb="(items) => breadcrumb = items"
            />

            <a-layout :class="{'lg:ml-[260px]': !sidebarCollapsed}">
                <a-layout-content class="flex">
                    <div class="flex flex-col mx-auto w-full py-3 px-2 lg:px-9"> <!-- max-w-screen-2xl -->

                        <div class="flex gap-3 items-center py-4 flex-col sm:flex-row sm:justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 flex-shrink-0 main-rounded flex items-center justify-center bg-primary/10">
                                    <font-awesome-icon :icon="icon" class="w-5 h-5 text-primary" />
                                </div>
                                <div class="flex flex-col">
                                    <h1 class="text-lg font-semibold">{{ title }}</h1>
                                    <a-breadcrumb v-if="breadcrumb.length > 0">
                                        <a-breadcrumb-item v-for="(item, index) in breadcrumb" :key="item.key" class="!text-gray-400 !text-xs">
                                            <span v-if="index === breadcrumb.length - 1 || !item.routeName">{{ item.label }}</span>
                                            <Link v-else :href="route(item.routeName)">{{ item.label }}</Link>
                                        </a-breadcrumb-item>
                                    </a-breadcrumb>
                                </div>
                            </div>

                            <div class="action-container flex gap-3 flex-col sm:flex-row w-full sm:w-auto">
                                <slot name="actions"></slot>
                            </div>
                        </div>

                        <div class="bg-gray-100 mt-4 flex-1">
                            <slot></slot>
                        </div>

                    </div>
                </a-layout-content>
            </a-layout>
        </a-layout>
    </Layout>
</template>

<style>

.action-container > * {
    @apply w-full sm:w-auto;
}

</style>
