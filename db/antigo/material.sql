-- -----------------------------------------------------
-- Table `wegia`.`material_parceiro`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wegia`.`material_parceiro` (
    id_parceiro INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    cpf VARCHAR(14),
    cnpj VARCHAR(18),
    telefone VARCHAR(20)
)ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `wegia`.`material_tipo_movimentacao`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wegia`.`material_tipo_movimentacao` (
    id_tipo_movimentacao INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    tipo ENUM('e', 's') NOT NULL
)ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `wegia`.`material_categoria`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wegia`.`material_categoria` (
    `id_categoria` INT(11) NOT NULL AUTO_INCREMENT,
    `descricao` VARCHAR(100) NOT NULL,
    PRIMARY KEY (`id_categoria`),
    UNIQUE INDEX `descricao` (`descricao` ASC))
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `wegia`.`material_unidade`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wegia`.`material_unidade` (
    `id_unidade` INT(11) NOT NULL AUTO_INCREMENT,
    `descricao` VARCHAR(100) NOT NULL,
    PRIMARY KEY (`id_unidade`),
    UNIQUE INDEX `descricao` (`descricao` ASC))
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `wegia`.`material_produto`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wegia`.`material_produto` (
    `id_produto` INT(11) NOT NULL AUTO_INCREMENT,
    `id_categoria` INT(11) NOT NULL,
    `id_unidade` INT(11) NOT NULL,
    `descricao` VARCHAR(150) NOT NULL,
    `codigo` VARCHAR(15) NULL DEFAULT NULL,
    `oculto` TINYINT NULL DEFAULT false,
    PRIMARY KEY (`id_produto`),
    UNIQUE INDEX `descricao` (`descricao` ASC),
    UNIQUE INDEX `codigo_UNIQUE` (`codigo` ASC),
    INDEX `id_categoria` (`id_categoria` ASC),
    INDEX `id_unidade` (`id_unidade` ASC),
    CONSTRAINT `material_produto_ibfk_1`
    FOREIGN KEY (`id_categoria`)
    REFERENCES `wegia`.`material_categoria` (`id_categoria`),
    CONSTRAINT `material_produto_ibfk_2`
    FOREIGN KEY (`id_unidade`)
    REFERENCES `wegia`.`material_unidade` (`id_unidade`)
) ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `wegia`.`material_almoxarifado`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wegia`.`material_almoxarifado` (
                                                               `id_almoxarifado` INT(11) NOT NULL AUTO_INCREMENT,
    `descricao` VARCHAR(240) NOT NULL,
    PRIMARY KEY (`id_almoxarifado`))
    ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `wegia`.`material_transacao`
-- -----------------------------------------------------
CREATE TABLE material_transacao (
    id_transacao INT AUTO_INCREMENT PRIMARY KEY,
    id_tipo_movimentacao INT NOT NULL,
    id_almoxarifado INT NOT NULL,
    id_responsavel INT NOT NULL,
    id_parceiro INT NOT NULL,
    data DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_tipo_movimentacao) REFERENCES material_tipo_movimentacao(id_tipo_movimentacao),
    FOREIGN KEY (id_almoxarifado) REFERENCES material_almoxarifado(id_almoxarifado),
    FOREIGN KEY (id_parceiro) REFERENCES material_parceiro(id_parceiro),
    FOREIGN KEY (id_responsavel) REFERENCES pessoa(id_pessoa)
);

-- -----------------------------------------------------
-- Table `wegia`.`material_transacao_produto`
-- -----------------------------------------------------
CREATE TABLE material_transacao_produto (
    id_transacao_produto INT AUTO_INCREMENT PRIMARY KEY,
    id_transacao INT NOT NULL,
    id_produto INT NOT NULL,
    quantidade INT NOT NULL,
    valor_unitario DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (id_transacao) REFERENCES material_transacao(id_transacao) ON DELETE CASCADE,
    FOREIGN KEY (id_produto) REFERENCES material_produto(id_produto)
);

-- -----------------------------------------------------
-- Table `wegia`.`material_transacao_produto_logs`
-- -----------------------------------------------------
CREATE TABLE material_transacao_produto_logs (
     id_transacao_produto_log INT AUTO_INCREMENT PRIMARY KEY,
     id_transacao_produto INT NOT NULL,
     id_transacao INT NOT NULL,
     id_produto INT NOT NULL,
     quantidade INT NOT NULL,
     valor_unitario DECIMAL(10,2) NOT NULL,
     id_usuario_acao INT NOT NULL,
     acao ENUM('create', 'update', 'delete') NOT NULL,
     data_acao DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- -----------------------------------------------------
-- View `wegia`.`view_material_relatorio`
-- -----------------------------------------------------
CREATE OR REPLACE VIEW view_material_relatorio AS
SELECT
    t.id_transacao,
    tm.id_tipo_movimentacao,
    t.id_responsavel,
    a.id_almoxarifado,
    p.id_produto,
    t.id_parceiro,
    t.data,
    tm.nome AS tipo_movimentacao,
    tm.tipo AS tipo,
    a.descricao AS almoxarifado,
    pa.nome AS parceiro,
    r.nome AS responsavel,
    p.descricao AS produto,
    u.descricao AS unidade,
    tp.quantidade,
    tp.valor_unitario,
    (tp.quantidade * tp.valor_unitario) AS total
FROM material_transacao t
         JOIN material_transacao_produto tp ON tp.id_transacao = t.id_transacao
         JOIN material_produto p ON p.id_produto = tp.id_produto
         JOIN material_unidade u ON u.id_unidade = p.id_unidade
         JOIN material_almoxarifado a ON a.id_almoxarifado = t.id_almoxarifado
         JOIN material_parceiro pa ON pa.id_parceiro = t.id_parceiro
         JOIN pessoa r ON r.id_pessoa = t.id_responsavel
         JOIN material_tipo_movimentacao tm ON tm.id_tipo_movimentacao = t.id_tipo_movimentacao;

-- -----------------------------------------------------
-- View `wegia`.`view_estoque_atual`
-- -----------------------------------------------------
CREATE OR REPLACE VIEW view_estoque_atual AS
SELECT
    tp.id_produto,
    mp.descricao AS nome_produto,
    t.id_almoxarifado,
    SUM(
            CASE
                WHEN tm.tipo = 'e' THEN tp.quantidade
                WHEN tm.tipo = 's' THEN -tp.quantidade
                ELSE 0
                END
    ) AS estoque
FROM material_transacao_produto tp
         JOIN material_transacao t ON tp.id_transacao = t.id_transacao
         JOIN material_tipo_movimentacao tm ON t.id_tipo_movimentacao = tm.id_tipo_movimentacao
         JOIN material_produto mp ON tp.id_produto = mp.id_produto
GROUP BY tp.id_produto, mp.descricao, t.id_almoxarifado;


CREATE TRIGGER `wegia`.`tr_material_transacao_produto_insert`
    AFTER INSERT ON material_transacao_produto
    FOR EACH ROW
BEGIN
    DECLARE v_responsavel INT;

    SELECT id_responsavel
    INTO v_responsavel
    FROM material_transacao
    WHERE id_transacao = NEW.id_transacao
        LIMIT 1;

    INSERT INTO material_transacao_produto_logs (
        id_transacao_produto,
        id_transacao,
        id_produto,
        quantidade,
        valor_unitario,
        id_usuario_acao,
        acao,
        data_acao
    ) VALUES (
                 NEW.id_transacao_produto,
                 NEW.id_transacao,
                 NEW.id_produto,
                 NEW.quantidade,
                 NEW.valor_unitario,
                 v_responsavel,
                 'create',
                 NOW()
             );