<script setup>
import { router } from '@inertiajs/vue3';
import {defineProps, ref, onBeforeMount, computed, watch} from 'vue';
import {FontAwesomeIcon} from "@fortawesome/vue-fontawesome";
import Avatar from "@/Components/Avatar.vue";
import {useAppPage} from "@/Composables/useAppPage.js";

const props = defineProps({
    selectedMenu: {
        type: String,
        default: ''
    }
})

const collapsed = defineModel('collapsed')

const openKeys = ref([]);

const { menu, findParentMenu } = useAppPage();
const filteredMenuData = computed(() => menu.value); // À utiliser quand on ajoutera un filtre sur le sidebar

function handleMenuCLick({ item, key, keyPath }) {
    if(item.routeName) {
        router.get(route(item.routeName), {}, {
            preserveState: true,
        });
    }
}

const handleCollapse = (collapsed, type) => {
    if(type === 'clickTrigger') {
        localStorage.setItem("sidebar-collapsed", JSON.stringify(collapsed));
    }
}

const handleMenuChange = () => {
    const parent = findParentMenu(props.selectedMenu);
    if(parent) openKeys.value.push(parent.key);
}

onBeforeMount(() => {
    handleMenuChange();
    // collapsed.value = localStorage.getItem("sidebar-collapsed") === 'true';
})
watch(() => props.selectedMenu, (newSelectedMenu) => handleMenuChange());

</script>

<template>
    <a-layout-sider
        id="side-bar"
        v-model:collapsed="collapsed"
        theme="light"
        :width="260"
        breakpoint="lg"
        :collapsed-width="0"
        class="!fixed h-full z-10 !bg-transparent"
        collapsible
        @collapse="handleCollapse"
    >

        <template #trigger>
            <font-awesome-icon v-if="collapsed" class="text-lg" icon="fa-solid fa-caret-right" />
            <font-awesome-icon v-else class="text-lg" icon="fa-solid fa-caret-left" />
        </template>

        <div class="flex flex-col shadow-lg bg-white h-full pb-2 main-rounded overflow-hidden rounded-l-none">
            <div
                class="flex flex-nowrap items-center gap-3 my-2 mx-1.5 p-2 cursor-pointer main-rounded hover:bg-black/5"
                @click="router.get(route('profile.edit'))"
            >
                <div class="bg-white rounded-full p-0.5 shadow">
                    <avatar
                        :src="$page.props.auth.user.avatar"
                        :color="$page.props.auth.user.color"
                        :size="50"
                        icon="fa-circle-user"
                    />
                </div>

                <div>
                    <div class="font-semibold text-lg line-clamp-1">
                        {{ $page.props.auth.user.name }}
                    </div>
                    <div class="text-xs text-gray-500 line-clamp-1">
                        {{ $page.props.auth.user.email }}
                    </div>
                </div>
            </div>

            <hr>

            <PerfectScrollbar class="flex-1" :options="{suppressScrollX: true}">
                <a-menu
                    :selectedKeys="[selectedMenu]"
                    v-model:open-keys="openKeys"
                    class="!border-0 bg-transparent"
                    theme="light"
                    mode="inline"
                    :items="filteredMenuData"
                    @click="handleMenuCLick"
                >
                </a-menu>
            </PerfectScrollbar>
        </div>

    </a-layout-sider>
</template>

<style>

#side-bar .ant-menu-item,
#side-bar .ant-menu-submenu-title {
    @apply min-h-12 text-text-primary/70 font-medium main-rounded overflow-visible relative;
}

#side-bar .ant-menu-sub .ant-menu-item{
    @apply !pl-6;
}

#side-bar .ant-menu-item-selected {
    @apply font-semibold text-primary ;
}

#side-bar .ant-menu-title-content{
    @apply w-full;
}

#side-bar .ant-menu-item-icon {
    @apply h-[18px] w-[18px]  !overflow-hidden;
}

#side-bar .ant-menu-sub .ant-menu-item-icon {
    @apply h-[15px];
}

#side-bar .ant-menu-item-group-title {
    @apply uppercase;
}

#side-bar .ant-layout-sider-zero-width-trigger {
    width: 30px;
    inset-inline-end: -30px;
    border-radius: 0 100% 100% 0;
    @apply shadow-lg top-6;
}

</style>
