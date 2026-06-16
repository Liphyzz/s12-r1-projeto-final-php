# Pj Final - Um upgrade do site The Battle Cats Wiki

Especificação dos Requisitos de Software (SRS)  
Estrutura Baseada na ISO/IEC/IEEE 29148:2018

## 1. Identificação do Documento

**Projeto:** The Battle Cats Ultimate Wiki  
**Versão:** 1.0.0  
**Data:** 2026-06-16

## 2. Introdução

### 2.1 Propósito
Este documento descreve as especificações, regras de negócio, restrições, requisitos funcionais e requisitos não funcionais da evolução do site de enciclopédia colaborativa "The Battle Cats Wiki", desenvolvido em formato de aplicação web estruturada na linguagem PHP. O objetivo é fornecer uma base clara para o desenvolvimento, validação e avaliação do sistema.

### 2.2 Escopo
O sistema consiste em uma melhoria substancial do site "The Battle Cats Wiki" que implementará:
- Otimização do design visual, responsividade, nível de informação e consistência de dados;
- CRUD completo (Adicionar, atualizar, listar e deletar) de recursos, gatos, inimigos e fases do jogo mobile;
- Nova funcionalidade de comparação direta de atributos entre gatos ou inimigos;
- Área de dicas avançadas e estratégias para a conclusão de fases;
- Sistema de controle de acesso (Níveis de Usuário): Apenas Administradores/Membros aprovados podem realizar alterações destrutivas ou de inserção (Criar, Editar, Deletar), aumentando a confiabilidade da Wiki;
- Aba dedicada a um Fórum comunitário para interação de usuários.

### 2.3 Definições, Acrônomos e Abreviações

| Termo | Definição |
|---|---|
| PHP | Linguagem de programação interpretada no lado do servidor, utilizada para estruturação lógica e integração com o banco de dados. |
| Wiki | Plataforma estruturada em páginas interligadas que facilita a criação, edição e versionamento centralizado de conteúdo. |
| The Battle Cats | Jogo eletrônico mobile 2D de estratégia no estilo de envio de tropas (gatos) em uma arena para conquistar a base inimiga e proteger a própria. |
| CRUD | Acrônimo para Create, Read, Update e Delete (Operações básicas de banco de dados). |
| Meatshield | Estratégia de usar unidades de baixo custo e alta velocidade de recarga para absorver danos na linha de frente. |

### 2.4 Visão Geral do Documento
Este documento está organizado em:
- Descrição geral do sistema
- Requisitos funcionais (completos)
- Requisitos não funcionais
- Modelagem de dados (PostgreSQL)
- Regras de negócio do ecossistema

---

## 3. Descrição Geral

### 3.1 Perspectiva do produto
O sistema se posiciona como uma plataforma web de enciclopédia de alta performance e fidelidade visual dedicada à comunidade do jogo The Battle Cats, oferecendo ferramentas analíticas adicionais que não existem em wikis tradicionais (como a ferramenta de comparação e controle estrito de edições).

### 3.2 Funções do Produto
O sistema deverá fornecer:
- Tela inicial informativa (Home);
- Fórum para discussão de estratégias;
- Listagem geral e páginas de detalhes com filtros avançados para Gatos, Inimigos, Recursos e Fases;
- Módulo de comparação dinâmica de atributos;
- Painel Administrativo de Moderação (Apenas para usuários autorizados);
- Controle total de sessões (Cadastro, Login com criptografia e Logout seguro).

### 3.3 Características do Usuário
- Jogadores casuais e competitivos de The Battle Cats buscando otimização de estratégias.
- Comunidade infanto-juvenil e entusiastas de jogos de estratégia mobile.

### 3.4 Restrições
- Desenvolvimento estruturado obrigatoriamente na linguagem PHP puro.
- Utilização correta de conexões seguras com banco de dados via PDO.
- Separação estrita de escopo de diretórios (Área pública isolada da lógica de negócios).

---

## 4. Requisitos Funcionais

### 4.1 Header e Navegação
- **RF01** – O sistema deve conter um Header fixo contendo a Logo oficial da Wiki e o Título do projeto.
- **RF02** – A barra de navegação superior (Navbar) deve permitir acesso rápido às seguintes telas: Início, Gatos, Inimigos, Fases, Recursos e Fórum.

### 4.2 Tela Inicial e Autenticação
- **RF03** – A tela inicial deve exibir seções dinâmicas contendo informações de introdução ao site e um resumo estratégico sobre o funcionamento do jogo.
- **RF04** – O sistema deve possuir controle de sessões real e validações de nível de acesso (`user comum` e `membro/adm`).
- **RF05** – **Tela de Cadastro:** Deve conter formulário solicitando Username, E-mail e Senha. O sistema deve validar duplicidade de e-mail e impedir injeção de dados na sessão caso o cadastro falhe.
- **RF06** – **Tela de Login:** Deve autenticar o usuário validando o e-mail e a senha correspondente (hash criptografado). Em caso de falha, deve reter o usuário na tela exibindo uma mensagem de alerta tratada via CSS, sem recarregar a aplicação de forma destrutiva.
- **RF07** – **Logout:** O usuário deve conseguir encerrar sua sessão a partir da página de Perfil via requisição POST segura, limpando todas as variáveis globais de autenticação e redirecionando para a Home.

### 4.3 Módulos de Conteúdo (Gatos, Inimigos, Recursos e Fases)
- **RF08** – **Telas de Listagem Geral:** Devem exibir miniaturas e informações básicas dos cards cadastrados, permitindo paginação ou filtros por categoria/raridade/tipo.
- **RF09** – **Tela do Gato / Inimigo:** Exibição analítica de todos os dados técnicos da unidade (Vida, Ataque, DPS, Alcance, Velocidade de Movimento, Alvos Especiais e Habilidades específicas).
- **RF10** – **Tela do Recurso / Fase:** Exibição da descrição textual de sua utilidade (para recursos) e listagem de inimigos presentes com dicas de composição de deck (para fases).

### 4.4 Painel de Moderação (Administração)
- **RF11** – O sistema deve interceptar requisições e garantir que apenas usuários com `userlvl == 'membro'` visualizem ou acessem as rotas de inserção, alteração ou exclusão de dados.

---

## 5. Requisitos Não-Funcionais

### 5.1 Usabilidade
- **RNF01** - Interface limpa utilizando Flexbox/Grid baseada no esquema de cores e identidade visual oficial de The Battle Cats.
- RNF02 Exibição amigável de erros de formulário (caixas de alertas estilizadas em vermelho e com tratamento contra quebra de layout).

### 5.2 Desempenho
- **RNF03** - Consultas otimizadas no banco de dados para que as páginas de listagem carreguem em tempo reduzido.

### 5.3 Manutenibilidade e Segurança
- **RNF04** - Arquitetura de código limpa, dividida estritamente nas pastas físicas: `config` (banco e rotas), `includes` (estruturas visuais fixas), `public` (arquivos visíveis ao navegador e assets) e `src` (lógica backend isolada).
- **RNF05** - Armazenamento de senhas em banco utilizando a função nativa `password_hash()` do PHP.

### 5.4 Portabilidade
- **RNF06** - Responsividade adaptável para layouts desktop iniciais e compatibilidade estrutural para dispositivos mobile através de Media Queries CSS.

---

## 6. Modelagem de Dados (PostgreSQL)

*(As entidades Gatos, Inimigos, Recursos, Fases e Usuarios permanecem idênticas ao seu padrão técnico do banco).*

### 6.1 Entidade Gato
```postgresql
CREATE TABLE Gatos (
  id SERIAL PRIMARY KEY,
  raridade VARCHAR(15) NOT NULL,
  CONSTRAINT chk_raridade CHECK (raridade IN ('Normal', 'Especial', 'Raro', 'Super Raro', 'Uber Super Raro', 'Lenda Rara')),
  nome VARCHAR(40) NOT NULL,
  vida INT NOT NULL,
  atq INT NOT NULL,
  vel_atq DECIMAL(5,2) NOT NULL,
  dps DECIMAL(10,2) NOT NULL,
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
  custo INT NOT NULL
);
```

### 6.3 Entidade Recurso

A entidade Recurso deve conter:

```postgresql
CREATE TABLE Recursos (
  id SERIAL PRIMARY KEY,
  tipo VARCHAR(20) NOT NULL,
  nome VARCHAR(25) NOT NULL,
  descricao TEXT NOT NULL
);
```

### 6.4 Entidade Fase

A entidade Fase deve conter:

```postgresql
CREATE TABLE Fases (
  id SERIAL PRIMARY KEY,
  tipo VARCHAR(18) NOT NULL,
  subtipo VARCHAR(25),
  nome VARCHAR(25) NOT NULL,
  descricao TEXT NOT NULL,
  dicas TEXT
);
```

### 6.5 Entidade Usuário

A entidade Usuário deve conter:

```postgresql
CREATE TABLE Usuarios (
  id SERIAL PRIMARY KEY,
  nome VARCHAR(40),
  email VARCHAR(40),
  senha_hash VARCHAR(67),
  is_membro BOOLEAN DEFAULT FALSE
);
```

## 7. Regras de Negócio
**RN01** (Segurança de Cadastro): Um e-mail não pode ser registrado mais de uma vez no sistema.

**RN02** (Isolamento de Estado de Sessão): Se uma tentativa de cadastro ou login falhar, nenhuma informação de credencial ativa ou privilégio administrativo deve persistir na sessão global do navegador.

**RN03** (Privilégio de Escrita): Apenas usuários autenticados cujos dados apontem is_membro = TRUE no banco de dados podem submeter requisições de criação, edição ou deleção para a API/Actions do sistema.

**RN04** (Integridade de Dados Técnicos): Atributos numéricos de combate (como Vida e Dano) de Gatos e Inimigos não podem receber valores negativos ou nulos no banco de dados.

## 8. Arquitetura do Sistema

Estrutura sugerida:

```
Root/
 ├── config/
 │    ├── database.php
 │    └── router.php
 ├── includes/
 │    ├── footer.php
 │    └── header.php
 ├── public/
 │    ├── assets/
 │    │    ├── css/
 │    │    └── img/
 │    ├── auth/
 │    │    ├── cadastro_page.php
 │    │    ├── login_page.php
 │    │    └── perfil_page.php
 │    ├── fases/
 │    ├── gatos/
 │    ├── inimigos/
 │    ├── recursos/
 │    └── index.php
 └── src/
      └── actions/
          ├── auth/
          │    ├── cadastro.php
          │    ├── login.php
          │    └── logout.php
          ├── fase/
          ├── gato/
          ├── inimigo/
          └── recurso/

```

## 9. Critérios de Aceitação

O sistema será considerado válido se:

- Arquivos separados
- Conexão reutilizada
- Código comentado
- Fluxo funcional completo

## 10. Entregáveis

Link do projeto no github contendo:
- Documentação
- Prototipagem
- Projeto em si
- Dump do DB

## 11. Como Testar o Projeto

Siga os passos abaixo para rodar e testar o sistema na sua máquina local:

### 11.1 Pré-requisitos
Certifique-se de ter instalado em seu computador:
* **PHP** (versão 7.4 ou superior)
* **PostgreSQL** (com um banco de dados criado)

### 11.2 Path
Coloque o caminho do php e do PostgreSQL no path

### 11.3 Extensões
Renomeie o arquivo php.ini-development para php.ini, abra o arquivo e descomente as seguintes extensões:
- curl
- fileinfo
- intl
- mbstring
- openssl
- pdo_pgsql
- pgsql
  
### 11.4 Clonar o Repositório
Abra o VS Code, abra o terminal integrado (`Ctrl + '` ou `Cmd + '` no Mac) e execute o comando para clonar o projeto:
```bash
git clone https://github.com/Liphyzz/s12-r1-projeto-final-php.git
```
Em seguida, entre na pasta do projeto:

```bash
cd s12-r1-projeto-final-php
```

### 11.5 Configurar e Restaurar o Banco de Dados (PostgreSQL)
Certifique-se de que o PostgreSQL está ativo na sua máquina.

1. Abra o arquivo config/database.php e configure as credenciais de acesso de acordo com o seu ambiente local (host, port, db, user, pass).

2. No terminal do VS Code, execute o comando abaixo para criar o banco de dados e importar a estrutura/dados do arquivo dump.sql:

```bash
# Caso use o terminal do Linux/macOS ou Git Bash no Windows:
psql -U seu_usuario -d nome_do_seu_banco -f caminho/para/o/dump.sql

# Caso use o PowerShell no Windows:
cmd /c "psql -U seu_usuario -d nome_do_seu_banco -f caminho/para/o/dump.sql"
```

(Nota: O terminal solicitará a senha do seu usuário do PostgreSQL)

### 11.6 Iniciar o Servidor Nativo do PHP
Para rodar o projeto apontando diretamente para a pasta public (onde fica o ponto de entrada do sistema), execute o comando do servidor embutido do PHP na raiz do projeto:

```bash
php -S localhost:8080 -t public
```

### 11.7 Acessar o Projeto
Com o servidor rodando e o terminal ocupado, abra o seu navegador e acesse:

http://localhost:8080

Dica: Para encerrar o servidor no terminal do VS Code a qualquer momento, basta pressionar Ctrl + C.