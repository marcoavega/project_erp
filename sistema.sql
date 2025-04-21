-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 21-04-2025 a las 07:42:21
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
-- Base de datos: `sistema`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `level_user` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `img_url` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`user_id`, `username`, `email`, `password`, `level_user`, `created_at`, `updated_at`, `img_url`) VALUES
(2, 'administrador2', 'administrador2@gmail.com', '$2y$10$GgtTWrlYykHcv6hednsnKOEJEKyOG5JQmrMnHjX736nL4p6gK2bAW', 2, '2025-03-18 20:15:59', '2025-04-20 21:51:26', ''),
(4, 'administrador4', 'administrador4@gmal.com', '$2y$10$AZY2PeKKwWrk2xQYRP.bdeP38C5UwfzIP9z4y1XoUCOZ2RY54SgOO', 2, '2025-03-24 03:54:09', '2025-04-13 00:04:09', ''),
(5, 'administrador5', 'administrador5@gmal.com', '$2y$10$yq3sYo7Ba8LSptE52b851e0.E.vy9abukFSUvxPw5e.pr/rIWPrAG', 2, '2025-03-24 03:57:18', '2025-04-13 00:04:09', ''),
(15, 'administrador1', 'administrador1@gmail.com', '$2y$10$HqeAjVjU2IdwaCGQfV3T.OvgOXuWF.IpPJPKT57FqDO3FtBby5dom', 2, '2025-03-28 23:33:42', '2025-04-20 15:44:22', ''),
(27, 'administrador', 'administrador@gmail.com', '$2y$10$5DSbp6nSLKLs1MfK.c8PUeq.RbXo94s7dF42u8maVwIGGOQInhIPS', 1, '2025-04-18 05:44:07', '2025-04-21 05:29:17', ''),
(28, 'administrador11', 'administrador11@gmail.com', '$2y$10$VhEhGEPDXtBPCph.3BVBmerGSYQ9OHZrwUmAhmTMAlzealISAjbSO', 0, '2025-04-20 21:48:31', '2025-04-20 21:49:38', '');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
