<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Models\Permission as SpatiePermission;

class Permission extends SpatiePermission
{
    use HasFactory;

    protected $guarded = ['created_at', 'updated_at'];

    const PERMISSIONS_DATA = [
        [
            'key' => 'dashboard', 'label' => 'Dashboard', 'is_group' => true,
            'children' => [
                ['key' => 'dashboard', 'label' => 'Afficher le tableau de bord', 'routes' => ['dashboard']],
                ['key' => 'dashboard.view_user_stat', 'label' => 'Voir statistiques utilisateurs', 'routes' => ['dashboard']],
            ],
        ],
        [
            'key' => 'role-user', 'label' => 'Gestion des groupes d\'utilisateurs', 'is_group' => true,
            'children' => [
                ['key' => 'role-user.index', 'label' => 'Lister groupes', 'routes' => ['role-user.index']],
                ['key' => 'role-user.store', 'label' => 'Créer groupe', 'routes' => ['role-user.store']],
                ['key' => 'role-user.update', 'label' => 'Modifier groupe', 'routes' => ['role-user.update']],
                ['key' => 'role-user.destroy', 'label' => 'Supprimer groupe', 'routes' => ['role-user.destroy']],
            ],
        ],
        [
            'key' => 'user', 'label' => 'Gestion des utilisateurs', 'is_group' => true,
            'children' => [
                ['key' => 'user.index', 'label' => 'Lister utilisateurs', 'routes' => ['user.index']],
                ['key' => 'user.store', 'label' => 'Créer user', 'routes' => ['user.store']],
                ['key' => 'user.update', 'label' => 'Modifier user', 'routes' => ['user.update']],
                ['key' => 'user.destroy', 'label' => 'Supprimer user', 'routes' => ['user.destroy']],
            ],
        ],
        [
            'key' => 'societe', 'label' => 'Gestion de la société', 'is_group' => true,
            'children' => [
                ['key' => 'societe.edit', 'label' => 'Afficher les informations de la société', 'routes' => ['societe.edit']],
                ['key' => 'societe.update', 'label' => 'Modifier société', 'routes' => ['societe.update']],
                ['key' => 'societe.logo.upload', 'label' => 'Téléverser logo', 'routes' => ['societe.logo.upload']],
                ['key' => 'societe.logo.delete', 'label' => 'Supprimer logo', 'routes' => ['societe.logo.delete']],
            ],
        ],
    ];

}
