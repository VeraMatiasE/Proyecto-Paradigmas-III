CREATE DATABASE mvProyectoParadigmasIII;
USE mvProyectoParadigmasIII;

-- Estados
CREATE TABLE IF NOT EXISTS status (
    id_status SMALLINT AUTO_INCREMENT PRIMARY KEY, 
    name VARCHAR(20) NOT NULL,
    is_deleted BOOLEAN DEFAULT FALSE
);

-- Agencias espaciales
CREATE TABLE IF NOT EXISTS space_agency (
    id_agency INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    logo VARCHAR(255),
    is_deleted BOOLEAN DEFAULT FALSE
);

-- Tabla: 
CREATE TABLE IF NOT EXISTS mission_details (
    id_mission_details INT AUTO_INCREMENT PRIMARY KEY,
    launch_site VARCHAR(100),
    end_date DATE,
    rocket_type VARCHAR(100),
    mission_duration VARCHAR(50),
    crew_size INT,
    budget DECIMAL(15,2),
    objectives TEXT,
    achievements TEXT,
    is_deleted BOOLEAN DEFAULT FALSE
);

-- Tabla celestial_object (agregar esta si aún no existe)
CREATE TABLE IF NOT EXISTS celestial_object (
    id_celestial_object INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    logo VARCHAR(255),
    is_deleted BOOLEAN DEFAULT FALSE
);

-- Tabla: mission_type
CREATE TABLE IF NOT EXISTS mission_type (
    id_mission_type INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    logo VARCHAR(255),
    is_deleted BOOLEAN DEFAULT FALSE
);

-- Misiones
CREATE TABLE IF NOT EXISTS mission (
    id_mission INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255),
    slug VARCHAR(255) UNIQUE,
    launch_date DATE NOT NULL,
    banner VARCHAR(255),
    description TEXT,
    id_status SMALLINT NOT NULL,
    id_celestial_object INT,
    id_mission_type INT,
    id_agency INT,
    id_mission_details INT,
    is_deleted BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (id_status) REFERENCES status(id_status),
    FOREIGN KEY (id_celestial_object) REFERENCES celestial_object(id_celestial_object),
    FOREIGN KEY (id_mission_type) REFERENCES mission_type(id_mission_type),
    FOREIGN KEY (id_agency) REFERENCES space_agency(id_agency),
    FOREIGN KEY (id_mission_details) REFERENCES mission_details(id_mission_details)
);

-- Usuarios
CREATE TABLE IF NOT EXISTS users (
    id_user INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(70) UNIQUE,
    firstname VARCHAR(70),
    lastname VARCHAR(70),
    email VARCHAR(255) UNIQUE,
    password VARCHAR(60),
    role ENUM('admin', 'news', 'user') DEFAULT 'user' NOT NULL,
    is_deleted BOOLEAN DEFAULT FALSE
);

-- Intentos de Sesión 
CREATE TABLE IF NOT EXISTS login_attempts (
    id_login_attempts INT AUTO_INCREMENT PRIMARY KEY,
    ip_address VARCHAR(45),
    email VARCHAR(255),
    attempt_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    is_deleted BOOLEAN DEFAULT FALSE
);

-- Posts
CREATE TABLE IF NOT EXISTS posts (
    id_post INT AUTO_INCREMENT PRIMARY KEY,
    slug VARCHAR(255) NOT NULL UNIQUE,
    id_user INT,
    title VARCHAR(100),
    description VARCHAR(600),
    count_comments INT DEFAULT 0,
    created_at DATE DEFAULT(NOW()),
    is_deleted BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (id_user) REFERENCES users(id_user)
);

-- Comentarios
CREATE TABLE IF NOT EXISTS comments (
	id_comment INT AUTO_INCREMENT PRIMARY KEY,
    id_user INT,
    content TEXT,
    id_post INT,
    created_at DATETIME DEFAULT NOW(),
    like_count INT DEFAULT 0,
    dislike_count INT DEFAULT 0,
    id_reply INT DEFAULT NULL,
    is_deleted BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (id_user) REFERENCES users(id_user),
    FOREIGN KEY (id_post) REFERENCES posts(id_post),
    FOREIGN KEY (id_reply) REFERENCES comments(id_comment)
);

-- Likes/Dislikes
CREATE TABLE IF NOT EXISTS comment_likes (
    id_comment_likes INT AUTO_INCREMENT PRIMARY KEY,
    id_comment INT NOT NULL,
    id_user INT NOT NULL,
    like_type ENUM('like', 'dislike') NOT NULL,
    is_deleted BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (id_comment) REFERENCES comments(id_comment),
    FOREIGN KEY (id_user) REFERENCES users(id_user),
    UNIQUE (id_comment, id_user) -- Evita duplicados de reacción por usuario
);

-- News
CREATE TABLE IF NOT EXISTS news (
    id_new INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255),
    content JSON,
    id_author INT,
    banner VARCHAR(255),
    published_at DATETIME,
    slug VARCHAR(255),
    is_deleted BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (id_author) REFERENCES users(id_user)
);

DELIMITER $$
CREATE TRIGGER increment_comment_count AFTER INSERT ON comments FOR EACH ROW
BEGIN
	UPDATE posts SET count_comments = count_comments + 1 WHERE id_post = NEW.id_post;
END$$

CREATE TRIGGER decrement_comment_count AFTER DELETE ON comments FOR EACH ROW 
BEGIN
	UPDATE posts SET count_comments = count_comments - 1 WHERE id_post = OLD.id_post;
END$$
DELIMITER ;

DELIMITER //

CREATE TRIGGER update_like_dislike_counts
AFTER INSERT ON comment_likes
FOR EACH ROW
BEGIN
    IF NEW.like_type = 'like' THEN
        UPDATE comments 
        SET like_count = like_count + 1 
        WHERE id_comment = NEW.id_comment;
    ELSEIF NEW.like_type = 'dislike' THEN
        UPDATE comments 
        SET dislike_count = dislike_count + 1 
        WHERE id_comment = NEW.id_comment;
    END IF;
END//
//

DELIMITER ;

DELIMITER //
CREATE TRIGGER update_like_dislike_counts_on_update
AFTER UPDATE ON comment_likes
FOR EACH ROW
BEGIN
    IF OLD.like_type != NEW.like_type THEN
        IF OLD.like_type = 'like' THEN
            UPDATE comments 
            SET like_count = like_count - 1 
            WHERE id_comment = OLD.id_comment;
        ELSEIF OLD.like_type = 'dislike' THEN
            UPDATE comments 
            SET dislike_count = dislike_count - 1 
            WHERE id_comment = OLD.id_comment;
        END IF;
        
        IF NEW.like_type = 'like' THEN
            UPDATE comments 
            SET like_count = like_count + 1 
            WHERE id_comment = NEW.id_comment;
        ELSEIF NEW.like_type = 'dislike' THEN
            UPDATE comments 
            SET dislike_count = dislike_count + 1 
            WHERE id_comment = NEW.id_comment;
        END IF;
    END IF;
END//

DELIMITER ;

DELIMITER //

CREATE TRIGGER update_like_dislike_counts_on_delete
AFTER DELETE ON comment_likes
FOR EACH ROW
BEGIN
    IF OLD.like_type = 'like' THEN
        UPDATE comments 
        SET like_count = like_count - 1 
        WHERE id_comment = OLD.id_comment;
    ELSEIF OLD.like_type = 'dislike' THEN
        UPDATE comments 
        SET dislike_count = dislike_count - 1 
        WHERE id_comment = OLD.id_comment;
    END IF;
END//

DELIMITER ;
