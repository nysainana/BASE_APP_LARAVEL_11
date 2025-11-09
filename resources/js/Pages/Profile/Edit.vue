<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue';
import LogoutForm from "./Partials/LogoutForm.vue";

defineProps({
    mustVerifyEmail: Boolean,
    status: String,
});

</script>

<template>
    <AuthenticatedLayout page-key="profile.edit">
        <div class="flex flex-col gap-6 max-w-5xl mx-auto mt-20">
            <UpdateProfileInformationForm />
            <UpdatePasswordForm />
            <LogoutForm />
        </div>
    </AuthenticatedLayout>
</template>
