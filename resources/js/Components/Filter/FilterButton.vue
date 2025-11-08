<script setup>

import ButtonIcon from "@/Components/ButtonIcon.vue";
import {ref} from "vue";
import {FontAwesomeIcon} from "@fortawesome/vue-fontawesome";

const open = ref(false);
const emit = defineEmits(["onOk", "onReset"])

const handleOk = () => {
    open.value = false;
    emit('onOk');
}

const handleReset = () => {
    open.value = false;
    emit('onReset');
}

</script>

<template>
    <a-dropdown class="filter-button" v-model:open="open" placement="bottomRight" :trigger="['click']">
        <ButtonIcon
            text="Filtre"
            icon="fa-filter"
            :class="{'border-gray-200 bg-gray-100 !text-primary transition-all duration-300': open}"
        />

        <template #overlay>
            <a-menu class="w-96 !px-0 !relative group">
                <a-button
                    class="!p-0 rounded-lg !w-6 !h-6 flex justify-center items-center border-0 hover:shadow-none hover:!bg-gray-200 absolute top-2 right-2 cursor-pointer z-50"
                    @click="() => open = false"
                >
                    <font-awesome-icon icon="fa-xmark" class="text-lg text-gray-400" />
                </a-button>

                <perfect-scrollbar class="space-y-4 p-4 w-full" :options="{suppressScrollX: true, suppressScrollY: true}">
                    <slot />
                </perfect-scrollbar>

                <hr class="mb-4 mt-3">
                <div class="flex justify-between px-4 pt-0 pb-3 gap-3 mt-2">
                    <ButtonIcon
                        text="Appliquer"
                        icon="fa-filter"
                        @click="handleOk"
                        class="flex-1"
                        type="primary"
                    />

                    <ButtonIcon
                        text="Restorer"
                        icon="filter-circle-xmark"
                        @click="handleReset"
                        class="flex-1 !border"
                    />
                </div>
            </a-menu>
        </template>
    </a-dropdown>
</template>
