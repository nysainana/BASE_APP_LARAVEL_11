<script setup>

defineProps({
    value: {
        type: String,
        default: () => ""
    },
    status: {
        type: Array,
        default: () => []
    },
})

const statusColors = {
    EN_ATTENTE: "",
    PARTIELEMENT: "blue",
    TERMINER: "green"
};

</script>

<template>
    <a-tag :color="statusColors[value]" :bordered="false">
        {{ status.find(d => d.value === value)?.label ?? '-' }}
    </a-tag>
</template>
