<script setup>
import { defineComponent, ref } from 'vue';
import {router, useForm} from "@inertiajs/vue3";
import FormItem from "@/Components/Form/FormItem.vue";
import {confirm_delete} from "@/Utils/confirmation_modal.js";
import {can} from "@/Utils/functions.js";

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

const props = defineProps({})

const value = defineModel("value");

const form = useForm({
    valeur: null,
})

const handleDropdownVisibleChange = (open) => {
    form.reset();
    form.clearErrors();
};

const handleAdd = e => {
    e.preventDefault();
    form.post(route('tva.store'), {
        onSuccess: params => {
            form.reset()
        }
    })
};

const handleDelete = tva => {
    confirm_delete(() => {
        router.delete(route('tva.destroy', tva.id), {
            preserveScroll: true,
            preserveState: true,
            onSuccess: params => {
                value.value = null
            }
        })
    });
}

</script>

<template>
    <a-select
        v-model:value="value"
        option-filter-prop="label"
        show-search
        allow-clear
        size="large"
        @dropdownVisibleChange="handleDropdownVisibleChange"
    >
        <template #option="option">
            <div class="flex flex-row justify-between">
                <span>{{ option.label }}</span>
                <a-button size="small" title="Supprimer" type="danger" v-if="can('tva.destroy')" @click="handleDelete(option)">
                    <template #icon>
                        <font-awesome-icon icon="fa-solid fa-xmark" color="red"/>
                    </template>
                </a-button>
            </div>
        </template>

        <template #dropdownRender="{ menuNode: menu }">
            <v-nodes :vnodes="menu" />
            <a-divider class="my-2" v-if="can('tva.store')"/>
            <form-item required has-feedback :help="form.errors.valeur" v-if="can('tva.store')" class="mb-1">
                <div class="flex flex-nowrap gap-1">
                    <a-input-number class="w-full" v-model:value="form.valeur" placeholder="Nouveau" />
                    <a-button type="primary" @click="handleAdd" :loading="form.processing">
                        Ajouter
                    </a-button>
                </div>
            </form-item>
        </template>
    </a-select>
</template>
