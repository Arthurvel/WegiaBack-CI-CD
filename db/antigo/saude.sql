-- -----------------------------------------------------
-- Table `wegia`.`saude_fichamedica`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wegia`.`saude_fichamedica` (
    `id_fichamedica` INT NOT NULL AUTO_INCREMENT,
    `id_pessoa` INT NOT NULL,
    `prontuario` TEXT NOT NULL,
    PRIMARY KEY (`id_fichamedica`),
    INDEX `fk_saude_fichamedica_pessoa_idx` (`id_pessoa` ASC),
    CONSTRAINT `fk_saude_fichamedica_pessoa`
    FOREIGN KEY (`id_pessoa`)
    REFERENCES `wegia`.`pessoa` (`id_pessoa`)
    ON DELETE CASCADE
    ON UPDATE CASCADE
) ENGINE=InnoDB;

-- -----------------------------------------------------
-- Table `wegia`.`saude_fichamedica_prontuario_historico`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wegia`.`saude_fichamedica_prontuario_historico` (
    `id_prontuario_historico` INT NOT NULL AUTO_INCREMENT,
    `id_fichamedica` INT NOT NULL,
    `prontuario` TEXT NOT NULL,
    `data` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id_prontuario_historico`),
    INDEX `fk_saude_fichamedica_prontuario_historico_fichamedica_idx` (`id_fichamedica` ASC),
    CONSTRAINT `fk_saude_fichamedica_prontuario_historico_fichamedica`
    FOREIGN KEY (`id_fichamedica`)
    REFERENCES `wegia`.`saude_fichamedica` (`id_fichamedica`)
    ON DELETE CASCADE
    ON UPDATE CASCADE
) ENGINE=InnoDB;

-- -----------------------------------------------------
-- Table `wegia`.`saude_alergia`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS saude_alergia (
    id_alergia INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(150) NOT NULL
) ENGINE=InnoDB;

-- -----------------------------------------------------
-- Table `wegia`.`saude_fichamedica_alergia`
-- -----------------------------------------------------

CREATE TABLE IF NOT EXISTS saude_fichamedica_alergia (
    id_fichamedica_alergia INT AUTO_INCREMENT PRIMARY KEY,
    id_fichamedica INT NOT NULL,
    id_alergia INT NOT NULL,
    UNIQUE KEY uk_fichamedica_alergia (id_fichamedica, id_alergia),
    CONSTRAINT fk_fichamedica_alergia FOREIGN KEY (id_fichamedica) REFERENCES saude_fichamedica(id_fichamedica) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_alergia FOREIGN KEY (id_alergia) REFERENCES saude_alergia(id_alergia) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

-- -----------------------------------------------------
-- Table `wegia`.`saude_tabelacid`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wegia`.`saude_tabelacid` (
    `id_CID` INT NOT NULL AUTO_INCREMENT,
    `CID` VARCHAR(10) NOT NULL,
    `descricao` VARCHAR(255) NOT NULL,
    PRIMARY KEY (`id_CID`),
    UNIQUE INDEX `CID_UNIQUE` (`CID` ASC))
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `wegia`.`saude_enfermidades`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wegia`.`saude_enfermidades` (
    `id_enfermidade` INT NOT NULL AUTO_INCREMENT,
    `id_fichamedica` INT NOT NULL,
    `id_CID` INT NOT NULL,
    `data_diagnostico` DATE NULL,
    `status` TINYINT NULL,
    PRIMARY KEY (`id_enfermidade`),
    INDEX `fk_daude_enfermidades_saude_fichamedica1_idx` (`id_fichamedica` ASC),
    INDEX `fk_saude_enfermidades_saude_CID1_idx` (`id_CID` ASC),
    CONSTRAINT `fk_daude_enfermidades_saude_fichamedica1`
    FOREIGN KEY (`id_fichamedica`)
    REFERENCES `wegia`.`saude_fichamedica` (`id_fichamedica`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
    CONSTRAINT `fk_saude_enfermidades_saude_CID1`
    FOREIGN KEY (`id_CID`)
    REFERENCES `wegia`.`saude_tabelacid` (`id_CID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `wegia`.`saude_exame_tipos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wegia`.`saude_exame_tipos` (
    `id_exame_tipo` INT NOT NULL AUTO_INCREMENT,
    `descricao` VARCHAR(255) NOT NULL,
    PRIMARY KEY (`id_exame_tipo`))
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `wegia`.`saude_exames`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wegia`.`saude_exames` (
    `id_exame` INT NOT NULL AUTO_INCREMENT,
    `id_fichamedica` INT NOT NULL,
    `id_exame_tipo` INT NOT NULL,
    `data` TIMESTAMP NOT NULL,
    `arquivo_nome` VARCHAR(255) NOT NULL,
    `arquivo_extensao` VARCHAR(10) NULL,
    `arquivo` VARCHAR(100) NOT NULL,
    PRIMARY KEY (`id_exame`),
    INDEX `fk_saude_exames_saude_fichamedica1_idx` (`id_fichamedica` ASC),
    INDEX `fk_saude_exames_saude_exame_tipos1_idx` (`id_exame_tipo` ASC),
    CONSTRAINT `fk_saude_exames_saude_fichamedica1`
    FOREIGN KEY (`id_fichamedica`)
    REFERENCES `wegia`.`saude_fichamedica` (`id_fichamedica`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
    CONSTRAINT `fk_saude_exames_saude_exame_tipos1`
    FOREIGN KEY (`id_exame_tipo`)
    REFERENCES `wegia`.`saude_exame_tipos` (`id_exame_tipo`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `wegia`.`saude_medicos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wegia`.`saude_medicos` (
    `id_medico` INT NOT NULL AUTO_INCREMENT,
    `crm` CHAR(10) NULL,
    `nome` VARCHAR(50) NULL,
    PRIMARY KEY (`id_medico`),
    CONSTRAINT `uq_nome_crm` UNIQUE (`crm`, `nome`))
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `wegia`.`saude_atendimento`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wegia`.`saude_atendimento` (
    `id_atendimento` INT NOT NULL AUTO_INCREMENT,
    `id_fichamedica` INT NOT NULL,
    `id_funcionario` INT(11) NOT NULL,
    `id_medico` INT NOT NULL,
    `data_registro` DATE NULL  DEFAULT CURRENT_TIMESTAMP,
    `data_atendimento` DATE NULL,
    `descricao` TEXT NULL,
    PRIMARY KEY (`id_atendimento`),
    INDEX `fk_saude_atendimento_saude_fichamedica1_idx` (`id_fichamedica` ASC),
    INDEX `fk_saude_atendimento_funcionario1_idx` (`id_funcionario` ASC),
    INDEX `fk_saude_atendimento_medico1_idx` (`id_medico` ASC),
    CONSTRAINT `fk_saude_atendimento_saude_fichamedica1`
    FOREIGN KEY (`id_fichamedica`)
    REFERENCES `wegia`.`saude_fichamedica` (`id_fichamedica`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
    CONSTRAINT `fk_saude_atendimento_medico1`
    FOREIGN KEY (`id_medico`)
    REFERENCES `wegia`.`saude_medicos` (`id_medico`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
    CONSTRAINT `fk_saude_atendimento_funcionario1`
    FOREIGN KEY (`id_funcionario`)
    REFERENCES `wegia`.`funcionario` (`id_funcionario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `wegia`.`saude_medicacao`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wegia`.`saude_medicacao` (
    `id_medicacao` INT NOT NULL AUTO_INCREMENT,
    `id_atendimento` INT NOT NULL,
    `medicamento` VARCHAR(255) NOT NULL,
    `dosagem` VARCHAR(100) NULL,
    `horario` VARCHAR(100) NULL,
    `duracao` VARCHAR(100) NULL,
    `status` ENUM('Tratamento', 'Concluido', 'Substituido', 'Cancelado') NOT NULL DEFAULT 'Tratamento',
    PRIMARY KEY (`id_medicacao`),
    INDEX `fk_saude_medicacao_saude_atendimento1_idx` (`id_atendimento` ASC),
    CONSTRAINT `fk_saude_medicacao_saude_atendimento1`
    FOREIGN KEY (`id_atendimento`)
    REFERENCES `wegia`.`saude_atendimento` (`id_atendimento`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
    )
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `wegia`.`saude_medicamento_administracao`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wegia`.`saude_medicamento_administracao` (
    `idsaude_medicamento_administracao` INT NOT NULL AUTO_INCREMENT,
    `registro` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `aplicacao` DATETIME NOT NULL,
    `saude_medicacao_id_medicacao` INT NOT NULL,
    `funcionario_id_funcionario` INT(11) NOT NULL,
    PRIMARY KEY (`idsaude_medicamento_administracao`),
    INDEX `fk_saude_medicamento_administracao_saude_medicacao1_idx` (`saude_medicacao_id_medicacao` ASC),
    INDEX `fk_saude_medicamento_administracao_funcionario1_idx` (`funcionario_id_funcionario` ASC),
    CONSTRAINT `fk_saude_medicamento_administracao_saude_medicacao1`
    FOREIGN KEY (`saude_medicacao_id_medicacao`)
    REFERENCES `wegia`.`saude_medicacao` (`id_medicacao`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
    CONSTRAINT `fk_saude_medicamento_administracao_funcionario1`
    FOREIGN KEY (`funcionario_id_funcionario`)
    REFERENCES `wegia`.`funcionario` (`id_funcionario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `wegia`.`saude_sinais_vitais
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wegia`.`saude_sinais_vitais` (
    `id_sinais_vitais` INT NOT NULL AUTO_INCREMENT,
    `id_fichamedica` INT NOT NULL,
    `id_funcionario` INT(11) NOT NULL,
    `data` TIMESTAMP NOT NULL,
    `saturacao` DECIMAL(5,2) NULL DEFAULT NULL,
    `pressao_arterial` VARCHAR(10) NULL DEFAULT NULL,
    `frequencia_cardiaca` INT(5) NULL DEFAULT NULL,
    `frequencia_respiratoria` INT(5) NULL DEFAULT NULL,
    `temperatura` DECIMAL(7,2) NULL DEFAULT NULL,
    `hgt` DECIMAL(7,2) NULL DEFAULT NULL,
    PRIMARY KEY (`id_sinais_vitais`),
    INDEX `fk_saude_sinais_vitais_saude_fichamedica1_idx` (`id_fichamedica` ASC),
    INDEX `fk_saude_sinais_vitais_funcionario1_idx` (`id_funcionario` ASC),
    CONSTRAINT `fk_saude_sinais_vitais_saude_fichamedica1`
    FOREIGN KEY (`id_fichamedica`)
    REFERENCES `wegia`.`saude_fichamedica` (`id_fichamedica`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
    CONSTRAINT `fk_saude_sinais_vitais_funcionario1`
    FOREIGN KEY (`id_funcionario`)
    REFERENCES `wegia`.`funcionario` (`id_funcionario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `wegia`.`saude_intercorrencia
-- -----------------------------------------------------
CREATE TABLE saude_intercorrencia (
    id_intercorrencia INT AUTO_INCREMENT PRIMARY KEY,
    data DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    descricao TEXT NOT NULL,
    id_funcionario INT NOT NULL,
    id_fichamedica INT NOT NULL,
    CONSTRAINT fk_intercorrencia_funcionario
    FOREIGN KEY (id_funcionario) REFERENCES funcionario(id_funcionario)
    ON UPDATE CASCADE ON DELETE RESTRICT,
    CONSTRAINT fk_intercorrencia_fichamedica
    FOREIGN KEY (id_fichamedica) REFERENCES saude_fichamedica(id_fichamedica)
    ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE = InnoDB;


CREATE TRIGGER `wegia`.`trg_intercorrencia_aviso`
    AFTER INSERT ON saude_intercorrencia
    FOR EACH ROW
BEGIN
    INSERT INTO aviso (id_pessoa, titulo, descricao, url, nivel)
    SELECT
        p.id_pessoa,
        CONCAT('Nova intercorrência registrada para o paciente ', pes.nome, ' ', IFNULL(pes.sobrenome, '')) AS titulo,
        NEW.descricao,
        CONCAT('/saude/ficha-medica/', NEW.id_fichamedica) AS url,
        'info'
    FROM pessoa p
             JOIN funcionario f ON p.id_pessoa = f.id_pessoa
             JOIN perfil pf ON f.id_perfil = pf.id_perfil
             JOIN perfil_permissao pp ON pf.id_perfil = pp.id_perfil
             JOIN permissao prm ON pp.id_permissao = prm.id_permissao
             JOIN saude_fichamedica sfm ON sfm.id_fichamedica = NEW.id_fichamedica
             JOIN pessoa pes ON pes.id_pessoa = sfm.id_pessoa
    WHERE prm.nome = 'Visualizar Saúde Intercorrência'
      AND f.id_funcionario <> NEW.id_funcionario;
    END$$
