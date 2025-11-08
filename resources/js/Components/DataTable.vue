<script setup>
import {computed, onMounted} from "vue";

const props = defineProps({
    data: {
        type: Object,
        required: true,
    },
    columns: {
        type: Array,
        required: true,
    },
    actions: Array,
    rowKey: {
        default: "id",
    },
    showIndex: {
        type: Boolean,
        default: false,
    },
    pagination: {
        type: Object,
        default: () => ({}),
    },
    rowColor: {
        type: Function,
        default: null,
    },
    striped: {
        type: Boolean,
        default: () => true,
    }
});

const pagination = computed(() => {
    return {
        total: props.data.total,
        current: props.data.current_page,
        pageSize: props.data.per_page,
        hideOnSinglePage: props.pagination?.hideOnSinglePage ?? false,
        showSizeChanger: props.pagination?.showSizeChanger ?? false,
        showTotal: (total, range) =>
            props.pagination?.showTotal != null
                ? props.pagination?.showTotal(total, range)
                : `${range[0]} - ${range[1]} sur ${total}`,
    };
});

const handleActionVisible = (action, record) => {
    if (action.visible === null || action.visible === undefined) return true;
    if (typeof action.visible === "boolean") return action.visible;
    if (typeof action.visible === "function") return action.visible(record);
    return false;
};

const getVisibleActions = (record) => {
    if (!props.actions || props.actions.length === 0) {
        return [];
    }

    const visibleActions = props.actions.filter(action => handleActionVisible(action, record));

    if (visibleActions.length === 0) {
        return [];
    }

    return visibleActions.reduce((accumulator, currentAction, index) => {
        if (currentAction.text !== '-') {
            accumulator.push(currentAction);
            return accumulator;
        }

        if (accumulator.length === 0) {
            return accumulator;
        }

        if (accumulator[accumulator.length - 1].text === '-') {
            return accumulator;
        }

        const hasVisibleActionAfter = visibleActions.slice(index + 1).some(action => action.text !== '-');

        if (hasVisibleActionAfter) {
            accumulator.push(currentAction);
        }

        return accumulator;
    }, []);
};

const handleActionDisabled = (action, record) => {
    if (action.disabled === null || action.disabled === undefined) return false;
    if (typeof action.disabled === "boolean") return action.disabled;
    if (typeof action.disabled === "function") return action.disabled(record);
    return true;
};

const areAnyActionsVisible = (record) => {
    return getVisibleActions(record).length > 0;
};

const getRowStyle = (record, index) => {
    const color = props.rowColor?.(record, index);
    if (color) {
        return { class: `table-${color}` };
    }
    return props.striped && (index % 2 === 1) ? { class: "table-striped" } : {};
};

const finalColumns = computed(() => {
    const cols = [...props.columns];

    if (props.showIndex && !cols.some(c => c.key === 'index')) {
        cols.unshift({ title: "#", key: "index", width: 20, fixed: "left" });
    }

    const hasAnyVisibleActions = props.actions && props.data.data?.some(record => getVisibleActions(record).length > 0);

    if (!hasAnyVisibleActions) {
        return cols.filter(c => c.key !== 'action');
    }

    if (!cols.some(c => c.key === 'action')) {
        cols.push({ title: "", key: "action", width: 50, fixed: "right" });
    }

    return cols;
});
</script>

<template>
    <a-table
        class="main-table whitespace-nowrap main-rounded overflow-hidden"
        :data-source="data.data"
        :pagination="pagination"
        :columns="finalColumns"
        :row-key="rowKey"
        :scroll="{ x: 'auto' }"
        :customRow="getRowStyle"
    >
        <template #emptyText>
            <slot name="emptyText" v-if="$slots.emptyText" />
            <a-empty v-else description="Aucun resultats" class="my-10" />
        </template>

        <template #headerCell="{ title,  column }">
            <slot name="headerCell" :title="title" :column="column">
                <template v-if="columns.map(c => c.key).includes(column.key)">
                    {{ title }}
                </template>
            </slot>
        </template>

        <template #bodyCell="{ column, record, text, index }">
            <slot :column="column" :record="record" :text="text" :index="index"></slot>

            <template v-if="column.key === 'index'">
                {{ (data.current_page - 1) * data.per_page + index + 1 }}
            </template>

            <template v-if="column.key === 'action'">
                <a-dropdown
                    v-if="areAnyActionsVisible(record)"
                    placement="bottomRight"
                    :trigger="['click']"
                >
                    <a-button
                        type="text"
                        class="!p-0 !h-0 hover:!bg-transparent hover:text-text-primary hover:shadow-none !text-lg"
                    >
                        <font-awesome-icon icon="fa-solid fa-ellipsis" />
                    </a-button>
                    <template #overlay>
                        <a-menu>
                            <span v-for="action in getVisibleActions(record)" :key="action.text">
                                <a-menu-divider class="!my-0.5" v-if="action.text === '-'" />
                                <a-menu-item
                                    v-else
                                    :class="[action.class, { 'opacity-50 !cursor-not-allowed': handleActionDisabled(action, record) }]"
                                    :disabled="handleActionDisabled(action, record)"
                                    @click="action.action(record)"
                                    :key="action.text"
                                >
                                    <font-awesome-icon
                                        v-if="action.icon"
                                        class="me-2"
                                        :icon="action.icon"
                                    />
                                    <span>{{ action.text }}</span>
                                </a-menu-item>
                            </span>
                        </a-menu>
                    </template>
                </a-dropdown>
            </template>
        </template>

        <template #summary>
            <slot name="summary" />
        </template>

        <template v-if="$slots.expandedRowRender" #expandedRowRender="{ record }">
            <div class="p-5">
                <slot name="expandedRowRender" :record="record" />
            </div>
        </template>
    </a-table>
</template>

<style>
.main-table {
    @apply p-5 bg-white;
}

.main-table .ant-spin-container .ant-pagination {
    @apply mt-5 mb-0;
}

.main-table .ant-table-thead .ant-table-cell {
    @apply pb-2 before:!w-0 uppercase text-nowrap;
}

.main-table .ant-table-row .ant-table-cell {
    @apply py-2;
}

.main-table .table-striped .ant-table-cell {
    background-color: #fafafa;
}

.main-table .table-danger td {
    @apply !bg-red-200;
}

.main-table .table-danger:hover td {
    @apply !bg-red-100;
}

.main-table .table-success td {
    @apply !bg-green-200;
}

.main-table .table-success:hover td {
    @apply !bg-green-100;
}

.main-table .table-info td {
    @apply !bg-blue-200;
}

.main-table .table-info:hover td {
    @apply !bg-blue-100;
}

.main-table .table-warning td {
    @apply !bg-yellow-200;
}

.main-table .table-warning:hover td {
    @apply !bg-yellow-100;
}

</style>
