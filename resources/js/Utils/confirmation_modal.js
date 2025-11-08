import {Modal} from 'ant-design-vue';
import {h} from 'vue';

export const confirm_save = (callback = () => {}, title = null, content = null, okText = null) => {
    Modal.confirm({
        title: title ?? 'Confirmation',
        content: h('div', {}, [
            h('p', {}, [content ?? 'Voulez vous vraiment continuer l\'enregistrement ?'])
        ]),
        okText: okText ?? 'CONTINNUER',
        cancelText: 'ANNULER',
        okType: 'primary',
        icon: null,
        centered: true,
        onOk() {
            callback();
        },
        onCancel() {

        },
    });
}

export const confirm_delete = (callback = () => {}, title = null, content = null, okText = null) => {
    Modal.confirm({
        title: title ?? 'Confirmation',
        content: h('div', {}, [
            h('p', {}, [content ?? 'Voulez vous vraiment continuer la suppression ?'])
        ]),
        okText: okText ?? 'SUPPRIMER',
        cancelText: 'ANNULER',
        okType: 'primary',
        okButtonProps: {danger: true},
        icon: null,
        centered: true,
        onOk() {
            callback();
        },
        onCancel() {

        },
    });
}
