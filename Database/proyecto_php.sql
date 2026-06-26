-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 26-06-2026 a las 19:47:50
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
-- Base de datos: `proyecto_php`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `correo` varchar(64) NOT NULL,
  `clave` varchar(255) NOT NULL,
  `estado` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `correo`, `clave`, `estado`) VALUES
(1, 'admin@gmail.com', '123456', 1),
(2, 'user@gmail.com', '654321', 1),
(3, 'inactivo@gmail.com', '111222', 0),
(4, 'nombre@gmail.com', '777555', 1),
(5, 'prueba@mail.com', '\\.dJ.GDMynllGGxduQf02zN60lYNTQUJ3zc6', 1),
(6, 'prueba2@mail.com', '$2y$10$EjATeY82Fh5UOhRv2WrjT.aIa07uenePZg2ivUG6tvgMs8GIiYF/G', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


CREATE TABLE `categorias` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `nombre` VARCHAR(100) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE `productos` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `nombre` VARCHAR(150) NOT NULL,
    `id_categoria` INT(11) NOT NULL,
    PRIMARY KEY (`id`),
    CONSTRAINT `fk_producto_categoria`
        FOREIGN KEY (`id_categoria`)
        REFERENCES `categorias`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE `atributos` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `nombre` VARCHAR(100) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `valores_productos` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `id_producto` INT(11) NOT NULL,
    `id_atributo` INT(11) NOT NULL,
    `valor` VARCHAR(255) NOT NULL,
    PRIMARY KEY (`id`),
    CONSTRAINT `fk_valor_producto`
        FOREIGN KEY (`id_producto`)
        REFERENCES `productos`(`id`),
    CONSTRAINT `fk_valor_atributo`
        FOREIGN KEY (`id_atributo`)
        REFERENCES `atributos`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =========================
-- ROPA DE HOMBRE (5 registros)
-- =========================

INSERT INTO productos VALUES (1, 'Polo Casual', 1);
INSERT INTO valores_productos (producto_id, atributo_id, valor) VALUES
(1, 1, 'Lacoste'),
(1, 2, 'Rojo'),
(1, 3, 'L');

INSERT INTO productos VALUES (3, 'Camisa Formal', 1);
INSERT INTO valores_productos (producto_id, atributo_id, valor) VALUES
(3, 1, 'Tommy Hilfiger'),
(3, 2, 'Blanco'),
(3, 3, 'M');

INSERT INTO productos VALUES (4, 'Casaca Deportiva', 1);
INSERT INTO valores_productos (producto_id, atributo_id, valor) VALUES
(4, 1, 'Adidas'),
(4, 2, 'Negro'),
(4, 3, 'XL');

INSERT INTO productos VALUES (5, 'Pantalón Jeans', 1);
INSERT INTO valores_productos (producto_id, atributo_id, valor) VALUES
(5, 1, 'Levis'),
(5, 2, 'Azul'),
(5, 3, '32');

INSERT INTO productos VALUES (6, 'Short Verano', 1);
INSERT INTO valores_productos (producto_id, atributo_id, valor) VALUES
(6, 1, 'Nike'),
(6, 2, 'Gris'),
(6, 3, 'M');

-- =========================
-- TELÉFONOS (5 registros)
-- =========================

INSERT INTO productos VALUES (2, 'Smartphone X1', 2);
INSERT INTO valores_productos (producto_id, atributo_id, valor) VALUES
(2, 1, 'Samsung'),
(2, 4, '2025'),
(2, 5, 'Android 15'),
(2, 6, '256GB'),
(2, 2, 'Azul');

INSERT INTO productos VALUES (7, 'iPhone 16', 2);
INSERT INTO valores_productos (producto_id, atributo_id, valor) VALUES
(7, 1, 'Apple'),
(7, 4, '2025'),
(7, 5, 'iOS 19'),
(7, 6, '128GB'),
(7, 2, 'Negro');

INSERT INTO productos VALUES (8, 'Galaxy S25', 2);
INSERT INTO valores_productos (producto_id, atributo_id, valor) VALUES
(8, 1, 'Samsung'),
(8, 4, '2025'),
(8, 5, 'Android 15'),
(8, 6, '512GB'),
(8, 2, 'Plata');

INSERT INTO productos VALUES (9, 'Xiaomi 15 Pro', 2);
INSERT INTO valores_productos (producto_id, atributo_id, valor) VALUES
(9, 1, 'Xiaomi'),
(9, 4, '2025'),
(9, 5, 'Android 15'),
(9, 6, '256GB'),
(9, 2, 'Verde');

INSERT INTO productos VALUES (10, 'Moto Edge 60', 2);
INSERT INTO valores_productos (producto_id, atributo_id, valor) VALUES
(10, 1, 'Motorola'),
(10, 4, '2025'),
(10, 5, 'Android 15'),
(10, 6, '256GB'),
(10, 2, 'Morado');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
