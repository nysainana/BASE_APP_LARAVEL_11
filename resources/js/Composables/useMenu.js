import { h, computed } from 'vue';
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import { can } from "@/Utils/functions.js";

const menuConfig = [
    { label: "Dashboard", key: "dashboard", icon: "fa-solid fa-gauge", routeName: "dashboard", permission: "dashboard" },
    {
        label: "Accès et securité", key: "acces_securite", type: 'group', icon: "fa-solid fa-shield",
        children: [
            { label: "Role utilisateurs", key: "role-user", icon: "fa-solid fa-user-group", routeName: "role-user.index", permission: "role-user.index" },
            { label: "Utilisateurs", key: "user", icon: "fa-solid fa-user", routeName: "user.index", permission: "user.index" },
        ]
    },
    {
        label: "Paramètres", key: "param", type: 'group', icon: "fa-solid fa-gear",
        children: [
            {
                label: "Application", key: "param-app", icon: "fa-solid fa-gear",
                children: [

                ]
            },
            { label: "Information société", key: "societe-info", icon: "fa-solid fa-building", routeName: "societe.edit", permission: "societe.index" },
        ]
    },
];


export function useMenu() {

    function buildAndFilterMenu(items) {
        return items.reduce((acc, item) => {
            const isVisible = item.permission ? can(item.permission) : true;

            if (!isVisible) {
                return acc;
            }

            let processedChildren = undefined;
            if (item.children && item.children.length > 0) {
                processedChildren = buildAndFilterMenu(item.children);
                if (processedChildren.length === 0 && !item.routeName) {
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
        return buildAndFilterMenu(menuConfig);
    });

    const findParentMenu = (menuItems, childKey) => {
        for (const item of menuItems) {
            if (item.children) {
                if (item.children.some(child => child.key === childKey)) {
                    if (item.type !== 'group') return item;
                }
                const parent = findParentMenu(item.children, childKey);
                if (parent && parent.type !== 'group') return parent;
            }
        }
        return null;
    };

    const generateBreadcrumb = (menuItems, selectedKey, path = []) => {
        for (const item of menuItems) {
            const newPath = [...path, { label: item.label, key: item.key, routeName: item.routeName }];
            if (item.key === selectedKey) {
                return newPath;
            }
            if (item.children) {
                const foundPath = generateBreadcrumb(item.children, selectedKey, newPath);
                if (foundPath) return foundPath;
            }
        }
        return null;
    };

    return {
        menu,
        findParentMenu,
        generateBreadcrumb
    };
}
