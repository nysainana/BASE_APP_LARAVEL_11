import { h, computed } from 'vue';
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import { can } from "@/Utils/functions.js";

const pageConfig = [
    {
        label: "Dashboard",
        key: "dashboard",
        icon: "fa-solid fa-gauge",
        routeName: "dashboard",
        permission: "dashboard",
        navbarData: true,
    },
    {
        label: "Accès et securité",
        key: "acces-securite",
        type: 'group',
        icon: "fa-solid fa-shield",
        children: [
            {
                label: "Role utilisateurs",
                key: "role-user.index",
                icon: "fa-solid fa-user-group",
                routeName: "role-user.index",
                permission: "role-user.index",
                navbarData: true,
            },
            {
                label: "Utilisateurs",
                key: "user.index",
                icon: "fa-solid fa-user",
                routeName: "user.index",
                permission: "user.index",
                navbarData: true,
            },
        ]
    },
    {
        label: "Paramètres",
        key: "param",
        type: 'group',
        icon: "fa-solid fa-gear",
        children: [
            {
                label: "Application",
                key: "param-app",
                icon: "fa-solid fa-gear",
                children: []
            },
            {
                label: "Information société",
                key: "societe.edit",
                icon: "fa-solid fa-building",
                routeName: "societe.edit",
                permission: "societe.edit",
                navbarData: true,
            },
        ]
    },
    {
        label: "Mon profil",
        key: "profile.edit",
        icon: "fa-solid fa-user",
        routeName: "profile.edit",
    },
];


export function useAppPage() {

    function buildAndFilterMenu(items) {
        return items.reduce((acc, item) => {

            if (!item.navbarData && !item.children?.length) {
                return acc;
            }

            const isVisible = item.permission ? can(item.permission) : true;
            if (!isVisible) {
                return acc;
            }

            let processedChildren = undefined;
            if (item.children && item.children.length > 0) {
                processedChildren = buildAndFilterMenu(item.children);
                if (processedChildren.length === 0 && !item.routeName && !item.navbarData) {
                    return acc;
                }
            }

            const iconComponent = item.icon
                ? h(FontAwesomeIcon, { icon: item.icon === '-' ? 'fa-solid fa-caret-right' : item.icon })
                : null;

            acc.push({
                ...item,
                icon: iconComponent,
                children: processedChildren,
            });
            return acc;
        }, []);
    }

    const menu = computed(() => {
        return buildAndFilterMenu(pageConfig);
    });

    const __findParentMenu = (menuItems, childKey) => {
        for (const item of menuItems) {
            if (item.children) {
                if (item.children.some(child => child.key === childKey)) {
                    if (item.type !== 'group') return item;
                }
                const parent = __findParentMenu(item.children, childKey);
                if (parent && parent.type !== 'group') return parent;
            }
        }
        return null;
    };

    const findParentMenu = (childKey) => {
        return __findParentMenu(pageConfig, childKey);
    }

    const __generateBreadcrumb = (menuItems, selectedKey, path = []) => {
        for (const item of menuItems) {
            const newPath = [...path, { label: item.label, key: item.key, routeName: item.routeName }];
            if (item.key === selectedKey) {
                return newPath;
            }
            if (item.children) {
                const foundPath = __generateBreadcrumb(item.children, selectedKey, newPath);
                if (foundPath) return foundPath;
            }
        }
        return null;
    };

    const generateBreadcrumb = (selectedKey) => {
        return __generateBreadcrumb(pageConfig, selectedKey);
    }

    const __findPageByKey = (items, key) => {
        for (const item of items) {
            if (item.key === key) {
                return item;
            }
            if (item.children) {
                const found = __findPageByKey(item.children, key);
                if (found) return found;
            }
        }
        return null;
    };

    const getPageConfig = (pageKey) => {
        return __findPageByKey(pageConfig, pageKey);
    };

    return {
        menu,
        findParentMenu,
        generateBreadcrumb,
        getPageConfig
    };
}
