<script setup>
import { useForm } from '@inertiajs/vue3';
import {confirm_save} from "@/Utils/confirmation_modal.js";

const form = useForm({});

const logout = () => {
    confirm_save(
        () => form.post(route('logout')),
        'Confirmation de déconnexion',
        'Êtes-vous sûr de vouloir vous déconnecter ?',
        'SE DÉCONNECTER'
    );
};
</script>

<template>
    <a-card class="main-card" title="Déconnexion">
        <a-card-meta
            description="Cliquez sur le bouton ci-dessous pour vous déconnecter de votre session actuelle." />

        <a-button class="mt-3 uppercase" type="primary" @click="logout" :loading="form.processing">
            Se déconnecter
        </a-button>
    </a-card>
</template>
