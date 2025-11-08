<script setup>
import {defineProps} from "vue";
import {can} from "@/Utils/functions.js";
import {useForm, usePage} from '@inertiajs/vue3'
import FormItem from "@/Components/Form/FormItem.vue";
import {message} from "ant-design-vue";
import FormDivider from "@/Components/Form/FormDivider.vue";
import UploadLogo from "@/Pages/Societe/Partials/UploadLogo.vue";

const props = defineProps({
    societe: {
        type: Object,
        default: {}
    }
})

const form = useForm({
    nom: props.societe?.nom,
    telephone: props.societe?.telephone,
    email: props.societe?.email,
    nif: props.societe?.nif,
    stat: props.societe?.stat,
    rcs: props.societe?.rcs,
    cif: props.societe?.cif,
    numero_compte: props.societe?.numero_compte,
    activite: props.societe?.activite,
    adresse: props.societe?.adresse,
    ville: props.societe?.ville,
    code_postal: props.societe?.code_postal,
    pays: props.societe?.pays,
})


const update = e => {
    form.clearErrors()
    if (props.societe.id)
        form.put(route('societe.update', {societe: props.societe.id}), {
            onSuccess: page => {

            }
        })
};

</script>

<template>
    <a-card class="main-card !overflow-visible">
        <div class="flex -mt-[90px] sm:-mt-[105px]">
            <UploadLogo :societe="societe" />
        </div>

        <a-form layout="vertical" class="!mt-7">

            <form-divider title="Information de la société" />
            <form-item required has-feedback label="Nom de la société" :help="form.errors.nom">
                <a-input v-model:value="form.nom" size="large" placeholder="Nom de la société"/>
            </form-item>

            <div class="md:grid md:grid-cols-2 md:gap-x-4">
                <form-item has-feedback label="Téléphone" :help="form.errors.telephone" class="!mt-0">
                    <a-input v-model:value="form.telephone" size="large" placeholder="Téléphone"/>
                </form-item>

                <form-item has-feedback label="Email" :help="form.errors.email">
                    <a-input v-model:value="form.email" size="large" type="email" placeholder="Email"/>
                </form-item>

                <form-item has-feedback label="NIF" :help="form.errors.nif">
                    <a-input v-model:value="form.nif" size="large" placeholder="NIF"/>
                </form-item>

                <form-item has-feedback label="STAT" :help="form.errors.stat">
                    <a-input v-model:value="form.stat" size="large" placeholder="STAT"/>
                </form-item>

                <form-item has-feedback label="RCS" :help="form.errors.rcs">
                    <a-input v-model:value="form.rcs" size="large" placeholder="RCS"/>
                </form-item>

                <form-item has-feedback label="CIF" :help="form.errors.cif">
                    <a-input v-model:value="form.cif" size="large" placeholder="CIF"/>
                </form-item>

                <form-item has-feedback label="Numero de compte" :help="form.errors.numero_compte">
                    <a-input v-model:value="form.numero_compte" size="large" placeholder="Numero de compte"/>
                </form-item>

                <form-item has-feedback label="Activité" :help="form.errors.activite" class="col-span-2">
                    <a-input v-model:value="form.activite" size="large" placeholder="Activité"/>
                </form-item>
            </div>

            <form-divider title="Adresse de la société" />
            <div class="md:grid md:grid-cols-4 md:gap-x-4">
                <form-item has-feedback label="Adresse" :help="form.errors.adresse" class="col-span-3">
                    <a-input class="w-full" v-model:value="form.adresse" size="large" placeholder="Adresse"/>
                </form-item>

                <form-item has-feedback label="Code postal" :help="form.errors.code_postal">
                    <a-input class="w-full" v-model:value="form.code_postal" size="large" placeholder="Code postal"/>
                </form-item>

                <form-item has-feedback label="Ville" :help="form.errors.ville" class="col-span-2">
                    <a-input class="w-full" v-model:value="form.ville" size="large" placeholder="Ville"/>
                </form-item>

                <form-item has-feedback label="Pays" :help="form.errors.pays" class="col-span-2">
                    <a-input class="w-full" v-model:value="form.pays" size="large" placeholder="Pays"/>
                </form-item>
            </div>

            <a-flex justify="start" gap="small" class="mt-2 ms-1.5">
                <a-button v-if="can('societe.update')" @click="update" class="uppercase" type="primary" :loading="form.processing">
                    Enrégistrer les modifications
                </a-button>
            </a-flex>
        </a-form>

    </a-card>

</template>
