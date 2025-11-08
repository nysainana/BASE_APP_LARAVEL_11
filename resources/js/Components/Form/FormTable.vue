<script setup>

import DataTable from "@/Components/DataTable.vue";
import {confirm_delete} from "@/Utils/confirmation_modal.js";
import {computed, onMounted, ref, watch} from "vue";

const props = defineProps({
    columns: {
        type: Array,
        default: () => []
    },
    dataTemplate: {
        type: Object,
        default: {}
    },
    min: {
        type: Number,
        default: () => 0
    },
    errors: {
        type: Object,
        default: () => null
    },
    error_key: {
        type: String,
        default: () => "key"
    },
    ajout_text: {
        type: String,
        default: () => "Ajouter"
    },
    can_add: {
        type: Boolean,
        default: () => true
    },
    can_remove: {
        type: Boolean,
        default: () => true
    },
    empty_text: {
        type: String,
        default: () => "Aucune donnée disponible."
    }
})

const data = defineModel("data", {type: Array})
const _errors = computed(() => loadErrors())
const showDelete = computed(() => data.value?.length > props.min && props.can_remove);
const allColumns = computed(() => {
    if(!props.columns.find(c => c.key === 'delete'))
        props.columns.push({title: '', key: 'delete', width: 10})

    return props.columns;
});

const ajoutVariation = () => {
    data.value.push({...props.dataTemplate});
}

const deleteVariation = (index) => {
    if(!showDelete.value) return;

    confirm_delete(() => {
        data.value.splice(index, 1);
    })
}

const loadErrors = () => {
    const _errors = [];

    if (props && props.errors) {
        if (data && data.value) {
            data.value.forEach((dat, index) => {
                if (props.error_key) {
                    Object.keys(props.errors).forEach(key => {
                        if (key.startsWith(`${props.error_key}.${index}`)) {
                            _errors.push({ index: index + 1, error: props.errors[key]});
                        }
                    });
                }
            });
        }
    }

    return _errors;
};

const checkDataLenght = () => {
    setTimeout(() => {
        if(data.value.length < props.min) {
            const diff = props.min - data.value.length;
            for (let i = 0; i < diff; i++) {
                ajoutVariation()
            }
        }
    }, 50)
}

watch(data, (value) => {
    checkDataLenght()
})

onMounted(() => {
    checkDataLenght()
})

</script>

<template>
    <div>
        <a-tag color="error" class="mb-4 text-sm w-full px-5 py-2" v-if="_errors && _errors.length" :bordered="false">
            <ul class="list-disc ps-3">
                <li v-for="error in _errors" class="my-1">
                    <strong>Ligne {{ error.index }}:</strong> {{ error.error }}
                </li>
            </ul>
        </a-tag>

        <data-table
            :columns="allColumns"
            :data="{
                data: data,
                per_page: 100,
                current_page: 1,
                total: data.length
            }"
            :pagination="{hideOnSinglePage: true}"
            class="!p-0 table-form"
            :striped="false"
        >
            <template #emptyText>
                <div class="text-center py-5 text-gray-400">
                    {{ empty_text }}
                </div>
            </template>

            <template #headerCell="{title, column}">
                <template v-if="columns.map(c => c.key).includes(column.key)">
                    <label :class="{'title-required': column.required}">
                        {{ title }}
                    </label>
                </template>
            </template>

            <template #default="{ column, record, text, index }">

                <slot :column="column" :record="record" :text="text" :index="index" />

                <template v-if="column.key === 'delete'">
                    <a-button
                        title="Supprimer"
                        type="text"
                        v-if="showDelete"
                        class="hover:!text-red-600 !p-0 !text-text-primary/40 hover:!bg-transparent hover:!shadow-none flex items-center"
                        @click="deleteVariation(index)"
                    >
                        <font-awesome-icon class="text-lg" icon="fa-solid fa-xmark"/>
                    </a-button>
                </template>
            </template>
        </data-table>

        <a-button class="mt-2" type="dashed" block @click="ajoutVariation" v-if="can_add">
            {{ ajout_text }}
        </a-button>
    </div>
</template>

<style>

.table-form td.ant-table-cell {
    @apply !px-1.5 !border-t-0;
}

.table-form th.ant-table-cell {
    @apply !px-[7px];
}

.table-form th.ant-table-cell .title-required:before {
    display: inline-block;
    margin-inline-end: 4px;
    color: #ff4d4f;
    font-size: 14px;
    font-family: SimSun,sans-serif;
    line-height: 1;
    content: "*";
    font-weight: normal;
}

</style>
