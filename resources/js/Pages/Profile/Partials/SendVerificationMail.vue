<template>
    <a-card class="main-card" title="Vérifiez votre email">

        <a-card-meta description="Votre adresse e-mail n'est pas vérifiée."/>

        <Link :href="route('verification.send')">
            <a-button class="btn-secondary mt-3">
                Renvoyer l'e-mail de vérification.
            </a-button>
        </Link>
    </a-card>
</template>

<script setup>
import {Link} from '@inertiajs/vue3';

</script>

<style scoped>

</style>
