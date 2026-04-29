# Sistema de Eventos Acadêmicos

Sistema web desenvolvido para gerenciamento de eventos acadêmicos, permitindo o cadastro e administração de eventos, palestrantes e apresentações.

## Objetivo

Centralizar o controle de eventos acadêmicos em uma plataforma simples, organizada e de fácil utilização.

## Tecnologias Utilizadas

* **Backend:** PHP puro (PDO)
* **Banco de Dados:** MySQL
* **Frontend:** HTML5, CSS3 e JavaScript
* **Framework CSS:** Bootstrap 5

## Estrutura do Projeto

* `/assets` → arquivos estáticos (CSS, JS e imagens)
* `/config` → configuração de banco de dados
* `/database` → script SQL do banco
* `/includes` → componentes reutilizáveis
* `/pages` → páginas internas do sistema

## Funcionalidades Implementadas

* Login administrativo
* Dashboard principal
* Cadastro, edição, exclusão e listagem de eventos
* Cadastro de palestrantes
* Cadastro de apresentações
* Busca de eventos
* Área pública para visualização
* Layout responsivo

## Controle de Versão
Versão entregue referente à Iteração 2, identificada no repositório pela tag:
## v2


## Como Executar no XAMPP

1. Instale o XAMPP.
2. Inicie Apache e MySQL.
3. Copie a pasta do projeto para:

Windows:
`C:\xampp\htdocs\sistema-eventos`

Mac:
`/Applications/XAMPP/xamppfiles/htdocs/sistema-eventos`

4. Acesse phpMyAdmin:
   `http://localhost/phpmyadmin`

5. Importe o arquivo:

`database/banco.sql`

6. Verifique a conexão no arquivo:

`config/database.php`

7. Acesse no navegador:

`http://localhost/sistema-eventos`

## Usuário para Testes

**Email:** [admin@admin.com](mailto:admin@admin.com)
**Senha:** 123456

## Controle de Versão

Versão entregue referente à **Iteração 2** com tag:

`v2`

## Autor

Projeto acadêmico desenvolvido para a disciplina Prática Profissional em Análise e Desenvolvimento de Sistemas.
