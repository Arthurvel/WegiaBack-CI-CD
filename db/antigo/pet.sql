-- -------------------------------------------------------
-- Table `wegia`.`pet_foto`
-- -------------------------------------------------------
CREATE TABLE IF NOT EXISTS `wegia`.`pet_foto` (
    `id_pet_foto` INT NOT NULL AUTO_INCREMENT,
    `arquivo_foto_pet` VARCHAR(255) NOT NULL,
    `arquivo_foto_pet_nome` varchar(200) NOT NULL,
    `arquivo_foto_pet_extensao` varchar(50) NOT NULL,
    PRIMARY KEY (`id_pet_foto`)
)ENGINE = InnoDB;

-- -------------------------------------------------------
-- Table `wegia`.`pet_especie`
-- -------------------------------------------------------
CREATE TABLE IF NOT EXISTS `wegia`.`pet_especie` (
    `id_pet_especie` INT NOT NULL AUTO_INCREMENT,
    `descricao` VARCHAR(200) NOT NULL,
    PRIMARY KEY (`id_pet_especie`))
ENGINE = InnoDB;

-- --------------------------------------------------------
-- Table `wegia`.`pet_raca`
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `wegia`.`pet_raca` (
    `id_pet_raca` INT NOT NULL AUTO_INCREMENT,
    `descricao` VARCHAR(50) NOT NULL,
    PRIMARY KEY (`id_pet_raca`))
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `wegia`.`pet`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wegia`.`pet` (
    `id_pet` INT(11) NOT NULL AUTO_INCREMENT,
    `nome` VARCHAR(200) NOT NULL,
    `data_nascimento` DATE NOT NULL,
    `data_acolhimento` DATE NOT NULL,
    `sexo` CHAR(1) NOT NULL,
    `caracteristicas_especificas` VARCHAR(250) NULL,
    `id_pet_foto` INT NULL,
    `id_pet_especie` INT NOT NULL,
    `id_pet_raca` INT NOT NULL,
    `cor` ENUM(
        'Preto',
        'Branco',
        'Cinza',
        'Marrom',
        'Caramelo',
        'Amarelo',
        'Bege',
        'Dourado',
        'Ruivo',
        'Creme',
        'Azul',
        'Chocolate',
        'Bicolor',
        'Tricolor'
    )  NOT NULL,
    PRIMARY KEY (`id_pet`),
    CONSTRAINT `fk_pet_especie`
    FOREIGN KEY (`id_pet_especie`)
    REFERENCES `wegia`.`pet_especie` (`id_pet_especie`),
    CONSTRAINT `fk_pet_raca`
    FOREIGN KEY (`id_pet_raca`)
    REFERENCES `wegia`.`pet_raca` (`id_pet_raca`),
    CONSTRAINT `fk_pet_foto`
    FOREIGN KEY (`id_pet_foto`)
    REFERENCES `wegia`.`pet_foto`(`id_pet_foto`)
)ENGINE = InnoDB;

-- ----------------------------------------------------------
-- Table `wegia`.`pet_adocao`
-- ----------------------------------------------------------
CREATE TABLE IF NOT EXISTS `wegia`.`pet_adocao` (
    `id_adocao` INT NOT NULL AUTO_INCREMENT,
    `id_pessoa` INT(11) NOT NULL,
    `id_pet` INT(11) NOT NULL,
    `data_adocao` DATE NOT NULL,
    PRIMARY KEY (`id_adocao`),
    CONSTRAINT `fk_pessoa`
    FOREIGN KEY (`id_pessoa`)
    REFERENCES `wegia`.`pessoa` (`id_pessoa`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
    CONSTRAINT `fk_pet`
    FOREIGN KEY (`id_pet`)
    REFERENCES `wegia`.`pet` (`id_pet`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
)ENGINE = InnoDB;

-- -------------------------------------------------------------
-- Table `wegia`.`pet_ficha_medica`
-- -------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `wegia`.`pet_ficha_medica` (
    `id_ficha_medica` INT NOT NULL AUTO_INCREMENT,
    `id_pet` INT(11) NOT NULL,
    `castrado` CHAR(1) NOT NULL,
    `necessidades_especiais` VARCHAR(255) NULL,
    PRIMARY KEY (`id_ficha_medica`),
    CONSTRAINT `fk_id_pet`
    FOREIGN KEY (`id_pet`)
    REFERENCES `wegia`.`pet`(`id_pet`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
)ENGINE = InnoDB;

-- ----------------------------------------------------------------
-- Table `wegia`.`pet_tipo_exame`
-- ----------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `wegia`.`pet_tipo_exame`(
    `id_tipo_exame` INT NOT NULL AUTO_INCREMENT,
    `descricao_exame` VARCHAR(255) NOT NULL,
    PRIMARY KEY (`id_tipo_exame`)
)ENGINE = InnoDB;

-- ---------------------------------------------------------------
-- Table  `wegia`.`pet_exame`
-- ---------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `wegia`.`pet_exame` (
    `id_exame` INT NOT NULL AUTO_INCREMENT,
    `id_ficha_medica` INT NOT NULL,
    `id_tipo_exame` INT NOT NULL,
    `data_exame` DATE NOT NULL,
    `arquivo_exame` LONGBLOB NOT NULL,
    `arquivo_nome` VARCHAR(200) NOT NULL,
    `arquivo_extensao` VARCHAR(50) NOT NULL,
    PRIMARY KEY (`id_exame`),
    CONSTRAINT `fk_pet_ficha_medica`
    FOREIGN KEY (`id_ficha_medica`)
    REFERENCES `wegia`.`pet_ficha_medica` (`id_ficha_medica`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
    CONSTRAINT `fk_pet_tipo_exame`
    FOREIGN KEY (`id_tipo_exame`)
    REFERENCES `wegia`.`pet_tipo_exame` (`id_tipo_exame`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
)ENGINE = InnoDB;

-- -------------------------------------------------------------------
-- Table `wegia`.`pet_atendimento`
-- -------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `wegia`.`pet_atendimento`(
    `id_pet_atendimento` INT NOT NULL AUTO_INCREMENT,
    `id_ficha_medica` INT NOT NULL,
    `data_atendimento` DATE NOT NULL,
    `descricao` TEXT NOT NULL,
    PRIMARY KEY (`id_pet_atendimento`),
    CONSTRAINT `fk_ficha_pet_medica`
    FOREIGN KEY (`id_ficha_medica`)
    REFERENCES `wegia`.`pet_ficha_medica` (`id_ficha_medica`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

-- ----------------------------------------------------------------------
-- Table `wegia`.`pet_medicamento`
-- ----------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `wegia`.`pet_medicamento`(
    `id_medicamento` INT NOT NULL AUTO_INCREMENT,
    `nome_medicamento` VARCHAR(200) NOT NULL,
    `descricao_medicamento` VARCHAR(200) NOT NULL,
    `aplicacao` VARCHAR(250) NOT NULL,
    PRIMARY KEY (`id_medicamento`))
ENGINE = InnoDB;


-- --------------------------------------------------------------------
-- Table `wegia`.`pet_medicacao`
-- --------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `wegia`.`pet_medicacao` (
    `id_medicacao` INT NOT NULL AUTO_INCREMENT,
    `id_medicamento` INT NOT NULL,
    `id_pet_atendimento` INT NOT NULL,
    `data_medicacao` DATE NULL,
    PRIMARY KEY (`id_medicacao`),
    CONSTRAINT `fk_pet_medicamento`
    FOREIGN KEY (`id_medicamento`)
    REFERENCES `wegia`.`pet_medicamento` (`id_medicamento`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
    CONSTRAINT `fk_pet_atendimento`
    FOREIGN KEY (`id_pet_atendimento`)
    REFERENCES  `wegia`.`pet_atendimento` (`id_pet_atendimento`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
)ENGINE = InnoDB;