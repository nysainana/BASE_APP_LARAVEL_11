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
import UserForm from "@/Pages/User/Partials/UserForm.vue";
import FilterCheckboxGroupe from "@/Components/Filter/FilterCheckboxGroupe.vue";
import FilterButton from "@/Components/Filter/FilterButton.vue";
import FilterItem from "@/Components/Filter/FilterItem.vue";

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
    {key: "tel", title: "Téléphone", dataIndex: "tel"},
    {key: "email", title: "Email", dataIndex: "email"},
    {key: "role_name", title: "Role", dataIndex: "role_name"},
    {key: "is_you", title: "", dataIndex: "is_you", width: 50},
]

const handleDelete = (record) => {
    confirm_delete(() => {
        router.delete(route('user.destroy', record.id), {
            preserveScroll: true,
        })
    });
}

const actions = [
    {text: "Modifier", action: (record) => formModal.value.update(record), icon: 'fa-pen-to-square', visible: can('user.update')},
    {text: "-"},
    {text: "Supprimer", action: handleDelete, icon: 'fa-trash', disabled: (record) => record.is_you || props.data.total < 1, class: '!text-red-500', visible: can('user.destroy')},
]

</script>

<template>
    <authenticated-layout title="Utilisateurs" selected-menu="user" icon="fa-solid fa-user">
        <template #actions>
            <ButtonIcon v-if="can('user.store')" @click="() => formModal.add()" type="primary" text="Créer un nouvel utilisateur" icon="fa-plus"/>
        </template>

        <div>
            <Toolbar :title="title">
                <Recherche v-model:value="filters.search" @on-search="reloadPage(filters)" />
                <FilterButton @on-ok="reloadPage(filters)" @on-reset="reloadPage()">
                    <FilterItem title="Rôle">
                        <a-select
                            v-model:value="filters.roles"
                            :options="extra_data.roles"
                            placeholder="Sélectionner les rôles à afficher"
                            class="w-full"
                            mode="multiple"
                            size="large"
                            allow-clear
                        />
                    </FilterItem>
                </FilterButton>
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
                    <template v-if="column.key === 'is_you'">
                        <a-tag v-if="text" color="success" :bordered="false">
                            VOUS
                        </a-tag>
                    </template>
                </template>
            </data-table>
        </div>
    </authenticated-layout>

    <UserForm ref="formModal" :roles="extra_data.roles" />
</template>

<style scoped>

</style>
