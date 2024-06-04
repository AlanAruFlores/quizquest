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
    id      INT PRIMARY KEY auto_increment,
    nombre  VARCHAR(100) NOT NULL unique,
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
    descripcion  TEXT,
    punto        INT     NOT NULL,
    esValido     BOOLEAN NOT NULL,
    categoria_id INT,
    FOREIGN KEY (categoria_id) REFERENCES Categoria (id)
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
    letra varchar(10) NOT NULL,
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
INSERT INTO Pregunta (id, descripcion, punto, esValido, categoria_id)
VALUES 
(1, "¿Cuál es la capital de Francia?", 10, TRUE, 5),
(2, "¿Quién formuló la teoría de la relatividad?", 10, TRUE, 2),
(3, "¿Cuál es el río más largo del mundo?", 10, TRUE, 5),
(4, "¿En qué año se desintegró la Unión Soviética?", 10, TRUE, 6),
(5, "¿Quién escribió la novela 'Don Quijote de la Mancha'?", 10, TRUE, 1),
(6, "¿Cuántos días tiene una semana?", 10, TRUE, 6),
(7, "¿Cuál es la fórmula química del agua?", 10, TRUE, 3),
(8, "¿Cuántas horas tiene un día?", 10, TRUE, 3),
(9, "¿Quién fue el primer presidente de los Estados Unidos?", 10, TRUE, 6),
(10, "¿Cuál es el segundo planeta del sistema solar?", 10, TRUE, 5),
(11, "¿Cuál es el planeta más grande del sistema solar?", 10, TRUE, 5),
(12, "¿En qué año comenzó la Segunda Guerra Mundial?", 10, TRUE, 6),
(13, "¿Quién escribió el libro 'Cien años de soledad'?", 10, TRUE, 1),
(14, "¿Cuál es el océano más grande del mundo?", 10, TRUE, 5),
(15, "¿Quién pintó la Mona Lisa?", 10, TRUE, 1);

-- Insertar datos en la tabla Respuesta para cada pregunta
-- Pregunta 1
INSERT INTO Respuesta (id, esCorreto, descripción, letra, pregunta_id)
VALUES (1, TRUE, 'París', 'A', 1),
       (2, FALSE, 'Londres', 'B', 1),
       (3, FALSE, 'Roma', 'C', 1),
       (4, FALSE, 'Berlín', 'D', 1);

-- Pregunta 2
INSERT INTO Respuesta (id, esCorreto, descripción, letra, pregunta_id)
VALUES (5, FALSE, 'Newton', 'A', 2),
       (6, TRUE, 'Einstein', 'B', 2),
       (7, FALSE, 'Galileo', 'C', 2),
       (8, FALSE, 'Tesla', 'D', 2);

-- Pregunta 3
INSERT INTO Respuesta (id, esCorreto, descripción, letra, pregunta_id)
VALUES (9, FALSE, 'Amazonas', 'A', 3),
       (10, FALSE, 'Nilo', 'B', 3),
       (11, TRUE, 'Yangtsé', 'C', 3),
       (12, FALSE, 'Mississippi', 'D', 3);

-- Pregunta 4
INSERT INTO Respuesta (id, esCorreto, descripción, letra, pregunta_id)
VALUES (13, FALSE, '2001', 'A', 4),
       (14, TRUE, '1991', 'B', 4),
       (15, FALSE, '1981', 'C', 4),
       (16, FALSE, '2011', 'D', 4);

-- Pregunta 5
INSERT INTO Respuesta (id, esCorreto, descripción, letra, pregunta_id)
VALUES (17, TRUE, 'Miguel de Cervantes', 'A', 5),
       (18, FALSE, 'Gabriel García Márquez', 'B', 5),
       (19, FALSE, 'Mario Vargas Llosa', 'C', 5),
       (20, FALSE, 'Pablo Neruda', 'D', 5);

-- Pregunta 6
INSERT INTO Respuesta (id, esCorreto, descripción, letra, pregunta_id)
VALUES (21, FALSE, '3', 'A', 6),
       (22, TRUE, '7', 'B', 6),
       (23, FALSE, '5', 'C', 6),
       (24, FALSE, '4', 'D', 6);

-- Pregunta 7
INSERT INTO Respuesta (id, esCorreto, descripción, letra, pregunta_id)
VALUES (25, FALSE, 'O2', 'A', 7),
       (26, FALSE, 'CO2', 'B', 7),
       (27, TRUE, 'H2O', 'C', 7),
       (28, FALSE, 'N2', 'D', 7);

-- Pregunta 8
INSERT INTO Respuesta (id, esCorreto, descripción, letra, pregunta_id)
VALUES (29, FALSE, '20', 'A', 8),
       (30, TRUE, '24', 'B', 8),
       (31, FALSE, '30', 'C', 8),
       (32, FALSE, '28', 'D', 8);

-- Pregunta 9
INSERT INTO Respuesta (id, esCorreto, descripción, letra, pregunta_id)
VALUES (33, TRUE, 'George Washington', 'A', 9),
       (34, FALSE, 'Thomas Jefferson', 'B', 9),
       (35, FALSE, 'Abraham Lincoln', 'C', 9),
       (36, FALSE, 'John Adams', 'D', 9);

-- Pregunta 10
INSERT INTO Respuesta (id, esCorreto, descripción, letra, pregunta_id)
VALUES (37, FALSE, 'Mercurio', 'A', 10),
       (38, TRUE, 'Venus', 'B', 10),
       (39, FALSE, 'Marte', 'C', 10),
       (40, FALSE, 'Júpiter', 'D', 10);

-- Pregunta 11
INSERT INTO Respuesta (id, esCorreto, descripción, letra, pregunta_id)
VALUES (41, FALSE, 'Mercurio', 'A', 11),
       (42, FALSE, 'Venus', 'B', 11),
       (43, FALSE, 'Marte', 'C', 11),
       (44, TRUE, 'Júpiter', 'D', 11);

-- Pregunta 12
INSERT INTO Respuesta (id, esCorreto, descripción, letra, pregunta_id)
VALUES (45, FALSE, '1938', 'A', 12),
       (46, TRUE, '1939', 'B', 12),
       (47, FALSE, '1940', 'C', 12),
       (48, FALSE, '1941', 'D', 12);

-- Pregunta 13
INSERT INTO Respuesta (id, esCorreto, descripción, letra, pregunta_id)
VALUES (49, FALSE, 'Gabriel García Márquez', 'A', 13),
       (50, TRUE, 'Gabriel García Márquez', 'B', 13),
       (51, FALSE, 'Pablo Neruda', 'C', 13),
       (52, FALSE, 'Julio Cortázar', 'D', 13);

-- Pregunta 14
INSERT INTO Respuesta (id, esCorreto, descripción, letra, pregunta_id)
VALUES (53, FALSE, 'Océano Atlántico', 'A', 14),
       (54, TRUE, 'Océano Pacífico', 'B', 14),
       (55, FALSE, 'Océano Índico', 'C', 14),
       (56, FALSE, 'Océano Ártico', 'D', 14);

-- Pregunta 15
INSERT INTO Respuesta (id, esCorreto, descripción, letra, pregunta_id)
VALUES (57, TRUE, 'Leonardo da Vinci', 'A', 15),
       (58, FALSE, 'Pablo Picasso', 'B', 15),
       (59, FALSE, 'Vincent van Gogh', 'C', 15),
       (60, FALSE, 'Rembrandt', 'D', 15);
       
/*SELECT*/
select p.id, p.descripcion, p.punto, c.nombre as categoria, c.color as color from pregunta p join categoria c on p.categoria_id = c.id order by rand() limit 1;
select r.id as res_id, r.esCorreto, r.descripción as descripcion_respuesta, p.id as preg_id, p.descripcion as descripcion_pregunta, p.punto, p.esValido from respuesta r join pregunta p on r.pregunta_id = p.id where p.id = 3;
select * from partida;
select * from realiza;
select * from pregunta;

/*Consultas multitabla para evitar repetidos*/

#Evitar repetidos
select * from pregunta p where p.id
		not in(
				select r.pregunta_id from realiza r
				where r.usuario_id =2
            ) order by rand() limit 10 ;

#Obtener preguntas de un realiza
select p.id, p.descripcion, p.punto, p.esValido, c.nombre, c.color as categoria from realiza r join pregunta p 	
	on r.pregunta_id = p.id
    join categoria c on c.id = p.categoria_id
    where partida_id = 2 order by rand();