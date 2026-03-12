-- Table des avis (notation + commentaire) sur les escape games.
-- Un utilisateur (id_client) ne peut déposer qu'un seul avis par escape (mis à jour s'il reposte).

CREATE TABLE IF NOT EXISTS avis_escape (
  id_avis INT AUTO_INCREMENT PRIMARY KEY,
  id_escape INT NOT NULL,
  id_client INT NOT NULL,
  note TINYINT NOT NULL CHECK (note >= 1 AND note <= 5),
  commentaire TEXT,
  date_avis DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY unique_avis_escape_client (id_escape, id_client),
  FOREIGN KEY (id_escape) REFERENCES escape_game(id_escape) ON DELETE CASCADE,
  FOREIGN KEY (id_client) REFERENCES client(id_client) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
