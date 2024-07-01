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
    nivel VARCHAR (100) NOT NULL,
    trampitas INT DEFAULT 0,
    fechaCreacion DATE
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
    nombre  VARCHAR(100) NOT NULL,
    puntaje INT          NOT NULL,
    codigo int not null unique,
	usuario_id INT NOT NULL,
	fechaCreacion DATE,
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
	fechaCreacion DATE,
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

CREATE TABLE venta(
	id int not null auto_increment,
    cantidad int not null,
    precio int not null,
    usuario_id int not null,
    constraint pk_venta primary key (id),
    constraint fk_venta foreign key (usuario_id) references usuario(id)
);

-- Insertar datos en la tabla Usuario
INSERT INTO Usuario (id, imagen, rol, nombreCompleto, esHabilitado, fechaNacimiento, Sexo, CorreoElectronico, contrasena,
                     nombrerUsuario,pais,ciudad,cantidad_dadas, cantidad_acertadas, ratio, nivel, trampitas,fechaCreacion)
VALUES (1, NULL, 'Basico', 'Juan Pérez', TRUE, "1985-01-02", "Masculino", 'juan.perez@example.com', 'password123', 'juanperez', "Argentina", "Buenos Aires",100,90,90,"AVANZADO", 0, "2000-01-10"),
       (2, NULL, 'Basico', 'Ana López', TRUE,  "1990-01-02", "Femenino" , 'ana.lopez@example.com', 'password456', 'analia123', "Argentina", "Buenos Aires",100,90,90,"AVANZADO",0,"2010-01-10"),
       (3, NULL, 'Basico', 'Carlos García', TRUE,  "1975-01-02", "Masculino" , 'carlos.garcia@example.com', 'password789', 'carlosgomez',"Argentina", "Buenos Aires",100,90,90,"AVANZADO",0,"2012-02-10"),
       (4, NULL, 'Basico', 'Jose Gomez', TRUE, '1995-11-15', 'Masculino', 'jose.gomez@example.com', 'password789', 'jose1234', 'México', 'Ciudad de México', 80, 75, 93, 'AVANZADO',0,"2009-02-10"),
	   (5, NULL, 'Basico', 'María García', TRUE, '1987-04-23', 'Femenino', 'maria.garcia@example.com', 'password987', 'maria.g', 'España', 'Madrid', 120, 110, 91, 'AVANZADO',0,"2004-01-01"),
	   (6, NULL, 'Basico', 'Carlos Martínez', TRUE, '2000-02-29', 'Masculino', 'carlos.martinez@example.com', 'password123', 'carlosm_29', 'Colombia', 'Bogotá', 95, 85, 89.47, 'AVANZADO',0,"2004-02-10"),
	   (7, NULL, 'Basico', 'Laura Fernández', TRUE, '1998-09-10', 'Femenino', 'laura.fernandez@example.com', 'passwordabc', 'laura_f', 'Argentina', 'Córdoba', 85, 80, 94.12, 'AVANZADO',0,"2018-02-10"),
       (8, NULL, 'Basico', 'Pedro Rodríguez', TRUE, '1993-12-05', 'Masculino', 'pedro.rodriguez@example.com', 'password456', 'pedrorod', 'Chile', 'Santiago', 110, 105, 95.45, 'AVANZADO',0, "2020-02-10"),
	   (9, NULL, 'Basico', 'Ana Ramírez', TRUE, '1990-10-08', 'Femenino', 'ana.ramirez@example.com', 'password789', 'ana_ram', 'España', 'Barcelona', 70, 65, 92.86, 'AVANZADO',0,"2020-01-10"),
       (10, NULL, 'Basico', 'Jorge Sánchez', TRUE, '1997-04-30', 'Masculino', 'jorge.sanchez@example.com', 'passwordxyz', 'jsancho', 'México', 'Guadalajara', 100, 95, 95, 'AVANZADO',0,"2014-02-10"),
	   (11, NULL, 'Basico', 'Lucía Morales', TRUE, '2003-02-14', 'Femenino', 'lucia.morales@example.com', 'password123', 'lucia_m', 'España', 'Valencia', 50, 40, 80, 'NOVATO',0,"2022-02-02"),
	   (12, NULL, 'Basico', 'Martín González', TRUE, '2001-12-03', 'Masculino', 'martin.gonzalez@example.com', 'password456', 'martin_g', 'Argentina', 'Rosario', 55, 45, 81.82, 'NOVATO',0,"2019-02-10"),
	   (13, NULL, 'Basico', 'Sofía Hernández', TRUE, '2000-08-20', 'Femenino', 'sofia.hernandez@example.com', 'password789', 'sofia_h', 'México', 'Monterrey', 40, 35, 87.5, 'NOVATO',0,"2019-08-10"),
	   (14, NULL, 'Basico', 'Mateo Díaz', TRUE, '2005-01-10', 'Masculino', 'mateo.diaz@example.com', 'passwordabc', 'mateo_d', 'Colombia', 'Medellín', 48, 42, 87.5, 'NOVATO',0,"2015-02-10"),
	   (15, NULL, 'Basico', 'Alan', TRUE, '2004-10-25', 'Femenino', 'alan@gmail.com', 'pachan242', 'alan', 'Argentina', 'Buenos Aires', 80, 80, 100, 'AVANZADO',0,"2014-02-10");

       
insert into usuario (id, imagen, rol, nombreCompleto, esHabilitado, fechaNacimiento, Sexo, CorreoElectronico, contrasena,
nombrerUsuario,pais,ciudad,cantidad_dadas, cantidad_acertadas, ratio, nivel, trampitas) values(100, NULL, 'Basico', 'BOT', TRUE, '', '', '', '', 'BOT', '', '', 0, 0, 0, 'INDEFINIDO',0);
-- Editor y administrador



-- Insertar partidas
-- Insert para Juan Pérez (Usuario ID: 1)
INSERT INTO Partida (nombre, puntaje, codigo, usuario_id,fechaCreacion)
VALUES ('Partida#1', 150, 1, 1,"20000110");
INSERT INTO Usuario (id, imagen, rol, nombreCompleto, esHabilitado, fechaNacimiento, Sexo, CorreoElectronico, contrasena,
                     nombrerUsuario,pais,ciudad,cantidad_dadas, cantidad_acertadas, ratio, nivel, trampitas,fechaCreacion)
VALUES (16, NULL, 'Editor', 'Editor Quizquest', TRUE, "1985-01-02", "Masculino", 'editor@gmail.com', 'editor1234', 'editor', "Argentina", "Buenos Aires",0,9,0,"NOVATO", 0, "2000-01-10"),
       (17, NULL, 'Administrador', 'Admin Quizquest', TRUE, "1985-01-02", "Masculino", 'admin@gmail.com', 'admin1234', 'admin', "Argentina", "Buenos Aires",0,9,0,"NOVATO", 0, "2000-01-10");

-- Insert para Ana López (Usuario ID: 2)
INSERT INTO Partida (nombre, puntaje, codigo, usuario_id,fechaCreacion)
VALUES ('Partida#2', 140, 2, 2,"20100110");

-- Insert para Carlos García (Usuario ID: 3)
INSERT INTO Partida (nombre, puntaje, codigo, usuario_id,fechaCreacion)
VALUES ('Partida#3', 200, 3, 3,"20120210");

-- Insert para Jose Gomez (Usuario ID: 4)
INSERT INTO Partida (nombre, puntaje, codigo, usuario_id,fechaCreacion)
VALUES ('Partida#4', 300, 4, 4,"20090210");

-- Insert para María García (Usuario ID: 5)
INSERT INTO Partida (nombre, puntaje, codigo, usuario_id,fechaCreacion)
VALUES ('Partida#5', 90, 5, 5,"20040101");

-- Insert para Carlos Martínez (Usuario ID: 6)
INSERT INTO Partida (nombre, puntaje, codigo, usuario_id,fechaCreacion)
VALUES ('Partida#6', 1700, 6, 6,"20040210");

-- Insert para Laura Fernández (Usuario ID: 7)
INSERT INTO Partida (nombre, puntaje, codigo, usuario_id,fechaCreacion)
VALUES ('Partida#7', 1600, 7, 7,"20180210");

-- Insert para Pedro Rodríguez (Usuario ID: 8)
INSERT INTO Partida (nombre, puntaje, codigo, usuario_id,fechaCreacion)
VALUES ('Partida#8', 80, 8, 8,"20200210");

-- Insert para Ana Ramírez (Usuario ID: 9)
INSERT INTO Partida (nombre, puntaje, codigo, usuario_id,fechaCreacion)
VALUES ('Partida#9', 100, 9, 9,"20200110");

-- Insert para Jorge Sánchez (Usuario ID: 10)
INSERT INTO Partida (nombre, puntaje, codigo, usuario_id, fechaCreacion)
VALUES ('Partida#10', 350, 10, 10,"20140210");

-- Insert para Lucía Morales (Usuario ID: 11)
INSERT INTO Partida (nombre, puntaje, codigo, usuario_id,fechaCreacion)
VALUES ('Partida#11', 400, 11, 11,"20220202");

-- Insert para Martín González (Usuario ID: 12)
INSERT INTO Partida (nombre, puntaje, codigo, usuario_id,fechaCreacion)
VALUES ('Partida#12', 100, 12, 12,"20190210");

-- Insert para Sofía Hernández (Usuario ID: 13)
INSERT INTO Partida (nombre, puntaje, codigo, usuario_id,fechaCreacion)
VALUES ('Partida#13', 40, 13, 13,"20190810");

-- Insert para Mateo Díaz (Usuario ID: 14)
INSERT INTO Partida (nombre, puntaje, codigo, usuario_id,fechaCreacion)
VALUES ('Partida#14', 950, 144, 14,"20150210");

-- Insert para Valentina Ruiz (Usuario ID: 15)
INSERT INTO Partida (nombre, puntaje, codigo, usuario_id,fechaCreacion)
VALUES ('Partida#15', 120, 15, 15,"20150210");

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


-- Mas preguntas y respuestaas
INSERT INTO Pregunta (id, descripcion, punto, esValido, categoria_id, cantidad_dadas, acertadas, porcentaje)
VALUES 
    (32, "¿Cuál es la capital de Italia?", 10, TRUE, 5, 150, 100, 66.67);
INSERT INTO Respuesta (id, esCorreto, descripción, letra, pregunta_id)
VALUES 
    (121, TRUE, 'Roma', 'A', 32),
    (122, FALSE, 'París', 'B', 32),
    (123, FALSE, 'Londres', 'C', 32),
    (124, FALSE, 'Berlín', 'D', 32);

INSERT INTO Pregunta (id, descripcion, punto, esValido, categoria_id, cantidad_dadas, acertadas, porcentaje)
VALUES 
    -- Preguntas fáciles (entre 50 y 100 de porcentaje)
    (33, "¿Cuántos lados tiene un triángulo?", 10, TRUE, 1, 100, 100, 100),
    (34, "¿En qué país se encuentra la Torre Eiffel?", 10, TRUE, 2, 80, 80, 100),
    (35, "¿Cuál es el resultado de 5 + 3?", 10, TRUE, 3, 120, 120, 100),
    (36, "¿Cuál es el océano más grande del mundo?", 10, TRUE, 4, 90, 90, 100),
    (37, "¿Cuál es el animal más grande del mundo?", 10, TRUE, 5, 70, 70, 100),
    
    -- Preguntas intermedias (entre 25 y 49 de porcentaje)
    (38, "¿En qué año comenzó la Primera Guerra Mundial?", 10, TRUE, 1, 80, 40, 50),
    (39, "¿Cuál es el valor de pi (π)?", 10, TRUE, 3, 70, 35, 50),
    (40, "¿Qué es la fotosíntesis?", 10, TRUE, 4, 100, 50, 50),
    (41, "¿Quién escribió 'Don Quijote de la Mancha'?", 10, TRUE, 5, 50, 25, 50),

    -- Preguntas difíciles (entre 0 y 24 de porcentaje)
    (42, "¿Cuál es el resultado de 2^10?", 10, TRUE, 1, 60, 10, 16.67),
    (43, "¿Cuál es la capital de Mongolia?", 10, TRUE, 2, 40, 8, 20),
    (44, "¿Cuál es la temperatura de congelación del agua en grados Celsius?", 10, TRUE, 3, 50, 12, 24),
    (45, "¿En qué año se descubrió América por Cristóbal Colón?", 10, TRUE, 4, 30, 7, 23.33),
    (46, "¿Cuál es el hueso más largo del cuerpo humano?", 10, TRUE, 5, 20, 4, 20),
   
	(47, "¿Cuántos elementos químicos tiene la tabla periódica?", 10, TRUE, 1, 40, 8, 20),
    (48, "¿En qué año se inventó la imprenta?", 10, TRUE, 2, 30, 5, 16.67),
    (49, "¿Cuál es la velocidad de la luz en el vacío?", 10, TRUE, 3, 20, 4, 20),
    (50, "¿Cuántas patas tiene una araña?", 10, TRUE, 5, 15, 3, 20),
	(51, "¿Cuál es la montaña más alta del mundo?", 10, TRUE, 5, 30, 6, 20);

INSERT INTO Respuesta (id, esCorreto, descripción, letra, pregunta_id)
VALUES 
    -- Respuestas para las preguntas fáciles
    (125, TRUE, 'Tres', 'A', 33),
    (126, FALSE, 'Cuatro', 'B', 33),
    (127, FALSE, 'Dos', 'C', 33),
    (128, FALSE, 'Cinco', 'D', 33),
    (129, TRUE, 'Francia', 'A', 34),
    (130, FALSE, 'España', 'B', 34),
    (131, FALSE, 'Italia', 'C', 34),
    (132, FALSE, 'Alemania', 'D', 34),
    (133, TRUE, 'Ocho', 'A', 35),
    (134, FALSE, 'Seis', 'B', 35),
    (135, FALSE, 'Diez', 'C', 35),
    (136, FALSE, 'Doce', 'D', 35),
    (137, TRUE, 'Pacífico', 'A', 36),
    (138, FALSE, 'Atlántico', 'B', 36),
    (139, FALSE, 'Índico', 'C', 36),
    (140, FALSE, 'Ártico', 'D', 36),
    (141, TRUE, 'Ballena azul', 'A', 37),
    (142, FALSE, 'Elefante africano', 'B', 37),
    (143, FALSE, 'Oso polar', 'C', 37),
    (144, FALSE, 'Jirafa', 'D', 37),
    
    -- Respuestas para las preguntas intermedias
    (145, TRUE, '1914', 'A', 38),
    (146, FALSE, '1918', 'B', 38),
    (147, FALSE, '1939', 'C', 38),
    (148, FALSE, '1945', 'D', 38),
    (149, TRUE, '3.14159', 'A', 39),
    (150, FALSE, '2.71828', 'B', 39),
    (151, FALSE, '1.61803', 'C', 39),
    (152, FALSE, '1.73205', 'D', 39),
    (153, TRUE, 'Proceso por el cual las plantas convierten la luz solar en energía', 'A', 40),
    (154, FALSE, 'Proceso por el cual las plantas absorben agua del suelo', 'B', 40),
    (155, FALSE, 'Proceso por el cual las plantas respiran dióxido de carbono', 'C', 40),
    (156, FALSE, 'Proceso por el cual las plantas producen oxígeno', 'D',40),
    (157, TRUE, 'Miguel de Cervantes', 'A', 41),
    (158, FALSE, 'Gabriel García Márquez', 'B', 41),
    (159, FALSE, 'Pablo Neruda', 'C', 41),
    (160, FALSE, 'William Shakespeare', 'D', 41),

    -- Respuestas para las preguntas difíciles
    (161, TRUE, '1024', 'A', 42),
    (162, FALSE, '512', 'B', 42),
    (163, FALSE, '2048', 'C', 42),
    (164, FALSE, '256', 'D', 42),
    (165, TRUE, 'Ulán Bator', 'A', 43),
    (166, FALSE, 'Bangkok', 'B', 43),
    (167, FALSE, 'Hanoi', 'C', 43),
    (168, FALSE, 'Dhaka', 'D', 43),
    (169, TRUE, '0 grados Celsius', 'A', 44),
    (170, FALSE, '100 grados Celsius', 'B', 44),
    (171, FALSE, '-10 grados Celsius', 'C', 44),
    (172, FALSE, '25 grados Celsius', 'D', 44),
    (173, TRUE, '1492', 'A', 45),
    (174, FALSE, '1498', 'B', 45),
    (175, FALSE, '1500', 'C', 45),
    (176, FALSE, '1502', 'D', 45),
    (177, TRUE, 'Fémur', 'A', 46),
    (178, FALSE, 'Húmero', 'B', 46),
    (179, FALSE, 'Fíbula', 'C', 46),
    (180, FALSE, 'Tibia', 'D', 46),
	(181, TRUE, '118', 'A', 47),
    (182, FALSE, '92', 'B', 47),
    (183, FALSE, '109', 'C', 47),
    (184, FALSE, '103', 'D', 47),
    (185, TRUE, '1440', 'A', 48),
    (186, FALSE, '1450', 'B', 48),
    (187, FALSE, '1430', 'C', 48),
    (188, FALSE, '1460', 'D', 48),
    (189, TRUE, '299,792,458 m/s', 'A', 49),
    (190, FALSE, '300,000,000 m/s', 'B', 49),
    (191, FALSE, '250,000,000 m/s', 'C', 49),
    (192, FALSE, '350,000,000 m/s', 'D', 49),
    (193, TRUE, '8', 'A', 50),
    (194, FALSE, '6', 'B', 50),
    (195, FALSE, '10', 'C', 50),
    (196, FALSE, '12', 'D', 50),
	(197, TRUE, 'Monte Everest', 'A', 51),
    (198, FALSE, 'Monte Kilimanjaro', 'B', 51),
    (199, FALSE, 'Monte McKinley', 'C',51),
    (200, FALSE, 'Monte Vinson', 'D',51);
