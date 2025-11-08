<script setup>
const props = defineProps({
    title: String,
})

</script>

<template>
    <div class="space-y-2">
        <h5 class="text-text-primary/75" v-if="title">{{ title }}</h5>

        <slot />
    </div>
</template>
