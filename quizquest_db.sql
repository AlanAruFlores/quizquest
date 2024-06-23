DROP DATABASE quizquest_db;
CREATE DATABASE quizquest_db;
USE quizquest_db;

-- Creación de la tabla Usuario
CREATE TABLE Usuario
(
    id                 INT PRIMARY KEY auto_increment,	 
    imagen             VARCHAR(255)	, -- Assuming image is stored as binary large object
    rol                VARCHAR(50)  NOT NULL,
    nombreCompleto     VARCHAR(150) NOT NULL,
    esHabilitado       BOOLEAN      NOT NULL,
    fechaNacimiento    DATE          NOT NULL,
    Sexo               VARCHAR(100)   NOT NULL,
    CorreoElectronico VARCHAR(100) NOT NULL,
    contrasena         VARCHAR(100) NOT NULL,
    nombrerUsuario    VARCHAR(100) NOT NULL,
	pais VARCHAR(100) NOT NULL,
    ciudad VARCHAR(100) NOT NULL,
    cantidad_dadas INT NOT NULL,
    cantidad_acertadas INT NOT NULL,
    ratio INT NOT NULL,
    nivel VARCHAR (100) NOT NULL
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
    puntaje INT          NOT NULL,
	usuario_id INT NOT NULL,
    FOREIGN KEY (usuario_id) REFERENCES usuario(id)
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
    id           INT PRIMARY KEY AUTO_INCREMENT,
    descripcion  TEXT,
    punto        INT     NOT NULL,
    esValido     BOOLEAN NOT NULL,
    cantidad_dadas INT,
    acertadas INT,
    porcentaje INT,
    categoria_id INT,
    FOREIGN KEY (categoria_id) REFERENCES Categoria (id)
);

-- Creación de la tabla Realiza
CREATE TABLE Realiza
(
    pregunta_id INT,
	usuario_id INT,
	PRIMARY KEY (usuario_id, pregunta_id),
    FOREIGN KEY (pregunta_id) REFERENCES Pregunta (id),
    FOREIGN KEY(usuario_id) REFERENCES Usuario(id)
 );

-- Creación de la tabla Respuesta
CREATE TABLE Respuesta
(
    id          INT PRIMARY KEY AUTO_INCREMENT,
    esCorreto   BOOLEAN NOT NULL,
    descripción TEXT    NOT NULL,
    letra varchar(10) NOT NULL,
    pregunta_id INT,
    FOREIGN KEY (pregunta_id) REFERENCES Pregunta (id)
);
/* TABLAS PARA REPORTAR UNA PREGUNTA CON RESPUESTAS */

CREATE TABLE reporta (
    id INT NOT NULL AUTO_INCREMENT,
    usuario_id INT NOT NULL,
    pregunta_id INT NOT NULL,
    razon TEXT NOT NULL,
    CONSTRAINT pk_reporta PRIMARY KEY (id),
    CONSTRAINT fk_reporta_usuario FOREIGN KEY (usuario_id) REFERENCES usuario(id),
    CONSTRAINT fk_reporta_pregunta FOREIGN KEY (pregunta_id) REFERENCES pregunta(id)
);

/* TABLAS PARA LAS PREGUNTAS SUGERIDAS */

CREATE TABLE preguntasugerida (
    id INT NOT NULL,
    descripcion TEXT NOT NULL,
    categoria_id INT NOT NULL,
    CONSTRAINT pk_preguntasugerida PRIMARY KEY (id),
    CONSTRAINT fk_categoria_preguntasugerida FOREIGN KEY (categoria_id) REFERENCES categoria(id)
);

CREATE TABLE respuestasugerida (
    id INT NOT NULL,
    descripcion TEXT NOT NULL,
    esCorrecto BOOL NOT NULL,
    CONSTRAINT pk_respuestasugerida PRIMARY KEY (id)
);

CREATE TABLE sugiere (
    usuario_id INT NOT NULL,
    preguntasugerida_id INT NOT NULL,
    respuestasugerida_id INT NOT NULL,
    CONSTRAINT pk_sugiere PRIMARY KEY (preguntasugerida_id, respuestasugerida_id),
    CONSTRAINT fk_preguntasugerida FOREIGN KEY (preguntasugerida_id) REFERENCES preguntasugerida(id),
    CONSTRAINT fk_respuestasugerida FOREIGN KEY (respuestasugerida_id) REFERENCES respuestasugerida(id)
);

-- Insertar datos en la tabla Usuario
INSERT INTO Usuario (id, imagen, rol, nombreCompleto, esHabilitado, fechaNacimiento, Sexo, CorreoElectronico, contrasena,
                     nombrerUsuario,pais,ciudad,cantidad_dadas, cantidad_acertadas, ratio, nivel)
VALUES (1, NULL, 'Administrador', 'Juan Pérez', TRUE, "19850102", "Masculino", 'juan.perez@example.com', 'password123', 'juanperez', "Argentina", "Buenos Aires",0,0,0,"NOVATO"),
       (2, NULL, 'Basico', 'Ana López', TRUE,  "19900102", "Femenino" , 'ana.lopez@example.com', 'password456', 'analia123', "Argentina", "Buenos Aires",0,0,0,"NOVATO"),
       (3, NULL, 'Editor', 'Carlos García', TRUE,  "19750102", "Masculino" , 'carlos.garcia@example.com', 'password789', 'carlosgomez',"Argentina", "Buenos Aires",0,0,0,"NOVATO");

-- Insertar datos en la tabla Administrador
INSERT INTO Administrador (Usuario_id)
VALUES (1);

-- Insertar datos en la tabla Basico
INSERT INTO Basico (Usuario_id)
VALUES (2);

-- Insertar datos en la tabla Editor
INSERT INTO Editor (Usuario_id)
VALUES (3);

-- Insertar datos en la tabla Categoría
INSERT INTO Categoria (id, nombre, color) VALUES
(1, 'Cultura', '#258D19'),
(2, 'Ciencia', '#003366'),
(3, 'Entretenimiento', '#FFD700'),
(4, 'Deportes', '#ff4500'),
(5, 'Geografía', '#0055ff'),
(6, 'Historia', '#ac00ac');

-- Insertar datos en la tabla Pregunta
INSERT INTO Pregunta (id, descripcion, punto, esValido, categoria_id, cantidad_dadas, acertadas, porcentaje)
VALUES 
(1, "¿Cuál es la capital de Francia?", 10, TRUE, 5, 100, 60, 60),
(2, "¿Quién formuló la teoría de la relatividad?", 10, TRUE, 2, 80, 25, 31),
(3, "¿Cuál es el río más largo del mundo?", 10, TRUE, 5, 70, 30, 42),
(4, "¿En qué año se desintegró la Unión Soviética?", 10, TRUE, 6, 80, 25, 31),
(5, "¿Quién escribió la novela 'Don Quijote de la Mancha'?", 10, TRUE, 1, 120, 10, 8),
(6, "¿Cuántos días tiene una semana?", 10, TRUE, 6, 110, 70, 63),
(7, "¿Cuál es la fórmula química del agua?", 10, TRUE, 3, 150, 120, 80),
(8, "¿Cuántas horas tiene un día?", 10, TRUE, 3, 130, 100, 76),
(9, "¿Quién fue el primer presidente de los Estados Unidos?", 10, TRUE, 6, 120, 10, 8),
(10, "¿Cuál es el segundo planeta del sistema solar?", 10, TRUE, 5, 140, 110, 78),
(11, "¿Cuál es el planeta más grande del sistema solar?", 10, TRUE, 5, 80, 25, 31),
(12, "¿En qué año comenzó la Segunda Guerra Mundial?", 10, TRUE, 6, 180, 160, 88),
(13, "¿Quién escribió el libro 'Cien años de soledad'?", 10, TRUE, 1, 120, 10, 8),
(14, "¿Cuál es el océano más grande del mundo?", 10, TRUE, 5, 220, 200, 90),
(15, "¿Quién pintó la Mona Lisa?", 10, TRUE, 1, 80, 25, 31);

/*MAS PREGUNTAS !!*/
-- Preguntas Fáciles
INSERT INTO Pregunta (id, descripcion, punto, esValido, categoria_id, cantidad_dadas, acertadas, porcentaje)
VALUES 
(16, "¿Cuál es la capital de España?", 10, TRUE, 5, 100, 60, 60),
(17, "¿Cuál es el color del cielo en un día despejado?", 10, TRUE, 5, 100, 100, 100),
(18, "¿Qué animal es famoso por tener una cola larga y peluda y colgarse de los árboles?", 10, TRUE, 5, 100, 90, 90),
(19, "¿Qué tipo de animal es un delfín?", 10, TRUE, 5, 100, 80, 80),
(20, "¿Cuál es el resultado de sumar 2 + 2?", 10, TRUE, 6, 100, 100, 100);

-- Preguntas de Nivel Medio
INSERT INTO Pregunta (id, descripcion, punto, esValido, categoria_id, cantidad_dadas, acertadas, porcentaje)
VALUES 
(21, "¿Cuál es la capital de Australia?", 10, TRUE, 5, 100, 40, 40),
(22, "¿Qué elemento químico tiene el símbolo 'H'?", 10, TRUE, 2, 100, 30, 30),
(23, "¿Quién escribió la obra de teatro 'Romeo y Julieta'?", 10, TRUE, 1, 100, 40, 40),
(24, "¿En qué país se encuentra la Gran Muralla China?", 10, TRUE, 5, 100, 40, 40),
(25, "¿Cuál es el resultado de multiplicar 8 por 7?", 10, TRUE, 6, 100, 40, 40);

-- Preguntas Difíciles
INSERT INTO Pregunta (id, descripcion, punto, esValido, categoria_id, cantidad_dadas, acertadas, porcentaje)
VALUES 
(26, "¿Cuál es el resultado de la raíz cuadrada de 144?", 10, TRUE, 2, 100, 10, 10),
(27, "¿Cuál es la capital de Islandia?", 10, TRUE, 5, 100, 14, 14),
(28, "¿En qué año se fundó la Organización de las Naciones Unidas (ONU)?", 10, TRUE, 6, 100, 12, 12),
(29, "¿Cuál es el componente principal del aire que respiramos?", 10, TRUE, 5, 100, 10, 10),
(30, "¿Quién fue el primer ser humano en orbitar la Tierra?", 10, TRUE, 6, 100, 8, 8);

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
       

/*RESPUESTAS DE LAS PREGUNTAS EXTRAS*/
-- Preguntas Fáciles
INSERT INTO Respuesta (id, esCorreto, descripción, letra, pregunta_id)
VALUES 
(61, TRUE, 'Madrid', 'A', 16),
(62, FALSE, 'Barcelona', 'B', 16),
(63, FALSE, 'Londres', 'C', 16),
(64, FALSE, 'París', 'D', 16);

INSERT INTO Respuesta (id, esCorreto, descripción, letra, pregunta_id)
VALUES 
(65, TRUE, 'Azul', 'A', 17),
(66, FALSE, 'Verde', 'B', 17),
(67, FALSE, 'Amarillo', 'C', 17),
(68, FALSE, 'Rojo', 'D', 17);

INSERT INTO Respuesta (id, esCorreto, descripción, letra, pregunta_id)
VALUES 
(69, TRUE, 'Mono', 'A', 18),
(70, FALSE, 'Tigre', 'B', 18),
(71, FALSE, 'Elefante', 'C', 18),
(72, FALSE, 'León', 'D', 18);

INSERT INTO Respuesta (id, esCorreto, descripción, letra, pregunta_id)
VALUES 
(73, TRUE, 'Mamífero marino', 'A', 19),
(74, FALSE, 'Pez', 'B', 19),
(75, FALSE, 'Ave', 'C', 19),
(76, FALSE, 'Reptil', 'D', 19);

INSERT INTO Respuesta (id, esCorreto, descripción, letra, pregunta_id)
VALUES 
(77, TRUE, '4', 'A', 20),
(78, FALSE, '2', 'B', 20),
(79, FALSE, '5', 'C', 20),
(80, FALSE, '3', 'D', 20);

-- Preguntas de Nivel Medio
INSERT INTO Respuesta (id, esCorreto, descripción, letra, pregunta_id)
VALUES 
(81, TRUE, 'Canberra', 'A', 21),
(82, FALSE, 'Sídney', 'B', 21),
(83, FALSE, 'Melbourne', 'C', 21),
(84, FALSE, 'Brisbane', 'D', 21);

INSERT INTO Respuesta (id, esCorreto, descripción, letra, pregunta_id)
VALUES 
(85, TRUE, 'Hidrógeno', 'A', 22),
(86, FALSE, 'Helio', 'B', 22),
(87, FALSE, 'Oxígeno', 'C', 22),
(88, FALSE, 'Carbono', 'D', 22);

INSERT INTO Respuesta (id, esCorreto, descripción, letra, pregunta_id)
VALUES 
(89, TRUE, 'William Shakespeare', 'A', 23),
(90, FALSE, 'Charles Dickens', 'B', 23),
(91, FALSE, 'Jane Austen', 'C', 23),
(92, FALSE, 'Federico García Lorca', 'D', 23);

INSERT INTO Respuesta (id, esCorreto, descripción, letra, pregunta_id)
VALUES 
(93, TRUE, 'China', 'A', 24),
(94, FALSE, 'India', 'B', 24),
(95, FALSE, 'Rusia', 'C', 24),
(96, FALSE, 'Estados Unidos', 'D', 24);

INSERT INTO Respuesta (id, esCorreto, descripción, letra, pregunta_id)
VALUES 
(97, TRUE, '56', 'A', 25),
(98, FALSE, '64', 'B', 25),
(99, FALSE, '42', 'C', 25),
(100, FALSE, '36', 'D', 25);

-- Preguntas Difíciles
INSERT INTO Respuesta (id, esCorreto, descripción, letra, pregunta_id)
VALUES 
(101, TRUE, '12', 'A', 26),
(102, FALSE, '6', 'B', 26),
(103, FALSE, '9', 'C', 26),
(104, FALSE, '16', 'D', 26);

INSERT INTO Respuesta (id, esCorreto, descripción, letra, pregunta_id)
VALUES 
(105, TRUE, 'Reikiavik', 'A', 27),
(106, FALSE, 'Helsinki', 'B', 27),
(107, FALSE, 'Oslo', 'C', 27),
(108, FALSE, 'Estocolmo', 'D', 27);

INSERT INTO Respuesta (id, esCorreto, descripción, letra, pregunta_id)
VALUES 
(109, TRUE, '1945', 'A', 28),
(110, FALSE, '1918', 'B', 28),
(111, FALSE, '1939', 'C', 28),
(112, FALSE, '1954', 'D', 28);

INSERT INTO Respuesta (id, esCorreto, descripción, letra, pregunta_id)
VALUES 
(113, TRUE, 'Nitrógeno', 'A', 29),
(114, FALSE, 'Oxígeno', 'B', 29),
(115, FALSE, 'Dióxido de carbono', 'C', 29),
(116, FALSE, 'Hidrógeno', 'D', 29);

INSERT INTO Respuesta (id, esCorreto, descripción, letra, pregunta_id)
VALUES 
(117, TRUE, 'Yuri Gagarin', 'A', 30),
(118, FALSE, 'Neil Armstrong', 'B', 30),
(119, FALSE, 'Buzz Aldrin', 'C', 30),
(120, FALSE, 'John Glenn', 'D', 30);


use quizquest_db;
select * from usuario;
select * from partida where usuario_id = 4 order by id desc limit 3;
select * from pregunta;
select * from partida where usuario_id  = 4;
update usuario set CorreoElectronico ="alanaruquipa242@gmail.com" , Sexo ="Masculino" WHERE id = 4;
update usuario set nivel ="NOVATO" WHERE id = 1;
update usuario set nivel ="AVANZADO" WHERE id = 2;
update usuario set nivel ="AVANZADO" WHERE id = 3;