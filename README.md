# :tickets: Compra Online de Ingressos - Banco de Dados

Este projeto foi desenvolvido como trabalho avaliativo da disciplina de Banco de Dados. O site foi desenvolvido utilizando a linguagem de marcação HMTL, CSS para estilização, javascript e PHP para integração com o banco de dados.

Proposta do site: armazenar dados referentes a compra de ingressos de eventos oferecidos pelas empresas parceiras.

#### Equipe
:woman_technologist: [@Caroline-Camargo](https://github.com/Caroline-Camargo) <br />
:woman_technologist: [@majudlorenzoni](https://github.com/majudlorenzoni) <br />
:woman_technologist: [@Yasmin-Camargo](https://github.com/Yasmin-Camargo) <br />

## :gear: Configuração para Executar o Site com PHP

### Instalando PHP

1. Instale o PHP a partir deste link: [Download do PHP](https://windows.php.net/download#php-8.2), escolhendo a opção "zip" (para Windows).

2. Extraia o arquivo .zip baixado, entre na pasta extraída e copie o caminho para o diretório.

3. Digitar na barra de pesquisa do windows "editar variaveis de ambiente do sistema", Clique em "Variáveis de ambiente" e selecione a variável "Path". Clique em "Editar" e depois em "Novo". Cole o caminho que você copiou anteriormente e pressione "OK".

4. Para verificar se a instalação foi bem-sucedida, abra o terminal e digite o comando:

   ```sh
   php -v
Deverá ser exibida a versão do PHP instalada.


### Conectar ao Banco de Dados PostgreSQL na Máquina
1. Verifique se o PostgreSQL está configurado nas variáveis de ambiente. Caso contrário, encontre a pasta bin na instalação do PostgreSQL, copie o caminho e adicione às variáveis de ambiente. O caminho para a pasta bin geralmente é semelhante a: C:\Program Files\PostgreSQL\versao\bin

2. Abra o arquivo php.ini (localizado na pasta de instalação do PHP) em um editor de texto. Se o arquivo php.ini não existir, mas houver um arquivo php.ini-developer, renomeie o último para php.ini.

3. Adicione ou descomente as seguintes linhas para habilitar as extensões PDO e PDO_PGSQL:
    ```sh
        extension="C:\caminho\para\ext\php_pdo_pgsql.dll"
        extension="C:\caminho\para\ext\php_pgsql.dll"
Substitua C:\caminho\para\ext pelo caminho real para a pasta de extensões do PHP.

Agora, o site deve estar acessível com as configurações necessárias para interagir com o banco de dados PostgreSQL.

### :play_or_pause_button: Executando

1. Abra o terminal e navegue até a pasta onde o arquivo index.php está localizado.

2. Execute o seguinte comando para iniciar o servidor PHP:
    ```sh
    php -S localhost:8000
3. Mantenha o terminal aberto e, no navegador, acesse:
    ```sh
    http://localhost:8000/index.php
Isso permitirá o acesso ao site.

ATENÇÃO: No arquivo conexão.php colocar as informações do banco de dados configurado na própria máquina 

## :computer: Site
### página index
![image](https://github.com/Yasmin-Camargo/compra_online_ingressos-BD/assets/88253809/013e8ca5-3d19-44bf-8b27-1c0f2673df22)

--> eventos
![image](https://github.com/Yasmin-Camargo/compra_online_ingressos-BD/assets/88253809/7e095496-10ae-4efc-a41a-c7a5d7c55276)

### página de cadastro
![image](https://github.com/Yasmin-Camargo/compra_online_ingressos-BD/assets/88253809/64f45848-c791-42c2-9106-c6c6ee234380)

### página de login
![image](https://github.com/Yasmin-Camargo/compra_online_ingressos-BD/assets/88253809/0d9271cf-af73-414a-bdb0-be457bdb0287)

### página do usuário
![image](https://github.com/Yasmin-Camargo/compra_online_ingressos-BD/assets/88253809/3464c084-ddbb-4cb7-a5cf-59fc3af9d63f)

### página dos ingressos
![image](https://github.com/Yasmin-Camargo/compra_online_ingressos-BD/assets/88253809/02028530-c5d1-45f3-8d53-93da43b82ca0)

### página do organizador
![image](https://github.com/Yasmin-Camargo/compra_online_ingressos-BD/assets/88253809/317d6684-4f89-454b-94d2-ff5288e175ba)

--> editar evento
![image](https://github.com/Yasmin-Camargo/compra_online_ingressos-BD/assets/88253809/75a28e07-d877-4d6d-91b5-35093dd448c0)

--> adicionar evento
![image](https://github.com/Yasmin-Camargo/compra_online_ingressos-BD/assets/88253809/ab4e10a5-f058-453b-bb4f-da0edb48c230)

### página da descrição
![image](https://github.com/Yasmin-Camargo/compra_online_ingressos-BD/assets/88253809/9267079b-459a-4807-942e-baabe2a30a1a)

