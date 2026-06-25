-- Mock data for local development / feature testing.
-- Runs automatically after 01-schema.sql on first DB startup.
USE journal;

SET NAMES utf8mb4;

-- ---------------------------------------------------------------------------
-- Users  (role: Learner = 0, Specialist = 1, Administrator = 2)
-- ---------------------------------------------------------------------------
INSERT INTO `user` (userId, email, first_name, last_name, gender, full_name, picture, verifiedEmail, token, role, created_at) VALUES
(1, 'olivier.luethy@kauz.ch', 'Olivier', 'Lüthy',   'male',   'Olivier Lüthy',  '', 1, 'dev-token-1', 0, '2026-05-01 08:00:00'),
(2, 'lena.vogt@kauz.ch',      'Lena',    'Vogt',     'female', 'Lena Vogt',      '', 1, 'dev-token-2', 0, '2026-05-02 08:00:00'),
(3, 'marco.bianchi@kauz.ch',  'Marco',   'Bianchi',  'male',   'Marco Bianchi',  '', 1, 'dev-token-3', 0, '2026-05-03 08:00:00'),
(4, 'nina.keller@kauz.ch',    'Nina',    'Keller',   'female', 'Nina Keller',    '', 1, 'dev-token-4', 0, '2026-05-04 08:00:00'),
(5, 'aurel.wicki@kauz.ch',    'Aurel',   'Wicki',    'male',   'Aurel Wicki',    '', 1, 'dev-token-5', 1, '2026-04-20 08:00:00'),
(6, 'sandra.meier@kauz.ch',   'Sandra',  'Meier',    'female', 'Sandra Meier',   '', 1, 'dev-token-6', 1, '2026-04-21 08:00:00'),
(7, 'janik.luethy@kauz.ch',   'Janik',   'Lüthi',    'male',   'Janik Lüthi',    '', 1, 'dev-token-7', 2, '2026-04-10 08:00:00');

-- ---------------------------------------------------------------------------
-- Topics / keywords (each belongs to a learner)
-- ---------------------------------------------------------------------------
INSERT INTO topic (topicId, topic, fk_userId) VALUES
(1,  'PHP',               1),
(2,  'Docker',            1),
(3,  'Datenbanken',       1),
(4,  'Projektmanagement', 1),
(5,  'JavaScript',        2),
(6,  'CSS',               2),
(7,  'UX Design',         2),
(8,  'Netzwerk',          3),
(9,  'Linux',             3),
(10, 'Security',          3),
(11, 'Testing',           4),
(12, 'Git',               4),
(13, 'Agile',             4);

-- ---------------------------------------------------------------------------
-- Daily journals  (status: Open = 0, Released = 1)
-- ---------------------------------------------------------------------------
INSERT INTO journal (journalId, text, status, date, released, fk_userId) VALUES
(1,  '<p>Heute habe ich die <strong>Docker-Umgebung</strong> aufgesetzt und die Container für Web und Datenbank konfiguriert.</p>', 1, '2026-05-05 16:30:00', '2026-05-05 17:00:00', 1),
(2,  '<p>Einarbeitung in das <em>MVC-Pattern</em>. Router- und Controller-Struktur verstanden.</p>',                                 1, '2026-05-06 16:00:00', '2026-05-06 16:45:00', 1),
(3,  '<p>Datenbankschema entworfen und erste Migrationsskripte geschrieben.</p>',                                                    0, '2026-05-07 15:30:00', NULL,                  1),
(4,  '<p>Bug im CKEditor untersucht und behoben &mdash; die Bilddarstellung funktioniert nun korrekt.</p>',                          0, '2026-05-08 17:10:00', NULL,                  1),
(5,  '<p>Layout der Startseite mit <strong>CSS Grid</strong> umgesetzt.</p>',                                                        1, '2026-05-05 14:00:00', '2026-05-05 15:00:00', 2),
(6,  '<p>JavaScript-Validierung für das Formular hinzugefügt.</p>',                                                                   1, '2026-05-06 14:30:00', '2026-05-06 15:15:00', 2),
(7,  '<p>Responsives Design getestet und Breakpoints angepasst.</p>',                                                                0, '2026-05-07 13:45:00', NULL,                  2),
(8,  '<p>Firewall-Regeln auf dem Testserver konfiguriert.</p>',                                                                      1, '2026-05-05 09:00:00', '2026-05-05 10:00:00', 3),
(9,  '<p>Linux-Benutzerverwaltung und Berechtigungen geübt.</p>',                                                                    1, '2026-05-06 09:30:00', '2026-05-06 10:30:00', 3),
(10, '<p>Grundlagen von Penetrationstests recherchiert.</p>',                                                                        0, '2026-05-07 10:00:00', NULL,                  3),
(11, '<p>Unit-Tests mit <strong>PHPUnit</strong> geschrieben.</p>',                                                                  1, '2026-05-05 11:00:00', '2026-05-05 11:45:00', 4),
(12, '<p>Git-Branching-Strategie im Team besprochen.</p>',                                                                           0, '2026-05-06 11:30:00', NULL,                  4),
(13, '<p>Sprint-Planung und Backlog-Pflege durchgeführt.</p>',                                                                       1, '2026-05-07 11:00:00', '2026-05-07 12:00:00', 4);

-- ---------------------------------------------------------------------------
-- Topics selected per journal (link journals <-> topics)
-- ---------------------------------------------------------------------------
INSERT INTO selectedTopics (id, fk_topicId, fk_journalId) VALUES
(1,  2,  1),
(2,  3,  1),
(3,  1,  2),
(4,  3,  3),
(5,  1,  4),
(6,  6,  5),
(7,  5,  6),
(8,  7,  7),
(9,  10, 8),
(10, 9,  9),
(11, 10, 10),
(12, 11, 11),
(13, 12, 12),
(14, 13, 13);

-- ---------------------------------------------------------------------------
-- Weekly reports  (status: Open = 0, Released = 1)
-- ---------------------------------------------------------------------------
INSERT INTO weeklyReport (weeklyReportId, calendarWeek, doneWork, ongoingWork, reflection, occurredProblems, status, date, fk_userId) VALUES
(1, 18, '<p>Docker-Setup fertiggestellt.</p>',     '<p>Mock-Daten erstellen.</p>',        '<p>Die Containerisierung war einfacher als gedacht.</p>', '<p>Probleme mit Volume-Mounts.</p>',     1, '2026-05-03 17:00:00', 1),
(2, 19, '<p>MVC-Struktur dokumentiert.</p>',       '<p>Tests schreiben.</p>',             '<p>Gutes Verständnis der Architektur gewonnen.</p>',      '<p>Keine nennenswerten.</p>',            1, '2026-05-10 17:00:00', 1),
(3, 20, '<p>Datenbank-Optimierung.</p>',           '<p>Frontend-Feinschliff.</p>',        '<p>Indizes verbessern die Performance deutlich.</p>',     '<p>Einige Slow Queries.</p>',            0, '2026-05-17 17:00:00', 1),
(4, 18, '<p>Startseiten-Layout umgesetzt.</p>',    '<p>Mobile Ansicht optimieren.</p>',   '<p>CSS Grid ist sehr mächtig.</p>',                       '<p>Browser-Inkompatibilitäten.</p>',     1, '2026-05-03 16:00:00', 2),
(5, 19, '<p>Formular-Validierung gebaut.</p>',     '<p>Barrierefreiheit prüfen.</p>',     '<p>UX deutlich verbessert.</p>',                          '<p>Keine.</p>',                          0, '2026-05-10 16:00:00', 2),
(6, 18, '<p>Servergrundlagen erarbeitet.</p>',     '<p>Monitoring einrichten.</p>',       '<p>Sicherheit ist ein zentrales Thema.</p>',              '<p>Konfigurationsfehler behoben.</p>',   1, '2026-05-03 10:00:00', 3),
(7, 18, '<p>Testabdeckung erhöht.</p>',            '<p>CI-Pipeline aufsetzen.</p>',       '<p>Automatisierung spart viel Zeit.</p>',                 '<p>Vereinzelt flaky Tests.</p>',         1, '2026-05-03 12:00:00', 4);
