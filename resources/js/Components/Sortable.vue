<script setup>
import {ref} from "vue";
import {Sortable} from "sortablejs-vue3";

const sortOption = ref({
    animation: 300,
    handle: ".draggable",
})

const list = defineModel("list", {type: Array});

const onDragEnd = (event) => {
    const oldIndex = event.oldIndex;
    const newIndex = event.newIndex;

    if (oldIndex !== newIndex && list.value) {
        const movedItem = list.value.splice(oldIndex, 1)[0];
        list.value.splice(newIndex, 0, movedItem);
    }
};


</script>

<template>
    <Sortable
        :list="list"
        item-key="id"
        tag="div"
        :options="sortOption"
        @end="onDragEnd"
    >
        <template #item="{element, index}">
            <slot name="item" :element="element" :index="index" />
        </template>
    </Sortable>
</template>

<style>
    .sortable-ghost {
        @apply opacity-70;
    }
</style>
