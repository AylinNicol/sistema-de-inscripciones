-- ============================
-- RESET DESDE CERO (OPCIONAL)
-- ============================

DROP DATABASE IF EXISTS `eventos`;
CREATE DATABASE `eventos`
  DEFAULT CHARACTER SET utf8mb4
  COLLATE utf8mb4_general_ci;

USE `eventos`;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";
/*!40101 SET NAMES utf8mb4 */;

-- Borrar en orden de dependencias
DROP TABLE IF EXISTS detalles_eventos;
DROP TABLE IF EXISTS inscripciones;
DROP TABLE IF EXISTS programas;
DROP TABLE IF EXISTS participantes;
DROP TABLE IF EXISTS organizadores;
DROP TABLE IF EXISTS administrativos;
DROP TABLE IF EXISTS expositores;
DROP TABLE IF EXISTS comisiones;
DROP TABLE IF EXISTS eventos;
DROP TABLE IF EXISTS usuarios;

-- ============================
-- CREACIÓN DE TABLAS
-- ============================

CREATE TABLE usuarios (
  cod_usuario INT(11) NOT NULL AUTO_INCREMENT,
  cuenta VARCHAR(30) NOT NULL,
  contraseña VARCHAR(50) NOT NULL,
  nombres_usuario VARCHAR(45) NOT NULL,
  apellidos_usuario VARCHAR(45) DEFAULT NULL,
  foto_usuario VARCHAR(300) DEFAULT NULL,
  correo_usuario VARCHAR(50) DEFAULT NULL,
  ci_usuario INT(11) NOT NULL,
  PRIMARY KEY (cod_usuario),
  UNIQUE KEY ci_usuario_UNIQUE (ci_usuario),
  UNIQUE KEY cuenta_UNIQUE (cuenta)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE administrativos (
  cod_administrativo INT(11) NOT NULL AUTO_INCREMENT,
  cargo VARCHAR(30) NOT NULL,
  fecha_nac DATE NOT NULL,
  cod_usuario INT(11) NOT NULL,
  PRIMARY KEY (cod_administrativo),
  KEY cod_usuario (cod_usuario),
  CONSTRAINT administrativos_ibfk_1 FOREIGN KEY (cod_usuario) REFERENCES usuarios (cod_usuario) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE comisiones (
  cod_comision INT(11) NOT NULL AUTO_INCREMENT,
  nombre VARCHAR(30) NOT NULL,
  descripcion VARCHAR(300) NOT NULL,
  PRIMARY KEY (cod_comision)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE eventos (
  cod_evento INT(11) NOT NULL AUTO_INCREMENT,
  nombre_evento VARCHAR(100) NOT NULL,
  fecha_inicio DATE NOT NULL,
  fecha_fin DATE NOT NULL,
  carrera VARCHAR(50) NOT NULL,
  material VARCHAR(100) DEFAULT NULL,
  costo FLOAT NOT NULL,
  tipo_evento VARCHAR(25) NOT NULL,
  poster VARCHAR(300) DEFAULT NULL,
  certificado VARCHAR(300) DEFAULT NULL,
  PRIMARY KEY (cod_evento)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE expositores (
  cod_expositor INT(11) NOT NULL AUTO_INCREMENT,
  nombres_expositor VARCHAR(45) NOT NULL,
  apellidos_expositor VARCHAR(45) NOT NULL,
  correo_expositor VARCHAR(30) NOT NULL,
  celular_expositor INT(11) NOT NULL,
  nacionalidad VARCHAR(50) NOT NULL,
  foto_expositor VARCHAR(300) DEFAULT NULL,
  ci_expositor INT(11) NOT NULL,
  PRIMARY KEY (cod_expositor),
  UNIQUE KEY ci_expositor_UNIQUE (ci_expositor)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE organizadores (
  cod_organizador INT(11) NOT NULL AUTO_INCREMENT,
  carrera VARCHAR(30) NOT NULL,
  rol VARCHAR(20) NOT NULL,
  cod_usuario INT(11) NOT NULL,
  celular INT(11) DEFAULT NULL,
  PRIMARY KEY (cod_organizador),
  KEY cod_usuario (cod_usuario),
  CONSTRAINT organizadores_ibfk_1 FOREIGN KEY (cod_usuario) REFERENCES usuarios (cod_usuario) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE participantes (
  cod_participante INT(11) NOT NULL AUTO_INCREMENT,
  ci INT(11) NOT NULL,
  nombres_participante VARCHAR(45) NOT NULL,
  apellidos_participante VARCHAR(45) NOT NULL,
  celular INT(11) DEFAULT NULL,
  correo VARCHAR(30) DEFAULT NULL,
  institucion VARCHAR(50) NOT NULL,
  PRIMARY KEY (cod_participante),
  UNIQUE KEY ci_UNIQUE (ci)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE programas (
  cod_programa INT(11) NOT NULL AUTO_INCREMENT,
  cod_evento INT(11) NOT NULL,
  cod_expositor INT(11) NOT NULL,
  tema VARCHAR(100) NOT NULL,
  hora_inicio TIME NOT NULL,
  hora_fin TIME NOT NULL,
  fecha DATE NOT NULL,
  PRIMARY KEY (cod_programa),
  KEY cod_evento (cod_evento),
  KEY cod_expositor (cod_expositor),
  CONSTRAINT programas_ibfk_1 FOREIGN KEY (cod_expositor) REFERENCES expositores (cod_expositor) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT programas_ibfk_2 FOREIGN KEY (cod_evento) REFERENCES eventos (cod_evento) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE inscripciones (
  cod_inscripcion INT(11) NOT NULL AUTO_INCREMENT,
  cod_evento INT(11) NOT NULL,
  fecha_inscripcion DATE NOT NULL,
  cod_participante INT(11) NOT NULL,
  promocion FLOAT NOT NULL DEFAULT 0,
  pago VARCHAR(20) NOT NULL,
  PRIMARY KEY (cod_inscripcion),
  KEY cod_evento (cod_evento),
  KEY cod_participante (cod_participante),
  CONSTRAINT inscripciones_ibfk_1 FOREIGN KEY (cod_evento) REFERENCES eventos (cod_evento) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT inscripciones_ibfk_2 FOREIGN KEY (cod_participante) REFERENCES participantes (cod_participante) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE detalles_eventos (
  cod_detalle INT(11) NOT NULL AUTO_INCREMENT,
  cod_evento INT(11) NOT NULL,
  cod_organizador INT(11) NOT NULL,
  cod_comision INT(11) NOT NULL,
  PRIMARY KEY (cod_detalle),
  KEY cod_evento (cod_evento),
  KEY cod_organizador (cod_organizador),
  KEY cod_comision (cod_comision),
  CONSTRAINT detalles_eventos_ibfk_1 FOREIGN KEY (cod_evento) REFERENCES eventos (cod_evento) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT detalles_eventos_ibfk_2 FOREIGN KEY (cod_organizador) REFERENCES organizadores (cod_organizador) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT detalles_eventos_ibfk_3 FOREIGN KEY (cod_comision) REFERENCES comisiones (cod_comision) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ============================
-- INSERTS
-- ============================

-- ===== USUARIOS: DOCENTES (PLANTEL 2025) =====
-- contraseña: SHA1('sistemas2025')
INSERT INTO usuarios (cuenta, contraseña, nombres_usuario, apellidos_usuario, foto_usuario, correo_usuario, ci_usuario) VALUES
('nelson_tapia',      SHA1('sistemas2025'), 'Nelson',           'Tapia Hinojosa',         'tapia-nelson.jpg',        'nelson.tapia@sistemas.edu.bo',        70000001),
('maria_andrade',     SHA1('sistemas2025'), 'Maria Angelica',   'Andrade Zeballos',       'andrade-maria.jpg',       'maria.andrade@sistemas.edu.bo',       70000002),
('renee_arrien',      SHA1('sistemas2025'), 'Renee Jaime',      'Arrien Ayala',           'arrien-renee.jpg',        'renee.arrien@sistemas.edu.bo',        70000003),
('juan_barrios',      SHA1('sistemas2025'), 'Juan',             'Barrios Cordova',        'barrios-juan.jpg',        'juan.barrios@sistemas.edu.bo',        70000004),
('julio_bermudez',    SHA1('sistemas2025'), 'Julio Cesar',      'Bermudez Vargas',        'bermudez-julio.jpg',      'julio.bermudez@sistemas.edu.bo',      70000005),
('ramiro_bernal',     SHA1('sistemas2025'), 'Ramiro Marcial',   'Bernal Martinez',        'bernal-ramiro.jpg',       'ramiro.bernal@sistemas.edu.bo',       70000006),
('andy_cespedes',     SHA1('sistemas2025'), 'Andy Alex',        'Cespedes Rojas',         'cespedes-andy.jpg',       'andy.cespedes@sistemas.edu.bo',       70000007),
('franz_chinche',     SHA1('sistemas2025'), 'Franz',            'Chinche Imana',          'chinche-franz.jpg',       'franz.chinche@sistemas.edu.bo',       70000008),
('juan_choque',       SHA1('sistemas2025'), 'Juan Gregorio',    'Choque Uno',             'choque-juan.jpg',         'juan.choque@sistemas.edu.bo',         70000009),
('cesar_escalante',   SHA1('sistemas2025'), 'Cesar Fernando',   'Escalante Lunario',      'escalante-cesar.jpg',     'cesar.escalante@sistemas.edu.bo',     70000010),
('roly_fernandez',    SHA1('sistemas2025'), 'Roly Marcos',      'Fernandez Gutierrez',    'fernandez-roly.jpg',      'roly.fernandez@sistemas.edu.bo',      70000011),
('hernan_helguero',   SHA1('sistemas2025'), 'Hernan Luis',      'Helguero Velasquez',     'helguero-hernan.jpg',     'hernan.helguero@sistemas.edu.bo',     70000012),
('ronald_huanca',     SHA1('sistemas2025'), 'Ronald',           'Huanca Calle',           'huanca-ronald.jpg',       'ronald.huanca@sistemas.edu.bo',       70000013),
('dennis_martinez',   SHA1('sistemas2025'), 'Dennis',           'Martinez Crovo',         'martinez-dennis.jpg',     'dennis.martinez@sistemas.edu.bo',     70000014),
('david_mayta',       SHA1('sistemas2025'), 'David Edgar',      'Mayta Sarmiento',        'mayta-david.jpg',         'david.mayta@sistemas.edu.bo',         70000015),
('ruben_medinaceli',  SHA1('sistemas2025'), 'Ruben',            'Medinaceli Ortiz',       'medinaceli-ruben.jpg',    'ruben.medinaceli@sistemas.edu.bo',    70000016),
('elizabeth_mejia',   SHA1('sistemas2025'), 'Elizabeth',        'Mejia Garcia',           'mejia-elizabeth.jpg',     'elizabeth.mejia@sistemas.edu.bo',     70000017),
('ivonne_menacho',    SHA1('sistemas2025'), 'Ivonne Karina',    'Menacho Mollo',          'menacho-ivonne.jpg',      'ivonne.menacho@sistemas.edu.bo',      70000018),
('richard_miranda',   SHA1('sistemas2025'), 'Richard Omar',     'Miranda Alconce',        'miranda-richard.jpg',     'richard.miranda@sistemas.edu.bo',     70000019),
('angel_miranda',     SHA1('sistemas2025'), 'Angel',            'Miranda Siles',          'miranda-angel.jpg',       'angel.miranda@sistemas.edu.bo',       70000020),
('teofilo_misericordia',SHA1('sistemas2025'),'Teofilo Cesar',   'Misericordia Ayaviri',   'misericordia-teofilo.jpg','teofilo.misericordia@sistemas.edu.bo',70000021),
('remy_monzon',       SHA1('sistemas2025'), 'Remy Kenier',      'Monzon Fuentes',         'monzon-remy.jpg',         'remy.monzon@sistemas.edu.bo',         70000022),
('jose_perez',        SHA1('sistemas2025'), 'Jose Luis',        'Perez Ancasi',           'perez-jose.jpg',          'jose.perez@sistemas.edu.bo',          70000023),
('miguel_reynolds',   SHA1('sistemas2025'), 'Miguel Angel',     'Reynolds Salinas',       'reynolds-miguel.jpg',     'miguel.reynolds@sistemas.edu.bo',     70000024),
('orestes_salas',     SHA1('sistemas2025'), 'Orestes',          'Salas Paredes',          'salas-orestes.jpg',       'orestes.salas@sistemas.edu.bo',       70000025),
('edilberto_salgado', SHA1('sistemas2025'), 'Edilberto Lucio',  'Salgado Ari',            'salgado-edilberto.jpg',   'edilberto.salgado@sistemas.edu.bo',   70000026),
('erwin_serrudo',     SHA1('sistemas2025'), 'Erwin Saul',       'Serrudo Condori',        'serrudo-erwin.jpg',       'erwin.serrudo@sistemas.edu.bo',       70000027),
('evelyn_teran',      SHA1('sistemas2025'), 'Evelyn Diana',     'Teran Mejia',            'teran-evelyn.jpg',        'evelyn.teran@sistemas.edu.bo',        70000028),
('gregorio_urena',    SHA1('sistemas2025'), 'Gregorio Fernando','Urena Merida',           'urena-gregorio.jpg',      'gregorio.urena@sistemas.edu.bo',      70000029),
('juan_vallejos',     SHA1('sistemas2025'), 'Juan Carlos',      'Vallejos Paniagua',      'vallejos-juan.jpg',       'juan.vallejos@sistemas.edu.bo',       70000030),
('edwin_villalobos',  SHA1('sistemas2025'), 'Edwin',            'Villalobos Sandy',       'villalobos-edwin.jpg',    'edwin.villalobos@sistemas.edu.bo',    70000031),
('franklin_villanueva',SHA1('sistemas2025'),'Franklin Humberto','Villanueva Fulguera',    'villanueva-franklin.jpg', 'franklin.villanueva@sistemas.edu.bo', 70000032),
('ivar_zabaleta',     SHA1('sistemas2025'), 'Ivar Fernando',    'Zabaleta Rioja',         'zabaleta-ivar.jpg',       'ivar.zabaleta@sistemas.edu.bo',       70000033),
('gerardo_zamora',    SHA1('sistemas2025'), 'Gerardo Ivan',     'Zamora Echenique',       'zamora-gerardo.jpg',      'gerardo.zamora@sistemas.edu.bo',      70000034);

-- ===== ADMINISTRATIVOS (Director + Docentes) =====
-- Fechas de nacimiento de ejemplo
INSERT INTO administrativos (cargo, fecha_nac, cod_usuario) VALUES
('Director', '1979-04-18', (SELECT cod_usuario FROM usuarios WHERE cuenta='nelson_tapia')),

('Docente', '1985-02-11', (SELECT cod_usuario FROM usuarios WHERE cuenta='maria_andrade')),
('Docente', '1984-09-09', (SELECT cod_usuario FROM usuarios WHERE cuenta='renee_arrien')),
('Docente', '1981-05-23', (SELECT cod_usuario FROM usuarios WHERE cuenta='juan_barrios')),
('Docente', '1983-07-14', (SELECT cod_usuario FROM usuarios WHERE cuenta='julio_bermudez')),
('Docente', '1978-10-30', (SELECT cod_usuario FROM usuarios WHERE cuenta='ramiro_bernal')),
('Docente', '1986-01-21', (SELECT cod_usuario FROM usuarios WHERE cuenta='andy_cespedes')),
('Docente', '1987-08-12', (SELECT cod_usuario FROM usuarios WHERE cuenta='franz_chinche')),
('Docente', '1982-03-03', (SELECT cod_usuario FROM usuarios WHERE cuenta='juan_choque')),
('Docente', '1980-12-05', (SELECT cod_usuario FROM usuarios WHERE cuenta='cesar_escalante')),
('Docente', '1981-06-16', (SELECT cod_usuario FROM usuarios WHERE cuenta='roly_fernandez')),
('Docente', '1977-11-27', (SELECT cod_usuario FROM usuarios WHERE cuenta='hernan_helguero')),
('Docente', '1983-02-02', (SELECT cod_usuario FROM usuarios WHERE cuenta='ronald_huanca')),
('Docente', '1986-09-19', (SELECT cod_usuario FROM usuarios WHERE cuenta='dennis_martinez')),
('Docente', '1985-04-07', (SELECT cod_usuario FROM usuarios WHERE cuenta='david_mayta')),
('Docente', '1982-08-25', (SELECT cod_usuario FROM usuarios WHERE cuenta='ruben_medinaceli')),
('Docente', '1988-01-09', (SELECT cod_usuario FROM usuarios WHERE cuenta='elizabeth_mejia')),
('Docente', '1984-12-28', (SELECT cod_usuario FROM usuarios WHERE cuenta='ivonne_menacho')),
('Docente', '1985-03-22', (SELECT cod_usuario FROM usuarios WHERE cuenta='richard_miranda')),
('Docente', '1983-06-02', (SELECT cod_usuario FROM usuarios WHERE cuenta='angel_miranda')),
('Docente', '1979-07-07', (SELECT cod_usuario FROM usuarios WHERE cuenta='teofilo_misericordia')),
('Docente', '1981-09-14', (SELECT cod_usuario FROM usuarios WHERE cuenta='remy_monzon')),
('Docente', '1982-01-24', (SELECT cod_usuario FROM usuarios WHERE cuenta='jose_perez')),
('Docente', '1980-05-20', (SELECT cod_usuario FROM usuarios WHERE cuenta='miguel_reynolds')),
('Docente', '1978-03-13', (SELECT cod_usuario FROM usuarios WHERE cuenta='orestes_salas')),
('Docente', '1983-10-10', (SELECT cod_usuario FROM usuarios WHERE cuenta='edilberto_salgado')),
('Docente', '1984-04-04', (SELECT cod_usuario FROM usuarios WHERE cuenta='erwin_serrudo')),
('Docente', '1986-06-29', (SELECT cod_usuario FROM usuarios WHERE cuenta='evelyn_teran')),
('Docente', '1979-02-15', (SELECT cod_usuario FROM usuarios WHERE cuenta='gregorio_urena')),
('Docente', '1982-07-26', (SELECT cod_usuario FROM usuarios WHERE cuenta='juan_vallejos')),
('Docente', '1985-09-17', (SELECT cod_usuario FROM usuarios WHERE cuenta='edwin_villalobos')),
('Docente', '1981-01-30', (SELECT cod_usuario FROM usuarios WHERE cuenta='franklin_villanueva')),
('Docente', '1984-11-08', (SELECT cod_usuario FROM usuarios WHERE cuenta='ivar_zabaleta')),
('Docente', '1982-05-28', (SELECT cod_usuario FROM usuarios WHERE cuenta='gerardo_zamora'));

-- ===== COMISIONES =====
INSERT INTO comisiones (nombre, descripcion) VALUES
('Acreditacion', 'Registro y acreditacion de participantes'),
('Logistica', 'Soporte de infraestructura, software y hardware'),
('Control Pruebas', 'Ejecucion y control de pruebas'),
('Material', 'Preparacion y provision de material'),
('Evaluacion', 'Evaluacion de resultados y rubricas'),
('Refrigerio', 'Provision de refrigerio'),
('Prensa', 'Cobertura y difusion en medios'),
('Protocolos', 'Protocolo y ceremonial');

-- ===== EVENTOS 2025 (posters/certificados con patrón) =====
INSERT INTO eventos (nombre_evento, fecha_inicio, fecha_fin, carrera, material, costo, tipo_evento, poster, certificado) VALUES
('Congreso de Innovacion y Sistemas 2025', '2025-10-10', '2025-10-13', 'Ingenieria de Sistemas', 'Credencial y carpeta', 120, 'Congreso', 'poster1.png', 'certificado1.png'),
('Jornadas de Software Libre 2025',        '2025-10-25', '2025-10-27', 'Ing. Sistemas / Ing. Informatica', 'Guia de instalacion', 0, 'Jornadas', 'poster2.png', 'certificado2.png'),
('Curso Intensivo: IA aplicada',           '2025-11-05', '2025-11-09', 'Ingenieria Informatica', 'Datasets y notebooks', 180, 'Curso', 'poster3.png', 'certificado3.png'),
('Taller: DevOps y Cloud',                 '2025-11-22', '2025-11-23', 'Ingenieria de Sistemas', 'Acceso a repositorio', 90, 'Taller', 'poster4.png', 'certificado4.png'),
('Seminario: Ciberseguridad',              '2025-12-06', '2025-12-07', 'Ingenieria Informatica', 'Checklist de hardening', 60, 'Seminario', 'poster5.png', 'certificado5.png'),
('Feria Tecnologica Universitaria',        '2025-12-15', '2025-12-16', 'Ing. Sistemas / Ing. Informatica', 'Stand y credencial', 0, 'Feria', 'poster6.png', 'certificado6.png');

-- ===== EXPOSITORES (ejemplo) =====
INSERT INTO expositores (nombres_expositor, apellidos_expositor, correo_expositor, celular_expositor, nacionalidad, foto_expositor, ci_expositor) VALUES
('Laura',  'Suarez Pinto',   'laura.suarez@expo.com',   71122334, 'Bolivia',   'foto1.jpg', 8011122),
('Carlos', 'Meza Dorado',    'carlos.meza@expo.com',    78901234, 'Bolivia',   'foto2.jpg', 8011123),
('Ana',    'Rivas Torres',   'ana.rivas@expo.com',      76543210, 'Chile',     'foto3.jpg', 8011124),
('Diego',  'Garcia Landa',   'diego.garcia@expo.com',   70123456, 'Argentina', 'foto4.jpg', 8011125),
('Marcos', 'Vega Quiroga',   'marcos.vega@expo.com',    77650123, 'Peru',      'foto5.jpg', 8011126),
('Julia',  'Reyes Rocha',    'julia.reyes@expo.com',    72114567, 'Mexico',    'foto6.jpg', 8011127),
('Pedro',  'Flores Pardo',   'pedro.flores@expo.com',   73456780, 'Bolivia',   'foto7.jpg', 8011128),
('Sofia',  'Molina Avila',   'sofia.molina@expo.com',   74678901, 'Colombia',  'foto8.jpg', 8011129),
('Ivan',   'Ortega Ramos',   'ivan.ortega@expo.com',    71234567, 'Espana',    'foto9.jpg', 8011130),
('Lucia',  'Hidalgo Serra',  'lucia.hidalgo@expo.com',  79876543, 'Bolivia',   'foto10.jpg',8011131),
('Tomas',  'Aramayo Lopez',   'tomas.aramayo@expo.com',   71345678, 'Bolivia',  'foto11.jpg', 8011132),
('Brenda', 'Campos Rios',     'brenda.campos@expo.com',   76451230, 'Peru',     'foto12.jpg', 8011133),
('Hector', 'Nuñez Saavedra',  'hector.nunez@expo.com',    77654321, 'Chile',    'foto13.jpg', 8011134),
('Andrea', 'Quispe Montaño',  'andrea.quispe@expo.com',   70199887, 'Bolivia',  'foto14.jpg', 8011135),
('Nicolas','Serrano Paredes', 'nicolas.serrano@expo.com', 76881234, 'Argentina','foto15.jpg', 8011136);

-- ===== USUARIOS: AUXILIARES (todos los de tu lista) =====
-- (cuenta/correo/imagen normalizados: sin acentos, sin eñes)
INSERT INTO usuarios (cuenta, contraseña, nombres_usuario, apellidos_usuario, foto_usuario, correo_usuario, ci_usuario) VALUES
('brayan_anover',    SHA1('sistemas2025'), 'Brayan Cristopher','Anover Silva',         'anover-brayan.jpg',      'brayan.anover@sistemas.edu.bo',    86000001),
('marcelo_antonio',   SHA1('sistemas2025'), 'Marcelo',          'Antonio Mamani',       'antonio-marcelo.jpg',     'marcelo.mamani@sistemas.edu.bo',   86000002),
('rodolfo_arias',    SHA1('sistemas2025'), 'Rodolfo',          'Arias Villegas',       'arias-rodolfo.jpg',      'rodolfo.arias@sistemas.edu.bo',    86000003),
('juan_bautista',    SHA1('sistemas2025'), 'Juan Pedro',       'Bautista Mujica',      'bautista-juan.jpg',      'juan.bautista@sistemas.edu.bo',    86000004),
('alan_beltran',     SHA1('sistemas2025'), 'Alan Joseph',      'Beltran Canaza',       'beltran-alan.jpg',       'alan.beltran@sistemas.edu.bo',     86000005),
('rodrigo_beltran',  SHA1('sistemas2025'), 'Rodrigo',          'Beltran Salvador',     'beltran-rodrigo.jpg',    'rodrigo.beltran@sistemas.edu.bo',  86000006),
('anderson_borras',  SHA1('sistemas2025'), 'Anderson',         'Borras Cruz',          'borras-anderson.jpg',    'anderson.borras@sistemas.edu.bo',  86000007),
('alex_cabezas',     SHA1('sistemas2025'), 'Alex Abraham',     'Cabezas Gutierrez',    'cabezas-alex.jpg',       'alex.cabezas@sistemas.edu.bo',     86000008),
('josue_carlo',      SHA1('sistemas2025'), 'Josue',            'Carlo Gomez',          'carlo-josue.jpg',        'josue.carlo@sistemas.edu.bo',      86000009),
('sergio_chocayta',  SHA1('sistemas2025'), 'Sergio',           'Chocayta Aguilar',     'chocayta-sergio.jpg',    'sergio.chocayta@sistemas.edu.bo',  86000010),
('cristian_choquetopa',SHA1('sistemas2025'),'Cristian',        'Choquetopa Aguilar',   'choquetopa-cristian.jpg','cristian.choquetopa@sistemas.edu.bo',86000011),
('aracely_chura',    SHA1('sistemas2025'), 'Laiz Aracely',     'Chura Choque',         'chura-laiz.jpg',      'laiz.chura@sistemas.edu.bo',       86000012),
('brandon_coca',     SHA1('sistemas2025'), 'Brandon Alexander','Coca Aguilera',        'coca-brandon.jpg',       'brandon.coca@sistemas.edu.bo',     86000013),
('kevin_colque',     SHA1('sistemas2025'), 'Kevin Moises',     'Colque Araviri',       'colque-kevin.jpg',       'kevin.colque@sistemas.edu.bo',     86000014),
('luis_condarco',    SHA1('sistemas2025'), 'Luis Diego',       'Condarco Navarro',     'condarco-luis.jpg',      'luis.condarco@sistemas.edu.bo',    86000015),
('wilder_copa',      SHA1('sistemas2025'), 'Wilder Sandro',    'Copa Calizaya',        'copa-wilder.jpg',        'wilder.copa@sistemas.edu.bo',      86000016),
('brayan_copa',      SHA1('sistemas2025'), 'Brayan Ruben',     'Copa Siles',           'copa-brayan.jpg',        'brayan.copa@sistemas.edu.bo',      86000017),
('najhely_cruz',     SHA1('sistemas2025'), 'Najhely',          'Cruz Antonio',         'cruz-najhely.jpg',       'najhely.cruz@sistemas.edu.bo',     86000018),
('franklin_flores',  SHA1('sistemas2025'), 'Franklin',         'Flores Condori',       'flores-franklin.jpg',    'franklin.flores@sistemas.edu.bo',  86000019),
('christian_flores', SHA1('sistemas2025'), 'Christian Sebastian','Flores Mamani',      'flores-christian.jpg',   'christian.flores@sistemas.edu.bo', 86000020),
('adalid_garcia',    SHA1('sistemas2025'), 'Adalid',           'Garcia Garcia',        'garcia-adalid.jpg',      'adalid.garcia@sistemas.edu.bo',    86000021),
('jose_garcia',      SHA1('sistemas2025'), 'Jose Daniel',      'Garcia Escobar',       'garcia-jose.jpg',        'jose.garcia@sistemas.edu.bo',      86000022),
('deymar_gomez',     SHA1('sistemas2025'), 'Deymar Efrain',    'Gomez Choque',         'gomez-deymar.jpg',       'deymar.gomez@sistemas.edu.bo',     86000023),
('pedro_guevara',    SHA1('sistemas2025'), 'Pedro Mario',      'Guevara Larrea',       'guevara-pedro.jpg',      'pedro.guevara@sistemas.edu.bo',    86000024),
('adrian_gutierrez', SHA1('sistemas2025'), 'Adrian Wilson',    'Gutierrez',            'gutierrez-adrian.jpg',   'adrian.gutierrez@sistemas.edu.bo', 86000025),
('fernando_guzman',  SHA1('sistemas2025'), 'Fernando',         'Guzman Gonzales',      'guzman-fernando.jpg',    'fernando.guzman@sistemas.edu.bo',  86000026),
('roger_hinojosa',   SHA1('sistemas2025'), 'Roger Sergio',     'Hinojosa Cuevas',      'hinojosa-roger.jpg',     'roger.hinojosa@sistemas.edu.bo',   86000027),
('antonio_lazarte',  SHA1('sistemas2025'), 'Antonio',          'Lazarte Anibarro',     'lazarte-antonio.jpg',    'antonio.lazarte@sistemas.edu.bo',  86000028),
('angelica_ledo',    SHA1('sistemas2025'), 'Angelica Linneth', 'Ledo Morales',         'ledo-angelica.jpg',      'angelica.ledo@sistemas.edu.bo',    86000029),
('miguel_llanque',   SHA1('sistemas2025'), 'Miguel Erlan',     'Llanque Fuentes',      'llanque-miguel.jpg',     'miguel.llanque@sistemas.edu.bo',   86000030),
('axel_lopez',       SHA1('sistemas2025'), 'Axel Rolando',     'Lopez Bustamante',     'lopez-axel.jpg',         'axel.lopez@sistemas.edu.bo',       86000031),
('maciel_lopez',     SHA1('sistemas2025'), 'Maciel Leonardo',  'Lopez Cornejo',        'lopez-maciel.jpg',       'maciel.lopez@sistemas.edu.bo',     86000032),
('joaquin_lovera',   SHA1('sistemas2025'), 'Joaquin Eduardo',  'Lovera Flores',        'lovera-joaquin.jpg',     'joaquin.lovera@sistemas.edu.bo',   86000033),
('juan_magne',       SHA1('sistemas2025'), 'Juan Gabriel',     'Magne',                'magne-juan.jpg',         'juan.magne@sistemas.edu.bo',       86000034),
('nataly_mallcu',    SHA1('sistemas2025'), 'Nataly',           'Mallcu Choqueticlla',  'mallcu-nataly.jpg',      'nataly.mallcu@sistemas.edu.bo',    86000035),
('mariana_mamani',   SHA1('sistemas2025'), 'Mariana',          'Mamani Ala',           'mamani-mariana.jpg',     'mariana.mamani@sistemas.edu.bo',   86000036),
('moises_mamani',    SHA1('sistemas2025'), 'Moises',           'Mamani Pillco',        'mamani-moises.jpg',      'moises.mamani@sistemas.edu.bo',    86000037),
('saul_martinez',    SHA1('sistemas2025'), 'Saul Gabriel',     'Martinez Moller',      'martinez-saul.jpg',      'saul.martinez@sistemas.edu.bo',    86000038),
('ricardo_mayta',    SHA1('sistemas2025'), 'Ricardo Ignacio',  'Mayta Cortez',         'mayta-ricardo.jpg',      'ricardo.mayta@sistemas.edu.bo',    86000039),
('alexis_mendivil',  SHA1('sistemas2025'), 'Alexis Andres',    'Mendivil Molina',      'mendivil-alexis.jpg',    'alexis.mendivil@sistemas.edu.bo',  86000040),
('fernando_morales', SHA1('sistemas2025'), 'Fernando',         'Morales Flores',       'morales-fernando.jpg',   'fernando.morales@sistemas.edu.bo', 86000041),
('mauricio_morales', SHA1('sistemas2025'), 'Mauricio Edwin',   'Morales Calderon',     'morales-mauricio.jpg',   'mauricio.morales@sistemas.edu.bo', 86000042),
('aylin_nina',       SHA1('sistemas2025'), 'Aylin Nicol',      'Nina Hannover',        'nina-aylin.jpg',         'aylin.nina@sistemas.edu.bo',       86000043),
('jhonatan_pally',   SHA1('sistemas2025'), 'Jhonatan',         'Pally Cotana',         'pally-jhonatan.jpg',     'jhonatan.pally@sistemas.edu.bo',   86000044),
('mayra_patino',     SHA1('sistemas2025'), 'Mayra Malena',     'Patino Bolivar',       'patino-mayra.jpg',       'mayra.patino@sistemas.edu.bo',     86000045),
('samantha_porrez',  SHA1('sistemas2025'), 'Samantha Zamira',  'Porrez Zabala',        'porrez-samantha.jpg',    'samantha.porrez@sistemas.edu.bo',  86000046),
('jefferson_quinonez',SHA1('sistemas2025'),'Jefferson Gervacio','Quinonez Aguirre',     'quinonez-jefferson.jpg', 'jefferson.quinonez@sistemas.edu.bo',86000047),
('franz_queso',      SHA1('sistemas2025'), 'Franz Ramiro',     'Queso Mamani',         'queso-franz.jpg',        'franz.queso@sistemas.edu.bo',      86000048),
('oriana_rafael',    SHA1('sistemas2025'), 'Oriana Sol',       'Rafael Villca',        'rafael-oriana.jpg',      'oriana.rafael@sistemas.edu.bo',    86000049),
('axel_rios',        SHA1('sistemas2025'), 'Axel Santiago',    'Rios Zegarra',         'rios-axel.jpg',          'axel.rios@sistemas.edu.bo',        86000050),
('miguel_rojas',     SHA1('sistemas2025'), 'Miguel Angel',     'Rojas Varela',         'rojas-miguel.jpg',       'miguel.rojas@sistemas.edu.bo',     86000051),
('john_rodriguez',   SHA1('sistemas2025'), 'John Axl',         'Rodriguez Gutierrez',  'rodriguez-john.jpg',     'john.rodriguez@sistemas.edu.bo',   86000052),
('erwin_salasquispe',SHA1('sistemas2025'), 'Erwin Cristian',   'Salasquispe Mamani',   'salasquispe-erwin.jpg',  'erwin.salasquispe@sistemas.edu.bo',86000053),
('paola_santos',     SHA1('sistemas2025'), 'Paola Gandiva',    'Santos Romero',        'santos-paola.jpg',       'paola.santos@sistemas.edu.bo',     86000054),
('anderson_soria',   SHA1('sistemas2025'), 'Anderson',         'Soria Ramirez',        'soria-anderson.jpg',     'anderson.soria@sistemas.edu.bo',   86000055),
('jorge_tapia',      SHA1('sistemas2025'), 'Jorge Eduardo',    'Tapia Tapia',          'tapia-jorge.jpg',        'jorge.tapia@sistemas.edu.bo',      86000056),
('gaston_tola',      SHA1('sistemas2025'), 'Gaston Gregorio',  'Tola Cruz',            'tola-gaston.jpg',        'gaston.tola@sistemas.edu.bo',      86000057),
('rholy_tupa',       SHA1('sistemas2025'), 'Rholy Elian',      'Tupa Fernandez',       'tupa-rholy.jpg',         'rholy.tupa@sistemas.edu.bo',       86000058),
('ximena_velarde',   SHA1('sistemas2025'), 'Ximena Susy',      'Velarde Rodriguez',    'velarde-ximena.jpg',     'ximena.velarde@sistemas.edu.bo',   86000059),
('kenny_ventura',    SHA1('sistemas2025'), 'Kenny Edgar',      'Ventura Llave',        'ventura-kenny.jpg',      'kenny.ventura@sistemas.edu.bo',    86000060),
('sebastian_villarroel',SHA1('sistemas2025'),'Sebastian',      'Villarroel Velasco',   'villarroel-sebastian.jpg','sebastian.villarroel@sistemas.edu.bo',86000061),
('jose_yucra',       SHA1('sistemas2025'), 'Jose Albert',      'Yucra Calderon',       'yucra-jose.jpg',         'jose.yucra@sistemas.edu.bo',       86000062);

-- ===== ORGANIZADORES: Auxiliares (rol Auxiliar) =====
-- Por simplicidad, carrera = 'Ingenieria de Sistemas' (puedes ajustar por SIS/INF si deseas)
INSERT INTO organizadores (carrera, rol, cod_usuario, celular) VALUES
('Ingenieria de Sistemas','Auxiliar',(SELECT cod_usuario FROM usuarios WHERE cuenta='brayan_anover'),    76123456),
('Ingenieria de Sistemas','Auxiliar',(SELECT cod_usuario FROM usuarios WHERE cuenta='marcelo_antonio'),   70111222),
('Ingenieria de Sistemas','Auxiliar',(SELECT cod_usuario FROM usuarios WHERE cuenta='rodolfo_arias'),    71222333),
('Ingenieria de Sistemas','Auxiliar',(SELECT cod_usuario FROM usuarios WHERE cuenta='juan_bautista'),    72333444),
('Ingenieria de Sistemas','Auxiliar',(SELECT cod_usuario FROM usuarios WHERE cuenta='alan_beltran'),     73444555),
('Ingenieria de Sistemas','Auxiliar',(SELECT cod_usuario FROM usuarios WHERE cuenta='rodrigo_beltran'),  74555666),
('Ingenieria de Sistemas','Auxiliar',(SELECT cod_usuario FROM usuarios WHERE cuenta='anderson_borras'),  75666777),
('Ingenieria de Sistemas','Auxiliar',(SELECT cod_usuario FROM usuarios WHERE cuenta='alex_cabezas'),     76777888),
('Ingenieria de Sistemas','Auxiliar',(SELECT cod_usuario FROM usuarios WHERE cuenta='josue_carlo'),      77888999),
('Ingenieria de Sistemas','Auxiliar',(SELECT cod_usuario FROM usuarios WHERE cuenta='sergio_chocayta'),  78999000),
('Ingenieria de Sistemas','Auxiliar',(SELECT cod_usuario FROM usuarios WHERE cuenta='cristian_choquetopa'),70123457),
('Ingenieria de Sistemas','Auxiliar',(SELECT cod_usuario FROM usuarios WHERE cuenta='aracely_chura'),    71234568),
('Ingenieria de Sistemas','Auxiliar',(SELECT cod_usuario FROM usuarios WHERE cuenta='brandon_coca'),     72345679),
('Ingenieria de Sistemas','Auxiliar',(SELECT cod_usuario FROM usuarios WHERE cuenta='kevin_colque'),     73456790),
('Ingenieria de Sistemas','Auxiliar',(SELECT cod_usuario FROM usuarios WHERE cuenta='luis_condarco'),    74567901),
('Ingenieria de Sistemas','Auxiliar',(SELECT cod_usuario FROM usuarios WHERE cuenta='wilder_copa'),      75679012),
('Ingenieria de Sistemas','Auxiliar',(SELECT cod_usuario FROM usuarios WHERE cuenta='brayan_copa'),      76790123),
('Ingenieria de Sistemas','Auxiliar',(SELECT cod_usuario FROM usuarios WHERE cuenta='najhely_cruz'),     77901234),
('Ingenieria de Sistemas','Auxiliar',(SELECT cod_usuario FROM usuarios WHERE cuenta='franklin_flores'),  78912345),
('Ingenieria de Sistemas','Auxiliar',(SELECT cod_usuario FROM usuarios WHERE cuenta='christian_flores'), 70122334),
('Ingenieria de Sistemas','Auxiliar',(SELECT cod_usuario FROM usuarios WHERE cuenta='adalid_garcia'),    71233445),
('Ingenieria de Sistemas','Auxiliar',(SELECT cod_usuario FROM usuarios WHERE cuenta='jose_garcia'),      72344556),
('Ingenieria de Sistemas','Auxiliar',(SELECT cod_usuario FROM usuarios WHERE cuenta='deymar_gomez'),     73455667),
('Ingenieria de Sistemas','Auxiliar',(SELECT cod_usuario FROM usuarios WHERE cuenta='pedro_guevara'),    74566778),
('Ingenieria de Sistemas','Auxiliar',(SELECT cod_usuario FROM usuarios WHERE cuenta='adrian_gutierrez'), 75677889),
('Ingenieria de Sistemas','Auxiliar',(SELECT cod_usuario FROM usuarios WHERE cuenta='fernando_guzman'),  76788990),
('Ingenieria de Sistemas','Auxiliar',(SELECT cod_usuario FROM usuarios WHERE cuenta='roger_hinojosa'),   77899001),
('Ingenieria de Sistemas','Auxiliar',(SELECT cod_usuario FROM usuarios WHERE cuenta='antonio_lazarte'),  78900112),
('Ingenieria de Sistemas','Auxiliar',(SELECT cod_usuario FROM usuarios WHERE cuenta='angelica_ledo'),    70111223),
('Ingenieria de Sistemas','Auxiliar',(SELECT cod_usuario FROM usuarios WHERE cuenta='miguel_llanque'),   71222334),
('Ingenieria de Sistemas','Auxiliar',(SELECT cod_usuario FROM usuarios WHERE cuenta='axel_lopez'),       72333445),
('Ingenieria de Sistemas','Auxiliar',(SELECT cod_usuario FROM usuarios WHERE cuenta='maciel_lopez'),     73444556),
('Ingenieria de Sistemas','Auxiliar',(SELECT cod_usuario FROM usuarios WHERE cuenta='joaquin_lovera'),   74555667),
('Ingenieria de Sistemas','Auxiliar',(SELECT cod_usuario FROM usuarios WHERE cuenta='juan_magne'),       75666778),
('Ingenieria de Sistemas','Auxiliar',(SELECT cod_usuario FROM usuarios WHERE cuenta='nataly_mallcu'),    76777889),
('Ingenieria de Sistemas','Auxiliar',(SELECT cod_usuario FROM usuarios WHERE cuenta='mariana_mamani'),   77888990),
('Ingenieria de Sistemas','Auxiliar',(SELECT cod_usuario FROM usuarios WHERE cuenta='moises_mamani'),    78999001),
('Ingenieria de Sistemas','Auxiliar',(SELECT cod_usuario FROM usuarios WHERE cuenta='saul_martinez'),    70133446),
('Ingenieria de Sistemas','Auxiliar',(SELECT cod_usuario FROM usuarios WHERE cuenta='ricardo_mayta'),    71244557),
('Ingenieria de Sistemas','Auxiliar',(SELECT cod_usuario FROM usuarios WHERE cuenta='alexis_mendivil'),  72355668),
('Ingenieria de Sistemas','Auxiliar',(SELECT cod_usuario FROM usuarios WHERE cuenta='fernando_morales'), 73466779),
('Ingenieria de Sistemas','Auxiliar',(SELECT cod_usuario FROM usuarios WHERE cuenta='mauricio_morales'), 74577880),
('Ingenieria de Sistemas','Auxiliar',(SELECT cod_usuario FROM usuarios WHERE cuenta='aylin_nina'),       75688991),
('Ingenieria de Sistemas','Auxiliar',(SELECT cod_usuario FROM usuarios WHERE cuenta='jhonatan_pally'),   76799002),
('Ingenieria de Sistemas','Auxiliar',(SELECT cod_usuario FROM usuarios WHERE cuenta='mayra_patino'),     77900113),
('Ingenieria de Sistemas','Auxiliar',(SELECT cod_usuario FROM usuarios WHERE cuenta='samantha_porrez'),  78911224),
('Ingenieria de Sistemas','Auxiliar',(SELECT cod_usuario FROM usuarios WHERE cuenta='jefferson_quinonez'),70122335),
('Ingenieria de Sistemas','Auxiliar',(SELECT cod_usuario FROM usuarios WHERE cuenta='franz_queso'),      71233446),
('Ingenieria de Sistemas','Auxiliar',(SELECT cod_usuario FROM usuarios WHERE cuenta='oriana_rafael'),    72344557),
('Ingenieria de Sistemas','Auxiliar',(SELECT cod_usuario FROM usuarios WHERE cuenta='axel_rios'),        73455668),
('Ingenieria de Sistemas','Auxiliar',(SELECT cod_usuario FROM usuarios WHERE cuenta='miguel_rojas'),     74566779),
('Ingenieria de Sistemas','Auxiliar',(SELECT cod_usuario FROM usuarios WHERE cuenta='john_rodriguez'),   75677880),
('Ingenieria de Sistemas','Auxiliar',(SELECT cod_usuario FROM usuarios WHERE cuenta='erwin_salasquispe'),76788991),
('Ingenieria de Sistemas','Auxiliar',(SELECT cod_usuario FROM usuarios WHERE cuenta='paola_santos'),     77899002),
('Ingenieria de Sistemas','Auxiliar',(SELECT cod_usuario FROM usuarios WHERE cuenta='anderson_soria'),   78900113),
('Ingenieria de Sistemas','Auxiliar',(SELECT cod_usuario FROM usuarios WHERE cuenta='jorge_tapia'),      70111224),
('Ingenieria de Sistemas','Auxiliar',(SELECT cod_usuario FROM usuarios WHERE cuenta='gaston_tola'),      71222335),
('Ingenieria de Sistemas','Auxiliar',(SELECT cod_usuario FROM usuarios WHERE cuenta='rholy_tupa'),       72333446),
('Ingenieria de Sistemas','Auxiliar',(SELECT cod_usuario FROM usuarios WHERE cuenta='ximena_velarde'),   73444557),
('Ingenieria de Sistemas','Auxiliar',(SELECT cod_usuario FROM usuarios WHERE cuenta='kenny_ventura'),    74555668),
('Ingenieria de Sistemas','Auxiliar',(SELECT cod_usuario FROM usuarios WHERE cuenta='sebastian_villarroel'),75666779),
('Ingenieria de Sistemas','Auxiliar',(SELECT cod_usuario FROM usuarios WHERE cuenta='jose_yucra'),       76777880);

-- También agregamos ALGUNOS DOCENTES como organizadores
INSERT INTO organizadores (carrera, rol, cod_usuario, celular) VALUES
('Ingenieria de Sistemas','Docente',(SELECT cod_usuario FROM usuarios WHERE cuenta='edilberto_salgado'),76113322),
('Ingenieria Informatica','Docente',(SELECT cod_usuario FROM usuarios WHERE cuenta='ivonne_menacho'),   76114455);

-- ===== PARTICIPANTES (ejemplo) =====
INSERT INTO participantes (ci, nombres_participante, apellidos_participante, celular, correo, institucion) VALUES
(9001001, 'JUAN', 'PEREZ', 70524895, 'juan.perez@gmail.com', 'U.T.O. - F.N.I. - Ing. Informatica'),
(9001002, 'MARIA', 'LOPEZ', 75148962, 'maria.lopez@gmail.com', 'U.T.O. - F.N.I. - Ing. Electronica'),
(9001003, 'CARLOS', 'GONZALES', 60425487, 'carlos.gonzalez@gmail.com', 'U.T.O. - F.N.I. - Ing. de Sistemas'),
(9001004, 'ANA', 'MARTINEZ', 78459621, 'ana.martinez@gmail.com', 'U.T.O. - F.N.I. - Ing. Industrial'),
(9001005, 'SOFIA', 'GONZALES', 74648798, 'sofia.gonzalez@gmail.com', 'U.T.O. - F.N.I. - Ing. Informatica'),
(9001006, 'ALEJANDRO', 'HERNANDEZ', 78451287, 'alejandro.hernandez@gmail.com', 'U.T.O. - F.N.I. - Ing. Industrial'),
(9001007, 'VALENTINA', 'RAMIREZ', 71457817, 'valentina.ramirez@gmail.com', 'U.T.O. - F.N.I. - Ing. Informatica'),
(9001008, 'MATEO', 'MARTINEZ', 66789563, 'mateo.martinez@gmail.com', 'U.T.O. - F.N.I. - Ing. de Sistemas'),
(9001009, 'CAMILA', 'RODRIGUEZ', 78222452, 'camila.rodriguez@gmail.com', 'U.T.O. - F.N.I. - Ing. Industrial'),
(9001010, 'ERIKA', 'MARTINEZ', 61412131, 'erika.martinez@gmail.com', 'U.T.O. - F.N.I. - Ing. de Sistemas'),
(9001011, 'ISABELLA', 'LOPEZ', 60525515, 'isabella.lopez@gmail.com', 'U.T.O. - F.N.I. - Ing. Electrica'),
(9001012, 'MARIANA', 'MAMANI', 60483607, 'mariana.mamani@gmail.com', 'U.T.O. - F.N.I. - Ing. Informatica');

-- ===== INSCRIPCIONES (2025) =====
INSERT INTO inscripciones (cod_evento, fecha_inscripcion, cod_participante, promocion, pago) VALUES
(1, '2025-03-01', 1, 0, 'SI'),
(1, '2025-03-02', 2, 0, 'SI'),
(1, '2025-03-03', 3, 0, 'NO'),
(2, '2025-04-10', 4, 0, 'SI'),
(2, '2025-04-12', 5, 0, 'SI'),
(2, '2025-04-12', 6, 0, 'NO'),
(3, '2025-04-28', 7, 10, 'SI'),
(3, '2025-04-30', 8, 0, 'SI'),
(3, '2025-05-01', 9, 0, 'NO'),
(4, '2025-06-01',10, 0, 'SI'),
(4, '2025-06-05',11, 0, 'NO'),
(5, '2025-07-10',12, 0, 'SI');

-- ===== PROGRAMAS (ligados a eventos/expositores) =====
INSERT INTO programas (cod_evento, cod_expositor, tema, hora_inicio, hora_fin, fecha) VALUES
-- Evento 1: 2025-10-10 a 2025-10-13
(1,  1, 'Apertura e Innovacion en Sistemas',         '09:00:00','10:30:00','2025-10-10'),
(1, 11, 'Tendencias TI 2026: panorama y retos',      '11:00:00','12:30:00','2025-10-10'),
(1,  2, 'Arquitecturas Cloud-Native en la practica', '14:00:00','15:30:00','2025-10-11'),
(1, 12, 'Gobernanza y calidad de datos',             '16:00:00','17:30:00','2025-10-11'),
(1,  3, 'Ciberseguridad para startups',              '09:00:00','10:30:00','2025-10-12'),
(1, 13, 'IA responsable: sesgos y regulacion',       '11:00:00','12:30:00','2025-10-13'),
-- Evento 2: 2025-10-25 a 2025-10-27
(2,  3, 'Instalacion y hardening GNU/Linux',         '09:00:00','11:00:00','2025-10-25'),
(2,  4, 'Automatizacion con Ansible',                '11:30:00','13:00:00','2025-10-25'),
(2, 12, 'Contenedores: seguridad y escaneo',         '09:00:00','10:30:00','2025-10-26'),
(2,  5, 'Migraciones a open source sin dolor',       '11:00:00','12:30:00','2025-10-27'),
-- Evento 3: 2025-11-05 a 2025-11-09
(3,  5, 'Fundamentos de IA aplicada',                '09:00:00','10:30:00','2025-11-05'),
(3,  6, 'MLOps: del notebook a produccion',          '11:00:00','12:30:00','2025-11-05'),
(3, 13, 'Vision por computadora y casos',            '09:00:00','10:30:00','2025-11-07'),
(3, 14, 'NLP aplicado al sector publico',            '11:00:00','12:30:00','2025-11-07'),
(3,  8, 'Etica, privacidad y regulacion en IA',      '15:00:00','16:30:00','2025-11-09'),
-- Evento 4: 2025-11-22 a 2025-11-23
(4,  7, 'CI/CD con Kubernetes y ArgoCD',             '09:00:00','11:00:00','2025-11-22'),
(4,  8, 'Observabilidad: logs, metrics y traces',    '11:30:00','13:00:00','2025-11-22'),
(4, 14, 'SRE practico para pymes',                   '09:00:00','10:30:00','2025-11-23'),
-- Evento 5: 2025-12-06 a 2025-12-07
(5,  9, 'Amenazas emergentes 2025',                  '09:00:00','10:30:00','2025-12-06'),
(5, 10, 'Respuesta a incidentes y playbooks',        '11:00:00','12:30:00','2025-12-06'),
(5, 15, 'Forense digital 101',                       '09:00:00','10:30:00','2025-12-07'),
-- Evento 6: 2025-12-15 a 2025-12-16
(6, 11, 'Pitch de proyectos y demo day',             '10:00:00','12:00:00','2025-12-15'),
(6, 12, 'Evaluacion y retroalimentacion',            '14:00:00','16:00:00','2025-12-15'),
(6,  1, 'Clausura y reconocimientos',                '10:00:00','11:00:00','2025-12-16');

-- ===== DETALLES_EVENTOS (referenciando organizadores por cuenta) =====
INSERT INTO detalles_eventos (cod_evento, cod_organizador, cod_comision) VALUES
(1, (SELECT o.cod_organizador FROM organizadores o JOIN usuarios u ON u.cod_usuario=o.cod_usuario WHERE u.cuenta='brayan_anover'), 1),
(1, (SELECT o.cod_organizador FROM organizadores o JOIN usuarios u ON u.cod_usuario=o.cod_usuario WHERE u.cuenta='marcelo_antonio'), 2),
(2, (SELECT o.cod_organizador FROM organizadores o JOIN usuarios u ON u.cod_usuario=o.cod_usuario WHERE u.cuenta='rodolfo_arias'),  3),
(2, (SELECT o.cod_organizador FROM organizadores o JOIN usuarios u ON u.cod_usuario=o.cod_usuario WHERE u.cuenta='juan_bautista'),  4),
(2, (SELECT o.cod_organizador FROM organizadores o JOIN usuarios u ON u.cod_usuario=o.cod_usuario WHERE u.cuenta='edilberto_salgado'),5),
(3, (SELECT o.cod_organizador FROM organizadores o JOIN usuarios u ON u.cod_usuario=o.cod_usuario WHERE u.cuenta='alan_beltran'),   2),
(3, (SELECT o.cod_organizador FROM organizadores o JOIN usuarios u ON u.cod_usuario=o.cod_usuario WHERE u.cuenta='rodrigo_beltran'),1),
(4, (SELECT o.cod_organizador FROM organizadores o JOIN usuarios u ON u.cod_usuario=o.cod_usuario WHERE u.cuenta='anderson_borras'),6),
(4, (SELECT o.cod_organizador FROM organizadores o JOIN usuarios u ON u.cod_usuario=o.cod_usuario WHERE u.cuenta='alex_cabezas'),   8),
(5, (SELECT o.cod_organizador FROM organizadores o JOIN usuarios u ON u.cod_usuario=o.cod_usuario WHERE u.cuenta='josue_carlo'),    5),
(5, (SELECT o.cod_organizador FROM organizadores o JOIN usuarios u ON u.cod_usuario=o.cod_usuario WHERE u.cuenta='ivonne_menacho'), 2),
(6, (SELECT o.cod_organizador FROM organizadores o JOIN usuarios u ON u.cod_usuario=o.cod_usuario WHERE u.cuenta='sergio_chocayta'),4),
(6, (SELECT o.cod_organizador FROM organizadores o JOIN usuarios u ON u.cod_usuario=o.cod_usuario WHERE u.cuenta='cristian_choquetopa'),1);

COMMIT;
