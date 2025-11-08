<script setup>
import { computed, ref } from "vue";
import { useForm } from "@inertiajs/vue3";
import FormItem from "@/Components/Form/FormItem.vue";
import SimpleCrudForm from "@/Components/Form/SimpleCrudForm.vue";
import { Tree as ATree, Checkbox as ACheckbox, Input as AInput } from 'ant-design-vue';
import PermissionGroupCard from "./PermissionGroupCard.vue";

const props = defineProps({
    permissions: {
        type: Array,
        default: () => [],
    },
    protected_roles: {
        type: Array,
        default: () => [],
    }
});

const form = useForm({
    id: null,
    name: null,
    permissions: ['dashboard'],
});

const sp = ref(null);
const searchQuery = ref('');

defineExpose({
    add: () => sp.value.add(),
    update: (data) => {
        sp.value.update(data);
        form.permissions = [...new Set([...data.permissions.map((p) => p.name), 'dashboard'])];
    },
    close: () => sp.value.close(),
});

const isProtectedRole = computed(() => {
    return props.protected_roles.includes(form.name);
});

const treeData = computed(() => {
    const transform = (items) => {
        return items.map(item => {
            const node = {
                key: item.key,
                title: item.label,
                is_group: !!item.is_group,
                disabled: item.key === 'dashboard', // Disable dashboard
            };
            if (item.children && item.children.length > 0) {
                node.children = transform(item.children);
            }
            return node;
        });
    };
    return transform(props.permissions);
});

const filteredPermissions = computed(() => {
    if (!searchQuery.value.trim()) {
        return treeData.value;
    }
    const query = searchQuery.value.trim().toLowerCase();

    function filter(items) {
        return items.reduce((acc, item) => {
            const labelMatches = item.title.toLowerCase().includes(query);
            let childrenFiltered = [];

            if (item.children && item.children.length > 0) {
                childrenFiltered = filter(item.children);
            }

            if (labelMatches || childrenFiltered.length > 0) {
                acc.push({ ...item, children: childrenFiltered.length > 0 ? childrenFiltered : item.children });
            }
            return acc;
        }, []);
    }

    return filter(treeData.value);
});
</script>

<template>
    <SimpleCrudForm
        ref="sp"
        :form="form"
        route="role-user"
        add_title="Nouveau role"
        update_title="Modification role"
        size="full"
    >
        <div class="space-y-6">
            <form-item required has-feedback label="Nom du role" :help="form.errors.name">
                <a-input
                    class="w-full"
                    v-model:value="form.name"
                    size="large"
                    placeholder="Nom du role"
                    :disabled="isProtectedRole"
                />
            </form-item>

            <div class="pt-4">
                <h3 class="text-base font-semibold mb-4 text-gray-700">Permissions</h3>

                <a-input
                    v-model:value="searchQuery"
                    placeholder="Rechercher une permission..."
                    class="mb-4"
                    allow-clear
                />

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                    <PermissionGroupCard
                        v-for="group in filteredPermissions"
                        :key="group.key"
                        :group="group"
                        :all-permissions="form.permissions"
                        @update:permissions="(newPermissions) => form.permissions = newPermissions"
                    />
                </div>
            </div>
        </div>
    </SimpleCrudForm>
</template>
