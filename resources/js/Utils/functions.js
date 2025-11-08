import {router, usePage} from "@inertiajs/vue3";
import printJS from "print-js";

export const reloadPage = (
    filters = null, page = 1, sorter = null,
    preserveState = true, preserveScroll = true) => {

    const _params = {};

    if(page > 1) _params.page = page;
    if(sorter && sorter.order) _params.sorter = sorter;

    if(filters) {
        Object.keys(filters).forEach(key => {
            if(filters[key] !== null && filters[key] !== '')
                _params[key] = filters[key];
        });
    }

    router.get(
        usePage().props.ziggy.location,
        _params,
        { preserveState: preserveState, preserveScroll: preserveScroll }
    );
}

export function getBase64(img, callback) {
    const reader = new FileReader();
    reader.addEventListener('load', () => callback(reader.result));
    reader.readAsDataURL(img);
}

export  function base64ToBlob(base64, mimeType) {
    const byteString = atob(base64.split(",")[1]);
    const arrayBuffer = new ArrayBuffer(byteString.length);
    const uintArray = new Uint8Array(arrayBuffer);
    for (let i = 0; i < byteString.length; i++) {
        uintArray[i] = byteString.charCodeAt(i);
    }
    return new Blob([arrayBuffer], { type: mimeType });
}

export function printPdf(route) {
    const userAgent = navigator.userAgent.toLowerCase();
    const isFirefox = userAgent.includes('firefox');
    const isSafari = /safari/.test(userAgent) && !/chrome/.test(userAgent);

    if (isFirefox || isSafari) {
        window.open(route, "_blank");
        return;
    }

    printJS({
        printable: route,
        type: "pdf",
        showModal: true,
        modalMessage: "Un moment s'il vous plait...",
        onError: () => window.open(route, "_blank"),
        onIncompatibleBrowser: () => window.open(route, "_blank")
    });
}

export function formatNumber(num, suffix = null, precision = null) {
    if (num === null || num === undefined) {
        return '';
    }

    const convertedNum = typeof num === 'string' ? parseFloat(num) : num;

    if (typeof convertedNum !== 'number' || isNaN(convertedNum)) {
        return num.toString();
    }

    const options = precision !== null ? {
        minimumFractionDigits: precision,
        maximumFractionDigits: precision
    } : {};

    const formattedNum = convertedNum.toLocaleString('fr-FR', options);

    return suffix ? `${formattedNum} ${suffix}` : formattedNum;
}

export const can = (...permissions) => {
    const userPermissions = usePage().props.auth.permissions || [];
    return permissions?.some(p => userPermissions.includes(p)) || false;
};
