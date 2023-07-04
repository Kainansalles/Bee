# ms-beedoo
*ms-beedoo* é o serviço responsável por permitir que usuário publique mensagens e estas apareçam no feed por meio de uma listagem dos 10 últimos posts.

### 📈 Principais funcionalidades

O projeto trata-se de uma avaliação da etapa 01 do processo seletivo para vaga de Dev Senior da Beedoo e possui alguns requisitos, sendo:

- [x] Criar uma rota POST, onde usuários (em anonimato) podem postar mensagens de texto de no máximo 300 caracteres;
- [x] Criar uma rota GET, que por padrão liste as últimas 10 mensagens, possibilite paginação, e pesquisa por palavras chave;

## DOCUMENTAÇÃO

### 💻 Informações relevantes

Este projeto utilizará as seguintes tecnologias:

- PHP (Laravel)
- Banco de dados (MySQL)
- Docker


### Iniciando serviço local
- Após clonar o projeto, entre na pasta na raiz do mesmo

# Para subir o serviço
Execute o comando abaixo para criar o .env

```
cp .env.example .env
```

Exeute o comando abaixo para criar a rede do docker do projeto
```
docker network create beedoo-network
```

Altere o arquivo /etc/vhosts e adicione:
```
127.0.0.1       beedoo-mysql
```

Buildando o projeto:
```
docker-compose up -d --build
```

Execute as migrations e seed do projet:
```
php artisan migrate:fresh --seed
```

Para rodar os testes, execute o comando abaixo:
```
php artisan test
```

### ✅ Exemplo de payload para criar mensagem
POST - api/v1/feed/create-message

```
{
    "consumer_id": "1",
    "message": "xpto",
    "anonymous": false
}
```

### ✅ Exemplo de payload para buscar o feed
GET - api/v1/feed

Pode ser enviado os seguintes campos como parâmetro na URL

|  Campo  |  Funcionalidade  |
|:-------:|:----------------:|
| keyword | Filtrar mensagem |
|  page   |    Paginação     |


## Servidores e Portas
|   Serviço    | porta |
|:------------:|:----:|
|  beedoo.api  |  80  |
| beedoo.mysql | 3306 |

## Arquitetura
- *Criacao de interfaces:* A criação de interfaces facilitou os testes bem como manteve um contrato, o que permite - caso seja necessário - que mais de uma pessoa mexa no mesmo fluxo, otimizando assim o trabalho.
- Separacao de responsabilidades: Desde o inicio do desenvolvimento da API é importante criar classes com responsabilidades separadas para facilitar a manutencao, escalabilidade e testabilidade. Assim, se desenvolvessemos a parte dos comentários, estes teriam controller, services e demais classes apartadas.

#  Melhorias

No futuro queremos permitir que os usuários possam adicionar comentários as mensagens. Por isso será necessário:

## Melhorias técnicas 💻

### Banco de dados:

Será necessário a criacao de uma *nova tabela no banco de dados* relacionada a tabela  `feed` para permitir o armazenamento dos comentários. Podemos nomear o mesmo como **feed_comments**.
Será interessante criar uma coluna com a *data da publicacao, bem como o **texto do comentário*.

### API:

Precisaremos criar novas rotas em nossa API. Uma rota de POST permitirá que os usuários enviem o novo comentário com uma determinada mensagem.
Além disso, precisaremos criar uma rota GET para consulta do comentário. Gostaria de sugerir ainda a implementacao de uma
rota GET para consultar a lista de comentários com base em palavras-chave, já que no caso desta API possivel listar por
usuários, uma vez que estes sao anonimos.

Também podemos verificar com o time de produtos se o usuário poderá editar ou excluir as mensagens e comentários, o que
fará com que criemos rotas de edicao do comentário (PATH - parcial / PUT - total) ou a exclusao do comentário (DELETE).

### Cache

Assim reduziremos a carga no banco de dados com o aumento de consultas de mensagens e comentários. A implementacao de cache de dados permitirá o melhor
desempenho da API.

### Expurgo

Criar expurgos automáticos para deixar a base quente menor

### Quais melhorias poderiam ser empregadas ao projeto se tivesse mais tempo:
- Testes de integração.
- Separar camada de provider para Repository e Service.

## Principais desafios 📈

### 1️⃣ Escalabilidade

Em decorrencia do número de comentários e mensagens precisamos nos preparar para possíveis desafios de desempenho e escalabilidade.

### 2️⃣ Controle de acesso

Como as postagens serão de forma anonima é necessário validar com o time de produtos se faz-se necessário implementar o uso
de tokens para garantir que apenas usuários autorizados possam postar comentários e mensagens.

### 3️⃣ Relacionamento entre tabelas

De mensagens e comentários.

### 4️⃣ Monitoramento de desempenho

Será necessário implementar ferramentas de monitoramento de desempenho da API em producao. Através de ferramentas como New Relic, Datadog e etc poderemos criar métricas relevantes
como tempo de resposta, tempo médio de processamento, taxas de erros, dentre outros pontos que analisaremos em conjunto com o time e necessidades da empresa.

## Principais questionamentos ao time de produtos 👨‍💻🚀

O alinhamento com o time de produtos é essencial. Em minha experiencia como desenvolvedor sempre trabalhei lado a lado com o time de produtos, por isso questionaria:

- Os comentários também serão anônimos?
- Qualquer pessoal pode publicar mensagens e comentários ou devemos exigir autenticação?
- Os usuários devem poder editar ou excluir seus comentários e mensagens posteriormente?
- Existe algum limite de tempo ou restrição para essas ações?
- Um comentário será associado a apenas uma mensagem ou a várias?
- Desejamos implementar um comentário associado a outro comentário? Como se fosse uma thread ou resposta ao comentário inicial?
- Os comentários devem ser classificados por data de criação (o mais recente ou mais antigo) ou de outra forma (implementar uma avaliacao do comentário por usuários e classificá-lo por classificacao de relevancia, por exemplo)?
- A lista de mensagens será dos 10 últimos Posts. O mesmo ocorrerá com os comentários? Qual será o número de comentários exibidos?
- Os usuários devem receber notificações quando novos comentários forem adicionados?

## Principais questionamentos ao time de Devops 🤖

_Acredito que o alinhamento com o time de Devops também é essencial, uma vez que cada empresa trabalha de uma forma bem como tem suas métricas
e hitóricos para lidar com possíveis problemas. Prevenir que nossa API sofra com uma alta demanda é tao importante quanto novas implementacoes
de funcionalidades._ Por isso eu perguntaria ao time de Devops:

- Como podemos configurar a infraestrutura e o ambiente de implantação para lidar com o aumento de tráfego e de dados à medida que mais usuários começarem a usar o sistema de mensagens e comentários?
- Quais estratégias de escalabilidade e balanceamento de carga devemos considerar?

## Principais questionamentos ao Tech lead 💻

- Qual tempo devemos manter para o cache?
- Quanto tempo devemos manter na base quente?
