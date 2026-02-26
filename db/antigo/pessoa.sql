-- -----------------------------------------------------
-- Table `wegia`.`pessoa`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wegia`.`pessoa` (
    `id_pessoa` INT(11) NOT NULL AUTO_INCREMENT,
    `cpf` VARCHAR(120) NULL,
    `senha` VARCHAR(70) NULL DEFAULT NULL,
    `nome` VARCHAR(100) NULL DEFAULT NULL,
    `sobrenome` VARCHAR(100) NULL DEFAULT NULL,
    `sexo` CHAR(1) NULL DEFAULT NULL,
    `telefone` VARCHAR(25) NULL DEFAULT NULL,
    `data_nascimento` DATE NULL DEFAULT NULL,
    `imagem` LONGTEXT NULL DEFAULT NULL,
    `cep` VARCHAR(10) NULL DEFAULT NULL,
    `estado` VARCHAR(5) NULL DEFAULT NULL,
    `cidade` VARCHAR(40) NULL DEFAULT NULL,
    `bairro` VARCHAR(40) NULL DEFAULT NULL,
    `logradouro` VARCHAR(100) NULL DEFAULT NULL,
    `numero_endereco` VARCHAR(80) NULL DEFAULT NULL,
    `complemento` VARCHAR(50) NULL DEFAULT NULL,
    `ibge` VARCHAR(20) NULL DEFAULT NULL,
    `registro_geral` VARCHAR(120) NULL DEFAULT NULL,
    `orgao_emissor` VARCHAR(120) NULL DEFAULT NULL,
    `data_expedicao` DATE NULL DEFAULT NULL,
    `nome_mae` VARCHAR(100) NULL DEFAULT NULL,
    `nome_pai` VARCHAR(100) NULL DEFAULT NULL,
    `tipo_sanguineo` VARCHAR(5) NULL DEFAULT NULL,
    `nivel_acesso` TINYINT(4) NULL DEFAULT '0',
    `adm_configurado` TINYINT(4) NULL DEFAULT '0',
    UNIQUE INDEX (`cpf` ASC),
    PRIMARY KEY (`id_pessoa`))
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `wegia`.`pessoa_tipo_arquivo`
-- -----------------------------------------------------

CREATE TABLE pessoa_tipo_arquivo (
    id_pessoa_tipo_arquivo INT AUTO_INCREMENT PRIMARY KEY,
    descricao VARCHAR(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -----------------------------------------------------
-- Table `wegia`.`pessoa_arquivo`
-- -----------------------------------------------------

CREATE TABLE pessoa_arquivo (
    id_pessoa_arquivo INT AUTO_INCREMENT PRIMARY KEY,
    id_pessoa INT NOT NULL,
    id_pessoa_tipo_arquivo INT NOT NULL,
    data DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    extensao_arquivo VARCHAR(10) NOT NULL,
    nome_arquivo VARCHAR(255) NOT NULL,
    arquivo LONGBLOB NOT NULL,
    CONSTRAINT fk_pessoa_arquivo_pessoa FOREIGN KEY (id_pessoa)
        REFERENCES pessoa (id_pessoa)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    CONSTRAINT fk_pessoa_arquivo_tipo FOREIGN KEY (id_pessoa_tipo_arquivo)
        REFERENCES pessoa_tipo_arquivo (id_pessoa_tipo_arquivo)
        ON DELETE RESTRICT
        ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -----------------------------------------------------
-- Table `wegia`.`pessoa_dependente`
-- -----------------------------------------------------

CREATE TABLE IF NOT EXISTS `wegia`.`pessoa_dependente` (
    id_dependente INT AUTO_INCREMENT PRIMARY KEY,
    id_pessoa INT NOT NULL,
    id_dependente_pessoa INT NOT NULL,
    parentesco ENUM(
        'Companheiro(a)',
        'Cônjuge',
        'Enteado(a)',
        'Ex-cônjuge',
        'Filho(a)',
        'Irmão(ã)',
        'Neto(a)',
        'Pais',
        'Outra relação de dependência'
    ) NOT NULL,
    CONSTRAINT fk_dependente_pessoa
    FOREIGN KEY (id_pessoa) REFERENCES pessoa(id_pessoa),
    CONSTRAINT fk_dependente_pessoa_dependente
    FOREIGN KEY (id_dependente_pessoa) REFERENCES pessoa(id_pessoa)
);
