# 🐦 Twitter Clone em PHP

Um clone simplificado do Twitter, desenvolvido com PHP puro e arquitetura MVC. A aplicação permite que os usuários se cadastrem, façam login, publiquem "tweets" e sigam outros usuários.

## 📝 Observação

Este projeto foi desenvolvido como parte de um curso para aprimorar meus conhecimentos em PHP, aplicando os conceitos de um miniframework MVC construído do zero. O código foi digitado por mim, com base nas aulas, e não é uma cópia direta.

## 🚀 Tecnologias Utilizadas

-   **PHP 7+:** Linguagem de programação principal.
-   **Arquitetura MVC:** Padrão de projeto para organização do código, utilizando o miniframework base.
-   **MySQL:** Banco de dados para persistência de usuários, tweets e seguidores.
-   **Composer:** Gerenciador de dependências para o autoload.

## ⚙️ Como Rodar o Projeto

### Pré-requisitos

-   PHP 7 ou superior
-   MySQL
-   Composer

### Passo a Passo

1.  **Clone o repositório:**
    ```bash
    git clone <URL_DO_REPOSITORIO>
    ```
2.  **Navegue até o diretório do projeto:**
    ```bash
    cd twitter-clone
    ```
3.  **Instale as dependências do Composer:**
    ```bash
    php composer.phar install
    ```
    ou, se tiver o Composer instalado globalmente:
    ```bash
    composer install
    ```
4.  **Configuração do Banco de Dados:**
    -   Crie um banco de dados no seu servidor MySQL.
    -   Execute as queries presentes no arquivo `querys.sql` para criar as tabelas `usuarios`, `tweets` e `usuarios_seguidores`.
    -   **Importante:** Configure as credenciais de acesso ao banco de dados no arquivo `App/Connection.php`.

5.  **Inicie o servidor (usando o servidor embutido do PHP):**
    -   Navegue até a pasta `public`:
        ```bash
        cd public
        ```
    -   Execute o comando:
        ```bash
        php -S localhost:8000
        ```
6.  **Acesse a aplicação em seu navegador: `http://localhost:8000`**

## 📂 Estrutura do Projeto

```text
twitter-clone/
├── App/
│   ├── Controllers/     # Controladores (lógica da aplicação)
│   ├── Models/          # Modelos de dados
│   └── Connection.php   # Configuração da conexão com o banco de dados
├── public/
│   └── index.php        # Ponto de entrada (Front Controller)
├── vendor/
│   └── MF/              # Núcleo do miniframework
├── composer.json
├── querys.sql           # Script de criação do banco de dados
└── README.md
```

## 📄 Licença

Este projeto está sob a licença MIT. Consulte o arquivo [LICENSE](LICENSE) para obter mais detalhes.