# 💸 Sistema de Transferências com Autenticação - Laravel

Este projeto é um sistema de transferências financeiras entre usuários, com autenticação via tokens, verificação de autorização em gateway externo e testes automatizados.

---

## 📄 Documentação

Dentro da pasta docs do projeto, pode-se encontrar imagens com o modelo conceitual do banco de dados, requisitos, regras de negócio e diagrama de caso de uso, bem como, acessando:

http://127.0.0.1/api/documentation


Está presente a documentação dos endpoints, gerado pelo Swagger

## 🚀 Funcionalidades

- Cadastro de usuários (`COMMON` e `SHOPKEEPER`)
- Autenticação com Sanctum
- Transferência entre usuários com verificação de saldo e autorização externa
- Notificação via API
- Validações robustas
- Testes automatizados (unit e feature)
- Pipeline CI com GitHub Actions

---

## 📦 Requisitos

- PHP >= 8.3
- Composer
- Laravel >= 12
- MySQL
- SQLite (para testes locais)
- Git

OU ENTÂO UTILIZE O

- 🐋 DOCKER COM SAIL

---

## ⚙️ Instalação e Execução

```bash
# Clone o repositório
git clone https://github.com/dilsoncampelo10/pagarFacil
cd pagarFacil

# Instale as dependências
composer install

# Copie o .env de exemplo e gere a chave
cp .env.example .env
php artisan key:generate

# Rode as migrations
php artisan migrate

# Rode o servidor local
php artisan serve

```
## 🐋 Utilizando SAIL

```bash
# Crie um ALIAS (OPCIONAL)
alias = "./vendor/bin/sail"

# Rode o container
sail up
# Rode o servidor
sail artisan serve
#Realize os testes
sail artisan test

```
