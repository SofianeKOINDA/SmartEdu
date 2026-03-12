# 📌 DIRECTIVES DU PROJET — SAAS GESTION UNIVERSITAIRE

## 🎯 Nature du projet
Application SaaS multi-tenant de gestion universitaire développée en **Laravel 12**.
Chaque université est un **tenant** isolé avec ses propres données.

---

## 🏗️ Architecture choisie

### Multi-tenancy
- Stratégie : **colonne `tenant_id`** sur toutes les tables principales
- Isolation automatique via le **Trait `BelongsToTenant`** (`app/Traits/BelongsToTenant.php`)
- Le `tenant_id` est injecté automatiquement à la création et filtré automatiquement à la lecture

### Héritage des utilisateurs
- Stratégie : **Table par entité**
- Table `users` = base commune (nom, prénom, email, password, role)
- Table `enseignants` = données métier enseignant (grade, spécialité, bureau, département)
- Table `etudiants` = données métier étudiant (numéro, promotion, date naissance)
- Les autres rôles (recteur, doyen, chef_departement, super_admin) n'ont **pas** de table séparée car ils n'ont pas de données métier propres

---

## 👥 Rôles utilisateurs

```
super_admin       → gère toutes les universités (SaaS owner)
recteur           → gère son université (tenant)
                    fixe le coût annuel de scolarité
doyen             → gère sa faculté
chef_departement  → gère son département
                    crée et gère l'emploi du temps
                    crée les séances, affecte enseignants et étudiants
enseignant        → voit ses cours et les étudiants dedans
                    gère présences, évaluations, notes
vacataire         → idem enseignant (grade = vacataire dans table enseignants)
etudiant          → lecture seule sur ses propres données
                    voit ses échéances mensuelles
                    paie via PayTech
```

---

## 🗄️ Tables & ordre de migration

```
1.  plans
2.  tenants
3.  abonnements
4.  users
5.  facultes
6.  departements
7.  filieres
8.  annees_scolaires
9.  promotions
10. semestres
11. ues
12. enseignants
13. etudiants
14. cours
15. inscriptions_pedagogiques
16. evaluations
17. notes
18. presences
19. tarifs
20. echeances
21. transactions
22. seances
23. paiements
24. deliberations
25. demandes
```

---

## 💳 Système de paiement (PayTech)

### Flux complet
```
Recteur fixe le coût annuel via un Tarif
        ↓
Événement Tarif::created → EcheanceService génère automatiquement
les échéances mensuelles pour TOUS les étudiants actifs du tenant
        ↓
Étudiant voit dans son onglet Paiements :
  - Numéro de l'échéance (Mois 1, Mois 2...)
  - Montant dû
  - Date limite
  - Statut (en_attente / paye / retard)
  - Bouton "Payer" si non payé
        ↓
Clic sur "Payer" → PayTechService::initierPaiement()
        ↓
Redirection vers page PayTech (Orange Money, Wave, CB...)
        ↓
Webhook PayTech → POST /webhooks/paytech
        ↓
PayTechService::traiterWebhook() → marque échéance comme payée
```

### Règles métier paiement
- Le montant mensuel = `montant_total / nombre_echeances` (arrondi à 2 décimales)
- Quand un nouveau tarif est créé, les échéances sont générées pour **tous les étudiants actifs**
- Si un nouvel étudiant s'inscrit après la création du tarif → `EcheanceService::genererPourEtudiant()` est appelé manuellement
- Un étudiant ne peut payer qu'une échéance à la fois
- Le webhook PayTech est la **seule source de vérité** pour confirmer un paiement

### Variables d'environnement requises
```env
PAYTECH_API_KEY=
PAYTECH_API_SECRET=
PAYTECH_ENV=test
```

---

## 📅 Emploi du temps (Chef de département)

### Flux complet
```
Chef de département :
  1. Crée une Séance (cours + enseignant + promotion + salle + jour + heure)
  2. Affecte les étudiants à une promotion
  3. Affecte un enseignant à un cours
        ↓
Enseignant voit son planning de la semaine
Étudiant voit l'emploi du temps de sa promotion
```

### Règles métier emploi du temps
- Pas deux séances dans la **même salle** au même créneau
- Pas un **même enseignant** dans deux séances au même créneau
- Pas une **même promotion** dans deux séances au même créneau
- Une séance peut être **récurrente** (chaque semaine) ou **ponctuelle** (date spécifique)
- Les conflits sont vérifiés dans `EmploiDuTempsService` **avant** insertion en base

---

## 📐 Schéma SQL des nouvelles tables

### tarifs
```sql
CREATE TABLE tarifs (
    id                BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    tenant_id         BIGINT UNSIGNED NOT NULL,
    annee_scolaire_id BIGINT UNSIGNED NOT NULL,
    montant_total     DECIMAL(10,2) NOT NULL,
    nombre_echeances  INT NOT NULL DEFAULT 9,
    jour_limite       INT NOT NULL DEFAULT 5,
    cree_par          BIGINT UNSIGNED NOT NULL,
    created_at        TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at        TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    UNIQUE KEY uq_tarif (tenant_id, annee_scolaire_id),

    CONSTRAINT fk_tarif_tenant   FOREIGN KEY (tenant_id)         REFERENCES tenants(id)          ON DELETE CASCADE,
    CONSTRAINT fk_tarif_annee    FOREIGN KEY (annee_scolaire_id) REFERENCES annees_scolaires(id) ON DELETE RESTRICT,
    CONSTRAINT fk_tarif_recteur  FOREIGN KEY (cree_par)          REFERENCES users(id)             ON DELETE RESTRICT,
    CONSTRAINT chk_jour_limite   CHECK (jour_limite BETWEEN 1 AND 28),
    CONSTRAINT chk_nb_echeances  CHECK (nombre_echeances BETWEEN 1 AND 12)
);
```

### echeances
```sql
CREATE TABLE echeances (
    id            BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    tenant_id     BIGINT UNSIGNED NOT NULL,
    etudiant_id   BIGINT UNSIGNED NOT NULL,
    tarif_id      BIGINT UNSIGNED NOT NULL,
    numero_mois   INT NOT NULL,
    montant       DECIMAL(10,2) NOT NULL,
    date_limite   DATE NOT NULL,
    statut        ENUM('en_attente','paye','retard') NOT NULL DEFAULT 'en_attente',
    created_at    TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at    TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    UNIQUE KEY uq_echeance (etudiant_id, tarif_id, numero_mois),

    CONSTRAINT fk_ech_tenant FOREIGN KEY (tenant_id)   REFERENCES tenants(id)   ON DELETE CASCADE,
    CONSTRAINT fk_ech_etu    FOREIGN KEY (etudiant_id) REFERENCES etudiants(id) ON DELETE CASCADE,
    CONSTRAINT fk_ech_tarif  FOREIGN KEY (tarif_id)    REFERENCES tarifs(id)    ON DELETE CASCADE
);
```

### transactions
```sql
CREATE TABLE transactions (
    id              BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    tenant_id       BIGINT UNSIGNED NOT NULL,
    echeance_id     BIGINT UNSIGNED NOT NULL,
    etudiant_id     BIGINT UNSIGNED NOT NULL,
    reference       VARCHAR(100) NOT NULL UNIQUE,
    montant         DECIMAL(10,2) NOT NULL,
    statut          ENUM('initie','succes','echec','annule') NOT NULL DEFAULT 'initie',
    paytech_token   VARCHAR(255) NULL,
    paytech_ref     VARCHAR(255) NULL,
    paye_le         DATETIME NULL,
    created_at      TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at      TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    CONSTRAINT fk_tr_tenant FOREIGN KEY (tenant_id)   REFERENCES tenants(id)   ON DELETE CASCADE,
    CONSTRAINT fk_tr_ech    FOREIGN KEY (echeance_id) REFERENCES echeances(id) ON DELETE RESTRICT,
    CONSTRAINT fk_tr_etu    FOREIGN KEY (etudiant_id) REFERENCES etudiants(id) ON DELETE RESTRICT
);
```

### seances
```sql
CREATE TABLE seances (
    id               BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    tenant_id        BIGINT UNSIGNED NOT NULL,
    cours_id         BIGINT UNSIGNED NOT NULL,
    promotion_id     BIGINT UNSIGNED NOT NULL,
    salle            VARCHAR(50) NULL,
    jour             ENUM('lundi','mardi','mercredi','jeudi','vendredi','samedi') NOT NULL,
    heure_debut      TIME NOT NULL,
    heure_fin        TIME NOT NULL,
    type             ENUM('cm','td','tp') NOT NULL DEFAULT 'cm',
    recurrent        BOOLEAN NOT NULL DEFAULT TRUE,
    date_specifique  DATE NULL,
    created_at       TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at       TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    UNIQUE KEY uq_salle_horaire (tenant_id, salle, jour, heure_debut),

    CONSTRAINT fk_seance_tenant FOREIGN KEY (tenant_id)    REFERENCES tenants(id)    ON DELETE CASCADE,
    CONSTRAINT fk_seance_cours  FOREIGN KEY (cours_id)     REFERENCES cours(id)      ON DELETE CASCADE,
    CONSTRAINT fk_seance_promo  FOREIGN KEY (promotion_id) REFERENCES promotions(id) ON DELETE CASCADE,

    CONSTRAINT chk_seance_date CHECK (
        (recurrent = TRUE  AND date_specifique IS NULL) OR
        (recurrent = FALSE AND date_specifique IS NOT NULL)
    )
);
```

---

## 📁 Structure des dossiers

```
app/
├── Traits/
│   └── BelongsToTenant.php
│
├── Policies/
│   ├── Traits/
│   │   └── PolicyHelpers.php
│   ├── TenantPolicy.php
│   ├── FacultePolicy.php
│   ├── DepartementPolicy.php
│   ├── FilierePolicy.php
│   ├── AnneeScolairePolicy.php
│   ├── PromotionPolicy.php
│   ├── SemestrePolicy.php
│   ├── UEPolicy.php
│   ├── EnseignantPolicy.php
│   ├── EtudiantPolicy.php
│   ├── CoursPolicy.php
│   ├── EvaluationPolicy.php
│   ├── NotePolicy.php
│   ├── PresencePolicy.php
│   ├── TarifPolicy.php
│   ├── EcheancePolicy.php
│   ├── SeancePolicy.php
│   ├── DeliberationPolicy.php
│   └── DemandePolicy.php
│
├── Services/
│   ├── EcheanceService.php
│   ├── PayTechService.php
│   ├── EmploiDuTempsService.php
│   ├── BulletinService.php
│   └── DeliberationService.php
│
├── Models/
│   ├── User.php
│   ├── Tenant.php
│   ├── Plan.php
│   ├── Abonnement.php
│   ├── Faculte.php
│   ├── Departement.php
│   ├── Filiere.php
│   ├── AnneeScolaire.php
│   ├── Promotion.php
│   ├── Semestre.php
│   ├── UE.php
│   ├── Enseignant.php
│   ├── Etudiant.php
│   ├── Cours.php
│   ├── InscriptionPedagogique.php
│   ├── Evaluation.php
│   ├── Note.php
│   ├── Presence.php
│   ├── Tarif.php
│   ├── Echeance.php
│   ├── Transaction.php
│   ├── Seance.php
│   ├── Paiement.php
│   ├── Deliberation.php
│   └── Demande.php
│
└── Http/
    ├── Controllers/
    │   ├── SuperAdmin/
    │   │   └── TenantController.php
    │   ├── Recteur/
    │   │   ├── TarifController.php
    │   │   └── DashboardController.php
    │   ├── Doyen/
    │   │   └── FaculteController.php
    │   ├── ChefDepartement/
    │   │   ├── SeanceController.php
    │   │   ├── PromotionController.php
    │   │   └── EmploiDuTempsController.php
    │   ├── Enseignant/
    │   │   ├── CoursController.php
    │   │   ├── PresenceController.php
    │   │   ├── EvaluationController.php
    │   │   └── NoteController.php
    │   └── Etudiant/
    │       ├── EcheanceController.php
    │       └── EmploiDuTempsController.php
    │
    ├── Requests/
    │   └── (StoreXxxRequest + UpdateXxxRequest par modèle)
    │
    └── Webhooks/
        └── PayTechWebhookController.php
```

---

## 🔑 Conventions de nommage

| Élément | Convention | Exemple |
|---|---|---|
| Tables | snake_case pluriel | `annees_scolaires` |
| Modèles | PascalCase singulier | `AnneeScolaire` |
| Controllers | PascalCase + Controller | `AnneeScolaireController` |
| Policies | PascalCase + Policy | `AnneeScolairePolicy` |
| Services | PascalCase + Service | `PayTechService` |
| Migrations | timestamp + snake_case | `2024_01_01_create_ues_table` |
| FK | nom_table_singulier_id | `enseignant_id`, `ue_id` |

---

## 📦 Packages requis

```bash
composer require spatie/laravel-permission
composer require spatie/laravel-activitylog
composer require barryvdh/laravel-dompdf
composer require maatwebsite/excel
```

---

## ⚠️ Règles importantes

1. **Ne jamais** faire une requête sans le scope tenant — le trait s'en occupe automatiquement
2. **Ne jamais** mettre de logique métier dans les controllers → utiliser les **Services**
3. **Toujours** valider les données via les **Form Requests**, jamais directement dans le controller
4. **Toujours** vérifier les permissions via `$this->authorize()` dans chaque action du controller
5. **Respecter l'ordre des migrations** pour éviter les erreurs de clés étrangères
6. La table `users` utilise déjà Laravel Auth (`Authenticatable`) — ne pas la recréer, la modifier
7. La route `/webhooks/paytech` doit être **exclue du middleware CSRF** dans `VerifyCsrfToken.php`
8. Le webhook PayTech est la **seule source de vérité** pour valider un paiement — ne jamais marquer une échéance comme payée sans passer par lui
9. Les conflits de séances (salle, enseignant, promotion) sont vérifiés dans `EmploiDuTempsService` **avant** toute insertion en base
10. Quand un tarif est créé → `EcheanceService::genererPourTousLesEtudiants()` est déclenché automatiquement via l'événement `Tarif::created`
11. Quand un nouvel étudiant est créé → vérifier s'il existe un tarif actif et appeler `EcheanceService::genererPourEtudiant()` via l'événement `Etudiant::created`
