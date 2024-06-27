-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 27-06-2024 a las 15:17:22
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `impuestos`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cilindraje`
--

CREATE TABLE `cilindraje` (
  `id_cc` int(11) NOT NULL,
  `cilindraje` varchar(30) NOT NULL,
  `id_tip_veh` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cilindraje`
--

INSERT INTO `cilindraje` (`id_cc`, `cilindraje`, `id_tip_veh`) VALUES
(1, '50', 6),
(2, '99', 6),
(3, '100', 7),
(4, '150', 7),
(5, '200', 7),
(6, '250', 7),
(7, '300', 8),
(8, '350', 8),
(9, '400', 8),
(11, 'Apartir de 450 en adelante', 8),
(12, '1.0L', 2),
(13, '1.5L', 2),
(14, '2.0L', 2),
(15, '2.5L', 2),
(16, '3.0L', 2),
(17, '3.5L', 2),
(18, '1 tonelada', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `color`
--

CREATE TABLE `color` (
  `id_color` int(11) NOT NULL,
  `color_nom` varchar(39) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `color`
--

INSERT INTO `color` (`id_color`, `color_nom`) VALUES
(1, 'Negro'),
(2, 'Blanco'),
(3, 'Rojo'),
(4, 'Azul'),
(5, 'Plateado'),
(6, 'Gris'),
(7, 'Verde'),
(8, 'Amarillo'),
(9, 'Naranja'),
(10, 'Marrón'),
(11, 'Púrpura'),
(12, 'Rosa'),
(13, 'Dorado'),
(14, 'Beige'),
(15, 'Bronce');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `combustible`
--

CREATE TABLE `combustible` (
  `id_com` int(11) NOT NULL,
  `comb_nom` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estado`
--

CREATE TABLE `estado` (
  `id_est` int(11) NOT NULL,
  `estado` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `estado`
--

INSERT INTO `estado` (`id_est`, `estado`) VALUES
(1, 'Pago'),
(2, 'En deuda');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `impuesto`
--

CREATE TABLE `impuesto` (
  `id_impuesto` int(11) NOT NULL,
  `id_tip_veh` int(11) NOT NULL,
  `id_modelo` int(11) NOT NULL,
  `valor_imp` decimal(10,0) NOT NULL,
  `valor` decimal(10,0) NOT NULL,
  `porcentaje` decimal(4,2) NOT NULL,
  `total_impuestos` decimal(10,0) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `impuesto`
--

INSERT INTO `impuesto` (`id_impuesto`, `id_tip_veh`, `id_modelo`, `valor_imp`, `valor`, `porcentaje`, `total_impuestos`) VALUES
(80, 5, 12, 593100, 200000000, 0.40, 201393100),
(81, 5, 13, 593100, 200000000, 0.40, 201393100),
(82, 5, 14, 593100, 200000000, 0.40, 201393100),
(83, 5, 15, 593100, 200000000, 0.40, 201393100),
(84, 5, 16, 593100, 200000000, 0.40, 201393100),
(85, 5, 17, 593100, 200000000, 0.40, 201393100),
(86, 5, 18, 593100, 200000000, 0.40, 201393100),
(87, 5, 19, 593100, 200000000, 0.40, 201393100),
(88, 5, 20, 593100, 200000000, 0.40, 201393100),
(89, 5, 21, 593100, 200000000, 0.40, 201393100),
(90, 5, 22, 593100, 200000000, 0.40, 201393100),
(91, 5, 23, 593100, 200000000, 0.40, 201393100),
(92, 5, 24, 593100, 200000000, 0.40, 201393100),
(93, 6, 1, 205650, 4500000, 0.20, 4714650),
(94, 7, 11, 316200, 7500000, 0.30, 7838700),
(95, 8, 12, 578200, 10000000, 0.30, 10608200),
(96, 8, 13, 578200, 10000000, 0.30, 10608200),
(97, 8, 14, 578200, 10000000, 0.30, 10608200),
(98, 8, 15, 578200, 10000000, 0.30, 10608200),
(99, 8, 16, 578200, 10000000, 0.30, 10608200),
(100, 8, 17, 578200, 10000000, 0.30, 10608200),
(101, 8, 18, 578200, 10000000, 0.30, 10608200),
(102, 8, 19, 578200, 10000000, 0.30, 10608200),
(103, 8, 20, 578200, 10000000, 0.30, 10608200),
(104, 8, 21, 578200, 10000000, 0.30, 10608200),
(105, 8, 22, 578200, 10000000, 0.30, 10608200),
(106, 8, 23, 578200, 10000000, 0.30, 10608200),
(107, 8, 24, 578200, 10000000, 0.30, 10608200),
(108, 2, 1, 328900, 33900000, 0.20, 34296700),
(109, 2, 2, 415700, 33900000, 0.20, 34383500),
(110, 2, 3, 415700, 33900000, 0.20, 34383500),
(111, 2, 4, 415700, 33900000, 0.20, 34383500),
(112, 2, 5, 415700, 33900000, 0.20, 34383500),
(113, 2, 6, 415700, 33900000, 0.20, 34383500),
(114, 2, 7, 415700, 33900000, 0.20, 34383500),
(115, 2, 8, 415700, 33900000, 0.20, 34383500),
(116, 2, 9, 415700, 33900000, 0.20, 34383500),
(117, 2, 10, 415700, 33900000, 0.20, 34383500),
(118, 2, 11, 487430, 33900000, 0.30, 34489130),
(119, 2, 12, 487430, 33900000, 0.30, 34489130),
(120, 2, 13, 487430, 33900000, 0.30, 34489130),
(121, 2, 14, 487430, 33900000, 0.30, 34489130),
(122, 2, 15, 487430, 33900000, 0.30, 34489130),
(123, 2, 16, 487430, 33900000, 0.30, 34489130),
(124, 2, 17, 487430, 33900000, 0.30, 34489130),
(125, 2, 18, 487430, 33900000, 0.30, 34489130),
(126, 2, 19, 487430, 33900000, 0.30, 34489130),
(127, 2, 20, 487430, 33900000, 0.30, 34489130),
(128, 2, 21, 487430, 33900000, 0.30, 34489130),
(129, 2, 22, 487430, 33900000, 0.30, 34489130),
(130, 2, 23, 487430, 33900000, 0.30, 34489130),
(131, 2, 24, 487430, 33900000, 0.30, 34489130),
(132, 3, 1, 410500, 63000000, 0.30, 63599500),
(133, 4, 11, 500800, 120000000, 0.30, 120860800),
(135, 4, 3, 500800, 120000000, 0.30, 120860800),
(136, 4, 4, 500800, 120000000, 0.30, 120860800),
(137, 4, 5, 500800, 120000000, 0.30, 120860800),
(138, 4, 6, 500800, 120000000, 0.30, 120860800),
(139, 4, 7, 500800, 120000000, 0.30, 120860800),
(140, 4, 8, 500800, 120000000, 0.30, 120860800),
(141, 4, 9, 500800, 120000000, 0.30, 120860800),
(142, 4, 10, 500800, 120000000, 0.30, 120860800),
(143, 4, 11, 500800, 120000000, 0.30, 120860800),
(144, 7, 2, 316200, 7500000, 0.30, 7838700),
(145, 7, 3, 316200, 7500000, 0.30, 7838700),
(146, 7, 4, 316200, 7500000, 0.30, 7838700),
(147, 7, 5, 316200, 7500000, 0.30, 7838700),
(148, 7, 6, 316200, 7500000, 0.30, 7838700),
(149, 7, 7, 316200, 7500000, 0.30, 7838700),
(150, 7, 8, 316200, 7500000, 0.30, 7838700),
(151, 7, 9, 316200, 7500000, 0.30, 7838700),
(152, 7, 10, 316200, 7500000, 0.30, 7838700),
(153, 7, 11, 316200, 7500000, 0.30, 7838700);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `linea`
--

CREATE TABLE `linea` (
  `id_linea` int(11) NOT NULL,
  `linea_nom` varchar(50) NOT NULL,
  `id_marca` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `linea`
--

INSERT INTO `linea` (`id_linea`, `linea_nom`, `id_marca`) VALUES
(1, 'Civic', 1),
(2, 'Accord', 1),
(3, 'CBR600RR', 2),
(4, 'YZF-R1', 2),
(5, 'Swift', 3),
(6, 'Hayabusa', 3),
(7, 'Ninja', 4),
(8, 'Vulcan', 4),
(9, 'Sportster', 5),
(10, 'Softail', 5),
(11, '3 Series', 6),
(12, 'X5', 6),
(13, 'C-Class', 7),
(14, 'S-Class', 7),
(15, 'Corolla', 8),
(16, 'Camry', 8),
(17, 'F-150', 9),
(18, 'Mustang', 9),
(19, 'Silverado', 10),
(20, 'Camaro', 10),
(21, 'Golf', 11),
(22, 'Passat', 11),
(23, 'Altima', 12),
(24, 'GT-R', 12),
(25, 'Lancer', 13),
(26, 'Outlander', 13),
(27, 'D-Max', 14),
(28, 'MU-X', 14),
(29, 'XC90', 15),
(30, 'FH16', 15),
(31, 'R-Series', 16),
(32, 'S-Series', 16),
(33, 'TGS', 17),
(34, 'TGX', 17),
(35, 'Actros', 18),
(36, 'Arocs', 18),
(37, 'Kangoo', 19),
(38, 'Megane', 19),
(39, 'Daily', 20),
(40, 'Stralis', 20);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `marca`
--

CREATE TABLE `marca` (
  `id_marca` int(11) NOT NULL,
  `marca_nom` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `marca`
--

INSERT INTO `marca` (`id_marca`, `marca_nom`) VALUES
(1, 'Honda'),
(2, 'Yamaha'),
(3, 'Suzuki'),
(4, 'Kawasaki'),
(5, 'Harley-Davidson'),
(6, 'BMW'),
(7, 'Mercedes-Benz'),
(8, 'Toyota'),
(9, 'Ford'),
(10, 'Chevrolet'),
(11, 'Volkswagen'),
(12, 'Nissan'),
(13, 'Mitsubishi'),
(14, 'Isuzu'),
(15, 'Volvo'),
(16, 'Scania'),
(17, 'MAN'),
(18, 'Daimler'),
(19, 'Renault'),
(20, 'Iveco');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `modelo`
--

CREATE TABLE `modelo` (
  `id_modelo` int(11) NOT NULL,
  `modelo_año` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `modelo`
--

INSERT INTO `modelo` (`id_modelo`, `modelo_año`) VALUES
(1, '2000'),
(2, '2001'),
(3, '2002'),
(4, '2003'),
(5, '2004'),
(6, '2005'),
(7, '2006'),
(8, '2007'),
(9, '2008'),
(10, '2009'),
(11, '2010'),
(12, '2011'),
(13, '2012'),
(14, '2013'),
(15, '2014'),
(16, '2015'),
(17, '2016'),
(18, '2017'),
(19, '2018'),
(20, '2019'),
(21, '2020'),
(22, '2021'),
(23, '2022'),
(24, '2023'),
(26, '2024');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_veh`
--

CREATE TABLE `tipo_veh` (
  `id_tip_veh` int(11) NOT NULL,
  `tip_veh` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipo_veh`
--

INSERT INTO `tipo_veh` (`id_tip_veh`, `tip_veh`) VALUES
(2, 'Automovil'),
(3, 'camión Ligero'),
(4, 'camión Mediano'),
(5, 'camión Pesado'),
(6, 'Moto cilindraje bajo'),
(7, 'Moto cilindraje medio'),
(8, 'Moto cilindraje alto');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `documento` int(11) NOT NULL,
  `nombre_comple` varchar(60) NOT NULL,
  `correo` varchar(60) DEFAULT NULL,
  `password` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`documento`, `nombre_comple`, `correo`, `password`) VALUES
(1111111, 'fvded', 'wdwe@gmail.com', '123'),
(21831938, 'odijaod', 'oidjwdo@gmail.com', '$2y$10$gp9RtI7NyZdSujWYS5CBae3fplzptwbnbqN8oWTMmJwVwR6CuoDSO'),
(1110172890, 'valentina mendoza', 'valenmendozaramirez@gmail.com', '$2y$10$qgHQ2oxdrlyEmoEtaecjsOgGjklD7NOJouwSvJwTesSrMiHWlw88a'),
(2147483647, 'dfergerg', 'efewfw@gmail.com', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vehiculo`
--

CREATE TABLE `vehiculo` (
  `docu_propietario` int(11) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `id_tip_veh` int(4) NOT NULL,
  `cilindraje_veh` int(11) DEFAULT NULL,
  `modelo` int(5) NOT NULL,
  `placa` varchar(30) NOT NULL,
  `marca` varchar(50) NOT NULL,
  `linea` varchar(50) NOT NULL,
  `color` varchar(30) NOT NULL,
  `numero_motor` varchar(50) NOT NULL,
  `numero_chasis` varchar(50) NOT NULL,
  `fecha_matricula` date NOT NULL,
  `fecha_actual` date NOT NULL DEFAULT current_timestamp(),
  `capacidad` int(30) NOT NULL,
  `estado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `vehiculo`
--

INSERT INTO `vehiculo` (`docu_propietario`, `nombre`, `id_tip_veh`, `cilindraje_veh`, `modelo`, `placa`, `marca`, `linea`, `color`, `numero_motor`, `numero_chasis`, `fecha_matricula`, `fecha_actual`, `capacidad`, `estado`) VALUES
(19389385, 'lorena bonilla', 2, 12, 1, '283748', '2', '3', '1', '2132121312', '22112312355674356', '2023-01-27', '2024-06-27', 4, 2),
(110928374, 'juan', 2, 12, 1, 'h133i', '1', '1', '1', '8349494848', '12345678910111211', '2022-01-27', '2024-06-27', 4, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vehiculo_anual`
--

CREATE TABLE `vehiculo_anual` (
  `id` int(11) NOT NULL,
  `vehiculo_id` varchar(30) NOT NULL,
  `anio` date NOT NULL,
  `valor_total` int(30) DEFAULT NULL,
  `estado` int(11) NOT NULL,
  `fecha_registro` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `vehiculo_anual`
--

INSERT INTO `vehiculo_anual` (`id`, `vehiculo_id`, `anio`, `valor_total`, `estado`, `fecha_registro`) VALUES
(527, 'h133i', '2022-01-27', 34296700, 2, '2024-06-27'),
(528, 'h133i', '2023-01-27', 34296700, 1, '2024-06-27'),
(529, 'h133i', '2024-01-27', 34296700, 1, '2024-06-27'),
(533, '283748', '2023-01-27', 34296700, 2, '2024-06-27'),
(534, '283748', '2024-01-27', 34296700, 1, '2024-06-27');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cilindraje`
--
ALTER TABLE `cilindraje`
  ADD PRIMARY KEY (`id_cc`);

--
-- Indices de la tabla `color`
--
ALTER TABLE `color`
  ADD PRIMARY KEY (`id_color`);

--
-- Indices de la tabla `combustible`
--
ALTER TABLE `combustible`
  ADD PRIMARY KEY (`id_com`);

--
-- Indices de la tabla `estado`
--
ALTER TABLE `estado`
  ADD PRIMARY KEY (`id_est`);

--
-- Indices de la tabla `impuesto`
--
ALTER TABLE `impuesto`
  ADD PRIMARY KEY (`id_impuesto`);

--
-- Indices de la tabla `linea`
--
ALTER TABLE `linea`
  ADD PRIMARY KEY (`id_linea`);

--
-- Indices de la tabla `marca`
--
ALTER TABLE `marca`
  ADD PRIMARY KEY (`id_marca`);

--
-- Indices de la tabla `modelo`
--
ALTER TABLE `modelo`
  ADD PRIMARY KEY (`id_modelo`);

--
-- Indices de la tabla `tipo_veh`
--
ALTER TABLE `tipo_veh`
  ADD PRIMARY KEY (`id_tip_veh`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`documento`);

--
-- Indices de la tabla `vehiculo`
--
ALTER TABLE `vehiculo`
  ADD PRIMARY KEY (`placa`);

--
-- Indices de la tabla `vehiculo_anual`
--
ALTER TABLE `vehiculo_anual`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vehiculo_id` (`vehiculo_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `cilindraje`
--
ALTER TABLE `cilindraje`
  MODIFY `id_cc` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `color`
--
ALTER TABLE `color`
  MODIFY `id_color` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `combustible`
--
ALTER TABLE `combustible`
  MODIFY `id_com` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `estado`
--
ALTER TABLE `estado`
  MODIFY `id_est` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `impuesto`
--
ALTER TABLE `impuesto`
  MODIFY `id_impuesto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=163;

--
-- AUTO_INCREMENT de la tabla `linea`
--
ALTER TABLE `linea`
  MODIFY `id_linea` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT de la tabla `marca`
--
ALTER TABLE `marca`
  MODIFY `id_marca` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de la tabla `modelo`
--
ALTER TABLE `modelo`
  MODIFY `id_modelo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de la tabla `tipo_veh`
--
ALTER TABLE `tipo_veh`
  MODIFY `id_tip_veh` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `vehiculo_anual`
--
ALTER TABLE `vehiculo_anual`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=535;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `vehiculo_anual`
--
ALTER TABLE `vehiculo_anual`
  ADD CONSTRAINT `vehiculo_anual_ibfk_1` FOREIGN KEY (`vehiculo_id`) REFERENCES `vehiculo` (`placa`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
