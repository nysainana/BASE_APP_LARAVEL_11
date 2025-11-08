<script setup>
import { defineComponent, ref } from 'vue';
import {can} from "@/Utils/functions.js";
import CouleurForm from '@/Pages/Couleur/Partials/CouleurForm.vue';
import ColorDisplay from '../ColorDisplay.vue';

const VNodes = defineComponent({
    props: {
        vnodes: {
            type: Object,
            required: true,
        },
    },
    render() {
        return this.vnodes;
    },
});

const props = defineProps({
    addButton: {
        type: Boolean,
        default: () => true,
    }
})
const value = defineModel("value");
const openDropdown = ref(false)
const formModal = ref()


const handleDropdownVisibleChange = (open) => {
     openDropdown.value = open;
};

const handleAdd = () => {
    formModal.value.add();
    openDropdown.value = false;
}

// const handleDelete = tva => {
//     confirm_delete(() => {
//         router.delete(route('couleur.destroy', tva.id), {
//             preserveScroll: true,
//             preserveState: true,
//             onSuccess: params => {
//                 value.value = null
//             }
//         })
//     });
// }

</script>

<template>
    <a-select
        v-model:value="value"
        :open="openDropdown"
        option-filter-prop="label"
        placeholder="Séléctioner une couleur"
        show-search
        allow-clear
        size="large"
        @dropdownVisibleChange="handleDropdownVisibleChange"
    >
        <template #option="{value, label, code}">
            <ColorDisplay :label="label" :color="code" />
        </template>

        <template #tagRender="{ value, label, closable, onClose, option }">
            <a-tag class="flex flex-nowrap gap-1 items-center py-1" size="large" :closable="closable" @close="onClose">
                <ColorDisplay :label="label" :color="option.code"  />
            </a-tag>
        </template>

        <template #dropdownRender="{ menuNode: menu }">
            <v-nodes :vnodes="menu" />
            <a-divider class="my-2" v-if="addButton && can('couleur.store')"/>
            <div v-if="addButton && can('couleur.store')" class="mb-1 mx-4">
                <a-button type="primary" @click="handleAdd" class="!w-full">
                    Ajouter une nouvelle couleur
                </a-button>

                <CouleurForm ref="formModal" />
            </div>
        </template>
    </a-select>
</template>
