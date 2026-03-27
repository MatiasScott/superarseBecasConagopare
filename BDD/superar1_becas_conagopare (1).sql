-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 18-02-2026 a las 15:00:11
-- Versión del servidor: 8.0.45
-- Versión de PHP: 8.4.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `superar1_becas_conagopare`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `activity_log`
--

CREATE TABLE `activity_log` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `action` varchar(255) NOT NULL,
  `details` text,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `activity_log`
--

INSERT INTO `activity_log` (`id`, `user_id`, `action`, `details`, `timestamp`) VALUES
(48, 12, 'Registro de nuevo usuario', NULL, '2025-09-05 19:16:11'),
(49, 12, 'Inicio de sesión', NULL, '2025-09-05 19:17:06'),
(50, 12, 'Inicio de sesión', NULL, '2025-09-05 19:17:38'),
(51, 12, 'Inicio de sesión', NULL, '2025-09-05 19:18:39'),
(52, 12, 'Inicio de sesión', NULL, '2025-09-05 19:19:37'),
(53, 12, 'Inicio de sesión', NULL, '2025-09-05 19:37:01'),
(54, 12, 'Inicio de sesión', NULL, '2025-09-05 19:44:12'),
(55, 12, 'Inicio de sesión', NULL, '2025-09-05 19:59:40'),
(56, 12, 'Inicio de sesión', NULL, '2025-09-05 20:05:08'),
(57, 13, 'Registro de nuevo usuario', NULL, '2025-09-05 20:07:15'),
(58, 12, 'Inicio de sesión', NULL, '2025-09-05 23:42:30'),
(59, 12, 'Inicio de sesión', NULL, '2025-09-08 14:11:27'),
(60, 13, 'Inicio de sesión', NULL, '2025-09-08 14:11:53'),
(61, 13, 'Inicio de sesión', NULL, '2025-09-08 21:25:24'),
(62, 13, 'Nuevo estudiante registrado', NULL, '2025-09-08 21:26:09'),
(63, 12, 'Inicio de sesión', NULL, '2025-09-24 15:54:36'),
(64, 12, 'Inicio de sesión', NULL, '2025-09-24 15:57:51'),
(65, 14, 'Registro de nuevo usuario', NULL, '2025-09-24 16:00:58'),
(66, 14, 'Inicio de sesión', NULL, '2025-09-24 16:01:14'),
(67, 14, 'Nuevo estudiante registrado', NULL, '2025-09-24 16:04:10'),
(68, 12, 'Inicio de sesión', NULL, '2025-09-24 16:05:32'),
(69, 13, 'Inicio de sesión', NULL, '2025-09-29 19:57:44'),
(70, 13, 'Inicio de sesión', NULL, '2025-09-29 20:00:31'),
(71, 12, 'Inicio de sesión', NULL, '2025-09-29 20:57:49'),
(72, 14, 'Inicio de sesión', NULL, '2025-09-29 21:00:27'),
(73, 12, 'Inicio de sesión', NULL, '2025-09-29 21:23:32'),
(74, 14, 'Inicio de sesión', NULL, '2025-09-30 15:46:37'),
(75, 15, 'Registro de nuevo usuario', NULL, '2025-09-30 15:48:25'),
(76, 14, 'Inicio de sesión', NULL, '2025-09-30 15:48:53'),
(77, 16, 'Registro de nuevo usuario', NULL, '2025-09-30 15:49:59'),
(78, 16, 'Inicio de sesión', NULL, '2025-09-30 15:50:26'),
(79, 16, 'Nuevo estudiante registrado', NULL, '2025-09-30 15:52:55'),
(80, 15, 'Inicio de sesión', NULL, '2025-09-30 15:54:39'),
(81, 15, 'Nuevo estudiante registrado', NULL, '2025-09-30 15:57:00'),
(82, 14, 'Inicio de sesión', NULL, '2025-09-30 17:00:43'),
(83, 17, 'Registro de nuevo usuario', NULL, '2025-09-30 17:01:57'),
(84, 17, 'Inicio de sesión', NULL, '2025-09-30 17:02:19'),
(85, 17, 'Nuevo estudiante registrado', NULL, '2025-09-30 17:04:26'),
(86, 12, 'Inicio de sesión', NULL, '2025-10-01 13:12:27'),
(87, 12, 'Inicio de sesión', NULL, '2025-10-01 13:55:10'),
(88, 12, 'Inicio de sesión', NULL, '2025-10-01 14:08:35'),
(89, 18, 'Registro de nuevo usuario', NULL, '2025-10-01 14:10:07'),
(90, 12, 'Inicio de sesión', NULL, '2025-10-01 14:20:06'),
(91, 19, 'Registro de nuevo usuario', NULL, '2025-10-01 14:21:48'),
(92, 14, 'Inicio de sesión', NULL, '2025-10-02 20:37:43'),
(93, 20, 'Registro de nuevo usuario', NULL, '2025-10-02 20:42:54'),
(94, 20, 'Inicio de sesión', NULL, '2025-10-02 20:43:35'),
(95, 20, 'Nuevo estudiante registrado', NULL, '2025-10-02 20:47:55'),
(96, 14, 'Inicio de sesión', NULL, '2025-10-06 13:12:36'),
(97, 14, 'Inicio de sesión', NULL, '2025-10-06 20:18:44'),
(98, 21, 'Registro de nuevo usuario', NULL, '2025-10-06 20:23:28'),
(99, 21, 'Inicio de sesión', NULL, '2025-10-06 20:24:12'),
(100, 21, 'Nuevo estudiante registrado', NULL, '2025-10-06 20:25:58'),
(101, 21, 'Inicio de sesión', NULL, '2025-10-06 20:33:14'),
(102, 14, 'Inicio de sesión', NULL, '2025-10-08 15:00:34'),
(103, 13, 'Inicio de sesión', NULL, '2025-10-13 15:25:49'),
(104, 14, 'Inicio de sesión', NULL, '2025-10-14 14:54:04'),
(105, 14, 'Inicio de sesión', NULL, '2025-10-15 14:51:38'),
(106, 13, 'Inicio de sesión', NULL, '2025-10-21 21:45:22'),
(107, 13, 'Inicio de sesión', NULL, '2025-10-21 21:51:32'),
(108, 13, 'Inicio de sesión', NULL, '2025-10-22 15:45:57'),
(109, 22, 'Registro de nuevo usuario', NULL, '2025-10-22 15:49:49'),
(110, 13, 'Inicio de sesión', NULL, '2025-10-22 15:54:57'),
(111, 19, 'Inicio de sesión', NULL, '2025-10-22 15:59:46'),
(112, 13, 'Inicio de sesión', NULL, '2025-10-22 16:03:08'),
(113, 22, 'Inicio de sesión', NULL, '2025-10-22 16:03:33'),
(114, 19, 'Inicio de sesión', NULL, '2025-10-22 16:04:37'),
(115, 19, 'Inicio de sesión', NULL, '2025-10-22 16:05:45'),
(116, 13, 'Inicio de sesión', NULL, '2025-10-23 18:29:41'),
(117, 24, 'Registro de nuevo usuario', NULL, '2025-10-23 18:33:59'),
(118, 24, 'Inicio de sesión', NULL, '2025-10-23 18:34:50'),
(119, 21, 'Inicio de sesión', NULL, '2025-10-27 20:28:49'),
(120, 21, 'Nuevo estudiante registrado', NULL, '2025-10-27 20:31:56'),
(121, 21, 'Inicio de sesión', NULL, '2025-10-27 20:39:52'),
(122, 14, 'Inicio de sesión', NULL, '2025-11-05 20:28:08'),
(123, 14, 'Inicio de sesión', NULL, '2025-12-11 14:30:30'),
(124, 12, 'Inicio de sesión', NULL, '2026-01-15 16:44:41'),
(125, 12, 'Inicio de sesión', NULL, '2026-01-15 16:47:02'),
(126, 12, 'Inicio de sesión', NULL, '2026-01-15 18:05:16'),
(127, 12, 'Inicio de sesión', NULL, '2026-01-15 18:11:15'),
(128, 12, 'Inicio de sesión', NULL, '2026-01-15 18:27:33'),
(129, 12, 'Inicio de sesión', NULL, '2026-01-15 18:28:27'),
(130, 12, 'Inicio de sesión', NULL, '2026-01-15 18:28:49'),
(131, 12, 'Inicio de sesión', NULL, '2026-01-15 18:29:05'),
(132, 12, 'Inicio de sesión', NULL, '2026-01-15 18:29:48'),
(133, 12, 'Inicio de sesión', NULL, '2026-01-15 18:31:38'),
(134, 32, 'Registro de nuevo usuario', NULL, '2026-01-15 18:42:30'),
(135, 12, 'Inicio de sesión', NULL, '2026-01-15 18:43:45'),
(136, 12, 'Inicio de sesión', NULL, '2026-01-15 18:44:20'),
(137, 12, 'Inicio de sesión', NULL, '2026-01-15 18:50:59'),
(138, 12, 'Inicio de sesión', NULL, '2026-01-15 18:54:30'),
(139, 12, 'Inicio de sesión', NULL, '2026-01-30 14:38:35'),
(140, 12, 'Inicio de sesión', NULL, '2026-01-30 14:39:58'),
(141, 12, 'Inicio de sesión', NULL, '2026-01-30 15:02:45'),
(142, 12, 'Inicio de sesión', NULL, '2026-01-30 15:06:13'),
(143, 12, 'Inicio de sesión', NULL, '2026-01-30 15:08:14');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cantons`
--

CREATE TABLE `cantons` (
  `id` int NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `cantons`
--

INSERT INTO `cantons` (`id`, `name`) VALUES
(1, 'QUITO'),
(2, 'MEJIA'),
(3, 'RUMIÑAHUI'),
(4, 'PEDRO MONCAYO'),
(5, 'CAYAMBE'),
(6, 'SAN MIGUEL DE LOS BANCOS');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `parishes`
--

CREATE TABLE `parishes` (
  `id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `canton_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `parishes`
--

INSERT INTO `parishes` (`id`, `name`, `canton_id`) VALUES
(1, 'ALANGASI', 1),
(2, 'AMAGUAÑA', 1),
(3, 'ATAHUALPA', 1),
(4, 'CALACALI', 1),
(5, 'CALDERON', 1),
(6, 'CONOCOTO', 1),
(7, 'CUMBAYA', 1),
(8, 'CHAVEZPAMBA', 1),
(9, 'CHECA', 1),
(10, 'EL QUINCHE', 1),
(11, 'GUALEA', 1),
(12, 'GUANGOPOLO', 1),
(13, 'GUAYLLABAMBA', 1),
(14, 'LA MERCED', 1),
(15, 'LLANO CHICO', 1),
(16, 'LLOA', 1),
(17, 'NANEGAL', 1),
(18, 'NANEGALITO', 1),
(19, 'NAYON', 1),
(20, 'NONO', 1),
(21, 'PACTO', 1),
(22, 'PERUCHO', 1),
(23, 'PIFO', 1),
(24, 'PINTAG', 1),
(25, 'POMASQUI', 1),
(26, 'PUELLARO', 1),
(27, 'PUEMBO', 1),
(28, 'SAN ANTONIO DE PICHINCHA', 1),
(29, 'SAN JOSE DE MINAS', 1),
(30, 'TABABELA', 1),
(31, 'TUMBACO', 1),
(32, 'YARUQUI', 1),
(33, 'ZAMBIZA', 1),
(34, 'ALOAG', 2),
(35, 'ALOASI', 2),
(36, 'CUTUGLAGUA', 2),
(37, 'EL CHAUPI', 2),
(38, 'MANUEL CORNEJO ASTORGA \"TANDAPI\"', 2),
(39, 'TAMBILLO', 2),
(40, 'UYUMBICHO', 2),
(41, 'COTOGCHOA', 3),
(42, 'RUMIPAMBA', 3),
(43, 'LA ESPERANZA', 4),
(44, 'MALCHINGUI', 4),
(45, 'TOCACHI', 4),
(46, 'TUPIGACHI', 4),
(47, 'ASCAZUBI', 5),
(48, 'AYORA', 5),
(49, 'CANGAHUA', 5),
(50, 'CUZUBAMBA', 5),
(51, 'OLMEDO/PESILLO', 5),
(52, 'OTON', 5),
(53, 'MINDO', 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `students`
--

CREATE TABLE `students` (
  `id` int NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `second_name` varchar(50) DEFAULT NULL,
  `first_last_name` varchar(50) NOT NULL,
  `second_last_name` varchar(50) DEFAULT NULL,
  `id_type` varchar(20) NOT NULL,
  `id_number` varchar(20) NOT NULL,
  `gender` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `cellphone` varchar(20) NOT NULL,
  `birth_date` date NOT NULL,
  `program` varchar(100) NOT NULL,
  `birth_place` varchar(100) NOT NULL,
  `address` varchar(255) NOT NULL,
  `residence_place` varchar(100) NOT NULL,
  `neighborhood` varchar(100) NOT NULL,
  `registered_by_user_id` int DEFAULT NULL,
  `scholarship` varchar(50) DEFAULT NULL,
  `academic_period` varchar(75) DEFAULT NULL,
  `registration_date` datetime DEFAULT NULL,
  `status` varchar(20) DEFAULT 'pendiente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `students`
--

INSERT INTO `students` (`id`, `first_name`, `second_name`, `first_last_name`, `second_last_name`, `id_type`, `id_number`, `gender`, `email`, `phone`, `cellphone`, `birth_date`, `program`, `birth_place`, `address`, `residence_place`, `neighborhood`, `registered_by_user_id`, `scholarship`, `academic_period`, `registration_date`, `status`) VALUES
(62, 'Matias', 'Scott', 'Valdivieso', 'Valdivieso', 'Cedula', '1725433203', 'Masculino', 'mvaldivieso31@gmail.com', '0963852741', '023930980', '1997-02-05', 'Tecnólogo en Instrumentación Quirúrgica', 'Quito', 'Av. General Rumiñahui e Isla Pinta 1111', 'Quito', 'Quito', 13, '20%', 'PAO nov2025 - abr2026', '2025-09-08 21:26:09', 'aprobado'),
(63, 'Tatiana', 'Trinidad', 'Quishpe', 'Casillas', 'Cedula', '1718192021', 'Femenino', 'tatiana.quishpe@superarse.edu.ec', '0963084740', '0963084740', '1991-02-21', 'Seguridad y Prevención de Riesgos Laborales', 'Quito', 'Tumbaco', 'Tumbaco', 'Tumbaco', 14, '20%', 'PAO nov2025 - abr2026', '2025-09-24 16:04:10', 'pendiente'),
(64, 'Jean', 'Paul', 'Landazuri', 'Silva', 'Cedula', '1717486078', 'Masculino', 'jeanpaul@gmail.com', '0983466945', '0983466875', '1994-02-18', 'Técnico Superior en Marketing Digital', 'Quito', 'el valle', 'sangolqui', 'la comuna', 16, '20%', 'PAO nov2025 - abr2026', '2025-09-30 15:52:55', 'pendiente'),
(65, 'Leidy', 'Geovana', 'Rodriguez', 'F', 'Cedula', '1726191990', 'Femenino', 'geovanaflores19@gmailcom', '0969864754', '0969864753', '1997-10-16', 'Tecnólogo en Educación Básica', 'Puellaro', 'Aloguincho', 'Aloguincho', 'El Estadio', 15, '20%', 'PAO nov2025 - abr2026', '2025-09-30 15:57:00', 'pendiente'),
(66, 'Alexandra', 'Andrea', 'Pinto', 'Salazar', 'Cedula', '1750684125', 'Femenino', 'andre@gmail.com', '2534814', '0983466789', '1994-02-21', 'Técnico Superior en Marketing Digital', 'quito', 'el valle', 'la florida', 'los rosales', 17, '20%', 'PAO nov2025 - abr2026', '2025-09-30 17:04:26', 'pendiente'),
(67, 'Andres', 'Matias', 'Alvarez', 'Martinez', 'Cedula', '1750694225', 'Masculino', 'andres@gmail.com', '09834768493', '0969864753', '2006-09-06', 'Tecnólogo en Minería', 'Quito', 'La Prensa', 'Rosales', 'La Luz', 20, '30%', 'PAO nov2025 - abr2026', '2025-10-02 20:47:55', 'pendiente'),
(68, 'Luis ', 'Felipe', 'Andrade', 'Laso', 'Cedula', '1750694126', 'Masculino', 'andradelaso9@gmail.com', '0983466845', '0983466854', '1994-02-21', 'Técnico Superior en Marketing Digital', 'Nono', 'la primavera', 'nono', 'el rosal', 21, '20%', 'PAO nov2025 - abr2026', '2025-10-06 20:25:58', 'pendiente'),
(69, 'JENNIFER', 'ALEXANDRA', 'OLMEDO', 'CARGUA', 'Cedula', '1727978791', 'Femenino', 'alexandracargua78@gmail.com', '2786150', '0982523943', '2000-04-20', 'Tecnología Superior en Enfermería Veterinaria', 'quito', 'parroquia nono', 'nono', 'la plaza', 21, '30%', 'PAO nov2025 - abr2026', '2025-10-27 20:31:56', 'pendiente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `second_name` varchar(50) DEFAULT NULL,
  `first_last_name` varchar(50) NOT NULL,
  `second_last_name` varchar(50) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `canton_id` int DEFAULT NULL,
  `parish_id` int DEFAULT NULL,
  `role` int NOT NULL DEFAULT '0',
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `first_name`, `second_name`, `first_last_name`, `second_last_name`, `email`, `phone`, `canton_id`, `parish_id`, `role`, `password`) VALUES
(12, 'Matias', 'Scott', 'Valdivieso', 'Salvatierra', 'matias.valdivieso@superarse.edu.ec', '0963852741', 1, 6, 1, '$2y$10$lzm8N0IAk0m9CYpmpjMBKer.eO2oIE81wJu7hWG17HhlV25ZlL/YW'),
(13, 'Diana', 'Mariela', 'Andrango', 'Chumaña', 'diana.andrango@superarse.edu.ec', '0985920441', 1, 2, 1, '$2y$10$z6NE86Sg8ePB9RcXsTgkKuSr7Lx4CFTGVWFu9Ld4QYQhSMQ7iV88y'),
(14, 'Luis', 'Felipe', 'Granja', 'Arcos', 'luis.granja@superarse.edu.ec', '0983466847', 1, 31, 1, '$2y$10$BvqrRbT/pNsTslGpgZvjvejc37jDQ148DeZAt0ncwlcgMfHVYHBQi'),
(15, 'Leidy', 'Geovana', 'Rodriguez', 'Flores', 'geovanaflores19@gmail.com', '0969864754', 1, 26, 0, '$2y$10$vBNSIyYqXPDcryzFrMX3JeOT5ndFzhpD2skZFo6i/EtwpCx9walI.'),
(16, 'Jenny', 'Beatriz', 'Herrera', 'Paredes', 'jbherrera17@gmail.com', '0986400730', 1, 26, 0, '$2y$10$Xcg7tcWyGHJeJgAi48rUg.rRUjQ7B6CIa.fO1U7FVvzPC02/YdltW'),
(17, 'Mayra', 'Alejandra', 'Pinto', 'Vaca', 'mayrapinto27@yahoo.es', '0980380365', 1, 22, 0, '$2y$10$jNL27Zp3GQf6ceP421LXfuJx5k0m3LyTbzyldMptRnGPXYYnENa6q'),
(18, 'JEAN', 'PAUL', 'LANDÁZURI', 'SILVA', 'infraestructura@superarse.edu.ec', '3930980', 1, 6, 0, '$2y$10$ysBxIHMBlIcgwARvxqND7ubKX6WrCTdDONRvtiy1czHR4TLTIv50S'),
(19, 'ALEXANDER', 'WLADIMIR', 'QUINGA', 'LOACHAMIN', 'alexander.quinga@superarse.edu.ec', '0995229806', 1, 2, 0, '$2y$10$smq9S.oyru2SbLZo9tw6ReOr50RoCI2cOku1aTfxpOK5ONC1svH6e'),
(20, 'Valery', 'Domenica', 'Martinez', 'Hidalgo', 'martinezvalery359@gmail.com', '0983344109', 1, 31, 0, '$2y$10$D/ZYLBG.j7DNaIRmyy58TO18F81sGoVIo0U08YbGlrzvr/mHFAMze'),
(21, 'Marco', 'Edmundo', 'Patiño', 'Quiroz', 'mundoprimario50@gmail.com', '0959766199', 1, 20, 0, '$2y$10$TlQG8apHwFu7S5ntwX82E.yYrNP0p8wSbYDbCsBumyzZHQjGQKW7G'),
(22, 'Camila', 'Francheska', 'Andrade', 'Palomino', 'f.c.andrade2405@gmail.com', '0995451930', 2, 38, 0, '$2y$10$f6lg1CN5.1f7rEOK9EN.8uz0MwFjNekjMnKvB9Ds8VzTtuoTDxmJe'),
(24, 'Soraida', 'Margarita', 'Guamán', 'Basurto', 'soraidaguamanbasurto@hotmail.com', '0994605286', 2, 38, 0, '$2y$10$gq.qNy2kqy9TFkR3vEH6mu3CQEPXWMOd/pJ/arzrffqNhRC7qkonO'),
(32, 'Alex', 'Wladimir', 'Quinga', 'Loachamin', 'a.q@superarse.edu.ec', '0987654321', 2, 35, 0, '$2y$10$r8svlqjuRQdyMIHmitmYROWRX0WruoCMcA6d9/4EUtq2eREyt5WNO');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `activity_log`
--
ALTER TABLE `activity_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indices de la tabla `cantons`
--
ALTER TABLE `cantons`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `parishes`
--
ALTER TABLE `parishes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `canton_id` (`canton_id`);

--
-- Indices de la tabla `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_number_UNIQUE` (`id_number`),
  ADD UNIQUE KEY `email_UNIQUE` (`email`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `canton_id` (`canton_id`),
  ADD KEY `parish_id` (`parish_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `activity_log`
--
ALTER TABLE `activity_log`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=144;

--
-- AUTO_INCREMENT de la tabla `cantons`
--
ALTER TABLE `cantons`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `parishes`
--
ALTER TABLE `parishes`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT de la tabla `students`
--
ALTER TABLE `students`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `activity_log`
--
ALTER TABLE `activity_log`
  ADD CONSTRAINT `activity_log_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Filtros para la tabla `parishes`
--
ALTER TABLE `parishes`
  ADD CONSTRAINT `parishes_ibfk_1` FOREIGN KEY (`canton_id`) REFERENCES `cantons` (`id`);

--
-- Filtros para la tabla `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`canton_id`) REFERENCES `cantons` (`id`),
  ADD CONSTRAINT `users_ibfk_2` FOREIGN KEY (`parish_id`) REFERENCES `parishes` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
