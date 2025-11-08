<template>

    <a-card id="image-upload" class="px-0 py-0" style="min-width: 200px;">
        <template #cover>
            <div class="p-1">
                <a-image
                    :height="150"
                    width="100%"
                    :src="image"
                    :preview="false"
                    class="object-contain"
                    fallback="/img/placeholder_img.png" />
            </div>
        </template>
        <template #actions>
            <a-upload
                :multiple="false"
                accept="image/png, image/jpeg, image/svg+xml"
                list-type="picture"
                :maxCount="1"
                :show-upload-list="false"
                :before-upload="beforeUpload"
            >
                <a-button type="link" class="hover:!shadow-none">
                    <div class="flex items-top gap-x-2 text-gray-800 hover:!text-primary">
                        <font-awesome-icon icon="fa-solid fa-upload"/>
                        <span>Choisir un fichier</span>
                    </div>
                </a-button>
            </a-upload>
        </template>
    </a-card>
</template>

<script setup>

import {ref, watch, defineEmits} from "vue";

const emit = defineEmits('onChange')
const props = defineProps({
    url: {
        type: String,
        default: ''
    },
    size: {
        type: Number,
        default: 100
    },
    color: {
        type: String,
        default: 'gray'
    },
    icon: {
        logo: String,
        default: 'fa-circle-dot'
    },
})
const image = ref(props.url ?? '')

watch(props, (newValue) => {
    image.value = newValue.url ?? ''
})

function getBase64(img, callback) {
    const reader = new FileReader();
    reader.addEventListener('load', () => callback(reader.result));
    reader.readAsDataURL(img);
}

const beforeUpload = file => {
    getBase64(file, (base64) => {
        image.value = base64
        emit('onChange', file)
    });
    return false;
};

const onRemove = () => {
    image.value = props.url ?? ''
    emit('onChange', null)
}

</script>

<style>

#image-upload .ant-image {
    @apply !rounded-t-md overflow-hidden;
}

#image-upload .ant-card-actions{
    @apply py-1;
}

#image-upload .ant-card-actions li{
    @apply my-0;
}

#image-upload .ant-card-actions li > span{
    @apply cursor-default;
}

</style>
