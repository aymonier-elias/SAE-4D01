-- Migration : 3 packs par escape (Télégraphe, Archive, Immersion)
-- À exécuter sur la base existante

-- Ajouter nom et description à la table version
ALTER TABLE `version`
  ADD COLUMN `nom` VARCHAR(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL AFTER `id_version`,
  ADD COLUMN `description` TEXT COLLATE utf8mb4_unicode_ci DEFAULT NULL AFTER `nom`;

-- Mettre à jour la version existante (id_version=1) en Pack Télégraphe
UPDATE `version` SET
  `nom` = 'Pack Télégraphe',
  `description` = 'Immersion Digitale : Votre smartphone est votre seul outil de décryptage.',
  `prix` = 10
WHERE `id_version` = 1 AND `id_escape` = 1;

-- Ajouter Pack Archive et Pack Immersion pour l'escape 1
INSERT INTO `version` (`durée`, `prix`, `id_escape`, `nom`, `description`) VALUES
('1h', 15, 1, 'Pack Archive', 'Vous imprimez vous-même vos documents pour une expérience personnalisée.'),
('1h', 25, 1, 'Pack Immersion', 'Mis en place par l\'équipe avec de vrais objets pour une immersion totale.');
