# CRUD de Tarefas com PHP, MySQL e Docker

Aplicação web simples para cadastrar, listar e excluir tarefas. O ambiente é executado com Docker Compose: um container Apache/PHP e um container MySQL.

## Funcionalidades disponíveis

- Cadastrar uma tarefa com nome e descrição opcional;
- Listar as tarefas, da mais recente para a mais antiga;
- Excluir uma tarefa;
- Criar automaticamente a tabela `tarefas` ao acessar a aplicação.

> O projeto possui um link de **Editar** na listagem, mas o arquivo `edit.php` ainda não existe. Portanto, a edição não está disponível na versão atual.

## Pré-requisitos

- [Docker Desktop](https://www.docker.com/products/docker-desktop/) instalado e em execução;
- Git, apenas para clonar o repositório.

Não é necessário instalar PHP, Apache ou MySQL na máquina.

## Como executar

1. Clone o repositório e entre na pasta criada:

   ```bash
   git clone https://github.com/ArturOnofreLupepsa/DockerPHP.git
   cd DockerPHP
   ```

2. Construa a imagem da aplicação e inicie os containers em segundo plano:

   ```bash
   docker compose up -d --build
   ```

3. Confira se os serviços estão em execução:

   ```bash
   docker compose ps
   ```

4. Aguarde o MySQL terminar sua inicialização. Na primeira execução isso pode levar alguns segundos. Caso a página mostre falha de conexão, aguarde e atualize-a. Para acompanhar os logs, use:

   ```bash
   docker compose logs -f db
   ```

   Use `Ctrl+C` para parar apenas a visualização dos logs.

5. Abra a aplicação no navegador:

   ```text
   http://localhost:8080
   ```

Ao abrir a página, o arquivo `src/db.php` conecta-se ao banco `planner` e executa a criação da tabela `tarefas` caso ela ainda não exista.

## Encerrar e reiniciar

Para parar e remover os containers, mantendo os dados do banco:

```bash
docker compose down
```

Para iniciar novamente depois:

```bash
docker compose up -d
```

Os dados são preservados no volume nomeado `DockerPHP`.

### Apagar todos os dados (opcional)

O comando abaixo remove também o volume do MySQL e, por isso, apaga permanentemente todas as tarefas:

```bash
docker compose down -v
```

Depois, execute `docker compose up -d --build` para criar um ambiente novo.

## Estrutura do projeto

```text
.
├── Dockerfile
├── docker-compose.yml
└── src/
    ├── db.php       # Conexão PDO e criação da tabela
    ├── index.php    # Listagem das tarefas
    ├── create.php   # Cadastro de tarefas
    └── delete.php   # Exclusão de tarefas
```

## Serviços Docker

| Serviço | Tecnologia | Função |
| --- | --- | --- |
| `app` | PHP 8.4 com Apache | Executa a aplicação e a expõe em `http://localhost:8080`. |
| `db` | MySQL 8.0 | Armazena o banco `planner` e as tarefas. |

Os dois serviços usam a rede bridge `planner_rede`. Por isso, a aplicação usa `db` como host do banco, sem depender de IP fixo.

O código em `./src` é montado em `/var/www/html` no container `app`; alterações nos arquivos PHP locais são refletidas sem reconstruir a imagem.

## Configuração do banco

As variáveis são definidas diretamente em `docker-compose.yml`:

| Variável | Valor | Uso |
| --- | --- | --- |
| `DB_HOST` | `db` | Host do MySQL na rede Docker. |
| `DB_USER` | `root` | Usuário de conexão. |
| `DB_PASSWORD` | `root` | Senha de conexão. |
| `DB_NAME` | `planner` | Banco utilizado pela aplicação. |

Para uso local/educacional, as credenciais ficam no Compose. Em produção, use segredos e não exponha senhas no repositório.

## Solução de problemas

- **A porta 8080 está ocupada:** altere o mapeamento `8080:80` no `docker-compose.yml`, por exemplo para `8081:80`, e acesse a nova porta.
- **Erro de conexão com o banco:** execute `docker compose ps` e `docker compose logs db`; aguarde o MySQL ficar pronto e atualize a página.
- **Reconstruir a imagem PHP:** use `docker compose up -d --build` após alterar o `Dockerfile`.

## Autores

- Artur Vinicius
- Bruno Januário
- Lucas Dantas
