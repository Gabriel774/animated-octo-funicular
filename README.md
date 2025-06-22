# Teste Técnico — Bussola Social

Este projeto foi desenvolvido como parte do teste técnico para a Bussola Social, seguindo boas práticas de desenvolvimento, testes automatizados e documentação clara.

## 🚀 Tecnologias Utilizadas

* **PHP 8.2**
* **Laravel Framework**
* **Docker** e **Docker Compose** (para ambientes consistentes e replicáveis)
* **Composer** (gerenciador de dependências PHP)
* **PHPUnit** (testes automatizados)
* **Insomnia** (documentação e testes manuais via arquivo `insomnia-docs.json`)

## ⚡ Pré-requisitos

* [Docker](https://www.docker.com/) instalado

## ▶️ Executando o Projeto

Clone o repositório, acesse o diretório do projeto e execute o seguinte comando para subir os containers Docker:

```sh
docker compose up -d --build
```

Após subir o ambiente, a aplicação ficará acessível pelo endereço:

```
http://localhost:8000
```

## 📄 Documentação da API

A documentação da API está disponível no arquivo [`insomnia-docs.json`](./insomnia-docs.json). Para visualizar e testar as requisições, importe esse arquivo no [Insomnia](https://insomnia.rest/).

## 💸 Regras de Arredondamento Monetário

Todos os valores monetários nesta aplicação seguem rigorosamente as recomendações do Banco Central do Brasil:

* Os valores monetários são truncados, ou seja, os decimais excedentes são descartados.
* Para cálculos envolvendo parcelas, como juros compostos, o arredondamento ocorre mês a mês, conforme a lógica bancária vigente.

## 🧪 Testes Automatizados

Para executar os testes unitários e de integração, certifique-se de que o ambiente Docker está ativo e execute o seguinte comando no root do projeto:

```sh
docker compose exec app php artisan test
```

## ✨ Observações

* O uso do Docker facilita o desenvolvimento e garante uma execução consistente em qualquer ambiente.
* O código foi organizado de maneira clara e estruturada, permitindo fácil compreensão e manutenção das regras de negócio e cálculos financeiros implementados.
