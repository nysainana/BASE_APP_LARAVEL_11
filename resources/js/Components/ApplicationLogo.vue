<script setup>
import { usePage } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

const props = defineProps({
    class: String,
})

const societe = usePage().props.societe;
const classes = computed(() => `${props.class} object-contain`);

const logoUrl = computed(() => societe?.logo || '/logo.png');

const fallbackToDefault = (event) => {
    event.target.src = '/logo.png';
};

</script>

<template>
    <img :src="logoUrl" alt="Logo" :class="classes" @error="fallbackToDefault" />
</template>
