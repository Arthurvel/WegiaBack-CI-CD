-- -----------------------------------------------------
-- Table `wegia`.`permissao`
-- -----------------------------------------------------

CREATE TABLE permissao (
    id_permissao INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    categoria ENUM(
        'Pessoa',
        'Pet',
        'Material',
        'Memorando',
        'Socios',
        'Saude',
        'Contribuição',
        'Configuração'
    ) NOT NULL
);

-- -----------------------------------------------------
-- Table `wegia`.`perfil`
-- -----------------------------------------------------
CREATE TABLE perfil (
    id_perfil INT AUTO_INCREMENT PRIMARY KEY,
    cargo VARCHAR(100) NOT NULL,
    nome VARCHAR(100) NOT NULL
);

-- -----------------------------------------------------
-- Table `wegia`.`perfil_permissao`
-- -----------------------------------------------------
CREATE TABLE perfil_permissao (
    id_perfil INT NOT NULL,
    id_permissao INT NOT NULL,
    PRIMARY KEY (id_perfil, id_permissao),
    CONSTRAINT fk_perfil FOREIGN KEY (id_perfil) REFERENCES perfil(id_perfil) ON DELETE CASCADE,
    CONSTRAINT fk_permissao FOREIGN KEY (id_permissao) REFERENCES permissao(id_permissao) ON DELETE CASCADE
);