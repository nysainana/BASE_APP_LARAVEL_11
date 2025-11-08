<script setup>
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import FormItem from "@/Components/Form/FormItem.vue";

const confirmingUserDeletion = ref(false);
const passwordInput = ref(null);

const form = useForm({
    password: '',
});

const confirmUserDeletion = () => {
    confirmingUserDeletion.value = true;
};

const deleteUser = () => {
    form.delete(route('profile.destroy'), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onFinish: () => form.reset(),
    });
};

const closeModal = () => {
    form.reset();
};

</script>

<template>
    <a-card class="main-card" title="Supprimer mon compte">

        <a-card-meta
            description="Une fois votre compte supprimé, toutes ses ressources et données seront définitivement
            effacées. Avant de supprimer votre compte, veuillez télécharger toutes les
            données ou informations que vous souhaitez conserver." />

        <a-button class="mt-3 uppercase !bg-red-500" type="primary" @click="confirmUserDeletion">
            Supprimer mon compte
        </a-button>
    </a-card>

    <a-modal
        title="Êtes-vous sûr(e) de vouloir supprimer votre compte ?"
        ok-text="Supprimer mon compte"
        cancel-text="Annuler"
        :confirm-loading="form.processing"
        v-model:open="confirmingUserDeletion"
        :closable="false"
        :ok-button-props="{class: '!bg-red-500'}"
        @cancel="closeModal"
        @ok="deleteUser">

        <p>
            Une fois votre compte supprimé, toutes ses ressources et données seront définitivement
            effacées. Avant de supprimer votre compte, veuillez télécharger toutes les
            données ou informations que vous souhaitez conserver.
        </p>

        <a-form layout="vertical">
            <div class="max-w-2xl">
                <form-item :rules="[{ required: true }]" has-feedback label="Mot de passe"
                           :help="form.errors.password">
                    <a-input-password v-model:value="form.password" size="large"/>
                </form-item>
            </div>
        </a-form>

    </a-modal>

</template>
