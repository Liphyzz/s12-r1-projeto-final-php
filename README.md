# Pj Final - Um upgrade do site The Battle Cats Wiki

Especificação dos Requisitos de Software (SRS)
Estrutura Baseada na ISO/IEC/IEEE 29148:2018


## 1. Identificação do Documento

**Projeto:** The Battle Cats Ultimate Wiki

**Versão:** 1.0.0

**Data:** 2026-05-28

## 2. Introdução

### 2.1 Propósito

Este documento descreve as especificações, regras de negócio, restrições, requisitos funcionais e requisitos não funcionais da evolução do site de enciclopédia colaborativa "The Battle Cats Wiki", desenvolvido em formato de site, feito em php.

O objetivo é fornecer uma base clara para desenvolvimento, validação e avaliação do sistema.

### 2.2 Escopo

O sistema consiste em uma melhoria do site "The Battle Cats Wiki" que implementará:

- Uma melhora na aparência, nível de informação e consistência dos dados;
- Adicionar, atualizar, listar e deletar recursos, gatos, inimigos e fases referêntes ao jogo mobile;
- Uma nova funcionalidade: comparar gatos ou inimigos;
- Parte dedicada à informações sobre o jogo e dicas de fases;
- Apenas Adms (pessoas com conta aprovada no site) podem adicionar, atualizar e deletar, para aumentar a confiabilidade do site.
- Aba para fórum.

O sistema será produzido puramente em php.

### 2.3 Definições, Acrônomos e Abreviações

|Termo|Definição|
|---|---|
|PHP|Linguagem de programação segura, boa e de fácil implementação e integração com o frontend|
|Wiki| Plataforma estruturada em páginas interligadas que facilita a criação, edição e versionamento centralizado de conteúdo. |
|The Battle Cats|Jogo eletrônico mobile 2D no estilo de spam de tropas (gatos de batalha) em uma arena com o intuito de conquistar a base do inimigo e proteger a sua própria|

### 2.4 Visão Geral do Documento

Este documento está organizado em:

- Descrição geral do sistema
- Requisitos funcionais
- Requisitos não funcionais
- Modelagem de dados
- Regras de negócio

---

## 3. Descrição Geral

### 3.1 Perspectiva do produto

O sistema é uma wiki sobre o jogo The Battle Cats, porém turbinada.

### 3.2 Funções do Produto

O sistema deverá:

- Ter uma tela inicial (Home);
- Ter uma tela para fórum;
- Ter uma tela com todos os gatos e possibilidade de filtrar;
- Ter uma tela com todos os inimigos e possibilidade de filtrar;
- Ter uma tela com todos os recursos e possibilidade de filtrar;
- Ter uma tela com todas as fases e possibilidade de filtrar;
- Ter uma tela para comparação entre gatos e/ou inimigos;
- Ter uma tela de mod -> para adição, modificação e exclusão, com seção individual para gatos, inimigos, recursos e fases;
- Garantir que só membros autorizados acessem a tela de mod;
- Permitir navegação entre telas.

### 3.3 Características do Usuário

Usuários esperados:

- Gamers curiosos
- Jogadores de The Battle Cats
- Nerds
- Crianças e adolescentes

### 3.4 Restrições

- Desenvolvimento obrigatório em PHP
- Produção e utilização correta de uma API
- Crud completo e funcional

## 4. Requisitos Funcionais

### 4.1 Header

**RF03** – Deve conter:
- Logo
- Título

### 4.2 Navegação

**RF03** – A navegação do sistema deve conter:

- Início (informações, dicas e sobre o site)
- Gatos
- Inimigos
- Fases
- Recursos

**RF04** – A navegação entre telas deve acontecer numa barra superior, abaixo do header.

### 4.3 Tela Inicial

**RF01** – O sistema deve exibir uma tela inicial contendo:

- Informações sobre o jogo
- Dicas sobre o jogo
- Informações sobre o site

**RF02** – O sistema deve conter simulação de login.

### 4.4 Tela de Cadastro



### 4.5 Tela de Login



### 4.6 Tela de gatos



#### 4.6.1 Tela do gato



### 4.7 tela de inimigos



#### 4.7.1 Tela do inimigo



### 4.8 tela de recursos



#### 4.8.1 tela do recurso



## 5. Requisitos Não-Funcionais

### 5.1 Usabilidade

- Interface intuitiva e simples
- Navegação clara

### 5.2 Desempenho

- Atualizações em tempo real sem travamentos
- Tempo de resposta imediato para ações do usuário

### 5.3 Manutenibilidade

- Código organizado em camadas
- Separação entre:
    - config
    - includes
    - public
    - src

### 5.4 Portabilidade

- As versões iniciais serão apenas para desktop, porém, com previsão de responsividade para smartphones

## 6. Modelagem de Dados

### 6.1 Entidade Gato

A entidade Gato deve conter:

```postgresql
CREATE TABLE Gatos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  raridade VARCHAR(15) NOT NULL,
  CONSTRAINT chk_raridade CHECK (raridade IN ('Normal', 'Especial', 'Raro', 'Super Raro', 'Uber Super Raro', 'Lenda Rara')),
  nome VARCHAR(40) NOT NULL,
  vida INT NOT NULL,
  atq INT NOT NULL,
  vel_atq DECIMAL(5,2) NOT NULL,
  dps DECIMAL (10,2) NOT NULL,
  alcance_atq INT NOT NULL,
  tipo_atq VARCHAR(5) NOT NULL,
  CONSTRAINT chk_tipo_atq CHECK (tipo_atq IN ('Único', 'Área')),
  vel_movimento DECIMAL(4,1) NOT NULL,
  qtde_knockbacks INT NOT NULL,
  tmp_recarga_unidade DECIMAL(5,2),
  lvl_max INT NOT NULL,
  lvls_adicionais INT,
  bom_contra TEXT[],
  CONSTRAINT chk_bom_contra CHECK (
        bom_contra IS NULL
        OR bom_contra <@ ARRAY['Vermelho', 'Flutuante', 'Preto', 'Metal', 'Anjo', 'Alien', 'Zumbi', 'Relíquia', 'Aku', 'Sem Características']::text[]
    ),
  hab_especiais TEXT[],
  custo INT NOT NULL,
);
```

### 6.2 Entidade Inimigo

A entidade Inimigo deve conter:

```postgresql
CREATE TABLE Inimigos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nome VARCHAR(40) NOT NULL,
  vida INT NOT NULL,
  atq INT NOT NULL,
  vel_atq DECIMAL(5,2) NOT NULL,
  dps DECIMAL (10,2) NOT NULL,
  alcance_atq INT NOT NULL,
  tipo_atq VARCHAR(5) NOT NULL,
  CONSTRAINT chk_tipo_atq CHECK (tipo_atq IN ('Único', 'Área')),
  vel_movimento DECIMAL(4,1) NOT NULL,
  qtde_knockbacks INT NOT NULL,
  tipo TEXT[] NOT NULL,
  CONSTRAINT chk_tipo CHECK (
        tipo <@ ARRAY['Vermelho', 'Flutuante', 'Preto', 'Metal', 'Anjo', 'Alien', 'Zumbi', 'Relíquia', 'Aku', 'Sem Características']::text[]
    ),
  hab_especiais TEXT[],
);
```

### 6.3 Entidade Recurso

A entidade Recurso deve conter:

```sql
CREATE TABLE Recursos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  tipo VARCHAR(20) NOT NULL,
  nome VARCHAR(25) NOT NULL,
  descricao TEXT NOT NULL,
);
```

### 6.4 Entidade Fase

A entidade Fase deve conter:

```sql
CREATE TABLE Fases (
  id INT AUTO_INCREMENT PRIMARY KEY,
  tipo VARCHAR(18) NOT NULL,
  subtipo VARCHAR(25),
  nome VARCHAR(25) NOT NULL,
  descricao TEXT NOT NULL,
  dicas TEXT,
);
```

## 7. Regras de Negócio

**RN01** – Um hábito só pode estar em uma lista (pendente ou concluído).

**RN02** – Ao concluir um hábito:

- ele deve ser automaticamente movido de lista.

**RN03** – O dashboard deve refletir os dados atualizados em tempo real.

**RN04** – Resetar progresso deve limpar todos os dados.

## 8. Arquitetura do Sistema

Estrutura sugerida:

```
Root/
 ├── config/
 ├── includes/
 ├── public/
 │   ├── assets/
 │   │   ├── css/
 │   │   └── imgs/
 │   ├── auth/
 │   ├── fases/
 │   ├── gatos/
 │   ├── inimigos/
 │   └── recursos/
 └── src/
     └── actions/
         ├── auth/
         ├── fase/
         ├── gato/
         ├── inimigo/
         └── recurso/

```

## 9. Critérios de Aceitação

O sistema será considerado válido se:



## 10. Entregáveis

