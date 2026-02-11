-- -----------------------------------------------------
-- Table `wegia`.`situacao`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wegia`.`situacao` (
    `id_situacao` INT(11) NOT NULL AUTO_INCREMENT,
    `situacoes` VARCHAR(30) NULL DEFAULT NULL,
    PRIMARY KEY (`id_situacao`),
    UNIQUE INDEX `situacoes` (`situacoes` ASC))
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `wegia`.`funcionario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wegia`.`funcionario` (
    `id_funcionario` INT(11) NOT NULL AUTO_INCREMENT,
    `id_pessoa` INT(11) NOT NULL,
    `id_perfil` INT(11) NOT NULL,
    `id_situacao` INT(11) NOT NULL,
    `data_admissao` DATE NOT NULL,
    `pis` VARCHAR(140) NULL DEFAULT NULL,
    `ctps` VARCHAR(150) NOT NULL,
    `uf_ctps` VARCHAR(20) NULL DEFAULT NULL,
    `numero_titulo` VARCHAR(150) NULL DEFAULT NULL,
    `zona` VARCHAR(30) NULL DEFAULT NULL,
    `secao` VARCHAR(40) NULL DEFAULT NULL,
    `certificado_reservista_numero` VARCHAR(100) NULL DEFAULT NULL,
    `certificado_reservista_serie` VARCHAR(100) NULL DEFAULT NULL,
    PRIMARY KEY (`id_funcionario`),
    INDEX `id_pessoa` (`id_pessoa` ASC),
    INDEX `fk_funcionario_perfil1_idx` (`id_perfil` ASC),
    INDEX `fk_funcionario_situacao1_idx` (`id_situacao` ASC),
    CONSTRAINT `funcionario_ibfk_1`
    FOREIGN KEY (`id_pessoa`)
    REFERENCES `wegia`.`pessoa` (`id_pessoa`),
    CONSTRAINT `fk_funcionario_perfil1`
    FOREIGN KEY (`id_perfil`)
    REFERENCES `wegia`.`perfil` (`id_perfil`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
    CONSTRAINT `fk_funcionario_situacao1`
    FOREIGN KEY (`id_situacao`)
    REFERENCES `wegia`.`situacao` (`id_situacao`)
    ON DELETE CASCADE
    ON UPDATE CASCADE
    )
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `wegia`.`escala_quadro_horario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wegia`.`escala_quadro_horario` (
    `id_escala` INT(11) NOT NULL AUTO_INCREMENT,
    `descricao` VARCHAR(200) NOT NULL,
    PRIMARY KEY (`id_escala`))
    ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;

-- -----------------------------------------------------
-- Table `wegia`.`tipo_quadro_horario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wegia`.`tipo_quadro_horario` (
    `id_tipo` INT(11) NOT NULL AUTO_INCREMENT,
    `descricao` VARCHAR(200) NOT NULL,
    PRIMARY KEY (`id_tipo`))
    ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;

-- -----------------------------------------------------
-- Table `wegia`.`quadro_horario_funcionario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wegia`.`quadro_horario_funcionario` (
    `id_quadro_horario` INT(11) NOT NULL AUTO_INCREMENT,
    `id_funcionario` INT(11) NOT NULL,
    `escala` INT(11) NOT NULL,
    `tipo` INT(11) NOT NULL,
    `carga_horaria` VARCHAR(200) NULL DEFAULT NULL,
    `entrada1` VARCHAR(200) NULL DEFAULT NULL,
    `saida1` VARCHAR(200) NULL DEFAULT NULL,
    `entrada2` VARCHAR(200) NULL DEFAULT NULL,
    `saida2` VARCHAR(200) NULL DEFAULT NULL,
    `total` VARCHAR(200) NULL DEFAULT NULL,
    `dias_trabalhados` VARCHAR(200) NULL DEFAULT NULL,
    `folga` VARCHAR(200) NULL DEFAULT NULL,
    PRIMARY KEY (`id_quadro_horario`),
    INDEX `id_funcionario` (`id_funcionario` ASC),
    INDEX `quadro_horario_funcionario_ibfk_2` (`escala` ASC),
    INDEX `quadro_horario_funcionario_ibfk_3` (`tipo` ASC),
    CONSTRAINT `quadro_horario_funcionario_ibfk_1`
    FOREIGN KEY (`id_funcionario`)
    REFERENCES `wegia`.`funcionario` (`id_funcionario`),
    CONSTRAINT `quadro_horario_funcionario_ibfk_2`
    FOREIGN KEY (`escala`)
    REFERENCES `wegia`.`escala_quadro_horario` (`id_escala`),
    CONSTRAINT `quadro_horario_funcionario_ibfk_3`
    FOREIGN KEY (`tipo`)
    REFERENCES `wegia`.`tipo_quadro_horario` (`id_tipo`))
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `wegia`.`funcionario_remuneracao_tipo`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wegia`.`funcionario_remuneracao_tipo` (
    `idfuncionario_remuneracao_tipo` INT NOT NULL AUTO_INCREMENT,
    `descricao` VARCHAR(255) NOT NULL,
    PRIMARY KEY (`idfuncionario_remuneracao_tipo`))
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `wegia`.`funcionario_remuneracao`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wegia`.`funcionario_remuneracao` (
    `idfuncionario_remuneracao` INT NOT NULL AUTO_INCREMENT,
    `funcionario_id_funcionario` INT(11) NOT NULL,
    `funcionario_remuneracao_tipo_idfuncionario_remuneracao_tipo` INT NOT NULL,
    `valor` DECIMAL(10,2) NOT NULL,
    `inicio` DATE NULL,
    `fim` DATE NULL,
    PRIMARY KEY (`idfuncionario_remuneracao`),
    INDEX `fk_funcionario_remuneracao_funcionario1_idx` (`funcionario_id_funcionario` ASC),
    INDEX `fk_funcionario_remuneracao_funcionario_remuneracao_tipo1_idx` (`funcionario_remuneracao_tipo_idfuncionario_remuneracao_tipo` ASC),
    CONSTRAINT `fk_funcionario_remuneracao_funcionario1`
    FOREIGN KEY (`funcionario_id_funcionario`)
    REFERENCES `wegia`.`funcionario` (`id_funcionario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
    CONSTRAINT `fk_funcionario_remuneracao_funcionario_remuneracao_tipo1`
    FOREIGN KEY (`funcionario_remuneracao_tipo_idfuncionario_remuneracao_tipo`)
    REFERENCES `wegia`.`funcionario_remuneracao_tipo` (`idfuncionario_remuneracao_tipo`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `wegia`.`funcionario_listainfo`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wegia`.`funcionario_listainfo` (
    `idfuncionario_listainfo` INT NOT NULL AUTO_INCREMENT,
    `descricao` VARCHAR(255) NULL,
    PRIMARY KEY (`idfuncionario_listainfo`))
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `wegia`.`funcionario_outrasinfo`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wegia`.`funcionario_outrasinfo` (
    `idfunncionario_outrasinfo` INT NOT NULL AUTO_INCREMENT,
    `funcionario_id_funcionario` INT(11) NOT NULL,
    `funcionario_listainfo_idfuncionario_listainfo` INT NOT NULL,
    `dado` VARCHAR(255) NOT NULL,
    PRIMARY KEY (`idfunncionario_outrasinfo`),
    INDEX `fk_funncionario_outrasinfo_funcionario1_idx` (`funcionario_id_funcionario` ASC),
    INDEX `fk_funcionario_outrasinfo_funcionario_listainfo1_idx` (`funcionario_listainfo_idfuncionario_listainfo` ASC),
    CONSTRAINT `fk_funncionario_outrasinfo_funcionario1`
    FOREIGN KEY (`funcionario_id_funcionario`)
    REFERENCES `wegia`.`funcionario` (`id_funcionario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
    CONSTRAINT `fk_funcionario_outrasinfo_funcionario_listainfo1`
    FOREIGN KEY (`funcionario_listainfo_idfuncionario_listainfo`)
    REFERENCES `wegia`.`funcionario_listainfo` (`idfuncionario_listainfo`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;