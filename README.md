# BASE APP LARAVEL 11

Application de base Laravel 11 avec Inertia.js, Vue 3, et Ant Design Vue. Cette base inclut un système d'authentification complet, la gestion des utilisateurs et des rôles avec permissions, ainsi qu'une interface d'administration moderne et responsive.

## 📋 Table des matières

- [Technologies](#-technologies)
- [Fonctionnalités](#-fonctionnalités)
- [Prérequis](#-prérequis)
- [Installation](#-installation)
- [Configuration](#-configuration)
- [Structure du projet](#-structure-du-projet)
- [Utilisation](#-utilisation)
- [Développement](#-développement)
- [Commandes utiles](#-commandes-utiles)

## 🚀 Technologies

### Backend
- **Laravel 11** - Framework PHP
- **Inertia.js** - Stack moderne pour SPA avec Laravel
- **Spatie Laravel Permission** - Gestion des rôles et permissions
- **Laravel Sanctum** - Authentification API
- **DomPDF** - Génération de PDF
- **Ziggy** - Utilisation des routes Laravel dans JavaScript

### Frontend
- **Vue 3** - Framework JavaScript progressif
- **Ant Design Vue 4** - Bibliothèque de composants UI
- **TailwindCSS** - Framework CSS utility-first
- **Font Awesome** - Icônes
- **Vite** - Build tool moderne
- **Axios** - Client HTTP

### Bibliothèques supplémentaires
- **ApexCharts** - Graphiques interactifs
- **FullCalendar** - Calendrier complet
- **Vue3 ColorPicker** - Sélecteur de couleurs
- **Perfect Scrollbar** - Scrollbar personnalisée
- **SortableJS** - Drag & drop
- **PrintJS** - Impression
- **DayJS** - Manipulation de dates

## ✨ Fonctionnalités

### Authentification
- ✅ Connexion / Déconnexion
- ✅ Inscription
- ✅ Réinitialisation de mot de passe
- ✅ Vérification d'email
- ✅ Confirmation de mot de passe

### Gestion des utilisateurs
- ✅ Liste des utilisateurs avec pagination et filtres
- ✅ Création / Modification / Suppression d'utilisateurs
- ✅ Attribution de rôles
- ✅ Upload et gestion d'avatar
- ✅ Profil utilisateur éditable

### Gestion des rôles et permissions
- ✅ Système de rôles dynamiques (via Spatie)
- ✅ Gestion granulaire des permissions
- ✅ Middleware automatique de vérification des permissions
- ✅ Interface d'administration des rôles

### Interface
- ✅ Dashboard moderne et responsive
- ✅ Sidebar avec menu hiérarchique
- ✅ Breadcrumb dynamique basé sur la navigation
- ✅ Layout authentifié avec système de pages configurables
- ✅ Composants réutilisables (DataTable, Forms, Filters, etc.)
- ✅ Dark mode ready

### Autres
- ✅ Gestion des informations de société
- ✅ Upload de logo de société
- ✅ Système de configuration centralisée des pages et menus

## 📦 Prérequis

- **PHP** >= 8.2
- **Composer** >= 2.0
- **Node.js** >= 18.x
- **NPM** ou **Yarn**
- **MySQL** >= 8.0 ou **PostgreSQL** >= 13
- **Git**

## 🔧 Installation

### 1. Cloner le repository

```bash
git clone <votre-repository>
cd BASE_APP_LARAVEL_11
```

### 2. Installer les dépendances PHP

```bash
composer install
```

### 3. Installer les dépendances JavaScript

```bash
npm install
```

### 4. Configurer l'environnement

```bash
cp .env.example .env
```

Éditez le fichier `.env` et configurez votre base de données :

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=votre_base_de_donnees
DB_USERNAME=votre_utilisateur
DB_PASSWORD=votre_mot_de_passe
```

### 5. Générer la clé d'application

```bash
php artisan key:generate
```

### 6. Exécuter les migrations et seeders

```bash
php artisan migrate --seed
```

Cela créera :
- Les tables de base de données
- Les permissions et rôles par défaut
- Un utilisateur administrateur
- Les informations de société par défaut

### 7. Créer le lien symbolique pour le storage

```bash
php artisan storage:link
```

### 8. Compiler les assets

**Mode développement :**
```bash
npm run dev
```

**Mode production :**
```bash
npm run build
```

## ⚙️ Configuration

### Utilisateur par défaut

Après l'exécution des seeders, vous pouvez vous connecter avec :

- **Email** : (vérifier dans `database/seeders/UserSeeder.php`)
- **Mot de passe** : (vérifier dans `database/seeders/UserSeeder.php`)

### Configuration des pages et menus

Le système utilise un fichier de configuration centralisé pour les pages et menus :

**Fichier** : `resources/js/Composables/useMenu.js`

```javascript
const pageConfig = [
    {
        label: "Dashboard",
        key: "dashboard",
        icon: "fa-solid fa-gauge",
        routeName: "dashboard",
        permission: "dashboard",
        navbarData: true, // Afficher dans le menu
    },
    // ... autres pages
];
```

### Permissions

Les permissions sont gérées via le middleware `permission.auto` qui vérifie automatiquement si l'utilisateur a la permission correspondant au nom de la route.

Pour ajouter une nouvelle permission :
1. Ajouter la permission dans `database/seeders/PermissionSeeder.php`
2. Attribuer la permission aux rôles appropriés
3. Exécuter `php artisan migrate:fresh --seed`

## 📁 Structure du projet

```
.
├── app/
│   ├── Http/
│   │   ├── Controllers/       # Contrôleurs
│   │   └── Middleware/        # Middlewares personnalisés
│   ├── Models/                # Modèles Eloquent
│   ├── Helpers/               # Fonctions helpers
│   ├── Enums/                 # Énumérations
│   ├── Traits/                # Traits réutilisables
│   └── Rules/                 # Règles de validation personnalisées
├── database/
│   ├── migrations/            # Migrations de base de données
│   └── seeders/               # Seeders
├── resources/
│   ├── js/
│   │   ├── Components/        # Composants Vue réutilisables
│   │   ├── Composables/       # Composables Vue (useMenu, etc.)
│   │   ├── Layouts/           # Layouts (AuthenticatedLayout, GuestLayout)
│   │   ├── Pages/             # Pages Inertia
│   │   ├── Utils/             # Utilitaires JavaScript
│   │   └── Theme/             # Configuration du thème
│   └── css/                   # Styles CSS
├── routes/
│   ├── web.php                # Routes web
│   └── auth.php               # Routes d'authentification
└── public/                    # Assets publics
```

## 🎯 Utilisation

### Créer une nouvelle page

1. **Créer le contrôleur** (si nécessaire) :
```bash
php artisan make:controller MonController
```

2. **Ajouter la route dans `routes/web.php`** :
```php
Route::get('/ma-page', [MonController::class, 'index'])->name('ma-page.index');
```

3. **Créer la page Vue dans `resources/js/Pages/`** :
```vue
<template>
    <AuthenticatedLayout page-key="ma-page.index">
        <!-- Votre contenu -->
    </AuthenticatedLayout>
</template>
```

4. **Ajouter la configuration dans `useMenu.js`** :
```javascript
{
    label: "Ma Page",
    key: "ma-page.index",
    icon: "fa-solid fa-star",
    routeName: "ma-page.index",
    permission: "ma-page.index",
    navbarData: true,
}
```

### Utiliser les composants

**DataTable** :
```vue
<DataTable
    :columns="columns"
    :data="data"
    :actions="actions"
    show-index
/>
```

**Formulaire modal** :
```vue
<FormModal ref="formModal" @on-ok="handleSubmit">
    <!-- Champs de formulaire -->
</FormModal>
```

**Toolbar avec recherche et filtres** :
```vue
<Toolbar :title="title">
    <Recherche v-model:value="filters.search" @on-search="reload" />
    <FilterButton @on-ok="reload" />
</Toolbar>
```

## 🛠️ Développement

### Lancer le serveur de développement

**Terminal 1** - Serveur Laravel :
```bash
php artisan serve
```

**Terminal 2** - Build Vite :
```bash
npm run dev
```

### Conventions de code

- **Backend** : Suivre les standards PSR-12
- **Frontend** : Suivre les conventions Vue 3 Composition API
- **Nommage** :
  - Composants Vue : PascalCase (`MyComponent.vue`)
  - Composables : camelCase avec préfixe `use` (`useMenu.js`)
  - Routes : kebab-case avec points (`user.index`)

### Tests

```bash
# Tests PHPUnit
php artisan test

# Tests avec couverture
php artisan test --coverage
```

## 📝 Commandes utiles

```bash
# Effacer le cache
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Recréer la base de données
php artisan migrate:fresh --seed

# Générer les routes Ziggy
php artisan ziggy:generate

# Formater le code PHP (Laravel Pint)
./vendor/bin/pint

# Optimisation pour la production
php artisan optimize
npm run build
```

## 📄 Licence

MIT License

---

**Note** : Cette application est une base de démarrage. Personnalisez-la selon vos besoins spécifiques.
