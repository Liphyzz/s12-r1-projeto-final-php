# Pj Final - Um upgrade do site The Battle Cats Wiki

Especificação dos Requisitos de Software (SRS)
Estrutura Baseada na ISO/IEC/IEEE 29148:2018


## 1. Identificação do Documento

**Projeto:** The Battle Cats Ultimate Wiki

**Versão:** 1.0.0

**Data:** 2026-05-28


## 2. Introdução

### 2.1 Propósito

Este documento descreve as especificações, regras de negócio, restrições, requisitos funcionais e requisitos não funcionais da evolução do site de enciclopédia colaborativa "The Battle Cats Wiki", desenvolvido em Flutter, com o uso de Provider.

O objetivo é fornecer uma base clara para desenvolvimento, validação e avaliação do sistema.

### 2.2 Escopo

O sistema consiste em um aplicativo mobile que permite ao usuário:

- registrar hábitos sustentáveis;
- acompanhar ações realizadas;
- visualizar progresso ambiental;
- gerenciar preferências do aplicativo.

O aplicativo será desenvolvido utilizando Flutter e gerenciamento de estado com Provider.

### 2.3 Definições, Acrônomos e Abreviações

|Termo|Definição|
|---|---|
|Flutter|Framework para construir aplicações mobile com a linguagem dart|
|Provider|Gerenciador de estado global do Flutter (permite guardar informações de uma tele em uma classe espacial e depois passar essas informações à outras telas ou ao Banco de Dados)|
|DashBoard|Tela de resumo com dados do usuário|
|Hábito|Ação sustentável registrada no sistema|

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

O sistema é um aplicativo independente (standalone), sem necessidade de backend neste protótipo.

### 3.2 Funções do Produto

O sistema deverá:

- Exibir tela inicial de apresentação
- Permitir navegação entre telas
- Gerenciar hábitos pendentes e concluídos
- Atualizar automaticamente dados do dashboard
- Permitir configurações do usuário

### 3.3 Características do Usuário

Usuários esperados:

- Pessoas interessadas em sustentabilidade
- Usuários com conhecimento básico em aplicativos mobile

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