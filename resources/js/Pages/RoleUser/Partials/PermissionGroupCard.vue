<script setup>
import { computed, ref } from "vue";
import { Tree as ATree, Checkbox as ACheckbox } from 'ant-design-vue';

const props = defineProps({
    group: {
        type: Object,
        required: true,
    },
    allPermissions: {
        type: Array,
        required: true,
    },
});

const emit = defineEmits(['update:permissions']);

const getAllChildKeys = (node) => {
    let keys = [];
    if (!node.children || node.children.length === 0) {
        if (node.key) keys.push(node.key);
    } else {
        for (const child of node.children) {
            keys = keys.concat(getAllChildKeys(child));
        }
    }
    return [...new Set(keys)];
};

const isLeafNode = (nodes, key) => {
    for (const node of nodes) {
        if (node.key === key) {
            return !node.children || node.children.length === 0;
        }
        if (node.children) {
            const found = isLeafNode(node.children, key);
            if (found) return true;
        }
    }
    return false;
};

const handleTreeCheck = (checkedKeysFromTree) => {
    const leafKeysFromTree = checkedKeysFromTree.filter(key => {
        return isLeafNode(props.group.children, key);
    });

    const allPossibleKeysInGroup = getAllChildKeys(props.group);

    const permissionsFromOtherGroups = props.allPermissions.filter(
        p => !allPossibleKeysInGroup.includes(p)
    );

    emit('update:permissions', [...new Set([...permissionsFromOtherGroups, ...leafKeysFromTree])]);
};

const checkAll = (e) => {
    const checked = e.target.checked;
    const groupPermissions = getAllChildKeys(props.group);

    if (checked) {
        emit('update:permissions', [...new Set([...props.allPermissions, ...groupPermissions])]);
    } else {
        const permissionsToRemove = new Set(groupPermissions);
        const newPermissions = props.allPermissions.filter(p => !permissionsToRemove.has(p));
        emit('update:permissions', newPermissions);
    }
};

const isGroupChecked = computed(() => {
    const groupPermissions = getAllChildKeys(props.group);
    if (groupPermissions.length === 0) return false;
    return groupPermissions.every((p) => props.allPermissions.includes(p));
});

const isGroupIndeterminate = computed(() => {
    const groupPermissions = getAllChildKeys(props.group);
    const selectedCount = groupPermissions.filter((p) => props.allPermissions.includes(p)).length;
    return selectedCount > 0 && selectedCount < groupPermissions.length;
});

const getAllKeysForExpansion = (nodes) => {
    let keys = [];
    nodes.forEach(node => {
        keys.push(node.key);
        if (node.children) {
            keys = keys.concat(getAllKeysForExpansion(node.children));
        }
    });
    return [...new Set(keys)];
};

const expandedKeys = computed(() => {
    return getAllKeysForExpansion(props.group.children);
});

const checkedKeysForTree = computed(() => {
    const allKeysInTree = getAllChildKeys(props.group);
    return props.allPermissions.filter(key => allKeysInTree.includes(key));
});
</script>

<template>
    <div
        class="border border-gray-200 rounded-lg p-4 bg-gray-50/50 hover:bg-gray-50 transition-colors overflow-hidden"
    >
        <a-checkbox
            @change="checkAll($event)"
            :checked="isGroupChecked"
            :indeterminate="isGroupIndeterminate"
            :disabled="group.key === 'dashboard'"
            class="font-semibold text-sm uppercase tracking-wide text-gray-700 mb-3"
        >
            {{ group.title }}
        </a-checkbox>

        <div class="h-px bg-gray-200 mb-3"></div>

        <div class="flex flex-col space-y-2">
            <a-tree
                class="!bg-transparent"
                v-if="group.children && group.children.length > 0"
                checkable
                :tree-data="group.children"
                :checked-keys="checkedKeysForTree"
                @check="(checkedKeys) => handleTreeCheck(checkedKeys)"
                :field-names="{ children: 'children', title: 'title', key: 'key' }"
            >
                <template #title="{ title }">
                    <span class="text-sm text-gray-600">{{ title }}</span>
                </template>
            </a-tree>
        </div>
    </div>
</template>
