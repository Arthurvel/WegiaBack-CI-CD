-- -----------------------------------------------------
-- Table `wegia`.`atendido_tipo`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wegia`.`atendido_tipo` (
    `idatendido_tipo` INT NOT NULL AUTO_INCREMENT,
    `descricao` VARCHAR(255) NOT NULL,
    PRIMARY KEY (`idatendido_tipo`))
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `wegia`.`atendido_status`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wegia`.`atendido_status` (
    `idatendido_status` INT NOT NULL AUTO_INCREMENT,
    `status` VARCHAR(255) NULL,
    PRIMARY KEY (`idatendido_status`))
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `wegia`.`atendido`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wegia`.`atendido` (
    `idatendido` INT NOT NULL AUTO_INCREMENT,
    `pessoa_id_pessoa` INT(11) NOT NULL,
    `atendido_tipo_idatendido_tipo` INT NOT NULL,
    `atendido_status_idatendido_status` INT NOT NULL,
    PRIMARY KEY (`idatendido`),
    INDEX `fk_atendido_pessoa1_idx` (`pessoa_id_pessoa` ASC),
    INDEX `fk_atendido_atendido_tipo1_idx` (`atendido_tipo_idatendido_tipo` ASC),
    INDEX `fk_atendido_atentido_status1_idx` (`atendido_status_idatendido_status` ASC),
    CONSTRAINT `fk_atendido_pessoa1`
    FOREIGN KEY (`pessoa_id_pessoa`)
    REFERENCES `wegia`.`pessoa` (`id_pessoa`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
    CONSTRAINT `fk_atendido_atendido_tipo1`
    FOREIGN KEY (`atendido_tipo_idatendido_tipo`)
    REFERENCES `wegia`.`atendido_tipo` (`idatendido_tipo`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
    CONSTRAINT `fk_atendido_atentido_status1`
    FOREIGN KEY (`atendido_status_idatendido_status`)
    REFERENCES `wegia`.`atendido_status` (`idatendido_status`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `wegia`.`atendido_ocorrencia_tipos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wegia`.`atendido_ocorrencia_tipos` (
    `idatendido_ocorrencia_tipos` INT NOT NULL AUTO_INCREMENT,
    `descricao` VARCHAR(255) NULL,
    PRIMARY KEY (`idatendido_ocorrencia_tipos`))
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `wegia`.`atendido_ocorrencia`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wegia`.`atendido_ocorrencia` (
    `idatendido_ocorrencias` INT NOT NULL AUTO_INCREMENT,
    `atendido_idatendido` INT NOT NULL,
    `atendido_ocorrencia_tipos_idatendido_ocorrencia_tipos` INT NOT NULL,
    `funcionario_id_funcionario` INT(11) NOT NULL,
    `data` DATE NOT NULL,
    `descricao` VARCHAR(255) NULL,
    PRIMARY KEY (`idatendido_ocorrencias`),
    INDEX `fk_atentido_ocorrencias_atendido1_idx` (`atendido_idatendido` ASC),
    INDEX `fk_atentido_ocorrencias_atendido_ocorrencia_tipos1_idx` (`atendido_ocorrencia_tipos_idatendido_ocorrencia_tipos` ASC),
    INDEX `fk_atentido_ocorrencias_funcionario1_idx` (`funcionario_id_funcionario` ASC),
    CONSTRAINT `fk_atentido_ocorrencias_atendido1`
    FOREIGN KEY (`atendido_idatendido`)
    REFERENCES `wegia`.`atendido` (`idatendido`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
    CONSTRAINT `fk_atentido_ocorrencias_atendido_ocorrencia_tipos1`
    FOREIGN KEY (`atendido_ocorrencia_tipos_idatendido_ocorrencia_tipos`)
    REFERENCES `wegia`.`atendido_ocorrencia_tipos` (`idatendido_ocorrencia_tipos`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
    CONSTRAINT `fk_atentido_ocorrencias_funcionario1`
    FOREIGN KEY (`funcionario_id_funcionario`)
    REFERENCES `wegia`.`funcionario` (`id_funcionario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `wegia`.`atendido_ocorrencia_doc`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wegia`.`atendido_ocorrencia_doc` (
    `idatendido_ocorrencia_doc` INT NOT NULL AUTO_INCREMENT,
    `atentido_ocorrencia_idatentido_ocorrencias` INT NOT NULL,
    `data` TIMESTAMP NOT NULL,
    `arquivo_nome` VARCHAR(255) NOT NULL,
    `arquivo_extensao` VARCHAR(200) NOT NULL,
    `arquivo` VARCHAR(255) NOT NULL,
    PRIMARY KEY (`idatendido_ocorrencia_doc`),
    INDEX `fk_atendido_ocorrencia_doc_atentido_ocorrencia1_idx` (`atentido_ocorrencia_idatentido_ocorrencias` ASC),
    CONSTRAINT `fk_atendido_ocorrencia_doc_atentido_ocorrencia1`
    FOREIGN KEY (`atentido_ocorrencia_idatentido_ocorrencias`)
    REFERENCES `wegia`.`atendido_ocorrencia` (`idatendido_ocorrencias`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

-- -----------------------------------------------------------------------
-- Table `wegia`.`pa_status`
-- -----------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `wegia`.`pa_status`(
    `id` INT NOT NULL AUTO_INCREMENT,
    `descricao` VARCHAR(512) NOT NULL,
    PRIMARY KEY (`id`))
ENGINE = InnoDB;

-- -----------------------------------------------------------------------
-- Table `wegia`.`processo_de_aceitacao`
-- -----------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `wegia`.`processo_de_aceitacao`(
    `id` INT NOT NULL AUTO_INCREMENT,
    `data_inicio` DATETIME NOT NULL,
    `data_fim` DATETIME NULL,
    `descricao` VARCHAR(512) NOT NULL,
    `id_status` INT NOT NULL,
    `id_pessoa` INT NOT NULL,
    PRIMARY KEY (`id`),
    CONSTRAINT `fk_processo_status`
    FOREIGN KEY (`id_status`)
    REFERENCES `wegia`.`pa_status` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
    CONSTRAINT `fk_processo_pessoa`
    FOREIGN KEY (`id_pessoa`)
    REFERENCES `wegia`.`pessoa` (`id_pessoa`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

-- -----------------------------------------------------------------------
-- Table `wegia`.`pa_etapa`
-- -----------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `wegia`.`pa_etapa`(
    `id` INT NOT NULL AUTO_INCREMENT,
    `data_inicio` DATETIME NOT NULL,
    `data_fim` DATETIME NULL,
    `descricao` VARCHAR(512) NOT NULL,
    `id_processo` INT NOT NULL,
    `id_status` INT NOT NULL,
    PRIMARY KEY (`id`),
    CONSTRAINT `fk_etapa_processo`
    FOREIGN KEY (`id_processo`)
    REFERENCES `wegia`.`processo_de_aceitacao` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
    CONSTRAINT `fk_etapa_status`
    FOREIGN KEY (`id_status`)
    REFERENCES `wegia`.`pa_status` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

-- -----------------------------------------------------------------------
-- Table `wegia`.`pa_arquivo`
-- -----------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `wegia`.`pa_arquivo`(
    `id` INT NOT NULL AUTO_INCREMENT,
    `id_processo` INT NULL,
    `id_etapa` INT NULL,
    `arquivo_nome` VARCHAR(255) NOT NULL,
    `arquivo_extensao` VARCHAR(10) NOT NULL,
    `arquivo` VARCHAR(255) NOT NULL,
    `data_upload` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    CONSTRAINT `fk_pa_arquivo_processo`
    FOREIGN KEY (`id_processo`)
    REFERENCES `wegia`.`processo_de_aceitacao` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
    CONSTRAINT `fk_pa_arquivo_etapa`
    FOREIGN KEY (`id_etapa`)
    REFERENCES `wegia`.`pa_etapa` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
)ENGINE = InnoDB;

-- -----------------------------------------------------------------------
-- Table `wegia`.`etapa_arquivo`
-- -----------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `wegia`.`etapa_arquivo`(
    `id` INT NOT NULL AUTO_INCREMENT,
    `etapa_id` INT NOT NULL,
    `arquivo_nome` VARCHAR(255) NOT NULL,
    `arquivo_extensao` VARCHAR(10) NOT NULL,
    `arquivo` VARCHAR(255) NOT NULL,
    `data_upload` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    CONSTRAINT `fk_etapa_arquivo_etapa`
    FOREIGN KEY (`etapa_id`)
    REFERENCES `wegia`.`pa_etapa` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
)ENGINE = InnoDB;
