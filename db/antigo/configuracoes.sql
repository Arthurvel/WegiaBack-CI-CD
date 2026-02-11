-- -----------------------------------------------------
-- Table `wegia`.`campo_imagem`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wegia`.`campo_imagem` (
    `id_campo` INT(11) NOT NULL AUTO_INCREMENT,
    `nome_campo` VARCHAR(40) NOT NULL,
    `tipo` ENUM('img', 'car') NOT NULL,
    PRIMARY KEY (`id_campo`),
    UNIQUE INDEX `nome_campo` (`nome_campo` ASC))
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `wegia`.`imagem`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wegia`.`imagem` (
    `id_imagem` INT(11) NOT NULL AUTO_INCREMENT,
    `nome` VARCHAR(50) NOT NULL,
    `imagem` LONGTEXT NULL DEFAULT NULL,
    `tipo` VARCHAR(25) NOT NULL,
    PRIMARY KEY (`id_imagem`),
    UNIQUE INDEX `nome` (`nome` ASC))
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `wegia`.`tabela_imagem_campo`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wegia`.`tabela_imagem_campo` (
    `id_relacao` INT(11) NOT NULL AUTO_INCREMENT,
    `id_campo` INT(11) NOT NULL,
    `id_imagem` INT(11) NOT NULL,
    PRIMARY KEY (`id_relacao`),
    INDEX `id_campo` (`id_campo` ASC),
    INDEX `id_imagem` (`id_imagem` ASC),
    CONSTRAINT `tabela_imagem_campo_ibfk_1`
    FOREIGN KEY (`id_campo`)
    REFERENCES `wegia`.`campo_imagem` (`id_campo`),
    CONSTRAINT `tabela_imagem_campo_ibfk_2`
    FOREIGN KEY (`id_imagem`)
    REFERENCES `wegia`.`imagem` (`id_imagem`))
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `wegia`.`selecao_paragrafo`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wegia`.`selecao_paragrafo` (
    `id_selecao` INT(11) NOT NULL AUTO_INCREMENT,
    `nome_campo` VARCHAR(40) NOT NULL,
    `paragrafo` TEXT NOT NULL,
    `original` TINYINT(4) NULL DEFAULT '1',
    PRIMARY KEY (`id_selecao`))
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `wegia`.`contato_instituicao`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wegia`.`contato_instituicao` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `descricao` VARCHAR(256) NOT NULL,
    `contato` VARCHAR(256) NOT NULL,
    PRIMARY KEY (`id`))
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `wegia`.`endereco_instituicao`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wegia`.`endereco_instituicao` (
    `id_inst` INT(11) NOT NULL AUTO_INCREMENT,
    `nome` VARCHAR(256) NOT NULL,
    `numero_endereco` VARCHAR(256) NOT NULL,
    `logradouro` VARCHAR(256) NOT NULL,
    `bairro` VARCHAR(256) NULL DEFAULT NULL,
    `cidade` VARCHAR(256) NOT NULL,
    `estado` VARCHAR(256) NOT NULL,
    `cep` VARCHAR(256) NOT NULL,
    `complemento` VARCHAR(256) NULL DEFAULT NULL,
    `ibge` VARCHAR(256) NOT NULL,
    PRIMARY KEY (`id_inst`))
ENGINE = InnoDB;

-- ------------------------------------------------------
-- Table `wegia`.`aviso`
-- ------------------------------------------------------

CREATE TABLE IF NOT EXISTS `wegia`.`aviso` (
    `id_aviso` INT(11) NOT NULL AUTO_INCREMENT,
    `id_pessoa` INT(11) NOT NULL,
    `titulo` VARCHAR(255) NOT NULL,
    `descricao` TEXT NOT NULL,
    `data_criacao` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `nivel` ENUM('info', 'alerta', 'erro') NOT NULL DEFAULT 'info',
    `url` VARCHAR(100) NULL,
    `ativo` BOOLEAN NOT NULL DEFAULT TRUE,
    PRIMARY KEY (`id_aviso`),
    FOREIGN KEY (`id_pessoa`)
    REFERENCES `wegia`.`pessoa` (`id_pessoa`)
    ON DELETE CASCADE
    ON UPDATE CASCADE
) ENGINE = InnoDB;