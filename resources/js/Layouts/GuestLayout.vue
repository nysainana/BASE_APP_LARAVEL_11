<script setup>
import {Link} from '@inertiajs/vue3';
import Layout from "@/Layouts/Layout.vue";
import Avatar from "@/Components/Avatar.vue";

</script>

<template>
    <layout>
        <div class="flex min-h-screen flex-col items-center bg-gray-100 pt-6 sm:justify-center sm:pt-0">
            <div>
                <Link href="/">
                    <div class="mx-auto bg-white rounded-full p-2 shadow">
                        <Avatar
                            :src="$page.props.societe?.logo || '/logo.png'"
                            :size="150"
                        />
                    </div>
                </Link>
            </div>

            <div class="mt-6 w-full overflow-hidden px-6 py-4 sm:max-w-md sm:rounded-lg">
                <slot />
            </div>
        </div>
    </layout>
</template>
