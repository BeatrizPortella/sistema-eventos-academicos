# Sistema de Eventos Acadêmicos

Sistema web completo para gerenciamento de eventos acadêmicos, palestrantes e apresentações.
Desenvolvido com PHP puro, MySQL, HTML5, CSS3, Bootstrap 5 e JavaScript.

## Tecnologias Utilizadas
- **Backend:** PHP (PDO)
- **Banco de Dados:** MySQL
- **Frontend:** HTML5, CSS3, JavaScript
- **Framework CSS:** Bootstrap 5

## Estrutura do Projeto
- `/assets`: Arquivos estáticos (CSS, JS, Imagens).
- `/config`: Configurações de banco de dados.
- `/database`: Arquivos relacionados ao banco de dados (SQL).
- `/includes`: Componentes reutilizáveis (Header, Footer, Autenticação).
- `/pages`: Telas restritas do sistema (CRUDs, Dashboard).

## Instruções de Instalação no XAMPP

1. **Baixe e instale o XAMPP:** Certifique-se de que o Apache e o MySQL estão rodando.
2. **Clone ou mova o projeto:** Coloque a pasta `sistema-eventos` dentro do diretório `htdocs` do seu XAMPP (ex: `C:\xampp\htdocs\sistema-eventos` no Windows ou `/Applications/XAMPP/xamppfiles/htdocs/sistema-eventos` no Mac).
3. **Configure o Banco de Dados:**
   - Acesse o phpMyAdmin: `http://localhost/phpmyadmin/`
   - Importe o arquivo `banco.sql` localizado na pasta `database/`. Isso criará o banco `sistema_eventos` e as tabelas necessárias, além de inserir o usuário admin padrão.
4. **Configure a Conexão:**
   - Verifique o arquivo `config/database.php`. Se o usuário do MySQL do seu XAMPP for diferente de `root` ou possuir senha, altere essas informações lá.
5. **Acesso:**
   - Acesse o sistema pelo navegador: `http://localhost/sistema-eventos/`
   - O login padrão do administrador é:
     - **Email:** admin@admin.com
     - **Senha:** 123456

## Funcionalidades
- Área pública para visualizar e buscar eventos.
- Área administrativa protegida por login.
- Gestão completa (CRUD) de Eventos, Palestrantes e Apresentações.
- Layout responsivo e moderno.
