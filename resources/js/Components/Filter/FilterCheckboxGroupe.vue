<script setup>

import {onMounted, reactive, ref, watch} from 'vue';

const props = defineProps({
    title: String,
    options: {
        type: Array,
        default: () => []
    },
    allText: {
        type: String,
        default: () => "Tous"
    }
})

const value = defineModel("value");
const selected = ref([]);

const state = reactive({
    indeterminate: false,
    checkAll: false,
});

const onCheckAllChange = e => {
    selected.value = e.target.checked ? props.options.map(d => d.value) : []
    state.indeterminate = false
};

watch(selected, val => setState(val));

const setState = (val) => {
    state.indeterminate = !!val?.length && val?.length < props.options.length;
    state.checkAll = val?.length === props.options.length;
    value.value = state.checkAll ? null : [ 0, ...val];
}

onMounted(() => {
    selected.value = value.value ? (value.value.length === 1 && value.value[0] === 0 ? [] : value.value) : props.options.map(d => d.value);
    setState(selected.value);
})

</script>

<template>
    <div class="space-y-2">
        <h5 class="text-text-primary/75" v-if="title">{{ title }}</h5>

        <div class="ml-3">
            <a-checkbox class="mb-3" v-model:checked="state.checkAll" :indeterminate="state.indeterminate" @change="onCheckAllChange">
                {{ allText }}
            </a-checkbox>
            <a-checkbox-group class="flex flex-col gap-3" v-model:value="selected" :options="options" />
        </div>
    </div>
</template>
