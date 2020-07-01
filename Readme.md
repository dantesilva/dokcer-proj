# HighAvailabilitySystem

## Escopo
Esse projeto tem por objetivo orquestrar ,com alta disponibilidade, e hospedar sistema de de cadastro de colaboradores. 

## Quanto ao Ambiente
Projeto hospedado no Microsoft Azure. Para tal foi utilizado uma instancia de Máquina Virtual.

###  1. Máquina Virtual: 

A máquina virtual foi utilizada apenas para conter o ambiênte. Porém o ambiente não é baseado em máquinas virtuais, e sim em Docker container.

#### Configuração

Nome do computador: containers
Sistema operacional: Linux (debian 10.4)
Endereço IP público: 40.84.187.192
Disco: SSD 120 GB
Mem.: 8GB

### Porque Máquina Virtual e não Docker a as Service?

Em uma máquina virtual, mesmo na nuvem, seria possível simular as condições reais de performance e comportamento. Tornando possível e fácil a migração para um ambiente on premises.



###  2. Containers:

Ambiente foi configurado com 8 Container's no total, distribuidos em camadas. Podemos separar em três câmadas. Duas de monitoramento e segurança e uma de aplicação

#### Camada Monitoramente - Prometheus

 - Prometheus: controle de porformance dos containers, através da geração de Logs;
 - Cadvisor: Trabalha ligado ao redis, gerando graficos em tempo real de acordo com os dados coletados pelo redis;
 - Readis: Faz a coleta dos dados das instâncias em docker e armazena em seu banco;

#### Camada de monitoramento - Graylog

Essa camada de monitoramento está sendo realizada diretamente no "Sistema Operacional" das instâncias, por meio do Rsyslog. A instância de monitoramento Graylog é composta pelas seguintes aplicações:
 - Graylog: Aplicação centrelizadora de Logs;
 - Elasticsearch: Funciona juntamente com o Greaylog. 
 - Mongo DB: Banco de dados Essencial para o funcionamento do Graylog.

#### Camada de Aplicação

Na camada de aplicação temos três containers. Um com php/Apache e outro com PHPMyAdmin
 - PHP/ Apache: Uma instância dedicada somente para o PHP e Apache;
 - PHPMyAdmin: Instância rodando o frontend PHPMy Admin;
    - Observação: Particularmente não recomendo o trabalho com PHPMyAdmin, devido a algumas falhas de segurança bem exploradas por       cibercriminosos. Quando uso, faço somente atráves de túnnel, para garantir a segurança;
 - Mysql: Uma instância dedicada ao Mysql, que vai receber os dados cadastrados no formulário do FrontEnd;

#### Diretórios Mapeados

Para o Projeto, foram mapeados alguns diretórios, de forma a grantir a não volatilidade dos dados. Ou seja, para que sejam preservados, mesmo se o container for parado, ou até mesmo exlcuído. Os diretórios seguem uma estrutura, conforme se segue:
- docker-proj - Diretório raiz;
    -  Mysql-Data - Arquivos do Banco Mysql da Aplicação;
    - prometheus - Pasta de arquivo de configuração do prometheus;
        - prometheus.yml - Arquivo de configuração para comunicação com o CardVisor;
    - rsyslog - Pasta com arquivo rsyslog.conf, compartilhado com todas as instâncias para envio de Logs para o Graylog;
    - docker-compose.yml - Arquivo de configuração geral do Docker Compose para carregamento dos serviços;
    - Dockerfile - Arquivo usado para personalizar as imagens;
    - Readme.md - Arquivo de documentação do projeto;

#### Portas de comunicação

As aplicações estão com as portas padrão de comunicação mapeadas. 

#### Aplicações/ Instâncias FrontEnd

Conforme falado anteriormente, cada aplicação tem uma função específca no ambiene. O acesso a cada aplicação deve ser através dos seguintes endereços:

Graylog: http://40.84.187.192:9000

Prometheus: http://40.84.187.192:9090

Cardvisor: http://40.84.187.192:8080

Quanto as outras aplicações, elas tem portas de comunicação apenas dentro do próprio ambiente. Não estão abertas ao "mundo exterior", pois seus dados são interprados pelas aplicações FrontEnd acima. Essas aplicações não requerem interatividade e  podem ser conferidas no arquvo docker-compose.yml, que consta nesse repositório. 

#### Aplicação PHP 

http://40.84.187.192/msg

http://40.84.187.192/colaboradores

O primeiro link acesso aplicação para envio de mensagens. 
O segundo link é para cadastro de colaboradores - Exemplificando por exemplo colaboradores em um Hospital. Esses colaboradores podem ser funcionarios e terceiros.
    Dados de acesso para a aplicação colaboradores:

        Usuario: Admin
       
        Senha: asdf



     
