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
- Adicionar, atualizar, listar e deletar itens, gatos e inimigos referêntes ao jogo mobile;
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
|XPTO|XPTO|

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

<!-- REsumir e detalhar só nos requisitos (aqui conceito, requisitos detalhamento técnico) -->
- Ter uma tela inicial (Home);
- Ter uma tela para informações e dicas;
- Ter uma tela para fórum;
- Ter uma tela com todos os gatos e possibilidade de filtrar;
- Ter uma tela com todos os inimigos e possibilidade de filtrar;
- Ter uma tela com todos os itens e possibilidade de filtrar;
- Ter uma tela para comparação entre gatos e/ou inimigos;
- Ter uma tela de mod -> para adição, modificação e exclusão, com seção individual para gatos, inimigos e itens;
- Garantir que só membros autorizados acessem a tela de mod;
- Permitir navegação entre telas;

### 3.3 Características do Usuário

Usuários esperados:

- Gamers curiosos;
- Jogadores de The Battle Cats;
- Nerds;
- Crianças e adolescentes.

### 3.4 Restrições

- Desenvolvimento obrigatório em Flutter
- Uso obrigatório do Provider
- Organização adequada do protótipo com a estrutura correta de widgets (Ex.: Scaffold -> AppBar etc...)

## 4. Requisitos Funcionais

### 4.1 Tela Inicial

**RF01** – O sistema deve exibir uma tela inicial contendo:

- nome do aplicativo;
- descrição;
- imagem ilustrativa;
- botão de acesso.

**RF02 (Opcional)** – O sistema pode conter simulação de login.

### 4.2 Navegação

**RF03** – O sistema deve possuir um BottomNavigationBar com no mínimo 3 opções:

- Dashboard
- Hábitos
- Configurações

**RF04 (Opcional)** – O sistema pode possuir um Drawer com:

- Dashboard
- Hábitos
- Configurações
- Ajuda

**RF05** – A navegação entre telas deve ser controlada por Provider.

### 4.3 Tela de Hábitos

**RF06** – O sistema deve exibir hábitos pendentes em uma lista (plantar uma árvore, economizar água e reciclar o lixo).

**RF07** – O sistema deve permitir marcar um hábito como concluído.

**RF08** – Ao concluir um hábito:

- ele pode ser removido da lista de pendentes;
- pode ser adicionado à lista de concluídos.

**RF09 (Opcional)** – O sistema pode exibir hábitos concluídos em uma segunda aba.

**RF10 (Opcional)** – A tela pode utilizar TabBarView com duas abas:

- Pendentes
- Concluídos

### 4.4 Dashboard

**RF11** – O sistema deve exibir:

- total de hábitos concluídos;
- hábitos pendentes;
- pontuação;
- meta semanal;
- nível do usuário;
- impacto estimado.

**RF12** – Os dados devem ser atualizados automaticamente via Provider.

### 4.5 Configurações

**RF13** – O sistema deve permitir ao menos 1 desses recursos (preferencialmente o de modo escuro):

- alterar nome do usuário;
- ativar/desativar modo escuro;
- redefinir progresso;
- limpar hábitos concluídos;
- configurar meta semanal.

**RF14** – Alterações devem refletir imediatamente na interface.

### 4.6 Gerenciamento de Estado

**RF15** – O sistema deve utilizar Provider para:

- controle de tela selecionada;
- gerenciamento de hábitos;
- atualização do dashboard;
- configurações globais.

## 5. Requisitos Não Funcionais

### 5.1 Usabilidade

- Interface intuitiva e simples
- Navegação clara

### 5.2 Desempenho

- Atualizações em tempo real sem travamentos
- Tempo de resposta imediato para ações do usuário

### 5.3 Manutenibilidade

- Código organizado em camadas
- Separação entre:
    - models
    - views
    - controllers

### 5.4 Portabilidade

- O aplicativo deve rodar em dispositivos Android (mínimo)

## 6. Modelagem de Dados

### 6.1 Entidade Habito

A entidade Habito deve conter:

```dart
class Habito {
  String titulo;
  String descricao;
  bool concluido;
}
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
lib/
 ├── models/
 ├── providers/
 ├── screens/
 ├── widgets/
 ├── main.dart
```

## 9. Critérios de Aceitação

O sistema será considerado válido se:

- ✔ Possuir no mínimo 3 telas
- ✔ Navegação funcional
- ✔ Uso correto de Provider
- ✔ ListView funcionando
- ✔ GridView funcionando
- ✔ Atualizações automáticas

## 10. Entregáveis

- Link do projeto commitado no GitHub, que deve conter:
    - Código fonte organizado
    - Documentação SRS (este documento)
- Protótipos de tela (Figma)
- Apresentação do sistema (screenshots)