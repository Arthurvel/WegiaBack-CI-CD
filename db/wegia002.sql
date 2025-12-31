use wegia;

INSERT INTO `pessoa` (`id_pessoa`, `cpf`, `senha`, `nome`) VALUES (NULL, 'admin', '9dcc9cbd309bfe63101c96687fb79ca847e9f238ce965f82eb44e8daf825cdbb', 'admin');

INSERT INTO `perfil`(`id_perfil`, `cargo`, `nome`) VALUES (1,'Administrador', 'Administrador');
INSERT INTO `perfil`(`id_perfil`, `cargo`, `nome`) VALUES (2,'Sem cargo definido', 'Sem cargo definido');

INSERT INTO `permissao` VALUES
    ('Criar Pessoa','Pessoa'),
    ('Visualizar Pessoa','Pessoa'),
    ('Atualizar Pessoa','Pessoa'),
    ('Deletar Pessoa','Pessoa'),
    ('Criar Material e Patrimônio','Material'),
    ('Visualizar Material e Patrimônio','Material'),
    ('Atualizar Material e Patrimônio','Material'),
    ('Deletar Material e Patrimônio','Material'),
    ('Criar Memorando','Memorando'),
    ('Visualizar Memorando','Memorando'),
    ('Criar Despacho','Memorando'),
    ('Visualizar Despacho','Memorando'),
    ('Criar Sócio','Socios'),
    ('Visualizar Sócio','Socios'),
    ('Atualizar Sócio','Socios'),
    ('Deletar Sócio','Socios'),
    ('Criar Saúde','Saude'),
    ('Visualizar Saúde','Saude'),
    ('Atualizar Saúde','Saude'),
    ('Deletar Saúde','Saude'),
    ('Criar Pet','Pet'),
    ('Visualizar Pet','Pet'),
    ('Atualizar Pet','Pet'),
    ('Deletar Pet','Pet'),
    ('Visualizar Funcionário','Pessoa'),
    ('Atualizar Funcionário','Pessoa'),
    ('Deletar Funcionário','Pessoa'),
    ('Criar Atendido','Pessoa'),
    ('Visualizar Atendido','Pessoa'),
    ('Atualizar Atendido','Pessoa'),
    ('Deletar Atendido','Pessoa'),
    ('Cadastrar Pet','Pet'),
    ('Visualizar Saúde Pet','Saude'),
    ('Atualizar Saúde Pet','Saude'),
    ('Deletar Saúde Pet','Saude'),
    ('Visualizar Informações Pet','Pet'),
    ('Atualizar Informações Pet','Pet'),
    ('Visualizar Adotantes Pet','Pet'),
    ('Criar Raça','Pet'),
    ('Visualizar Raça','Pet'),
    ('Visualizar Especie','Pet'),
    ('Criar Especie','Pet'),
    ('Criar Ficha Medica','Pet'),
    ('Atualizar Ficha Medica','Pet'),
    ('Criar Medicamento','Pet'),
    ('Atualizar Medicamento','Pet'),
    ('Visualizar Medicamento','Pet'),
    ('Criar Atendimento','Pet'),
    ('Visualizar Atendimento','Pet'),
    ('Criar Adoção','Pet'),
    ('Atualizar Adoção','Pet'),
    ('Atualizar senha de outras pessoas','Pessoa'),
    ('Visualizar Dependente','Pessoa'),
    ('Deletar Dependente','Pessoa'),
    ('Criar Dependente','Pessoa'),
    ('Cadastrar Arquivo do Funcionario','Pessoa'),
    ('Visualizar Arquivo do Funcionario','Pessoa'),
    ('Deletar Arquivo do Funcionario','Pessoa'),
    ('Visualizar Outras Informações do Funcionario','Pessoa'),
    ('Criar Outras Informações do Funcionario','Pessoa'),
    ('Deletar Outras Informações do Funcionario','Pessoa'),
    ('Visualizar Funcionario Quadro Horario','Pessoa'),
    ('Criar Funcionario Quadro Horario','Pessoa'),
    ('Visualizar Remuneração do Funcionario','Pessoa'),
    ('Criar Remuneração do Funcionario','Pessoa'),
    ('Deletar Remuneração do Funcionario','Pessoa'),
    ('Criar Perfil','Pessoa'),
    ('Visualizar Perfil','Pessoa'),
    ('Visualizar Permissao','Configuração'),
    ('Vincular Perfil a uma Permissao','Configuração'),
    ('Atualizar Perfil','Pessoa'),
    ('Criar Atendido','Pessoa'),
    ('Visualizar Atendido','Pessoa'),
    ('Visualizar Ocorrencia dos atendidos','Pessoa'),
    ('Criar Ocorrencia dos atendidos','Pessoa'),
    ('Visualizar tipo de atendido','Pessoa'),
    ('Visualizar status de atendido','Pessoa'),
    ('Criar tipo de arquivo','Pessoa'),
    ('Visualizar tipo de arquivo','Pessoa'),
    ('Visualizar Arquivo Da Pessoa','Pessoa'),
    ('Criar Arquivo para Pessoa','Pessoa'),
    ('Deletar Arquivo da Pessoa','Pessoa'),
    ('Atualizar Memorando','Memorando');
    ('Criar Saúde Sinais Vitais', 'Saude'),
    ('Visualizar Saúde Sinais Vitais', 'Saude'),
    ('Criar Saúde Medico', 'Saude'),
    ('Visualizar Saúde Medico', 'Saude'),
    ('Criar Saúde Medicamento Administração', 'Saude'),
    ('Visualizar Saúde Medicamento Administração', 'Saude'),
    ('Atualizar Saúde Medicação', 'Saude'),
    ('Visualizar Saúde Medicação', 'Saude'),
    ('Criar Saúde Intercorrencia', 'Saude'),
    ('Visualizar Saúde Intercorrencia', 'Saude'),
    ('Criar Saúde Ficha Médica', 'Saude'),
    ('Visualizar Saúde Ficha Médica', 'Saude'),
    ('Atualizar Saúde Ficha Médica', 'Saude'),
    ('Criar Saúde Historico Prontuario', 'Saude'),
    ('Criar Saúde Tipos de Exame', 'Saude'),
    ('Visualizar Saúde Tipos de Exame', 'Saude'),
    ('Criar Saúde Exame', 'Saude'),
    ('Visualizar Saúde Exame', 'Saude'),
    ('Deletar Saúde Exame', 'Saude'),
    ('Criar Saúde Enfermidade', 'Saude'),
    ('Visualizar Saúde Enfermidade', 'Saude'),
    ('Atualizar Saúde Enfermidade', 'Saude'),
    ('Criar Saúde CID', 'Saude'),
    ('Visualizar Saúde CID', 'Saude'),
    ('Criar Saúde Atendimento', 'Saude'),
    ('Visualizar Saúde Atendimento', 'Saude'),
    ('Cadastrar Saúde alergia na ficha medica', 'Saude'),
    ('Visualizar Saúde alergia na ficha medica', 'Saude'),
    ('Deletar Saúde Alergia na Ficha Médica', 'Saude'),
    ('Criar entrada de material', 'Material'),
    ('Criar origem e saida de material', 'Material'),
    ('Criar almoxarifado do material', 'Material'),
    ('Criar tipo de movimentação do material', 'Material'),
    ('Criar produto material', 'Material'),
    ('Criar categoria material', 'Material'),
    ('Criar unidade material', 'Material'),
    ('Atualizar produto após entrada de material', 'Material'),
    ('Deletar produto após entrada de material', 'Material'),
    ('Atualizar produto após entrada de material', 'Material'),
    ('Deletar produto após entrada de material', 'Material'),
    ('Visualizar Entrada de material', 'Material'),
    ('Criar saida de material', 'Material'),
    ('Visualizar saída de material', 'Material'),
    ('Atualizar produto após saída de material', 'Material'),
    ('Deletar produto após saída de material', 'Material'),
    ('Visualizar produto material', 'Material'),
    ('Atualizar produto material', 'Material'),
    ('Visualizar unidade material', 'Material'),
    ('Atualizar unidade material', 'Material'),
    ('Visualizar categoria material', 'Material'),
    ('Atualizar categoria material', 'Material'),
    ('Visualizar tipo de movimentação do material', 'Material'),
    ('Atualizar tipo de movimentação do material', 'Material'),
    ('Visualizar origem e saida de material', 'Material'),
    ('Atualizar origem e saida de material', 'Material'),
    ('Visualizar almoxarifado do material', 'Material'),
    ('Atualizar almoxarifado do material', 'Material'),
    ('Visualizar relatorio material', 'Material'),
    ('Criar Gateway de contribuição','Contribuição'),
    ('Visualizar Gateway de contribuição','Contribuição'),
    ('Atualizar Gateway de contribuição','Contribuição'),
    ('Criar regras de pagamento de contribuição','Contribuição'),
    ('Visualizar regras de pagamento de contribuição','Contribuição'),
    ('Atualizar regras de pagamento de contribuição','Contribuição'),
    ('Criar meio de pagamento de contribuição','Contribuição'),
    ('Visualizar meio de pagamento de contribuição','Contribuição'),
    ('Atualizar meio de pagamento de contribuição','Contribuição')
    ('Visualizar as contribuições','Contribuição'),
    ('Visualizar os Socios','Socios'),
    ('Visualizar os Socios Aniversariante','Socios'),
    ('Visualizar os Socios Gráfico','Socios'),
    ('Visualizar os Socios Relatorio','Socios'),
    ('Atualizar o Socio','Socios'),
    ('Criar tag de Socio','Socios'),
    ('Visualizar tag de Socio','Socios'),
    ('Atualizar tag de Socio','Socios'),
    ('Sincronizar pagamentos','Socios'),
    ('Atualizar textos do conteudo do sistema','Configuração'),
    ('Atualizar endereco da instituição','Configuração'),
    ('Cadastrar contato da instituição','Configuração'),
    ('Atualizar contato da instituição','Configuração'),
    ('Deletar contato da instituição','Configuração');

INSERT INTO perfil_permissao (id_perfil, id_permissao)
SELECT 1, id_permissao
FROM permissao;

INSERT INTO `situacao` (`situacoes`) VALUES ('Ativo'), ('Inativo');

INSERT INTO `funcionario` (`id_pessoa`, `id_perfil`, `id_situacao`, `data_admissao`, `pis`, `ctps`, `uf_ctps`, `numero_titulo`, `zona`, `secao`, `certificado_reservista_numero`, `certificado_reservista_serie`) VALUES ('1', '1', '1', '2020-06-03', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL);

INSERT INTO `escala_quadro_horario` (`descricao`) VALUES ('5x2 - 5 dias trabalhados com 2 dias de folga'), ('12x36 - 12 horas trabalhadas com 36 horas de folga');

INSERT INTO `tipo_quadro_horario` (`descricao`) VALUES ('Segunda à Sexta, folga Sábado e Domingo'), ('Dias alternados');

INSERT INTO `selecao_paragrafo` (`id_selecao`, `nome_campo`, `paragrafo`, `original`) VALUES
(1, 'Titulo', 'WeGIA', 1),
(2, 'Subtitulo', 'Web Gerenciador Institucional', 1),
(3, 'Conheça', 'O WEGIA é um software livre licenciado pela GNU/GPL v3.', 1),
(4, 'Objetivo', 'Promover uma boa administração ao fornecer serviços de ajuda e controle de estoques, gerenciamento de funcionários e pessoal, visando um maior proveito de recursos.\r\n\r\nEntre com suas credenciais padrão de administrador para configurar o sistema:\r\n\r\nusuário: admin\r\nsenha: wegia', 1),
(5, 'Rodapé', 'WeGIA - Desenvolvido pelo Cefet/RJ UnED Nova Friburgo', 1),
(6, 'ContribuiçãoMSG', 'Contribua você também!', 1),
(7, 'agradecimento_doador', 'Mensagem de Agradecimento ao DOADOR', 1);

INSERT INTO `campo_imagem` (`id_campo`, `nome_campo`, `tipo`) VALUES 
(1, 'Logo', 'img'), 
(2, 'Carrossel', 'car');

INSERT INTO `contato_instituicao`(`id`, `descricao`, `contato`) VALUES
    (1, 'Apoio aos doadores', 'telefone_ou_@email.com');

INSERT INTO `tabela_imagem_campo` (`id_relacao`, `id_campo`, `id_imagem`) VALUES
(1, 1, 1),
(2, 2, 1);

INSERT INTO `socio_tipo` (`id_sociotipo`, `tipo`) VALUES
(0, 'Física - Casual - Boleto'),
(1, 'Jurídica - Casual - Boleto'),
(2, 'Física - Mensal - Boleto'),
(3, 'Jurídica - Mensal - Boleto'),
(4, 'Física - Sem informação'),
(5, 'Jurídica - Sem informação'),
(6, 'Física - Bimestral - Boleto'),
(7, 'Jurídica - Bimestral - Boleto'),
(8, 'Física - Trimestral - Boleto'),
(9, 'Jurídica - Trimestral - Boleto'),
(10, 'Física - Semestral - Boleto'),
(11, 'Jurídica - Semestral - Boleto'),
(12, 'Física - Anual - Boleto'),
(13, 'Jurídica - Anual - Boleto'),

(20, 'Física - Casual - Cartão'),
(21, 'Jurídica - Casual - Cartão'),
(22, 'Física - Mensal - Cartão'),
(23, 'Jurídica - Mensal - Cartão'),
(24, 'Física - Bimestral - Cartão'),
(25, 'Jurídica - Bimestral - Cartão'),
(26, 'Física - Trimestral - Cartão'),
(27, 'Jurídica - Trimestral - Cartão'),
(28, 'Física - Semestral - Cartão'),
(29, 'Jurídica - Semestral - Cartão'),
(30, 'Física - Anual - Cartão'),
(31, 'Jurídica - Anual - Cartão'),

(40, 'Física - Casual - Outros'),
(41, 'Jurídica - Casual - Outros'),
(42, 'Física - Mensal - Outros'),
(43, 'Jurídica - Mensal - Outros'),
(44, 'Física - Bimestral - Outros'),
(45, 'Jurídica - Bimestral - Outros'),
(46, 'Física - Trimestral - Outros'),
(47, 'Jurídica - Trimestral - Outros'),
(48, 'Física - Semestral - Outros'),
(49, 'Jurídica - Semestral - Outros'),
(50, 'Física - Anual - Outros'),
(51, 'Jurídica - Anual - Outros');

INSERT INTO `socio_status` (`id_sociostatus`, `status`) VALUES
(0, 'Ativo'),
(1, 'Inativo'),
(2, 'Inadimplente'),
(3, 'Inativo Temporariamente'),
(4, 'Sem informação');

INSERT INTO `socio_tag` (`tag`) VALUES
('Solicitante');

INSERT INTO `unidade` (`descricao_unidade`) VALUES ('Quilo'), ('Litro'), ('Metro'), ('Pacote'), ('Unidade');

INSERT INTO `recurso` (`id_recurso`, `descricao`) VALUES 
('1', 'Módulo Pessoa'),
('11', 'Funcionário'),
('12', 'Atendido'),
('13', 'Voluntário'),
('2', 'Módulo Material e Patrimônio'),
('21', 'Almoxarifado'),
('22', 'Produto'),
('23', 'Entrada'),
('24', 'Saída'),
('25', 'Relatórios'),
('3', 'Módulo Memorando'),
('4', 'Módulo Sócio'),
('5', 'Módulo Saúde'),
('51', 'Criar ficha médica'),
('52', 'Ficha do paciente'),
('53', 'Alergia'),
('54', 'Enfermidade'),
('6', 'Módulo Pet'),
('7', 'Módulo Contribuição'),
('61', 'Cadastrar Pet'),
('62', 'Saúde Pet'),
('63', 'Informações Pet'),
('64', 'Adotantes Pet'),
('9', 'Configurações'),
('91', 'Permissões');


INSERT INTO `modulos_visiveis` (`id_recurso`, `visivel`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(6, 1),
(7, 1);

INSERT INTO `sistema_pagamento` (`id`, `nome_sistema`) VALUES 
(1, 'PAGSEGURO'), 
(2, 'PAYPAL'), 
(3, 'BOLETOFACIL'), 
(4, 'WIDEPAY'),
(5, 'PIX');

INSERT INTO `doacao_pix_tipos` (`ID`, `TIPO`) VALUES
(1, 'CNPJ'),
(2, 'e-mail'),
(3, 'telefone'),
(4, 'aleatória');

INSERT INTO `doacao_boleto_regras` (`id`, `min_boleto_uni`, `max_dias_venc`, `juros`, `multa`, `max_parcela`, `min_parcela`, `agradecimento`, `dias_boleto_a_vista`, `dias_venc_carne_op1`, `dias_venc_carne_op2`, `dias_venc_carne_op3`, `dias_venc_carne_op4`, `dias_venc_carne_op5`, `dias_venc_carne_op6`) VALUES 
('1', '10.00', '29', '0', '0', '1000.00', '30.00', 'Agradecemos sua ajuda financeira!', '3', '1', '5', '10', '15', '20', '25');

INSERT INTO `doacao_boleto_info` (`id`, `api`, `token_api`, `sandbox`, `token_sandbox`, `id_sistema`, `id_regras`) VALUES 
('0', 'https://sandbox.boletobancario.com/boletofacil/integration/api/v1/issue-charge?', 'CADASTRA-SE NO GATEWAY DE PAGAMENTO PARA RECEBER UM TOKEN', '', '', '3', '1');

INSERT INTO `doacao_cartao_avulso` (`url`, `id_sistema`) VALUES ('Cadastre sua instituição no gateway de pagamento', 1);

INSERT INTO `atendido_ocorrencia_tipos` (`idatendido_ocorrencia_tipos`, `descricao`) VALUES
(1, 'Acolhimento'),
(2, 'Falecimento'); 

INSERT INTO `atendido_tipo` (`idatendido_tipo`, `descricao`) VALUES (1, 'Interno');
INSERT INTO `atendido_status` (`idatendido_status`, `status`) VALUES 
(1, 'Ativo'),
(2, 'Inativo');

INSERT INTO `funcionario_remuneracao_tipo` (`idfuncionario_remuneracao_tipo`, `descricao`) VALUES
(1, 'Vencimento Básico'),
(2, 'Vale-alimentação'),
(3, 'Salário Família'),
(4, 'Adicional Noturno'),
(5, 'Insalubridade'),
(6, 'Periculosidade'),
(7, 'Vale transporte');

INSERT INTO `funcionario_listainfo` (`idfuncionario_listainfo`, `descricao`) VALUES
(1, 'Escolaridade'),
(2, 'Naturalidade'),
(3, 'Estado Civil'),
(4, 'Carteira do SUS');

INSERT INTO categoria_produto (descricao_categoria) VALUES ('Alimento'),('Higiene'),('Limpeza'),('Medicamento'),('Papelaria');

INSERT INTO origem (nome_origem) VALUES ('Doador não identificado');

INSERT INTO tipo_entrada (descricao) VALUES ('Doação'), ('Compra'), ('Troca'); 

INSERT INTO tipo_saida (descricao) VALUES ('Consumo'), ('Troca'), ('Vencido');

INSERT INTO `saude_exame_tipos` (`id_exame_tipo`, `descricao`) VALUES
(1, 'Fezes'),
(2, 'Hemograma'),
(3, 'Urina'),
(4, 'Cardíaco'),
(5, 'Glicemia'),
(6, 'Colesterol'),
(7, 'TSH'),
(8, 'Papanicolau'),
(9, 'Transaminases'),
(10, 'Creatinina'),
(11, 'Triglicerídios'),
(12, 'Ácido úrico'),
(13, 'Ureia'),
(14, 'TGO'),
(15, 'TGP');

-- Inserir as descrições existentes na tabela `saude_fichamedica` na tabela `saude_fichamedica_descricoes`
/*INSERT INTO `wegia`.`saude_fichamedica_descricoes` (`id_fichamedica`, `descricao`)
SELECT `id_fichamedica`, `descricao`
FROM `wegia`.`saude_fichamedica`
WHERE `descricao` IS NOT NULL;*/

INSERT INTO `saude_medicacao_status` (`descricao`) VALUES ('Em tratamento'), ('Concluído') , ('Substituído'), ('Cancelado');

INSERT INTO `saude_tabelacid` (`CID`, `descricao`) VALUES ('B34.2', 'Infecção por coronavírus de localização não especificada');

-- 240621: Refatoração do módulo Contribuição, dados para as novas tabelas --
INSERT INTO `contribuicao_regras` (`regra`) VALUES 
('MIN_VALUE'), 
('MAX_VALUE');

INSERT INTO `contribuicao_gatewayPagamento` (plataforma,endPoint,token,status) VALUES ("NAO DEFINIDA","https://localhost/api","coloque o token aqui",0);

INSERT INTO `contribuicao_meioPagamento` (meio,id_plataforma,status) VALUES ("Boleto",1,0), ("Pix",1,0), ("Carne",1,0);

INSERT INTO `contribuicao_conjuntoRegras` (id_meioPagamento,id_regra,valor,status) 
VALUES (1,1,1,0), (1,2,1000,0), (2,1,1,0), (2,2,1000,0), (3,1,1,0), (3,2,1000,0);