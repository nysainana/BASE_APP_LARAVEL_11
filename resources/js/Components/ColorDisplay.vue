<script setup>
const props = defineProps({
    label: {
        type: String,
        required: true
    },
    color: {
        type: String,
        required: false
    }
})
</script>

<template>
<div class="flex flex-nowrap items-center">
    <span class="inline-block w-4 h-4 rounded-full border border-gray-300" :style="{backgroundColor: color}"></span>
    <span class="ml-2">{{label}}</span>
</div>
</template>