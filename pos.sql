-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 18-02-2026 a las 14:41:29
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
-- Base de datos: `pos`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cajas`
--

CREATE TABLE `cajas` (
  `id` int(11) NOT NULL,
  `numero_caja` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `folio` int(11) DEFAULT 1,
  `activo` tinyint(1) DEFAULT 1,
  `fecha_alta` datetime DEFAULT current_timestamp(),
  `fecha_edit` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `cajas`
--

INSERT INTO `cajas` (`id`, `numero_caja`, `nombre`, `folio`, `activo`, `fecha_alta`, `fecha_edit`) VALUES
(1, 1, 'Caja Principal', 1, 1, '2026-02-14 06:34:47', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `activo` tinyint(1) DEFAULT 1,
  `fecha_alta` datetime DEFAULT current_timestamp(),
  `fecha_edit` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id`, `nombre`, `activo`, `fecha_alta`, `fecha_edit`) VALUES
(1, 'General', 1, '2026-02-14 06:34:47', '2026-02-14 17:05:19'),
(2, 'Bebidas', 1, '2026-02-14 06:34:47', NULL),
(3, 'Alimentos', 1, '2026-02-14 06:34:47', NULL),
(4, 'Limpieza', 1, '2026-02-14 06:34:47', NULL),
(5, 'Papeleria', 1, '2026-02-14 06:34:47', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `correo` varchar(100) DEFAULT NULL,
  `activo` tinyint(1) DEFAULT 1,
  `fecha_alta` datetime DEFAULT current_timestamp(),
  `fecha_modifica` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id`, `nombre`, `direccion`, `telefono`, `correo`, `activo`, `fecha_alta`, `fecha_modifica`) VALUES
(1, 'Armando Paredes del Castillo', 'Cualquiera', '+5354549845', 'carlos.montenegro@gm.unal.cu', 1, '2026-02-15 04:46:00', '2026-02-15 04:46:00'),
(2, 'Público en General', 'Cualquiera', '54549845', 'carlos@gm.unal.cu', 1, '2026-02-14 23:49:06', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compras`
--

CREATE TABLE `compras` (
  `id` int(11) NOT NULL,
  `folio` varchar(20) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `activo` tinyint(1) DEFAULT 1,
  `fecha_alta` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `compras`
--

INSERT INTO `compras` (`id`, `folio`, `total`, `id_usuario`, `activo`, `fecha_alta`) VALUES
(1, '699011d621e3d', 4000.00, 1, 1, '2026-02-14 07:10:55'),
(2, '6990150e4e72f', 4000.00, 1, 1, '2026-02-14 07:24:21'),
(3, '6992a34d8eaf3', 2000.00, 1, 1, '2026-02-15 23:55:52'),
(4, '6992ab8a22a66', 2000.00, 1, 1, '2026-02-16 00:30:58');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `configuracion`
--

CREATE TABLE `configuracion` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `valor` varchar(255) DEFAULT NULL,
  `fecha_alta` datetime DEFAULT current_timestamp(),
  `fecha_edit` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `configuracion`
--

INSERT INTO `configuracion` (`id`, `nombre`, `valor`, `fecha_alta`, `fecha_edit`) VALUES
(1, 'tienda_nombre', 'Doña Nuria', '2026-02-14 06:19:44', '2026-02-16 14:12:11'),
(2, 'tienda_direccion', 'Maximo Gomez esq. Emilio Giro', '2026-02-14 06:19:44', '2026-02-14 07:21:07'),
(3, 'serie_compra', 'C', '2026-02-14 06:19:44', '2026-02-14 07:21:16'),
(4, 'serie_venta', 'V', '2026-02-14 06:19:44', '2026-02-14 07:21:21'),
(5, 'impuesto', '16', '2026-02-14 06:19:44', '2026-02-14 07:21:26'),
(6, 'moneda', '$', '2026-02-14 06:19:44', '2026-02-14 07:21:34'),
(8, 'tienda_email', 'alonsomenganaernesto@gmail.com', '2026-02-14 07:22:34', NULL),
(9, 'tienda_telefono', '+5356942221', '2026-02-14 07:22:56', '2026-02-16 14:02:42'),
(10, 'tienda_leyenda', 'Gracias por su Compra', '2026-02-14 07:23:19', '2026-02-15 21:22:24');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_compra`
--

CREATE TABLE `detalle_compra` (
  `id` int(11) NOT NULL,
  `id_compra` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `detalle_compra`
--

INSERT INTO `detalle_compra` (`id`, `id_compra`, `id_producto`, `nombre`, `cantidad`, `precio`) VALUES
(1, 1, 1, 'Refresco Cola', 20, 200.00),
(2, 2, 1, 'Refresco Cola', 20, 200.00),
(3, 3, 1, 'Refresco Cola', 10, 200.00),
(4, 4, 1, 'Refresco Cola', 10, 200.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_venta`
--

CREATE TABLE `detalle_venta` (
  `id` int(11) NOT NULL,
  `id_venta` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `fecha_alta` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `detalle_venta`
--

INSERT INTO `detalle_venta` (`id`, `id_venta`, `id_producto`, `nombre`, `cantidad`, `precio`, `fecha_alta`) VALUES
(1, 1, 1, 'Refresco Cola', 2, 250.00, '2026-02-16 00:45:50'),
(2, 1, 2, 'Refresco Naranja', 4, 250.00, '2026-02-16 00:45:50'),
(3, 2, 2, 'Refresco Naranja', 1, 250.00, '2026-02-16 00:59:28'),
(4, 3, 1, 'Refresco Cola', 1, 250.00, '2026-02-16 13:42:44'),
(5, 3, 2, 'Refresco Naranja', 2, 250.00, '2026-02-16 13:42:44');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(11) NOT NULL,
  `codigo` varchar(20) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `precio_venta` decimal(10,2) NOT NULL,
  `precio_compra` decimal(10,2) DEFAULT 0.00,
  `existencias` int(11) DEFAULT 0,
  `stock_minimo` int(11) DEFAULT 0,
  `inventariable` tinyint(1) DEFAULT 1,
  `id_unidad` int(11) NOT NULL,
  `id_categoria` int(11) NOT NULL,
  `activo` tinyint(1) DEFAULT 1,
  `fecha_alta` datetime DEFAULT current_timestamp(),
  `fecha_modifica` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `codigo`, `nombre`, `precio_venta`, `precio_compra`, `existencias`, `stock_minimo`, `inventariable`, `id_unidad`, `id_categoria`, `activo`, `fecha_alta`, `fecha_modifica`) VALUES
(1, '01', 'Refresco Cola', 250.00, 200.00, 84, 10, 1, 1, 2, 1, '2026-02-14 06:10:22', '2026-02-17 09:49:13'),
(2, '02', 'Refresco Naranja', 250.00, 200.00, 40, 10, 1, 1, 2, 1, '2026-02-16 02:14:52', '2026-02-17 09:49:28'),
(3, '03', 'Pruebita', 150.00, 100.00, 50, 10, 1, 1, 1, 1, '2026-02-16 19:27:04', '2026-02-17 09:49:50'),
(4, '04', 'Loco', 150.00, 100.00, 10, 10, 1, 2, 1, 1, '2026-02-16 19:32:47', '2026-02-16 19:32:47');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `activo` tinyint(1) DEFAULT 1,
  `fecha_alta` datetime DEFAULT current_timestamp(),
  `fecha_edit` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `nombre`, `activo`, `fecha_alta`, `fecha_edit`) VALUES
(1, 'Administrador', 1, '2026-02-14 06:34:47', NULL),
(2, 'Vendedor', 1, '2026-02-14 06:34:47', NULL),
(3, 'Almacenista', 1, '2026-02-14 06:34:47', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `temporal_compra`
--

CREATE TABLE `temporal_compra` (
  `id` int(11) NOT NULL,
  `folio` varchar(20) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `codigo` varchar(20) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `fecha_alta` datetime DEFAULT current_timestamp(),
  `fecha_edit` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `temporal_compra`
--

INSERT INTO `temporal_compra` (`id`, `folio`, `id_producto`, `codigo`, `nombre`, `cantidad`, `precio`, `subtotal`, `fecha_alta`, `fecha_edit`) VALUES
(3, '6991539c32f76', 1, '01', 'Refresco Cola', 4, 200.00, 800.00, '2026-02-15 00:03:36', '2026-02-15 00:03:56'),
(4, '69915a9bb0f8d', 1, '01', 'Refresco Cola', 1, 200.00, 200.00, '2026-02-15 00:35:33', NULL),
(6, '69915cc87f129', 1, '01', 'Refresco Cola', 1, 200.00, 200.00, '2026-02-15 00:42:49', NULL),
(7, '69915f4368880', 1, '01', 'Refresco Cola', 1, 200.00, 200.00, '2026-02-15 00:55:49', NULL),
(8, '69915fedd4466', 1, '01', 'Refresco Cola', 1, 200.00, 200.00, '2026-02-15 00:56:06', NULL),
(11, '6991e6403cfa4', 1, '01', 'Refresco Cola', 1, 200.00, 200.00, '2026-02-15 10:33:07', NULL),
(12, '6991e73ac13af', 1, '01', 'Refresco Cola', 1, 200.00, 200.00, '2026-02-15 10:33:23', NULL),
(13, '6991e76fb225e', 1, '01', 'Refresco Cola', 1, 200.00, 200.00, '2026-02-15 10:34:15', NULL),
(14, '6991e7caa4922', 1, '01', 'Refresco Cola', 1, 200.00, 200.00, '2026-02-15 10:35:43', NULL),
(15, '6991f45b3b4e8', 1, '01', 'Refresco Cola', 1, 200.00, 200.00, '2026-02-15 11:29:37', NULL),
(16, '6991f62395601', 1, '01', 'Refresco Cola', 1, 200.00, 200.00, '2026-02-15 11:36:59', NULL),
(17, '6991ff56eeef8', 1, '01', 'Refresco Cola', 1, 200.00, 200.00, '2026-02-15 12:16:18', NULL),
(18, '69920844589e1', 1, '01', 'Refresco Cola', 1, 200.00, 200.00, '2026-02-15 12:54:30', NULL),
(19, '699223b0b08a6', 1, '01', 'Refresco Cola', 1, 200.00, 200.00, '2026-02-15 14:51:24', NULL),
(20, '69926f7822ce5', 1, '01', 'Refresco Cola', 1, 200.00, 200.00, '2026-02-15 20:14:51', NULL),
(34, '69929f8d56d26', 2, '02', 'Refresco Naranja', 1, 200.00, 200.00, '2026-02-15 23:39:51', NULL),
(35, '6992a0045ca6e', 2, '02', 'Refresco Naranja', 1, 200.00, 200.00, '2026-02-15 23:41:44', NULL),
(36, '6992a09761fad', 2, '02', 'Refresco Naranja', 1, 200.00, 200.00, '2026-02-15 23:44:12', NULL),
(37, '6992a10a12ef3', 2, '02', 'Refresco Naranja', 1, 200.00, 200.00, '2026-02-15 23:46:07', NULL),
(40, '6992a4d713268', 1, '01', 'Refresco Cola', 1, 200.00, 200.00, '2026-02-16 00:02:20', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `temporal_venta`
--

CREATE TABLE `temporal_venta` (
  `id` int(11) NOT NULL,
  `folio` varchar(50) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `codigo` varchar(50) NOT NULL,
  `nombre` varchar(200) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `subtotal` decimal(12,2) NOT NULL,
  `fecha_alta` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_edit` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `unidades`
--

CREATE TABLE `unidades` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `nombre_corto` varchar(10) NOT NULL,
  `activo` tinyint(1) DEFAULT 1,
  `fecha_alta` datetime DEFAULT current_timestamp(),
  `fecha_edit` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `unidades`
--

INSERT INTO `unidades` (`id`, `nombre`, `nombre_corto`, `activo`, `fecha_alta`, `fecha_edit`) VALUES
(1, 'Pieza', 'PZ', 1, '2026-02-14 06:34:47', NULL),
(2, 'Kilogramo', 'KG', 1, '2026-02-14 06:34:47', NULL),
(3, 'Gramo', 'G', 1, '2026-02-14 06:34:47', NULL),
(4, 'Litro', 'L', 1, '2026-02-14 06:34:47', NULL),
(5, 'Mililitro', 'ML', 1, '2026-02-14 06:34:47', NULL),
(6, 'Metro', 'M', 1, '2026-02-14 06:34:47', NULL),
(7, 'Centímetro', 'CM', 1, '2026-02-14 06:34:47', NULL),
(8, 'Caja', 'CJA', 1, '2026-02-14 06:34:47', NULL),
(9, 'Paquete', 'PAQ', 1, '2026-02-14 06:34:47', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `id_caja` int(11) DEFAULT NULL,
  `id_rol` int(11) NOT NULL,
  `activo` tinyint(1) DEFAULT 1,
  `fecha_alta` datetime DEFAULT current_timestamp(),
  `fecha_edit` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `usuario`, `nombre`, `password`, `id_caja`, `id_rol`, `activo`, `fecha_alta`, `fecha_edit`) VALUES
(1, 'carlos', 'Carlos Montenegro', '$2y$10$rUcBCuvuOTiDomfFRnsf3Oij5g2EHitQJvZGE4s6.Hm1J6udp2tDS', 1, 1, 1, '2026-02-14 07:07:39', '2026-02-14 11:55:05'),
(3, 'prueba', 'Consultor', '$2y$10$JbQOR.vMc6caN0EUOcXP/.lgy15KdBAErh/o2uBu/5Xzo8MUlX2oq', 1, 2, 1, '2026-02-14 23:10:20', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE `ventas` (
  `id` int(11) NOT NULL,
  `folio` varchar(20) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_caja` int(11) NOT NULL,
  `id_cliente` int(11) DEFAULT NULL,
  `forma_pago` varchar(20) DEFAULT 'EFECTIVO',
  `activo` tinyint(1) DEFAULT 1,
  `fecha_alta` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `ventas`
--

INSERT INTO `ventas` (`id`, `folio`, `total`, `id_usuario`, `id_caja`, `id_cliente`, `forma_pago`, `activo`, `fecha_alta`) VALUES
(1, '6992aef9a3b92', 1500.00, 1, 1, 1, '002', 0, '2026-02-16 00:45:50'),
(2, '6992b20b2ba3c', 250.00, 1, 1, 1, '002', 0, '2026-02-16 00:59:28'),
(3, '69936509b822a', 750.00, 1, 1, 2, '002', 1, '2026-02-16 13:42:44');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cajas`
--
ALTER TABLE `cajas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `compras`
--
ALTER TABLE `compras`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `folio` (`folio`),
  ADD KEY `idx_compras_folio` (`folio`),
  ADD KEY `idx_compras_usuario` (`id_usuario`);

--
-- Indices de la tabla `configuracion`
--
ALTER TABLE `configuracion`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `detalle_compra`
--
ALTER TABLE `detalle_compra`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_detalle_compra_compra` (`id_compra`),
  ADD KEY `idx_detalle_compra_producto` (`id_producto`);

--
-- Indices de la tabla `detalle_venta`
--
ALTER TABLE `detalle_venta`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_detalle_venta_venta` (`id_venta`),
  ADD KEY `idx_detalle_venta_producto` (`id_producto`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `codigo` (`codigo`),
  ADD KEY `idx_productos_codigo` (`codigo`),
  ADD KEY `idx_productos_categoria` (`id_categoria`),
  ADD KEY `idx_productos_unidad` (`id_unidad`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `temporal_compra`
--
ALTER TABLE `temporal_compra`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_temporal_compra_folio` (`folio`),
  ADD KEY `idx_temporal_compra_producto` (`id_producto`);

--
-- Indices de la tabla `temporal_venta`
--
ALTER TABLE `temporal_venta`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_folio` (`folio`),
  ADD KEY `idx_id_producto` (`id_producto`),
  ADD KEY `idx_deleted` (`deleted_at`);

--
-- Indices de la tabla `unidades`
--
ALTER TABLE `unidades`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `usuario` (`usuario`),
  ADD KEY `id_caja` (`id_caja`),
  ADD KEY `id_rol` (`id_rol`);

--
-- Indices de la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `folio` (`folio`),
  ADD KEY `idx_ventas_folio` (`folio`),
  ADD KEY `idx_ventas_usuario` (`id_usuario`),
  ADD KEY `idx_ventas_caja` (`id_caja`),
  ADD KEY `idx_ventas_cliente` (`id_cliente`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `cajas`
--
ALTER TABLE `cajas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `compras`
--
ALTER TABLE `compras`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `configuracion`
--
ALTER TABLE `configuracion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `detalle_compra`
--
ALTER TABLE `detalle_compra`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `detalle_venta`
--
ALTER TABLE `detalle_venta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `temporal_compra`
--
ALTER TABLE `temporal_compra`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT de la tabla `temporal_venta`
--
ALTER TABLE `temporal_venta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `unidades`
--
ALTER TABLE `unidades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `ventas`
--
ALTER TABLE `ventas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `compras`
--
ALTER TABLE `compras`
  ADD CONSTRAINT `compras_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `detalle_compra`
--
ALTER TABLE `detalle_compra`
  ADD CONSTRAINT `detalle_compra_ibfk_1` FOREIGN KEY (`id_compra`) REFERENCES `compras` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `detalle_compra_ibfk_2` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `detalle_venta`
--
ALTER TABLE `detalle_venta`
  ADD CONSTRAINT `detalle_venta_ibfk_1` FOREIGN KEY (`id_venta`) REFERENCES `ventas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `detalle_venta_ibfk_2` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`id_unidad`) REFERENCES `unidades` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `productos_ibfk_2` FOREIGN KEY (`id_categoria`) REFERENCES `categorias` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `temporal_compra`
--
ALTER TABLE `temporal_compra`
  ADD CONSTRAINT `temporal_compra_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `temporal_venta`
--
ALTER TABLE `temporal_venta`
  ADD CONSTRAINT `temporal_venta_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`id_caja`) REFERENCES `cajas` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `usuarios_ibfk_2` FOREIGN KEY (`id_rol`) REFERENCES `roles` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD CONSTRAINT `ventas_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `ventas_ibfk_2` FOREIGN KEY (`id_caja`) REFERENCES `cajas` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `ventas_ibfk_3` FOREIGN KEY (`id_cliente`) REFERENCES `clientes` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
