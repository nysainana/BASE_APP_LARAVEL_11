<script setup>
defineProps({
    title: String
})
</script>

<template>
    <a-divider
        orientation="left"
        :orientation-margin="0"
        class="!font-semibold !my-6"
    >
        {{ title }}
    </a-divider>
</template>
