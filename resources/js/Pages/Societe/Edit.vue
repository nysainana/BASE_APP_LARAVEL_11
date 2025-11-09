<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {defineProps} from "vue";
import UpdateSocieteInfo from "@/Pages/Societe/Partials/UpdateSocieteInfo.vue";

const props = defineProps({
    societe: {
        type: Object,
        default: {}
    }
})

</script>

<template>
    <AuthenticatedLayout page-key="societe.edit">
        <div class="flex flex-col gap-6 max-w-5xl mx-auto mt-20">
            <UpdateSocieteInfo :societe="societe" />
        </div>
    </AuthenticatedLayout>
</template>
