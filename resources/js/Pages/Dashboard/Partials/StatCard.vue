<script setup>
import { computed } from 'vue';

const props = defineProps({
    title: String,
    value: [String, Number],
    icon: String,
    footer: String,
    color: {
        type: String,
        default: 'blue',
        validator: (value) => [
            'blue', 'green', 'red', 'yellow',
            'indigo', 'purple', 'pink', 'orange',
            'emerald', 'teal', 'cyan', 'sky',
            'violet', 'fuchsia', 'rose', 'amber'
        ].includes(value)
    },
    trend: {
        type: String,
        validator: (value) => ['up', 'down', 'neutral'].includes(value)
    }
});

const colorClasses = computed(() => {
    const colorMap = {
        blue: {
            bg: 'bg-gradient-to-br from-blue-500/10 to-blue-600/20',
            iconGradient: 'bg-gradient-to-br from-blue-400 to-blue-600'
        },
        green: {
            bg: 'bg-gradient-to-br from-green-500/10 to-green-600/20',
            iconGradient: 'bg-gradient-to-br from-green-400 to-green-600'
        },
        red: {
            bg: 'bg-gradient-to-br from-red-500/10 to-red-600/20',
            iconGradient: 'bg-gradient-to-br from-red-400 to-red-600'
        },
        yellow: {
            bg: 'bg-gradient-to-br from-yellow-500/10 to-yellow-600/20',
            iconGradient: 'bg-gradient-to-br from-yellow-400 to-yellow-600'
        },
        indigo: {
            bg: 'bg-gradient-to-br from-indigo-500/10 to-indigo-600/20',
            iconGradient: 'bg-gradient-to-br from-indigo-400 to-indigo-600'
        },
        purple: {
            bg: 'bg-gradient-to-br from-purple-500/10 to-purple-600/20',
            iconGradient: 'bg-gradient-to-br from-purple-400 to-purple-600'
        },
        pink: {
            bg: 'bg-gradient-to-br from-pink-500/10 to-pink-600/20',
            iconGradient: 'bg-gradient-to-br from-pink-400 to-pink-600'
        },
        orange: {
            bg: 'bg-gradient-to-br from-orange-500/10 to-orange-600/20',
            iconGradient: 'bg-gradient-to-br from-orange-400 to-orange-600'
        },
    };
    return colorMap[props.color] || colorMap.blue;
});
</script>

<template>
    <div class="group relative overflow-hidden main-shadow main-rounded transition-all duration-300 hover:shadow-lg"
         :class="colorClasses.bg">

        <!-- Contenu principal -->
        <div class="relative p-6">
            <div class="flex justify-between items-start">
                <div class="flex-1">
                    <p class="text-sm font-semibold text-gray-600 mb-3 tracking-wide uppercase">{{ title }}</p>
                    <div class="flex items-baseline gap-2">
                        <p class="text-4xl font-bold text-gray-800">
                            {{ value }}
                        </p>
                        <!-- Indicateur de tendance -->
                        <div v-if="trend" class="flex items-center gap-1">
                            <div class="w-2 h-2 rounded-full" :class="{
                                'bg-emerald-500 animate-pulse': trend === 'up',
                                'bg-red-500 animate-pulse': trend === 'down',
                                'bg-gray-400': trend === 'neutral'
                            }"></div>
                        </div>
                    </div>
                </div>

                <!-- Icône avec gradient -->
                <div class="relative">
                    <div class="h-12 w-12 rounded-full flex items-center justify-center transition-transform duration-300"
                         :class="colorClasses.iconGradient">
                        <font-awesome-icon :icon="icon" class="h-5 w-5 text-white" />
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div v-if="footer || $slots.footer" class="mt-6 pt-4 border-t border-gray-200/40">
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-600 font-medium">
                        <slot name="footer">
                            {{ footer }}
                        </slot>
                    </span>
                </div>
            </div>
        </div>
    </div>
</template>
