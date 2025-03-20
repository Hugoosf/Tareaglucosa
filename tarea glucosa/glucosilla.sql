-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 20-03-2025 a las 21:28:18
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `glucosilla`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comidas`
--

CREATE TABLE `comidas` (
  `idusuario` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `idcomida` varchar(60) NOT NULL,
  `gl1h` int(11) NOT NULL,
  `rac` int(11) NOT NULL,
  `insu` int(11) NOT NULL,
  `glh2` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `comidas`
--

INSERT INTO `comidas` (`idusuario`, `fecha`, `idcomida`, `gl1h`, `rac`, `insu`, `glh2`) VALUES
(10, '2025-03-16', 'cena', 23, 8, 4, 9),
(10, '2025-03-16', 'comida', 30, 3, 4, 70),
(10, '2025-03-16', 'desayuno', 10, 7, 15, 10);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `controlglu`
--

CREATE TABLE `controlglu` (
  `idusuario` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `lenta` int(11) NOT NULL,
  `deporte` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `controlglu`
--

INSERT INTO `controlglu` (`idusuario`, `fecha`, `lenta`, `deporte`) VALUES
(10, '2025-03-16', 3, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `hiper`
--

CREATE TABLE `hiper` (
  `idusuario` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `idcomida` varchar(60) NOT NULL,
  `glu` int(11) NOT NULL,
  `hora` time(6) NOT NULL,
  `corr` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `hiper`
--

INSERT INTO `hiper` (`idusuario`, `fecha`, `idcomida`, `glu`, `hora`, `corr`) VALUES
(10, '2025-03-16', 'cena', 186, '21:11:00.000000', 9),
(10, '2025-03-16', 'comida', 190, '14:11:00.000000', 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `hipo`
--

CREATE TABLE `hipo` (
  `idusuario` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `idcomida` varchar(60) NOT NULL,
  `glu` int(11) NOT NULL,
  `hora` time(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `hipo`
--

INSERT INTO `hipo` (`idusuario`, `fecha`, `idcomida`, `glu`, `hora`) VALUES
(10, '2025-03-16', 'desayuno', 10, '08:41:00.000000');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `idusuario` int(11) NOT NULL,
  `nombre` varchar(60) NOT NULL,
  `apellidos` varchar(60) NOT NULL,
  `fechanac` date NOT NULL,
  `contrasena` varchar(200) NOT NULL,
  `correo` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`idusuario`, `nombre`, `apellidos`, `fechanac`, `contrasena`, `correo`) VALUES
(10, 'Hugo', 'Suárez Fuella', '2005-06-10', '$2y$10$V.kCQ0LK1CTDTTqLUcsBVuhmLaaFajBw6ty66U/9CDSMxMHRN884y', 'Huguito');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `comidas`
--
ALTER TABLE `comidas`
  ADD PRIMARY KEY (`idusuario`,`fecha`,`idcomida`),
  ADD KEY `fecha` (`fecha`),
  ADD KEY `idusuario` (`idusuario`),
  ADD KEY `idcomida` (`idcomida`);

--
-- Indices de la tabla `controlglu`
--
ALTER TABLE `controlglu`
  ADD PRIMARY KEY (`idusuario`,`fecha`),
  ADD KEY `fecha` (`fecha`),
  ADD KEY `idusuario` (`idusuario`);

--
-- Indices de la tabla `hiper`
--
ALTER TABLE `hiper`
  ADD PRIMARY KEY (`idusuario`,`fecha`,`idcomida`),
  ADD KEY `idusuario` (`idusuario`) USING BTREE,
  ADD KEY `hiper_ibfk_2` (`fecha`),
  ADD KEY `hiper_ibfk_3` (`idcomida`);

--
-- Indices de la tabla `hipo`
--
ALTER TABLE `hipo`
  ADD PRIMARY KEY (`idusuario`,`fecha`,`idcomida`),
  ADD KEY `idusuario` (`idusuario`) USING BTREE,
  ADD KEY `hipo_ibfk_2` (`fecha`),
  ADD KEY `hipo_ibfk_3` (`idcomida`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`idusuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `idusuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `comidas`
--
ALTER TABLE `comidas`
  ADD CONSTRAINT `comidas_ibfk_2` FOREIGN KEY (`fecha`) REFERENCES `controlglu` (`fecha`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `controlglu`
--
ALTER TABLE `controlglu`
  ADD CONSTRAINT `controlglu_ibfk_1` FOREIGN KEY (`idusuario`) REFERENCES `usuarios` (`idusuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `hiper`
--
ALTER TABLE `hiper`
  ADD CONSTRAINT `hiper_ibfk_2` FOREIGN KEY (`fecha`) REFERENCES `comidas` (`fecha`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `hipo`
--
ALTER TABLE `hipo`
  ADD CONSTRAINT `hipo_ibfk_2` FOREIGN KEY (`fecha`) REFERENCES `comidas` (`fecha`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
