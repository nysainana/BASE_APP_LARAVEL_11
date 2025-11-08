<script setup>
import {ref} from "vue";
import {useForm} from "@inertiajs/vue3";
import FormItem from "@/Components/Form/FormItem.vue";
import FormModal from "@/Components/Form/FormModal.vue";
import SimpleCrudForm from "@/Components/Form/SimpleCrudForm.vue";

const props = defineProps({
    roles: {
        type: Array,
        default: () => []
    }
})

const form = useForm({
    id: null,
    name: null,
    email: null,
    tel: null,
    password: null,
    password_confirmation: null,
    role: null
})

const sp = ref(null);
defineExpose({
    add: () => sp.value.add(),
    update: (data) => sp.value.update(data),
    close: () => sp.value.close(),
});

</script>

<template>
    <SimpleCrudForm
        ref="sp"
        :form="form"
        route="user"
        add_title="Nouvel utilisateur"
        update_title="Modification utilisateur"
        size="default"
    >
        <form-item required has-feedback label="Nom" :help="form.errors.name">
            <a-input class="w-full" v-model:value="form.name" size="large" placeholder="Nom"/>
        </form-item>

        <form-item required has-feedback label="E-mail" :help="form.errors.email">
            <a-input class="w-full" v-model:value="form.email" size="large" placeholder="E-mail"/>
        </form-item>

        <form-item has-feedback label="Téléphone" :help="form.errors.tel">
            <a-input class="w-full" v-model:value="form.tel" size="large" placeholder="Téléphone"/>
        </form-item>

        <form-item required has-feedback label="Role" :help="form.errors.role">
            <a-select class="w-full" v-model:value="form.role" block :options="roles" size="large"  placeholder="Role"/>
        </form-item>

        <form-item :required="form.id == null" has-feedback label="Mot de passe" :help="form.errors.password">
            <a-input-password class="w-full" v-model:value="form.password" size="large" placeholder="Mot de passe"/>
        </form-item>

        <form-item :required="form.id == null" has-feedback label="Confirmation de mot de passe" :help="form.errors.password_confirmation">
            <a-input-password class="w-full" v-model:value="form.password_confirmation" size="large" placeholder="Confirmation de mot de passe"/>
        </form-item>
    </SimpleCrudForm>
</template>

<style scoped>

</style>
