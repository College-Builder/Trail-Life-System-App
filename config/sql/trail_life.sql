-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 25, 2023 at 01:01 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `trail_life`
--

-- --------------------------------------------------------

--
-- Table structure for table `cargas`
--

CREATE TABLE `cargas` (
  `id` bigint(20) NOT NULL,
  `cliente` bigint(20) NOT NULL,
  `filial` bigint(20) NOT NULL,
  `rota` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`rota`)),
  `tipo_carga` enum('geral','especial','perigosa','perecivel','fracionada','farmaceutica') NOT NULL,
  `motorista` bigint(20) NOT NULL,
  `criador` bigint(20) NOT NULL,
  `criado` datetime DEFAULT current_timestamp(),
  `fechado` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `clientes`
--

CREATE TABLE `clientes` (
  `id` bigint(20) NOT NULL,
  `empresa` varchar(100) NOT NULL,
  `cnpj` char(64) NOT NULL,
  `estado` char(44) NOT NULL,
  `cidade` varchar(64) NOT NULL,
  `rua` varchar(108) NOT NULL,
  `numero` varchar(44) NOT NULL,
  `celular` char(64) NOT NULL,
  `email` varchar(108) NOT NULL,
  `fechado` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `filiais`
--

CREATE TABLE `filiais` (
  `id` bigint(20) NOT NULL,
  `cidade` varchar(20) NOT NULL,
  `estado` char(2) NOT NULL,
  `rua` varchar(100) NOT NULL,
  `bairro` varchar(100) NOT NULL,
  `numero` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `motoristas`
--

CREATE TABLE `motoristas` (
  `id` bigint(20) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `celular` char(64) NOT NULL,
  `rg` char(128) NOT NULL,
  `cpf` char(128) NOT NULL,
  `status` enum('livre','encarregado') NOT NULL DEFAULT 'livre',
  `nome_emergencia` varchar(50) NOT NULL,
  `celular_emergencia` char(64) NOT NULL,
  `email_emergencia` varchar(108) NOT NULL,
  `fechado` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `usuarios_adm`
--

CREATE TABLE `usuarios_adm` (
  `id` bigint(20) NOT NULL,
  `email` varchar(108) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `usuario` char(128) NOT NULL,
  `senha` char(128) NOT NULL,
  `permissao` enum('ler','escrever','todas') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `usuarios_adm`
--

INSERT INTO `usuarios_adm` (`id`, `email`, `nome`, `usuario`, `senha`, `permissao`) VALUES
(47, 'ZDGmGqSr6q0uZCszKdY2UiNKd7AUhd5YFa22RDtIRJbKth/hiJhBhicoqM/IHmvw', 'Gabriel Flores', 'c7ad44cbad762a5da0a452f9e854fdc1e0e7a52a38015f23f3eab1d80b931dd472634dfac71cd34ebc35d16ab7fb8a90c81f975113d6c7538dc69dd8de9077ec', 'c7ad44cbad762a5da0a452f9e854fdc1e0e7a52a38015f23f3eab1d80b931dd472634dfac71cd34ebc35d16ab7fb8a90c81f975113d6c7538dc69dd8de9077ec', 'todas');

-- --------------------------------------------------------

--
-- Table structure for table `usuarios_adm_session`
--

CREATE TABLE `usuarios_adm_session` (
  `id` bigint(20) NOT NULL,
  `token` varchar(108) NOT NULL,
  `creation` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cargas`
--
ALTER TABLE `cargas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_cargas_cliente` (`cliente`),
  ADD KEY `fk_cargas_filial` (`filial`),
  ADD KEY `fk_cargas_motorista` (`motorista`),
  ADD KEY `fk_cargas_criador` (`criador`);

--
-- Indexes for table `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `filiais`
--
ALTER TABLE `filiais`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `motoristas`
--
ALTER TABLE `motoristas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `usuarios_adm`
--
ALTER TABLE `usuarios_adm`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `usuario` (`usuario`);

--
-- Indexes for table `usuarios_adm_session`
--
ALTER TABLE `usuarios_adm_session`
  ADD KEY `id` (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cargas`
--
ALTER TABLE `cargas`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `filiais`
--
ALTER TABLE `filiais`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `motoristas`
--
ALTER TABLE `motoristas`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `usuarios_adm`
--
ALTER TABLE `usuarios_adm`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cargas`
--
ALTER TABLE `cargas`
  ADD CONSTRAINT `fk_cargas_cliente` FOREIGN KEY (`cliente`) REFERENCES `clientes` (`id`),
  ADD CONSTRAINT `fk_cargas_criador` FOREIGN KEY (`criador`) REFERENCES `usuarios_adm` (`id`),
  ADD CONSTRAINT `fk_cargas_filial` FOREIGN KEY (`filial`) REFERENCES `filiais` (`id`),
  ADD CONSTRAINT `fk_cargas_motorista` FOREIGN KEY (`motorista`) REFERENCES `motoristas` (`id`);

--
-- Constraints for table `usuarios_adm_session`
--
ALTER TABLE `usuarios_adm_session`
  ADD CONSTRAINT `usuarios_adm_session_ibfk_1` FOREIGN KEY (`id`) REFERENCES `usuarios_adm` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
