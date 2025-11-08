<script setup>

const props = defineProps({
    title: String,
})

</script>

<template>
    <div class="toolbar-container flex w-full bg-white main-shadow main-rounded">
        <div v-if="title || $slots.left" class="toolbar-container-placement  left">
            <div v-if="title" class="flex items-center px-5">
                <h6>{{ title }}</h6>
            </div>

            <slot name="left"/>
        </div>

        <div class="toolbar-container-placement flex-1 flex justify-end">
            <slot />
        </div>
    </div>
</template>

<style>

.toolbar-container .toolbar-container-placement {
    @apply flex flex-nowrap;
}

.toolbar-container > .toolbar-container-placement > * {
    @apply !rounded-none border-x border-gray-200 h-full border-l-0 last:border-r-0;
}

.toolbar-container .toolbar-container-placement:nth-child(2) > * {
    @apply first:border-l;
}

.toolbar-container > * > .ant-btn {
    @apply !p-5 hover:border-gray-200 hover:bg-gray-100 hover:!text-primary transition-all duration-300;
}

.toolbar-container > * > .ant-btn span {
    @apply hidden sm:block;
}

</style>
