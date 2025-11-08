<script setup>
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import FormItem from "@/Components/Form/FormItem.vue";

const passwordInput = ref(null);
const currentPasswordInput = ref(null);

const form = useForm({
    current_password: '',
    password: '',
    password_confirmation: '',
});

const updatePassword = () => {
    form.put(route('password.update'), {
        onSuccess: () => form.reset(),
        onError: () => {
            if (form.errors.password) {
                form.reset('password', 'password_confirmation');
                passwordInput.value.focus();
            }
            if (form.errors.current_password) {
                form.reset('current_password');
                currentPasswordInput.value.focus();
            }
        },
    });
};
</script>

<template>

    <a-card class="main-card" title="Modification du mot de passe">

        <a-card-meta description="Changez votre mot de passe." />

        <div class="mt-7">
            <a-form layout="vertical">
                <div class="md:grid md:grid-cols-2 md:gap-x-4">
                    <form-item label="Mot de passe actuel" :help="form.errors.current_password" required>
                        <a-input-password ref="currentPasswordInput" v-model:value="form.current_password" size="large" placeholder="Mot de passe actuel"/>
                    </form-item>

                    <div></div>

                    <form-item label="Nouveau mot de passe" :help="form.errors.password" required>
                        <a-input-password ref="passwordInput" v-model:value="form.password" size="large" placeholder="Nouveau mot de passe"/>
                    </form-item>

                    <form-item label="Confirmer le mot de passe" :help="form.errors.password_confirmation" required>
                        <a-input-password v-model:value="form.password_confirmation" size="large" placeholder="Confirmer le mot de passe"/>
                    </form-item>
                </div>

                <a-flex justify="start" gap="small" class="mt-2 ms-1.5">
                    <a-button @click="updatePassword" class="uppercase" type="primary" :loading="form.processing">
                        Enrégistrer
                    </a-button>
                </a-flex>
            </a-form>
        </div>
    </a-card>

</template>
