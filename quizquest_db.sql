DROP DATABASE quizquest_db;
CREATE DATABASE quizquest_db;
use quizquest_db;
-- Creación de la tabla Localidad
CREATE TABLE Localidad
(
    id     INT PRIMARY KEY,
    País   VARCHAR(100) NOT NULL,
    Ciudad VARCHAR(100) NOT NULL
);

-- Creación de la tabla Usuario
CREATE TABLE Usuario
(
    id                 INT PRIMARY KEY,	 
    imagen             VARCHAR(255)	, -- Assuming image is stored as binary large object
    rol                VARCHAR(50)  NOT NULL,
    nombreCompleto     VARCHAR(150) NOT NULL,
    esHabilitado       BOOLEAN      NOT NULL,
    añoNacimiento      INT          NOT NULL,
    Sexo               CHAR(1)      NOT NULL,
    CorreoElectronico VARCHAR(100) NOT NULL,
    contrasena         VARCHAR(100) NOT NULL,
    nombrerUsuario    VARCHAR(100) NOT NULL,
    puntaje            INT          NOT NULL,
    localidad_id       INT,
    FOREIGN KEY (localidad_id) REFERENCES Localidad (id)
);

-- Creación de la tabla Administrador
CREATE TABLE Administrador
(
    Usuario_id INT PRIMARY KEY,
    FOREIGN KEY (Usuario_id) REFERENCES Usuario (id)
);

-- Creación de la tabla Básico
CREATE TABLE Basico
(
    Usuario_id INT PRIMARY KEY,
    FOREIGN KEY (Usuario_id) REFERENCES Usuario (id)
);

-- Creación de la tabla Editor
CREATE TABLE Editor
(
    Usuario_id INT PRIMARY KEY,
    FOREIGN KEY (Usuario_id) REFERENCES Usuario (id)
);

-- Creación de la tabla Partida
CREATE TABLE Partida
(
    id      INT PRIMARY KEY,
    nombre  VARCHAR(100) NOT NULL,
    puntaje INT          NOT NULL
);

-- Creación de la tabla Categoría (necesaria para FK en Pregunta)
CREATE TABLE Categoria
(
    id     INT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    color VARCHAR(100) NOT NULL
);

-- Creación de la tabla Pregunta
CREATE TABLE Pregunta
(
    id           INT PRIMARY KEY,
    punto        INT     NOT NULL,
    esValido     BOOLEAN NOT NULL,
    descripcion  TEXT,
    categoría_id INT,
    FOREIGN KEY (categoría_id) REFERENCES Categoria (id)
);

-- Creación de la tabla Realiza
CREATE TABLE Realiza
(
    partida_id  INT,
    pregunta_id INT,
	usuario_id INT,
	PRIMARY KEY (partida_id, pregunta_id),
    FOREIGN KEY (partida_id) REFERENCES Partida (id),
    FOREIGN KEY (pregunta_id) REFERENCES Pregunta (id),
    FOREIGN KEY(usuario_id) REFERENCES Usuario(id)
 );

-- Creación de la tabla Respuesta
CREATE TABLE Respuesta
(
    id          INT PRIMARY KEY,
    esCorreto   BOOLEAN NOT NULL,
    descripción TEXT    NOT NULL,
    pregunta_id INT,
    FOREIGN KEY (pregunta_id) REFERENCES Pregunta (id)
);


-- Datos base

-- Insertar datos en la tabla Localidad
INSERT INTO Localidad (id, País, Ciudad)
VALUES (1, 'Argentina', 'Buenos Aires');

-- Insertar datos en la tabla Usuario
INSERT INTO Usuario (id, imagen, rol, nombreCompleto, esHabilitado, añoNacimiento, Sexo, CorreoElectronico, contrasena,
                     nombrerUsuario, puntaje, localidad_id)
VALUES (1, NULL, 'Administrador', 'Juan Pérez', TRUE, 1985, 'M', 'juan.perez@example.com', 'password123', 'juanp', 100,
        1),
       (2, NULL, 'Basico', 'Ana López', TRUE, 1990, 'F', 'ana.lopez@example.com', 'password456', 'anal', 50, 1),
       (3, NULL, 'Editor', 'Carlos García', TRUE, 1978, 'M', 'carlos.garcia@example.com', 'password789', 'carlosg', 75,
        1);

-- Insertar datos en la tabla Administrador
INSERT INTO Administrador (Usuario_id)
VALUES (1);

-- Insertar datos en la tabla Basico
INSERT INTO Basico (Usuario_id)
VALUES (2);

-- Insertar datos en la tabla Editor
INSERT INTO Editor (Usuario_id)
VALUES (3);

-- Insertar datos en la tabla Partida
INSERT INTO Partida (id, nombre, puntaje)
VALUES (1, 'Partida 1', 100);

-- Insertar datos en la tabla Categoría
INSERT INTO Categoria (id, nombre, color) VALUES
(1, 'Cultura', '#258D19'),
(2, 'Ciencia', '#003366'),
(3, 'Entretenimiento', '#FFD700'),
(4, 'Deportes', '#ff4500'),
(5, 'Geografía', '#0055ff'),
(6, 'Historia', '#ac00ac');

-- Insertar datos en la tabla Pregunta
INSERT INTO Pregunta (id, punto, esValido, categoría_id)
VALUES (1, 10, TRUE, 1),
       (2, 10, TRUE, 1),
       (3, 10, TRUE, 1),
       (4, 10, TRUE, 1),
       (5, 10, TRUE, 1),
       (6, 10, TRUE, 1),
       (7, 10, TRUE, 1),
       (8, 10, TRUE, 1),
       (9, 10, TRUE, 1),
       (10, 10, TRUE, 1);

-- Insertar datos en la tabla Realiza
/*
INSERT INTO Realiza (partida_id, pregunta_id)
VALUES (1, 1),
       (1, 2),
       (1, 3),
       (1, 4),
       (1, 5),
       (1, 6),
       (1, 7),
       (1, 8),
       (1, 9),
       (1, 10);
*/
-- Insertar datos en la tabla Respuesta para cada pregunta
-- Pregunta 1
INSERT INTO Respuesta (id, esCorreto, descripción, pregunta_id)
VALUES (1, TRUE, 'París', 1),
       (2, FALSE, 'Londres', 1),
       (3, FALSE, 'Roma', 1),
       (4, FALSE, 'Berlín', 1);

-- Pregunta 2
INSERT INTO Respuesta (id, esCorreto, descripción, pregunta_id)
VALUES (5, FALSE, 'Newton', 2),
       (6, TRUE, 'Einstein', 2),
       (7, FALSE, 'Galileo', 2),
       (8, FALSE, 'Tesla', 2);

-- Pregunta 3
INSERT INTO Respuesta (id, esCorreto, descripción, pregunta_id)
VALUES (9, FALSE, 'Amazonas', 3),
       (10, FALSE, 'Nilo', 3),
       (11, TRUE, 'Yangtsé', 3),
       (12, FALSE, 'Mississippi', 3);

-- Pregunta 4
INSERT INTO Respuesta (id, esCorreto, descripción, pregunta_id)
VALUES (13, FALSE, '2001', 4),
       (14, TRUE, '1991', 4),
       (15, FALSE, '1981', 4),
       (16, FALSE, '2011', 4);

-- Pregunta 5
INSERT INTO Respuesta (id, esCorreto, descripción, pregunta_id)
VALUES (17, TRUE, 'Miguel de Cervantes', 5),
       (18, FALSE, 'Gabriel García Márquez', 5),
       (19, FALSE, 'Mario Vargas Llosa', 5),
       (20, FALSE, 'Pablo Neruda', 5);

-- Pregunta 6
INSERT INTO Respuesta (id, esCorreto, descripción, pregunta_id)
VALUES (21, FALSE, '3', 6),
       (22, TRUE, '7', 6),
       (23, FALSE, '5', 6),
       (24, FALSE, '4', 6);

-- Pregunta 7
INSERT INTO Respuesta (id, esCorreto, descripción, pregunta_id)
VALUES (25, FALSE, 'O2', 7),
       (26, FALSE, 'CO2', 7),
       (27, TRUE, 'H2O', 7),
       (28, FALSE, 'N2', 7);

-- Pregunta 8
INSERT INTO Respuesta (id, esCorreto, descripción, pregunta_id)
VALUES (29, FALSE, '20', 8),
       (30, TRUE, '24', 8),
       (31, FALSE, '30', 8),
       (32, FALSE, '28', 8);

-- Pregunta 9
INSERT INTO Respuesta (id, esCorreto, descripción, pregunta_id)
VALUES (33, TRUE, 'George Washington', 9),
       (34, FALSE, 'Thomas Jefferson', 9),
       (35, FALSE, 'Abraham Lincoln', 9),
       (36, FALSE, 'John Adams', 9);

-- Pregunta 10
INSERT INTO Respuesta (id, esCorreto, descripción, pregunta_id)
VALUES (37, FALSE, 'Mercurio', 10),
       (38, TRUE, 'Venus', 10),
       (39, FALSE, 'Marte', 10),
       (40, FALSE, 'Júpiter', 10);