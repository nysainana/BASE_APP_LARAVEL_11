<template>
    <div class="relative mx-auto sm:ms-3 bg-white rounded-full p-2 shadow">
        <avatar
            :src="societe.logo"
            :size="130"
            icon="fa-building"
        />

        <a-upload
            v-if="can('societe.logo.upload')"
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
import {defineProps} from "vue";
import {can} from "@/Utils/functions.js";

const props = defineProps({
    societe: {
        type: Object,
        required: true
    }
})

const beforeUpload = file => {
    router.post(route('societe.logo.upload', {societe: props.societe.id}), {logo_file: file}, {
        onSuccess: (page) => {

        }
    })
    return false;
};

</script>

<style>

</style>
