<template>
    <div class="relative overflow-hidden bg-gradient-to-br from-primary/5 via-white to-primary/10 main-rounded main-shadow">
        <!-- Éléments décoratifs en arrière-plan -->
        <div class="absolute top-0 right-0 w-64 h-64 bg-gradient-to-br from-primary/20 to-primary/30 rounded-full blur-3xl opacity-30 -mr-32 -mt-32"></div>
        <div class="absolute bottom-0 left-0 w-48 h-48 bg-gradient-to-tr from-primary/15 to-primary/25 rounded-full blur-3xl opacity-30 -ml-24 -mb-24"></div>

        <!-- Contenu principal -->
        <div class="relative px-8 py-5 md:px-12 md:py-7 text-left">
            <!-- Titre principal -->
            <h3 class="text-4xl md:text-5xl font-bold text-text-primary mb-4">
                Bonjour
                <span class="bg-gradient-to-r from-primary to-primary/70 bg-clip-text text-transparent">
                    {{ userName }}
                </span>
                👋
            </h3>

            <!-- Sous-titre -->
            <p class="text-xl text-gray-700 font-medium mb-3">
                Ravis de vous revoir ! Voici un aperçu de votre activité.
            </p>

            <!-- Description -->
            <p class="text-gray-600 text-base mb-6">
                Consultez les métriques importantes de votre entreprise et accédez rapidement aux fonctionnalités essentielles.
            </p>

            <!-- Info complémentaire -->
            <div class="mt-6 pt-5 md:pt-7 border-t border-gray-200">
                <p class="text-sm text-gray-500 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Utilisez le menu de navigation pour explorer toutes les sections
                </p>
            </div>
        </div>
    </div>
</template>

<script setup>
defineProps({
    userName: {
        type: String,
        default: 'Utilisateur',
    },
});
</script>
