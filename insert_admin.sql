-- Insert Admin User
INSERT INTO users (guru_id, username, password, level, can_verify, created_at, updated_at) 
VALUES (NULL, 'admin', '$2y$12$LQv3c1yycaHdb/JQcWQOKOuYyvzLIbtYACGMkjAg7QT5zlC4A4Emu', 'admin', 1, NOW(), NOW());

-- Username: admin
-- Password: admin123
