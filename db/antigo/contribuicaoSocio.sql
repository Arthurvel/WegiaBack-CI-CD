-- -----------------------------------------------------
-- Table `wegia`.`contribuicao_gatewayPagamento`
-- -----------------------------------------------------
CREATE TABLE `wegia`.`contribuicao_gatewayPagamento` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `plataforma` VARCHAR(50) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `wegia`.`contribuicao_regras`
-- -----------------------------------------------------
CREATE TABLE `wegia`.`contribuicao_regras` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `regra` VARCHAR(128) NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE INDEX `regra_UNIQUE` (`regra` ASC) VISIBLE
) ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `wegia`.`contribuicao_meioPagamento`
-- -----------------------------------------------------
CREATE TABLE `wegia`.`contribuicao_meioPagamento` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `meio` VARCHAR(45) NOT NULL,
    `id_plataforma` INT NOT NULL,
    `status` BOOLEAN NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE INDEX `meio_UNIQUE` (`meio` ASC) VISIBLE,
    CONSTRAINT `fk_contribuicao_gatewayPagamento_plataforma`
    FOREIGN KEY (`id_plataforma`)
    REFERENCES `wegia`.`contribuicao_gatewayPagamento` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
) ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `wegia`.`contribuicao_conjuntoRegras`
-- -----------------------------------------------------
CREATE TABLE `wegia`.`contribuicao_conjuntoRegras` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `id_meioPagamento` INT,
    `id_regra` INT,
    `valor` DECIMAL(10, 2),
    `status` BOOLEAN NOT NULL,
    CONSTRAINT `fk_contribuicao_meioPagamento` FOREIGN KEY (`id_meioPagamento`) REFERENCES `wegia`.`contribuicao_meioPagamento`(`id`),
    CONSTRAINT `fk_contribuicao_regras` FOREIGN KEY (`id_regra`) REFERENCES `wegia`.`contribuicao_regras`(`id`),
    CONSTRAINT `unico_meioPagamento_regra` UNIQUE (`id_meioPagamento`, `id_regra`)
) ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `wegia`.`socio_status`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wegia`.`socio_status` (
    `id_sociostatus` INT NOT NULL,
    `status` VARCHAR(255) NOT NULL,
    PRIMARY KEY (`id_sociostatus`))
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `wegia`.`socio_tipo`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wegia`.`socio_tipo` (
    `id_sociotipo` INT NOT NULL,
    `tipo` VARCHAR(255) NOT NULL,
    PRIMARY KEY (`id_sociotipo`))
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `wegia`.`socio_tag`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wegia`.`socio_tag` (
    `id_sociotag` INT NOT NULL AUTO_INCREMENT,
    `tag` VARCHAR(255) NOT NULL,
    UNIQUE INDEX (`tag` ASC),
    PRIMARY KEY (`id_sociotag`))
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `wegia`.`socio`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wegia`.`socio` (
    `id_socio` INT(11) NOT NULL AUTO_INCREMENT,
    `id_pessoa` INT(11) NOT NULL,
    `id_sociostatus` INT NOT NULL,
    `id_sociotipo` INT NOT NULL,
    `id_sociotag` INT NULL DEFAULT NULL,
    `email` VARCHAR(256) NULL DEFAULT NULL,
    `valor_periodo` DECIMAL(10,2) NULL DEFAULT NULL,
    `data_referencia` DATE NULL DEFAULT NULL,
    UNIQUE INDEX (`id_pessoa` ASC),
    PRIMARY KEY (`id_socio`),
    INDEX `fk_socio_socio_status1_idx` (`id_sociostatus` ASC),
    INDEX `fk_socio_pessoa1_idx` (`id_pessoa` ASC),
    INDEX `fk_socio_socio_tipo1_idx` (`id_sociotipo` ASC),
    INDEX `fk_socio_socio_tag1_idx` (`id_sociotag` ASC),
    CONSTRAINT `fk_socio_socio_status1`
    FOREIGN KEY (`id_sociostatus`)
    REFERENCES `wegia`.`socio_status` (`id_sociostatus`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
    CONSTRAINT `fk_socio_pessoa1`
    FOREIGN KEY (`id_pessoa`)
    REFERENCES `wegia`.`pessoa` (`id_pessoa`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
    CONSTRAINT `fk_socio_socio_tipo1`
    FOREIGN KEY (`id_sociotipo`)
    REFERENCES `wegia`.`socio_tipo` (`id_sociotipo`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
    CONSTRAINT `fk_socio_socio_tag1`
    FOREIGN KEY (`id_sociotag`)
    REFERENCES `wegia`.`socio_tag` (`id_sociotag`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `wegia`.`recorrencia`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS wegia.recorrencia (
    id INT NOT NULL AUTO_INCREMENT,
    id_socio INT(11) NOT NULL,
    id_gateway INT(11) NOT NULL,
    codigo VARCHAR(255) NOT NULL UNIQUE,
    valor DECIMAL(10,2) NOT NULL,
    data_inicio DATE NOT NULL,
    data_termino DATE,
    status BOOLEAN DEFAULT TRUE,
    PRIMARY KEY (id),
    CONSTRAINT FK_recorrencia_socios
    FOREIGN KEY (id_socio)
    REFERENCES wegia.socio (id_socio),
    CONSTRAINT FK_recorrencia_gateways
    FOREIGN KEY (id_gateway)
    REFERENCES wegia.contribuicao_gatewayPagamento (id)
)ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `wegia`.`contribuicao_log`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS wegia.contribuicao_log (
    id INT NOT NULL AUTO_INCREMENT,
    id_socio INT(11) NOT NULL,
    id_gateway INT(11) NOT NULL,
    id_meio_pagamento INT(11) NOT NULL,
    id_recorrencia INT(11) DEFAULT NULL,
    codigo VARCHAR(255) NOT NULL UNIQUE,
    valor DECIMAL(10,2) NOT NULL,
    data_geracao DATE NOT NULL,
    data_vencimento DATE NOT NULL,
    data_pagamento DATE,
    status_pagamento BOOLEAN NOT NULL,
    url LONGTEXT DEFAULT NULL,
    PRIMARY KEY (id),
    CONSTRAINT FK_id_socios
    FOREIGN KEY (id_socio)
    REFERENCES wegia.socio (id_socio),
    CONSTRAINT FK_id_gateways
    FOREIGN KEY (id_gateway)
    REFERENCES wegia.contribuicao_gatewayPagamento (id),
    CONSTRAINT FK_id_meio_pagamentos
    FOREIGN KEY (id_meio_pagamento)
    REFERENCES wegia.contribuicao_meioPagamento (id),
    CONSTRAINT FK_id_recorrencia
    FOREIGN KEY (id_recorrencia)
    REFERENCES wegia.recorrencia (id)
)ENGINE = InnoDB;