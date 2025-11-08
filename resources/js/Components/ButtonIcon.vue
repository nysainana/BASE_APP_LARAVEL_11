<script setup>

const props = defineProps({
    text: String,
    icon: String,
    color: String,
    loading: {
        type: Boolean,
        default: () => false,
    }
})

</script>

<template>
    <a-button :loading="loading" :title="text" class="border-0 !py-3 flex gap-2 items-center justify-center" :style="color ? {backgroundColor: color} : {}">
        <template #icon>
            <font-awesome-icon class="text-[15px]" v-if="icon && !loading" :icon="icon"/>
        </template>
        <span v-if="text" class="uppercase line-clamp-1" style="line-height: normal;">{{text}}</span>
    </a-button>
</template>
