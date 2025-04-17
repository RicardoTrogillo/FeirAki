
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";



CREATE TABLE `post` (
  `post_id` int(11) NOT NULL,
  `nome_feira` varchar(255) NOT NULL,
  `nome_feirante` varchar(255) NOT NULL,
  `descricao` text NOT NULL,
  `regiao` varchar(255) NOT NULL,
  `imagem` varchar(255) DEFAULT NULL,
  `usuario_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `post` (`post_id`, `nome_feira`, `nome_feirante`, `descricao`, `regiao`, `imagem`, `usuario_id`) VALUES


CREATE TABLE `post2` (
  `post_id` int(11) NOT NULL,
  `nome_condominio` varchar(100) NOT NULL,
  `nome_sindico` varchar(100) NOT NULL,
  `descricao` text NOT NULL,
  `endereco` varchar(255) NOT NULL,
  `foto_condominio` varchar(255) DEFAULT NULL,
  `usuario_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `post2` (`post_id`, `nome_condominio`, `nome_sindico`, `descricao`, `endereco`, `foto_condominio`, `usuario_id`) VALUES


CREATE TABLE `usuarios` (
  `usuario_id` int(11) NOT NULL,
  `nome_feira` varchar(100) NOT NULL,
  `nome_feirante` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `descricao` varchar(100) NOT NULL,
  `imagem` varchar(255) DEFAULT NULL,
  `regiao` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `usuarios` (`usuario_id`, `nome_feira`, `nome_feirante`, `email`, `senha`, `descricao`, `imagem`, `regiao`) VALUES


CREATE TABLE `usuarios2` (
  `usuario_id` int(11) NOT NULL,
  `nome_condominio` varchar(100) NOT NULL,
  `nome_sindico` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `descricao` text NOT NULL,
  `senha` varchar(255) NOT NULL,
  `endereco` varchar(255) NOT NULL,
  `foto_condominio` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `usuarios2` (`usuario_id`, `nome_condominio`, `nome_sindico`, `email`, `descricao`, `senha`, `endereco`, `foto_condominio`) VALUES


ALTER TABLE `post`
  ADD PRIMARY KEY (`post_id`),
  ADD KEY `fk_usuario_id` (`usuario_id`);


ALTER TABLE `post2`
  ADD PRIMARY KEY (`post_id`),
  ADD KEY `fk_usuario_id` (`usuario_id`);


ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`usuario_id`);


ALTER TABLE `usuarios2`
  ADD PRIMARY KEY (`usuario_id`);


ALTER TABLE `post`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;


ALTER TABLE `post2`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;


ALTER TABLE `usuarios`
  MODIFY `usuario_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

ALTER TABLE `usuarios2`
  MODIFY `usuario_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;
