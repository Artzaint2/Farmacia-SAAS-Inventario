-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 24-07-2023 a las 20:08:16
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
-- Base de datos: `farmacia`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(11) NOT NULL,
  `nombre_producto` varchar(100) NOT NULL,
  `proveedor` varchar(60) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `fecha_ingreso` date DEFAULT NULL,
  `fecha_vencimiento` date DEFAULT NULL,
  `lote` int(11) DEFAULT NULL,
  `tipo_farmaceutico` varchar(50) DEFAULT NULL,
  `personal_ingreso` varchar(100) DEFAULT NULL,
  `ruta_imagen` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `nombre_producto`, `proveedor`, `cantidad`, `fecha_ingreso`, `fecha_vencimiento`, `lote`, `tipo_farmaceutico`, `personal_ingreso`, `ruta_imagen`) VALUES
(3, 'Cetirizina', 'Umbrella Corporation', 60, '2023-07-11', '2023-07-15', 25, 'Anti-Alergico', 'Enrique Hidalgo', 'carpeta_imagenes/pills.png'),
(4, 'Carbedilol', 'Hal Laboratories', 40, '2023-07-21', '2025-01-31', 70, 'Cardio', 'Esteban Dido', 'carpeta_imagenes/pills.png'),
(5, 'Adrenalina (injeccion)', 'Capybara Science', 10, '2023-07-22', '2029-12-02', 2, 'Analgesico', 'David Estevez', 'carpeta_imagenes/pills.png'),
(8, 'Dreamer', 'Johnson&Johnson', 100, '2023-07-29', '2025-07-23', 3, 'Somnifero', 'Maria Antonieta de las Nieves', 'carpeta_imagenes/pills.png'),
(9, 'Dol', 'Genova Labs', 35, '2023-07-24', '2027-07-22', 2, 'Esteroide', 'Jose Monagas', 'carpeta_imagenes/pills.png'),
(10, 'Omeprazol', 'Drogas y Farmacos Bella Vista', 70, '2023-07-24', '2028-08-15', 10, 'Inhibidor', 'Andres Medina', 'carpeta_imagenes/pills.png'),
(11, 'Clonazepam', 'Centro de Diagnostico Integral (CDI)', 50, '2023-07-24', '2032-07-22', 20, 'Benzodiacepina', 'Gustavo Fuenmayor', 'carpeta_imagenes/pills.png');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `email` varchar(30) NOT NULL,
  `password` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `email`, `password`) VALUES
(3, 'Enrique Hidalgo', 'ejhd7@hotmail.com', '2101');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
