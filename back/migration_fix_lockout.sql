-- Migration à exécuter si la base lockout existe déjà et a été modifiée par erreur
-- (coordonnées GPS en décimal, clés primaires manquantes)

USE lockout;

-- 1) Corriger longitude/latitude : passer de INT à DECIMAL pour les coordonnées GPS
ALTER TABLE `escape_game`
  MODIFY `longitude` decimal(10,7) NOT NULL,
  MODIFY `latitude` decimal(10,7) NOT NULL;

-- 2) Ajouter la clé primaire sur acheter si elle n'existe pas
ALTER TABLE `acheter`
  ADD PRIMARY KEY (`id_client`, `id_version`, `date`, `heure`);

-- 3) Ajouter la clé primaire sur mettre_favoris_version si elle n'existe pas
ALTER TABLE `mettre_favoris_version`
  ADD PRIMARY KEY (`id_client`, `id_version`);
