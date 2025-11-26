-- Insert data admin
INSERT INTO users (id, guru_id, username, password, level, can_verify, created_at, updated_at) 
VALUES (1, NULL, 'admin', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', 1, NOW(), NOW());
