<script setup>
import {ref} from "vue";
import FormModal from "@/Components/Form/FormModal.vue";

const props = defineProps({
    form: {
        type: Object,
        required: true
    },
    route: {
        type: String,
        required: true
    },
    add_title: {
        type: String,
        default: () => "Nouveau"
    },
    update_title: {
        type: String,
        default: () => "Modification"
    },
    before_submit: {
        type: Function,
        default: null
    },
})

const open = ref(false);
const title = ref("");
const emit = defineEmits(["close", "onUpdate", "onAdd"]);

const close = () => {
    open.value = false;
    props.form.reset();
    props.form.clearErrors();
    emit("close");
}

const add = () => {
    title.value = props.add_title;
    open.value = true;
    emit("onAdd");
}

const update = (data) => {
    const dataCopy = JSON.parse(JSON.stringify(data));

    title.value = props.update_title;
    open.value = true;

    Object.keys(dataCopy).forEach(key => {
        props.form[key] = dataCopy[key];
    });
    emit("onUpdate", dataCopy);
};

const submit = () => {
    props.form.clearErrors()
    if(props.before_submit) props.before_submit()
    if(props.form.id){
        props.form.put(route(`${props.route}.update`, props.form.id), {
            onSuccess: () => {
                close()
            },
        })
    }
    else {
        props.form.post(route(`${props.route}.store`), {
            onSuccess: () => {
                close()
            }
        })
    }
}

defineExpose({
    open,
    add,
    update,
    close,
});

</script>

<template>
    <FormModal
        v-model:open="open"
        :title="title"
        :loading="props.form.processing"
        @close="close"
        @submit="submit"
        size="lg"
    >
        <slot  />
    </FormModal>
</template>
