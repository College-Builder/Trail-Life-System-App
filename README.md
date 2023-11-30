<div align="center">
  <a href="https://collegebuilder.easyvirtual.net/trail-life/s/system/administracao/dashboard">
    <img src='https://github.com/College-Builder/College-Builder/blob/main/global-assets/Trail-Life-System-App/logo.png' height='80'>
  </a>
</div>

<br/>
<br/>
<br/>

<p align="center">
A empresa de transporte fictícia "Trail Life" foi desenvolvida como parte do projeto integrador do terceiro semestre na Universidade de Sorocaba pelo grupo de alunos que estão aqui neste repositório. Este repositório abriga o código da aplicação backend, que inclui o site da Trail Life Aministração e APIs para conexão com o banco de dados.
</p>

<p align="center">
  <img src="https://img.shields.io/badge/version-1.0.0-blue" alt="version">
</p>

## Projeto 

<a href="https://collegebuilder.easyvirtual.net/trail-life/s/system/administracao/login/">
  <img src="https://github.com/College-Builder/College-Builder/blob/main/global-assets/Trail-Life-System-App/screenshot.1.png"/>
</a>

O projeto Trail Life Administração foi desenvolvido com fins acadêmicos, com o objetivo de aplicar os conhecimentos adquiridos em HTML, CSS, JavaScript, Bootstrap, AWS e API Gateway. O projeto consiste em uma landing page para uma transportadora fictícia, chamada Trail Life.

O sistema administrador de transportadora "Trail Life" é uma solução tecnológica abrangente desenvolvida para otimizar e aprimorar a gestão operacional de empresas de transporte e logística. Projetado com uma abordagem centrada na eficiência, o Trail Life oferece uma variedade de recursos e funcionalidades para simplificar e aperfeiçoar os processos administrativos e operacionai.

## Ferramentas 

O projeto foi desenvolvido usando as seguintes ferramentas e tecnologias:

- HTML (Hypertext Markup Language): Continua sendo a linguagem de marcação fundamental para estruturar o conteúdo da página web.
- CSS (Cascading Style Sheets): Mantém seu papel essencial na definição da aparência e estilo da página web.
- JavaScript: Ainda é utilizado para adicionar interatividade e funcionalidades dinâmicas à página web.
- Bootstrap: Foi integrado ao projeto para proporcionar uma abordagem ágil e responsiva no desenvolvimento do layout.
- Saas: Contribuiu para uma gestão mais eficiente e modular do código CSS.
- PHP: A utilização do PHP permitiu a implementação de lógicas complexas e manipulação de dados, contribuindo para a construção de um sistema coeso e funcional.
- MySQL: O MySQL foi estruturado de maneira a oferecer uma base sólida e confiável para a persistência de informações, assegurando a criptografia gerada pela aplicação, permitindo consultas eficientes e contribuindo para a integridade e segurança dos dados.

## Arquitetura Cloud

O diagrama da arquitetura do servidor cloud foi aprimorado para oferecer uma estrutura completa, aproveitando os seguintes serviços da AWS:

- AWS (Amazon Web Services): Continua sendo a plataforma de computação em nuvem principal, fornecendo escalabilidade e confiabilidade.
- VPC: Permite criar uma rede privada isolada, garantindo a segurança e o controle da comunicação.
- Route 53: Permanece encarregado do gerenciamento de domínios e DNS, garantindo uma navegação eficiente e segura.
- API Gateway: Através deste serviço, são criadas e gerenciadas as interfaces de programação de aplicativos, permitindo uma comunicação eficaz entre diferentes componentes da arquitetura.
- AWS EC2: Oferece capacidade computacional sob demanda, permitindo aos usuários criar e executar instâncias virtuais de servidores de acordo com suas necessidades específicas. 
- SES (Simple Email Service): Permanece como a solução para o envio de e-mails, garantindo a confiabilidade na comunicação com os usuários.
- RDS My SQL: Oferece uma base de dados gerenciada, escalável e altamente disponível.

<img src="https://github.com/College-Builder/College-Builder/blob/main/global-assets/Trail-Life-System-App/diagram.jpg"/>

## Setup

### Para configurar o projeto, basta seguir os passos abaixo:

1. Faça um clone do repositório usando o comando `git clone`.
2. Configure o arquivo `.env` com as variáveis de ambiente necessárias.
3. Instalar o APACHE no seu dispositivo.
4. Instalar o MySQL no seu dispositivo.

### Arquivo .env

```env
# ---------------------------------------------------------------------------------------------------------------------------------------------------
# --- Global ----------------------------------------------------------------------------------------------------------------------------------------
# ---------------------------------------------------------------------------------------------------------------------------------------------------

##
# SQL AUTH
##

# GRANT SELECT ON `trail_life`.`usuarios_adm_session` TO `global-validate-api-data`@`127.0.0.1`
# GRANT SELECT ON `trail_life`.`clientes` TO `global-validate-api-data`@`127.0.0.1`
# GRANT SELECT ON `trail_life`.`filiais` TO `global-validate-api-data`@`127.0.0.1`
# GRANT SELECT ON `trail_life`.`cargas` TO `global-validate-api-data`@`127.0.0.1`
# GRANT SELECT ON `trail_life`.`motoristas` TO `global-validate-api-data`@`127.0.0.1`
SQL_HOST_GLOBAL_VALIDATE_API_DATA='127.0.0.1' 
SQL_USER_GLOBAL_VALIDATE_API_DATA='global-validate-api-data'
SQL_PASSWORD_GLOBAL_VALIDATE_API_DATA=<Senha de 12 caracteres>
SQL_DATABASE_GLOBAL_VALIDATE_API_DATA='trail_life'

# ---------------------------------------------------------------------------------------------------------------------------------------------------
# --- Administracao ---------------------------------------------------------------------------------------------------------------------------------
# ---------------------------------------------------------------------------------------------------------------------------------------------------

##
# CYPHER KEYS
##

# Usuarios ADM Session
USUARIOS_ADM_SESSION_TOKEN_CYPHER_KEY=<Senha de 66 caracteres>

# Usuarios ADM
USUARIOS_ADM_EMAIL_CYPHER_KEY=<Senha de 66 caracteres>

# Clientes
CLIENTES_CNPJ_CYPHER_KEY=<Senha de 66 caracteres>
CLIENTES_ESTADO_CYPHER_KEY=<Senha de 66 caracteres>
CLIENTES_CIDADE_CYPHER_KEY=<Senha de 66 caracteres>
CLIENTES_RUA_CYPHER_KEY=<Senha de 66 caracteres>
CLIENTES_NUMERO_CYPHER_KEY=<Senha de 66 caracteres>
CLIENTES_CELULAR_CYPHER_KEY=<Senha de 66 caracteres>
CLIENTES_EMAIL_CYPHER_KEY=<Senha de 66 caracteres>

# Motoristas
MOTORISTAS_CELULAR_CYPHER_KEY=<Senha de 66 caracteres>
MOTORISTAS_NOME_EMERGENCIA_CYPHER_KEY=<Senha de 66 caracteres>
MOTORISTAS_CELULAR_EMERGENCIA_CYPHER_KEY=<Senha de 66 caracteres>
MOTORISTAS_EMAIL_EMERGENCIA_CYPHER_KEY=<Senha de 66 caracteres>

##
# SQL AUTH
##

# GRANT SELECT, INSERT ON `trail_life`.`usuarios_adm_session` TO `administracao-login`@`127.0.0.1`
# GRANT SELECT ON `trail_life`.`usuarios_adm` TO `administracao-login`@`127.0.0.1`                                           
SQL_HOST_ADMINISTRACAO_LOGIN='127.0.0.1' 
SQL_USER_ADMINISTRACAO_LOGIN='administracao-login'
SQL_PASSWORD_ADMINISTRACAO_LOGIN=<Senha de 12 caracteres>
SQL_DATABASE_ADMINISTRACAO_LOGIN='trail_life'

# GRANT SELECT ON `trail_life`.`usuarios_adm` TO `administracao-dashboard`@`127.0.0.1`
# GRANT SELECT ON `trail_life`.`usuarios_adm_session` TO `administracao-dashboard`@`127.0.0.1`
# GRANT SELECT ON `trail_life`.`cargas` TO `administracao-dashboard`@`127.0.0.1`
# GRANT SELECT ON `trail_life`.`clientes` TO `administracao-dashboard`@`127.0.0.1`
# GRANT SELECT ON `trail_life`.`motoristas` TO `administracao-dashboard`@`127.0.0.1`
# GRANT SELECT ON `trail_life`.`filiais` TO `administracao-dashboard`@`127.0.0.1`
SQL_HOST_ADMINISTRACAO_DASHBOARD='127.0.0.1' 
SQL_USER_ADMINISTRACAO_DASHBOARD='administracao-dashboard'
SQL_PASSWORD_ADMINISTRACAO_DASHBOARD=<Senha de 12 caracteres>
SQL_DATABASE_ADMINISTRACAO_DASHBOARD='trail_life'

# GRANT INSERT, SELCT ON `trail_life`.`usuarios_adm` TO `administracao-add`@`127.0.0.1`
# GRANT INSERT, SELECT ON `trail_life`.`clientes` TO `administracao-add`@`127.0.0.1`
# GRANT INSERT, SELECT, UPDATE ON `trail_life`.`motoristas` TO `administracao-add`@`127.0.0.1`
# GRANT INSERT, SELECT ON `trail_life`.`cargas` TO `administracao-add`@`127.0.0.1`
# GRANT SELECT ON `trail_life`.`filiais` TO `administracao-add`@`127.0.0.1`
SQL_HOST_ADMINISTRACAO_ADD='127.0.0.1' 
SQL_USER_ADMINISTRACAO_ADD='administracao-add'
SQL_PASSWORD_ADMINISTRACAO_ADD=<Senha de 12 caracteres>
SQL_DATABASE_ADMINISTRACAO_ADD='trail_life'

# GRANT SELECT ON `trail_life`.`usuarios_adm` TO `administracao-get`@`127.0.0.1`
# GRANT SELECT ON `trail_life`.`clientes` TO `administracao-get`@`127.0.0.1`
# GRANT SELECT ON `trail_life`.`motoristas` TO `administracao-get`@`127.0.0.1`
# GRANT SELECT ON `trail_life`.`cargas` TO `administracao-get`@`127.0.0.1`
# GRANT SELECT ON `trail_life`.`filiais` TO `administracao-get`@`127.0.0.1`
SQL_HOST_ADMINISTRACAO_GET='127.0.0.1' 
SQL_USER_ADMINISTRACAO_GET='administracao-get'
SQL_PASSWORD_ADMINISTRACAO_GET=<Senha de 12 caracteres>
SQL_DATABASE_ADMINISTRACAO_GET='trail_life'

# GRANT SELECT, UPDATE ON `trail_life`.`usuarios_adm` TO `administracao-update`@`127.0.0.1`
# GRANT SELECT, UPDATE ON `trail_life`.`clientes` TO `administracao-update`@`127.0.0.1`
# GRANT SELECT, UPDATE ON `trail_life`.`motoristas` TO `administracao-update`@`127.0.0.1`
# GRANT SELECT, UPDATE ON `trail_life`.`cargas` TO `administracao-update`@`127.0.0.1`
SQL_HOST_ADMINISTRACAO_UPDATE='127.0.0.1' 
SQL_USER_ADMINISTRACAO_UPDATE='administracao-update'
SQL_PASSWORD_ADMINISTRACAO_UPDATE=<Senha de 12 caracteres>
SQL_DATABASE_ADMINISTRACAO_UPDATE='trail_life'

# GRANT SELECT, UPDATE ON `trail_life`.`usuarios_adm` TO `administracao-del`@`127.0.0.1`
# GRANT SELECT, DELETE ON `trail_life`.`usuarios_adm_session` TO `administracao-del`@`127.0.0.1`
# GRANT SELECT, UPDATE ON `trail_life`.`clientes` TO `administracao-del`@`127.0.0.1`
# GRANT SELECT, UPDATE ON `trail_life`.`motoristas` TO `administracao-del`@`127.0.0.1`
# GRANT SELECT, UPDATE ON `trail_life`.`cargas` TO `administracao-del`@`127.0.0.1`
SQL_HOST_ADMINISTRACAO_DEL='127.0.0.1' 
SQL_USER_ADMINISTRACAO_DEL='administracao-del'
SQL_PASSWORD_ADMINISTRACAO_DEL=<Senha de 12 caracteres>
SQL_DATABASE_ADMINISTRACAO_DEL='trail_life'
```

## License

This script is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

Feel free to use, modify, and distribute this script as per the terms of the license.

[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT)
