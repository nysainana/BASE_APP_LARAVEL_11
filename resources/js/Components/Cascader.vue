<script setup>
import {onMounted, ref, watch} from "vue";

const props = defineProps({
    options: {
        type: Array,
        default: () => []
    }
})

const _value = ref([])
const value = defineModel("value")
const emit = defineEmits(['change'])

const handleChange = (val) => {
    value.value = val && val.length > 0 ? val[val.length - 1] : null
    emit('change', value.value)
}

function findParents(tree, targetValue, parents = []) {
    for (const node of tree) {
        if (node.children && node.children.length > 0) {
            const result = findParents(node.children, targetValue, [...parents, node.value]);
            if (result) return result;
        }

        if (node.value === targetValue && (!node.children || node.children.length === 0)) {
            return [...parents, node.value];
        }
    }

    return null;
}

watch(() => value.value, (newVal) => {
    _value.value = findParents(props.options, newVal) || [];
}, { immediate: true })

onMounted(() => {
    _value.value = findParents(props.options, value.value) || [];
})
</script>

<template>
    <a-cascader
        class="cascader"
        :options="options"
        v-model:value="_value"
        option-filter-prop="label"
        size="large"
        allow-clear
        show-search
        @change="handleChange"
    >
        <template #expandIcon>
            <span class="flex items-center justify-items-center ms-2">
                <font-awesome-icon class="!text-[15px]" icon="angle-right" />
            </span>
        </template>

        <template #displayRender="{ labels, selectedOptions }">
          <span v-for="(label, index) in labels" :key="selectedOptions[index]?.value">
            {{ label }}
            <font-awesome-icon class="mx-2" icon="angle-right" v-if="index !== labels.length - 1"/>
          </span>
        </template>
    </a-cascader>
</template>

<style>
.cascader .ant-select-selection-item {
    padding-inline-end: 30px !important;
}

.ant-cascader-menu {
    height: 256px !important;
}
</style>
