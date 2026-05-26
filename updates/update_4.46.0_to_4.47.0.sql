-- Atualizações na tabela Emitente
ALTER TABLE `emitente` MODIFY `rua` VARCHAR(255) NULL;
ALTER TABLE `emitente` MODIFY `bairro` VARCHAR(100) NULL;
ALTER TABLE `emitente` MODIFY `cidade` VARCHAR(100) NULL;
ALTER TABLE `emitente` MODIFY `numero` VARCHAR(10) NULL;
ALTER TABLE `emitente` MODIFY `cep` VARCHAR(10) NULL;
ALTER TABLE `emitente` MODIFY `telefone` VARCHAR(25) NULL;
ALTER TABLE `emitente` MODIFY `cnpj` VARCHAR(18) NULL;
ALTER TABLE `emitente` MODIFY `ie` VARCHAR(20) NULL;

ALTER TABLE `emitente` ADD COLUMN IF NOT EXISTS `complemento` VARCHAR(255) NULL AFTER `numero`;
ALTER TABLE `emitente` ADD COLUMN IF NOT EXISTS `im` VARCHAR(20) NULL AFTER `ie`;
ALTER TABLE `emitente` ADD COLUMN IF NOT EXISTS `cnae` VARCHAR(10) NULL AFTER `im`;
ALTER TABLE `emitente` ADD COLUMN IF NOT EXISTS `atividade_principal` TEXT NULL AFTER `cnae`;
ALTER TABLE `emitente` ADD COLUMN IF NOT EXISTS `situacao` VARCHAR(50) NULL AFTER `atividade_principal`;
ALTER TABLE `emitente` ADD COLUMN IF NOT EXISTS `data_situacao` DATE NULL AFTER `situacao`;
ALTER TABLE `emitente` ADD COLUMN IF NOT EXISTS `data_abertura` DATE NULL AFTER `data_situacao`;
ALTER TABLE `emitente` ADD COLUMN IF NOT EXISTS `natureza_juridica` VARCHAR(100) NULL AFTER `data_abertura`;
ALTER TABLE `emitente` ADD COLUMN IF NOT EXISTS `porte` VARCHAR(50) NULL AFTER `natureza_juridica`;
ALTER TABLE `emitente` ADD COLUMN IF NOT EXISTS `capital_social` DECIMAL(15,2) NULL AFTER `porte`;
ALTER TABLE `emitente` ADD COLUMN IF NOT EXISTS `qsa` TEXT NULL AFTER `capital_social`;
ALTER TABLE `emitente` ADD COLUMN IF NOT EXISTS `email_contador` VARCHAR(255) NULL AFTER `email`;
ALTER TABLE `emitente` ADD COLUMN IF NOT EXISTS `codigo_ibge` VARCHAR(10) NULL AFTER `cep`;
ALTER TABLE `emitente` ADD COLUMN IF NOT EXISTS `numero_nfe` INT(11) NOT NULL DEFAULT 0 AFTER `codigo_ibge`;
ALTER TABLE `emitente` ADD COLUMN IF NOT EXISTS `numero_nfce` INT(11) NOT NULL DEFAULT 0 AFTER `numero_nfe`;
ALTER TABLE `emitente` ADD COLUMN IF NOT EXISTS `latitude` VARCHAR(50) NULL;
ALTER TABLE `emitente` ADD COLUMN IF NOT EXISTS `longitude` VARCHAR(50) NULL;

-- Atualizações na tabela Clientes
CREATE TABLE IF NOT EXISTS `contatos` (
  `idContatos` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `cliente_id` INT(11) NOT NULL,
  `nome` VARCHAR(255) NOT NULL,
  `telefone` TEXT NULL,
  `celular` TEXT NULL,
  `email` TEXT NULL,
  `cargo` VARCHAR(100) NULL,
  `observacoes` TEXT NULL,
  `dataCadastro` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idContatos`),
  INDEX `fk_contatos_idx` (`cliente_id` ASC),
  CONSTRAINT `fk_contatos` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`idClientes`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE `clientes` MODIFY `email` VARCHAR(255) NOT NULL;
ALTER TABLE `clientes` MODIFY `rua` VARCHAR(255) NULL;
ALTER TABLE `clientes` MODIFY `bairro` VARCHAR(100) NULL;
ALTER TABLE `clientes` MODIFY `cidade` VARCHAR(100) NULL;
ALTER TABLE `clientes` MODIFY `cep` VARCHAR(10) NULL;
ALTER TABLE `clientes` MODIFY `telefone` VARCHAR(25) NOT NULL;
ALTER TABLE `clientes` MODIFY `celular` VARCHAR(25) NULL;
ALTER TABLE `clientes` MODIFY `numero` VARCHAR(10) NULL;
ALTER TABLE `clientes` MODIFY `complemento` VARCHAR(100) NULL;
ALTER TABLE `clientes` MODIFY `contato` VARCHAR(100) NULL;

ALTER TABLE `clientes` ADD COLUMN IF NOT EXISTS `ie` VARCHAR(20) NULL AFTER `documento`;
ALTER TABLE `clientes` ADD COLUMN IF NOT EXISTS `im` VARCHAR(20) NULL AFTER `ie`;
ALTER TABLE `clientes` ADD COLUMN IF NOT EXISTS `codigo_ibge` VARCHAR(10) NULL AFTER `cep`;
ALTER TABLE `clientes` ADD COLUMN IF NOT EXISTS `tipo` VARCHAR(32) NULL;
ALTER TABLE `clientes` ADD COLUMN IF NOT EXISTS `porte` VARCHAR(50) NULL;
ALTER TABLE `clientes` ADD COLUMN IF NOT EXISTS `cnae` VARCHAR(7) NULL;
ALTER TABLE `clientes` ADD COLUMN IF NOT EXISTS `fantasia` VARCHAR(255) NULL;
ALTER TABLE `clientes` ADD COLUMN IF NOT EXISTS `atividade_principal` VARCHAR(255) NULL;
ALTER TABLE `clientes` ADD COLUMN IF NOT EXISTS `atividades_secundarias` TEXT NULL;
ALTER TABLE `clientes` ADD COLUMN IF NOT EXISTS `natureza_juridica` VARCHAR(255) NULL;
ALTER TABLE `clientes` ADD COLUMN IF NOT EXISTS `situacao` VARCHAR(50) NULL;
ALTER TABLE `clientes` ADD COLUMN IF NOT EXISTS `data_situacao` DATE NULL;
ALTER TABLE `clientes` ADD COLUMN IF NOT EXISTS `motivo_situacao` VARCHAR(255) NULL;
ALTER TABLE `clientes` ADD COLUMN IF NOT EXISTS `situacao_especial` VARCHAR(100) NULL;
ALTER TABLE `clientes` ADD COLUMN IF NOT EXISTS `data_situacao_especial` DATE NULL;
ALTER TABLE `clientes` ADD COLUMN IF NOT EXISTS `capital_social` VARCHAR(50) NULL;
ALTER TABLE `clientes` ADD COLUMN IF NOT EXISTS `qsa` TEXT NULL;
ALTER TABLE `clientes` ADD COLUMN IF NOT EXISTS `nascimento` DATE NULL AFTER `sexo`;
ALTER TABLE `clientes` ADD COLUMN IF NOT EXISTS `tratamento` VARCHAR(50) NULL DEFAULT 'Sr.(a)' AFTER `nascimento`;
ALTER TABLE `clientes` ADD COLUMN IF NOT EXISTS `latitude` DECIMAL(10,8) NULL;
ALTER TABLE `clientes` ADD COLUMN IF NOT EXISTS `longitude` DECIMAL(11,8) NULL;
ALTER TABLE `clientes` ADD COLUMN IF NOT EXISTS `endereco_geocodificado` TEXT NULL AFTER `longitude`;
ALTER TABLE `clientes` ADD COLUMN IF NOT EXISTS `data_enriquecimento` DATETIME NULL AFTER `dataCadastro`;
ALTER TABLE `clientes` ADD COLUMN IF NOT EXISTS `prospectado` TINYINT(1) DEFAULT 0 AFTER `data_enriquecimento`;
ALTER TABLE `clientes` ADD COLUMN IF NOT EXISTS `origem_prospeccao` VARCHAR(50) NULL AFTER `prospectado`;

-- Atualizações para Monitor de Serviços (OSRM)
ALTER TABLE `os` ADD COLUMN IF NOT EXISTS `ordem_itinerario` INT DEFAULT 0 NULL;

CREATE TABLE IF NOT EXISTS `osrm_queue` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `idUsuarios` INT(11) NOT NULL,
  `status` VARCHAR(20) DEFAULT 'pending',
  `created_at` DATETIME,
  `processed_at` DATETIME NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
