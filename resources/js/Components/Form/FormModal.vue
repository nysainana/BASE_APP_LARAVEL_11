<script setup>

import {computed} from "vue";

const props = defineProps({
    loading: {
        type: Boolean,
        default: false
    },
    okText: {
        type: String,
        default: () => 'Enrégistrer'
    },
    show: {
        type: Boolean,
        default: () => true
    },
    size: {
        type: String || Number,
        default: () => "default",
    },
    spinning: {
        type: Boolean,
        default: false,
    },
    disableOk: {
        type: Boolean,
        default: false
    },
    disableCancel: {
        type: Boolean,
        default: false
    },
    hideOk: {
        type: Boolean,
        default: false
    },
    hideCancel: {
        type: Boolean,
        default: false
    }
})

const open = defineModel('open')
const emits = defineEmits(['close', 'submit'])

const getSize = (size) => {
    if(size === "default") return "520px";
    if(size === "lg") return "800px";
    if(size === "xl") return "1140px";
    if(size === "2xl") return "1400px";
    if(size === "3xl") return "1800px";
    if(size === "full") return "100%";
    return size;
}

const okButtonProps = computed(() => {
    return {
        disabled: props.disableOk || props.spinning,
        style: props.hideOk ? { display: 'none' } : {}
    }
})

const cancelButtonProps = computed(() => {
    return {
        disabled: props.disableCancel || props.loading || props.spinning,
        style: props.hideCancel ? { display: 'none' } : {}
    }
})

</script>

<template>
    <a-modal
        v-model:open="open"
        @close="emits('close')"
        class="main-modal"
        @cancel="emits('close')"
        @ok="emits('submit')"
        :ok-text="okText"
        cancel-text="Fermer"
        :confirm-loading="loading"
        :mask-closable="false"
        :closable="!loading && !spinning"
        :cancel-button-props="cancelButtonProps"
        :ok-button-props="okButtonProps"
        :width="getSize(size)"
        centered
    >
        <a-spin :spinning="spinning">
            <a-alert type="warning" class="border-none my-7 py-3">
                <template #message>
                    Les champs marqués par <b class="text-red-600">*</b> sont obligatoires.
                </template>
            </a-alert>

            <a-form layout="vertical">
                <slot />
            </a-form>
        </a-spin>
    </a-modal>
</template>

<style>

</style>
