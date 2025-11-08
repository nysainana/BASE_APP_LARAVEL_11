<template>
    <div class="relative mx-auto sm:ms-3 bg-white rounded-full p-2 shadow">
        <avatar
            :src="$page.props.auth.user.avatar"
            :color="$page.props.auth.user.color"
            :size="130"
            icon="fa-circle-user"
        />

        <a-upload
            class="absolute top-[100px] right-0"
            :multiple="false"
            accept="image/png, image/jpeg"
            list-type="picture"
            :maxCount="1"
            :show-upload-list="false"
            :before-upload="beforeUpload"
        >
            <a-button class="!shadow !p-2 rounded-full bg-white border-0">
                <div class="flex text-gray-600">
                    <font-awesome-icon icon="fa-solid fa-camera"/>
                </div>
            </a-button>
        </a-upload>
    </div>
</template>

<script setup>
import Avatar from '@/Components/Avatar.vue';
import {router} from '@inertiajs/vue3';

const beforeUpload = file => {
    router.post(route('profile.avatar'), {avatar_file: file}, {
        onSuccess: (page) => {

        }
    })
    return false;
};

</script>

<style>

</style>
