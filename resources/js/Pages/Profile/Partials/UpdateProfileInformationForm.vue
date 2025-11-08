<script setup>
import FormItem from "@/Components/Form/FormItem.vue";
import { useForm, usePage } from '@inertiajs/vue3';
import UploadProfilAvatar from "./UploadProfilAvatar.vue";

const user = usePage().props.auth.user;

const form = useForm({
    name: user.name,
    email: user.email,
    tel: user.tel,
});
</script>

<template>

    <a-card class="main-card !overflow-visible">
        <div class="flex -mt-[90px] sm:-mt-[105px]">
            <upload-profil-avatar />
        </div>

        <a-card-meta class="!mt-7" description="Mettez à jour les informations de profil de votre compte ainsi que votre adresse e-mail." />

        <div class="mt-7">
            <a-form layout="vertical">
                <div class="md:grid md:grid-cols-2 md:gap-x-4">
                    <form-item label="Nom" :help="form.errors.name" required>
                        <a-input v-model:value="form.name" size="large" placeholder="Nom"/>
                    </form-item>

                    <div></div>

                    <form-item label="E-mail" :help="form.errors.email" required>
                        <a-input v-model:value="form.email" size="large" placeholder="E-mail"/>
                    </form-item>

                    <form-item label="Téléphone" :help="form.errors.tel">
                        <a-input v-model:value="form.tel" size="large" placeholder="Téléphone"/>
                    </form-item>
                </div>

                <a-flex justify="start" gap="small" class="mt-2 ms-1.5">
                    <a-button @click="form.patch(route('profile.update'))" class="uppercase" type="primary" :loading="form.processing">
                        Enrégistrer les modifications
                    </a-button>
                </a-flex>
            </a-form>
        </div>

    </a-card>
</template>
