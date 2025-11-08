**Titre du projet :** Application web de gestion de collecte et de commerce de vanille  
**Technologie :** Laravel 11 (backend) + Inertia.js + Vue 3 (frontend) + MySQL  
**Objectif :** Créer une application complète, performante et intuitive pour la gestion des achats, ventes, paiements, stocks et factures de vanille, avec support des **types de vanille** et **unités de mesure dynamiques**.

---

## ⚙️ 1. Modules principaux

### 🧾 1.1 Gestion des fournisseurs
- Ajouter, modifier, supprimer un fournisseur.  
- Champs : nom, prénom, adresse, contact, CIN, région, solde.  
- Liste des fournisseurs avec affichage du **solde** (crédit ou dette).  
- Accès à l’historique des achats et paiements liés à chaque fournisseur.

---

### 🧾 1.2 Gestion des types de vanille
- Créer, modifier et supprimer un **type de vanille**.  
- Champs :  
  - Nom du type (ex. Vanille Noire, Vanille Rouge, etc.)  
  - Description  
  - **Prix unitaire prévisionnel par unité de mesure** (ex. 150 000 Ar/kg ou 150 Ar/g).  
- Permet de définir des **prix de référence** à utiliser automatiquement lors d’un achat ou d’une vente, mais modifiables si besoin.  
- Possibilité d’activer/désactiver un type de vanille (archivage).

---

### 💰 1.3 Gestion des achats (auprès des fournisseurs)
- Enregistrer un achat de vanille avec :  
  - Date d’achat  
  - Fournisseur sélectionné  
  - **Type de vanille** (liste déroulante)  
  - **Quantité**  
  - **Unité de mesure dynamique** (kg, g, tonne, etc.)  
  - **Prix unitaire (prérempli selon type + unité, modifiable)**  
  - Montant total (quantité × prix unitaire)  
  - Paiement initial (partiel ou total)  
  - Reste à payer (calcul automatique)  
  - Statut : *Payé / Partiel / Non payé*  
- Génération automatique d’une **facture d’achat PDF**.  
- Mise à jour automatique du **stock** (entrée).  

---

### 💳 1.4 Paiements fournisseurs
- Enregistrer un paiement pour une facture fournisseur.  
- Historique complet des paiements (date, montant, mode de paiement).  
- Mise à jour automatique du **solde fournisseur** et du statut de la facture.

---

### 👥 1.5 Gestion des clients
- Ajouter, modifier, supprimer un client.  
- Champs : nom, entreprise, adresse, contact, NIF/STAT, e-mail, solde.  
- Historique des ventes et paiements.  
- Liste avec solde client (montant dû ou avance).

---

### 💸 1.6 Gestion des ventes (aux clients)
- Enregistrer une vente de vanille avec :  
  - Date de vente  
  - Client sélectionné  
  - **Type de vanille**  
  - **Quantité vendue**  
  - **Unité de mesure dynamique**  
  - **Prix unitaire prévisionnel** (chargé automatiquement selon type et unité, mais modifiable)  
  - Montant total automatique  
  - Paiement initial (partiel ou total)  
  - Reste à payer (calcul automatique)  
  - Statut : *Payé / Partiel / Non payé*  
- Génération automatique d’une **facture client PDF**.  
- Mise à jour automatique du **stock** (sortie).

---

### 💵 1.7 Paiements clients
- Enregistrer un paiement complémentaire pour une facture.  
- Historique des paiements clients (date, montant, mode).  
- Mise à jour du solde client et du statut de la facture.

---

### 📦 1.8 Gestion des stocks
- Suivi du **stock global** et **stock par type de vanille**.  
- Chaque achat = entrée / chaque vente = sortie.  
- Gestion multi-unité (conversion automatique selon ratio).  
- Alerte lorsque le stock total ou celui d’un type tombe sous un seuil défini.  
- Ajustement manuel possible avec justification.

---

### 📊 1.9 Tableau de bord (Dashboard)
- Vue globale avec :
  - Total des achats et ventes du mois  
  - Montant dû aux fournisseurs / dû par les clients  
  - Stock total et par type  
  - Profit brut (ventes - achats)  
- Graphiques interactifs :
  - Évolution du stock  
  - Répartition des ventes par type de vanille  
  - Répartition des achats par fournisseur  

---

### ⚙️ 1.10 Paramètres
- Gestion des **unités de mesure** (ex. kg, g, tonne, litre, etc.) avec ratio de conversion.  
- Configuration du **stock minimum d’alerte**.  
- Informations de l’entreprise (nom, logo, adresse) pour les factures.  
- Préfixes automatiques des factures (ex. FAC-ACH-2025-0001, FAC-VTE-2025-0001).

---

## 🗄️ 2. Structure MySQL

**Tables principales :**
- `fournisseurs (id, nom, contact, adresse, cin, region, solde, created_at, updated_at)`  
- `clients (id, nom, entreprise, contact, adresse, nif, solde, created_at, updated_at)`  
- `types_vanille (id, nom, description, actif, created_at, updated_at)`  
- `prix_previsionnels (id, type_vanille_id, unite_id, prix_achat_previsionnel, prix_vente_previsionnel, created_at, updated_at)`  
- `achats (id, fournisseur_id, type_vanille_id, unite_id, date, quantite, prix_unitaire, total, avance, reste, statut, facture_num, created_at, updated_at)`  
- `ventes (id, client_id, type_vanille_id, unite_id, date, quantite, prix_unitaire, total, avance, reste, statut, facture_num, created_at, updated_at)`  
- `paiements_fournisseurs (id, achat_id, montant, date, mode_paiement, note, created_at, updated_at)`  
- `paiements_clients (id, vente_id, montant, date, mode_paiement, note, created_at, updated_at)`  
- `stocks (id, type_vanille_id, type_mouvement, reference_id, quantite, unite_id, commentaire, created_at)`  
- `unites_mesure (id, nom, symbole, ratio_base)`  
- `parametres (clé, valeur)`  

---

## 🎨 3. Interface (Inertia + Vue 3 + Tailwind)
- Layout principal avec barre latérale : Tableau de bord, Fournisseurs, Achats, Paiements fournisseurs, Clients, Ventes, Paiements clients, Types de vanille, Stocks, Paramètres.  
- Barre supérieure : recherche, utilisateur connecté, bouton “Nouvelle transaction”.  
- Interfaces modernes et réactives (Vue 3 + Tailwind).  
- Calcul dynamique du montant total selon type, unité, prix et quantité.

---

## 🧾 4. Facturation
- Génération PDF (via `barryvdh/laravel-dompdf`).  
- Factures achat et vente avec informations complètes.  
- Numérotation automatique et option d’envoi par e-mail.

---

## 🔐 5. Authentification et rôles
- Authentification Laravel Breeze + Inertia.js.  
- Rôles : Admin, Agent achat, Agent vente, Comptable.

---

## 🎯 Objectif final
Créer une application professionnelle permettant de :
- gérer fournisseurs, clients, types de vanille, unités dynamiques,  
- suivre achats, ventes, paiements partiels/totaux,  
- gérer stock multi-type et multi-unité,  
- produire automatiquement des factures PDF,  
- visualiser statistiques et performance commerciale.
