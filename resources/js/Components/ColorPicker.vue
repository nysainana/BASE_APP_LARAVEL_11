<script setup>

const value = defineModel("value");

</script>

<template>
<div 
    class="main-color-picker flex flex-col gap-4 p-5 main-rounded border border-gray-200"
    :style="{ backgroundColor: value }"
>
    <!-- <div class="flex justify-center">
        <div 
            class="w-full h-20 rounded-lg flex items-center justify-center border-3 border-white relative overflow-hidden"
            :style="{ backgroundColor: value }"
        >
            <div class="absolute inset-0 bg-gradient-to-br from-white/20 via-transparent to-black/10 pointer-events-none"></div>
            <span class="text-base font-semibold shadow-md z-10 px-4 py-1.5 bg-white/90 backdrop-blur-sm rounded-md text-gray-800 border border-black/10 uppercase tracking-wide">
                {{ value }}
            </span>
        </div>
    </div> -->

    <div class="flex justify-center py-3">
        <color-picker 
            v-model:pureColor="value"
            disableAlpha
            isWidget
            useType="pure"
            format="hex"
            shape="circle"
        />
    </div>
</div>
</template>

<style>
    .main-color-picker .vc-colorpicker {
        @apply shadow-none main-rounded;
    }

    .main-color-picker .vc-display {
        @apply h-10;
    }

    .main-color-picker .vc-input-toggle, 
    .main-color-picker .vc-current-color {
        @apply !hidden;
    }

    .main-color-picker .vc-color-input {
        @apply main-rounded border border-gray-300 hover:border-primary;
    }
</style>