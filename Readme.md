#HighAvailabilitySystem

##Escopo
Esse projeto tem por objetivo orquestrar ,com alta disponibilidade, hospedar sistema de de cadastro de colaboradores. 

##Quanto ao Ambiente
Projeto hospedado no Azure. Para tal foi utilizado uma instancia de Máquina Virtual.

Porque Máquina Virtual e não Docker as Service?

Em uma máquina virtual, mesmo na nuvem, seria possível simular as condições reais de performance e comportamento. Tornando possível e fácil a migração para um ambiente on premises

Configurações da Máquina Virtual: 

Nome do computador: containers
Sistema operacional: Linux (debian 10.4)
Endereço IP público: 40.84.187.192
Disco: SSD 120 GB
Mem.: 8GB

Containers:

Ambiente foi configurado com 8 Container's no total, distribuidos em camadas.

 - Prometheus: controle de porformance dos containers, através da geração de Logs.
 - Cadvisor: Trabalha ligado ao redis, gerando graficos em tempo real de acordo com os dados coletados pelo redis
 - Readis: Faz a coleta dos dados das instâncias em docker
 - 
