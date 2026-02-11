-- -----------------------------------------------------
-- Table `wegia`.`memorando`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wegia`.`memorando` (
    `id_memorando` INT(11) NOT NULL AUTO_INCREMENT,
    `id_pessoa` INT(11) NOT NULL,
    `status_memorando` ENUM('Ativo', 'Lido', 'Não Lido', 'Importante', 'Pendente', 'Arquivado') NOT NULL DEFAULT 'Pendente',
    `titulo` TEXT NULL DEFAULT NULL,
    `data` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id_memorando`),
    INDEX `id_pessoa` (`id_pessoa` ASC),
    CONSTRAINT `memorando_ibfk_1`
    FOREIGN KEY (`id_pessoa`)
    REFERENCES `wegia`.`pessoa` (`id_pessoa`)
) ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `wegia`.`despacho`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wegia`.`despacho` (
    `id_despacho` INT(11) NOT NULL AUTO_INCREMENT,
    `id_memorando` INT(11) NOT NULL,
    `id_remetente` INT(11) NOT NULL,
    `id_destinatario` INT(11) NOT NULL,
    `texto` LONGTEXT NULL DEFAULT NULL,
    `data` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id_despacho`),
    INDEX `id_memorando` (`id_memorando` ASC),
    INDEX `id_remetente` (`id_remetente` ASC),
    INDEX `id_destinatario` (`id_destinatario` ASC),
    CONSTRAINT `despacho_ibfk_1`
    FOREIGN KEY (`id_memorando`)
    REFERENCES `wegia`.`memorando` (`id_memorando`),
    CONSTRAINT `despacho_ibfk_2`
    FOREIGN KEY (`id_remetente`)
    REFERENCES `wegia`.`pessoa` (`id_pessoa`),
    CONSTRAINT `despacho_ibfk_3`
    FOREIGN KEY (`id_destinatario`)
    REFERENCES `wegia`.`pessoa` (`id_pessoa`))
ENGINE = InnoDB


-- -----------------------------------------------------
-- Table `wegia`.`anexo`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wegia`.`anexo` (
    `id_anexo` INT(11) NOT NULL AUTO_INCREMENT,
    `id_despacho` INT(11) NOT NULL,
    `anexo` VARCHAR(100) NOT NULL,
    `extensao` VARCHAR(256) NOT NULL,
    `nome` VARCHAR(256) NOT NULL,
    PRIMARY KEY (`id_anexo`),
    INDEX `id_despacho` (`id_despacho` ASC),
    CONSTRAINT `anexo_ibfk_1`
    FOREIGN KEY (`id_despacho`)
    REFERENCES `wegia`.`despacho` (`id_despacho`))
ENGINE = InnoDB;

-- -----------------------------------------------------
-- View para consultar o utlimo despacho por memorando
-- -----------------------------------------------------

CREATE OR REPLACE VIEW view_ultimo_despacho_por_memorando AS
SELECT d.*, m.titulo, m.status_memorando, m.id_pessoa as criado_por, p.nome as origem
FROM despacho d
         JOIN (
    SELECT id_memorando, MAX(data) AS max_data
    FROM despacho
    GROUP BY id_memorando
) latest ON d.id_memorando = latest.id_memorando AND d.data = latest.max_data
         JOIN memorando m ON m.id_memorando = d.id_memorando
         JOIN pessoa p ON p.id_pessoa = d.id_remetente;

CREATE TRIGGER `wegia`.`tr_despacho_aviso`
    AFTER INSERT ON `wegia`.`despacho`
    FOR EACH ROW
BEGIN
    DECLARE memorando_titulo TEXT;

    SELECT titulo INTO memorando_titulo
    FROM memorando
    WHERE id_memorando = NEW.id_memorando;

    INSERT INTO aviso (
        id_pessoa,
        titulo,
        descricao,
        url,
        nivel,
        ativo
    ) VALUES (
                 NEW.id_destinatario,
                 memorando_titulo,
                 CONCAT('Você recebeu um novo despacho do memorando: "', memorando_titulo, '"'),
                 CONCAT('/memorando/',  NEW.id_memorando),
                 'info',
                 1
             );