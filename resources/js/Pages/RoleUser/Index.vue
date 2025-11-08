<script setup>

import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import DataTable from "@/Components/DataTable.vue";
import Toolbar from "@/Components/Toolbar/Toolbar.vue";
import ButtonIcon from "@/Components/ButtonIcon.vue";
import Recherche from "@/Components/Toolbar/Recherche.vue";
import {computed, ref} from "vue";
import {can, reloadPage} from "@/Utils/functions.js";
import {confirm_delete} from "@/Utils/confirmation_modal.js";
import {router} from "@inertiajs/vue3";
import RoleUserForm from "@/Pages/RoleUser/Partials/RoleUserForm.vue";

const props = defineProps({
    data: {
        type: Object,
        default: () => {}
    },
    extra_data: {
        type: Object,
        default: () => {}
    },
    filters: {
        type: Object,
        default: () => {}
    },

})

const formModal = ref()
const title = computed(() => `Resultats (${ props.data?.total ?? 0 })`)

const columns = [
    {key: "name", title: "Nom", dataIndex: "name"},
    {key: "permissions_count", title: "Nombre de permissions", dataIndex: "permissions_count"},
]

const handleDelete = (record) => {
    confirm_delete(() => {
        router.delete(route('role-user.destroy', record.id), {
            preserveScroll: true,
        })
    });
}

const actions = [
    {text: "Modifier", action: (record) => formModal.value.update(record), icon: 'fa-pen-to-square', visible: can('role-user.update')},
    {text: "-"},
    {
        text: "Supprimer",
        action: handleDelete,
        icon: 'fa-trash',
        disabled: (record) => props.extra_data.protected_roles.includes(record.name),
        class: '!text-red-500',
        visible: can('role-user.destroy')
    },
]

</script>

<template>
    <authenticated-layout title="Role utilisateurs" selected-menu="role-user" icon="fa-solid fa-user-group">
        <template #actions>
            <ButtonIcon v-if="can('role-user.store')" @click="() => formModal.add()" type="primary" text="Créer une nouvelle role" icon="fa-plus"/>
        </template>

        <div>
            <Toolbar :title="title">
                <Recherche v-model:value="filters.search" @on-search="reloadPage(filters)" />
                <ButtonIcon @click="reloadPage(filters)" text="Actualiser" icon="fa-refresh"/>
            </Toolbar>

            <data-table
                :columns="columns"
                :data="data"
                :actions="actions"
                @change="(p, f, s) => reloadPage(filters, p.current)"
                class="main-shadow mt-5"
                show-index
            >
                 <template #default="{ column, record, text }">
                    <template v-if="column.key === 'permissions_count'">
                        <span>{{ record.permissions.length }}</span>
                    </template>
                </template>
            </data-table>
        </div>
    </authenticated-layout>

    <RoleUserForm ref="formModal" :permissions="extra_data.permissions" />
</template>
