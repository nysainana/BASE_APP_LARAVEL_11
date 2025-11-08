<template>
    <Head :title="title"/>

    <a-config-provider :theme="AntdvTheme">
        <div class="text-text-primary">
            <slot></slot>
        </div>
    </a-config-provider>
</template>

<script setup>
import AntdvTheme from "@/Theme/antdv-theme.js"
import {Head, usePage} from "@inertiajs/vue3";
import {defineProps, onMounted, watch} from "vue";
import {message} from "ant-design-vue";

const props = defineProps({
    title: String
})

const page = usePage();

watch(() => page.props.message, (data) => showMessage(data));

const showMessage = (data) => {
    const duration = 5;

    if (data.success)
        message.success(data.success, duration);

    if (data.error)
        message.error(data.error, duration);
}

onMounted(() => {
    setTimeout(() => showMessage(page.props.message), 1000);
})

</script>
