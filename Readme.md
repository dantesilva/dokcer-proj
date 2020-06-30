# HighAvailabilitySystem

## Escopo
Esse projeto tem por objetivo orquestrar ,com alta disponibilidade, e hospedar sistema de de cadastro de colaboradores. 

## Quanto ao Ambiente
Projeto hospedado no Azure. Para tal foi utilizado uma instancia de Máquina Virtual.

### Porque Máquina Virtual e não Docker as Service?

Em uma máquina virtual, mesmo na nuvem, seria possível simular as condições reais de performance e comportamento. Tornando possível e fácil a migração para um ambiente on premises

### Configurações da Máquina Virtual: 

Nome do computador: containers
Sistema operacional: Linux (debian 10.4)
Endereço IP público: 40.84.187.192
Disco: SSD 120 GB
Mem.: 8GB

### Containers:

Ambiente foi configurado com 8 Container's no total, distribuidos em camadas. POdemos separar em três câmdas. Duas de monitoramento e segurança e uma de aplicação

#### Camada Monitoramente - Prometheus
 - Prometheus: controle de porformance dos containers, através da geração de Logs;
 - Cadvisor: Trabalha ligado ao redis, gerando graficos em tempo real de acordo com os dados coletados pelo redis;
 - Readis: Faz a coleta dos dados das instâncias em docker e armazena em seu baco;

#### Camada de monitoramento Graylog

Essa camada de monitoramento está sendo realizada diretamente no "Sistema Operacional" das instâncias, por meio do Rsyslog. A instância de monitoramento Graylog é composta pelas seguintes aplicações:
 - Graylog: Aplicação centrelizadora de Logs;
 - Elasticsearch: Funciona juntamente com o Greaylog. 
 - Mongo DB: Banco de dados Essencial para o funcionamento do Graylog

#### Camada de Aplicação

Na camada de aplicação temos três containers. Um com php/Apache e outro com PHPMyAdmin
 - PHP/ Apache: Uma instância dedicada somente para o PHP e Apache;
 - PHPMyAdmin: Instância rodando o frontend PHPMy Admin.
    - Observação: Particularmente não recomendo o trabalho com PHPMyAdmin, devido a algumas falhas de segurança bem exploradas por       cibercriminosos. Quando uso, faço somente atráves de túnnel, para garantir a segurança.
 - Mysql: Uma instância dedicada ao Mysql, que vai receber os dados cadastrados no formulário do FrontEnd

### Diretórios Mapeados

Para o Projeto, foram mapeados alguns diretórios, de forma a grantir a não volatilidade dos dados. Ou seja, para que sejam preservados, mesmo se o container for parado, ou até mesmo exlcuído. Os diretórios seguem uma estrutura, conforme se segue:
 - 
