CREATE DATABASE IF NOT EXISTS firmanpollen CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE firmanpollen;

CREATE TABLE IF NOT EXISTS pages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(150) NOT NULL,
    slug VARCHAR(150) NOT NULL UNIQUE,
    meta_description VARCHAR(255) DEFAULT '',
    hero_title VARCHAR(200) DEFAULT '',
    hero_subtitle TEXT,
    is_published TINYINT(1) NOT NULL DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS page_sections (
    id INT AUTO_INCREMENT PRIMARY KEY,
    page_id INT NOT NULL,
    heading VARCHAR(200) NOT NULL,
    body TEXT NOT NULL,
    cta_label VARCHAR(120) DEFAULT '',
    cta_url VARCHAR(255) DEFAULT '',
    sort_order INT NOT NULL DEFAULT 10,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_page_sections_page FOREIGN KEY (page_id) REFERENCES pages(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS site_settings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    setting_key VARCHAR(100) NOT NULL UNIQUE,
    setting_value TEXT NOT NULL,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

INSERT INTO site_settings (setting_key, setting_value) VALUES
('site_name', 'Firman Pollen'),
('site_tagline', 'Precision pollen intelligence for high-performing farms.'),
('footer_text', '© 2026 Firman Pollen. Built for modern growers.')
ON DUPLICATE KEY UPDATE setting_value = VALUES(setting_value);

INSERT INTO pages (title, slug, meta_description, hero_title, hero_subtitle, is_published)
VALUES
('Home', 'home', 'Farm-tech pollen forecasting and crop intelligence.', 'Data-driven pollen intelligence for resilient farms.', 'Track pollen dynamics, microclimate signals, and crop readiness from one platform.', 1),
('Solutions', 'solutions', 'End-to-end agronomy solutions for crop teams.', 'Integrated tools for agronomy and operations.', 'From bloom predictions to in-field recommendations, our modules keep teams aligned.', 1),
('About', 'about', 'Meet the Firman Pollen team.', 'Built by agronomists and engineers.', 'We blend field science and software to support every acre you manage.', 1),
('Contact', 'contact', 'Talk to the Firman Pollen team.', 'Let\'s improve this season together.', 'Share your region and crop profile to receive a tailored deployment plan.', 1)
ON DUPLICATE KEY UPDATE title = VALUES(title);

INSERT INTO page_sections (page_id, heading, body, cta_label, cta_url, sort_order)
SELECT p.id, 'Pollen Forecast Engine', 'Our forecasting pipeline combines historical bloom data, weather streams, and in-field observations to estimate pollen peaks days in advance.', 'Request Forecast Sample', '/?page=contact', 10 FROM pages p WHERE p.slug='home'
UNION ALL
SELECT p.id, 'Field Ops Dashboard', 'Monitor pollination windows, team tasks, and risk hotspots through one actionable command center.', 'Explore Solutions', '/?page=solutions', 20 FROM pages p WHERE p.slug='home'
UNION ALL
SELECT p.id, 'Advisory Modules', 'Configure recommendations per crop, zone, and season phase. Deliver insights directly to agronomy, irrigation, and harvest teams.', 'Talk to Sales', '/?page=contact', 10 FROM pages p WHERE p.slug='solutions'
UNION ALL
SELECT p.id, 'Why we built Firman Pollen', 'Growers needed fast and dependable guidance during sensitive bloom stages. We built a platform that translates research into daily action.', '', '', 10 FROM pages p WHERE p.slug='about'
UNION ALL
SELECT p.id, 'Start your deployment', 'Email hello@firmanpollen.com or use your preferred procurement process. We support pilots and full multi-farm deployments.', 'Email the Team', 'mailto:hello@firmanpollen.com', 10 FROM pages p WHERE p.slug='contact';
