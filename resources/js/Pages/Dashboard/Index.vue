<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import StatCard from "@/Pages/Dashboard/Partials/StatCard.vue";
import WelcomeCard from "@/Pages/Dashboard/Partials/WelcomeCard.vue";
import {can} from "@/Utils/functions.js";
import { usePage } from "@inertiajs/vue3";
import { computed } from "vue";

const page = usePage();
const userName = computed(() => page.props.auth.user.name);

defineProps({
    data: {
        type: Object,
        default: () => {},
    }
})

</script>

<template>
    <AuthenticatedLayout page-key="dashboard">

        <div class="mx-auto pb-8 flex flex-col gap-10">
            <WelcomeCard :user-name="userName" />

            <div
                v-if="can('dashboard.view_user_stat')"
                class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 gap-y-5"
            >
                <StatCard
                    v-if="can('dashboard.view_user_stat')"
                    title="Utilisateurs"
                    :value="data.stats.user?.toLocaleString('FR-fr')"
                    icon="user"
                    color="red"
                />
            </div>

        </div>
    </AuthenticatedLayout>
</template>
