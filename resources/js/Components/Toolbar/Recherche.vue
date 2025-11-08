<script setup>
const value = defineModel("value")
const emit = defineEmits(["onSearch"])
</script>

<template>
    <div class="h-full w-full flex flex-nowrap recherche">
        <a-input
            @pressEnter="emit('onSearch')"
            v-model:value="value"
            placeholder="Rechercher"
            size="large"
            :bordered="false"
            class="h-full w-full group/recherche"
            allow-clear
        >
            <template #prefix>
                <font-awesome-icon
                    class="mx-3 text-text-primary/70 group-focus-within/recherche:text-primary transition-all duration-300"
                    icon="fa-solid fa-search"
                />
            </template>

            <template #clearIcon>
                <font-awesome-icon class="text-lg mx-2" icon="fa-solid fa-xmark"/>
            </template>
        </a-input>
    </div>
</template>

<style>
    .recherche .ant-input-clear-icon {
        @apply flex items-center;
    }
</style>
