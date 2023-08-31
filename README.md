# Compra Online de Ingressos - Banco de Dados

Este projeto foi desenvolvido como parte da disciplina de Banco de Dados.

## Configuração para Executar o Site com PHP

### Instalando PHP

1. Instale o PHP a partir deste link: [Download do PHP](https://windows.php.net/download#php-8.2), escolhendo a opção "zip" (para Windows).

2. Extraia o arquivo .zip baixado, entre na pasta extraída e copie o caminho para o diretório.

3. Digitar na barra de pesquisa do windows "editar variaveis de ambiente do sistema", Clique em "Variáveis de ambiente" e selecione a variável "Path". Clique em "Editar" e depois em "Novo". Cole o caminho que você copiou anteriormente e pressione "OK".

4. Para verificar se a instalação foi bem-sucedida, abra o terminal e digite o comando:

   ```sh
   php -v
Deverá ser exibida a versão do PHP instalada.


### Configuração para Conectar ao Banco de Dados PostgreSQL na Máquina
1. Verifique se o PostgreSQL está configurado nas variáveis de ambiente. Caso contrário, encontre a pasta bin na instalação do PostgreSQL, copie o caminho e adicione às variáveis de ambiente. O caminho para a pasta bin geralmente é semelhante a: C:\Program Files\PostgreSQL\versao\bin

2. Abra o arquivo php.ini (localizado na pasta de instalação do PHP) em um editor de texto. Se o arquivo php.ini não existir, mas houver um arquivo php.ini-developer, renomeie o último para php.ini.

3. Adicione ou descomente as seguintes linhas para habilitar as extensões PDO e PDO_PGSQL:
    ```sh
        extension="C:\caminho\para\ext\php_pdo_pgsql.dll"
        extension="C:\caminho\para\ext\php_pgsql.dll"
Substitua C:\caminho\para\ext pelo caminho real para a pasta de extensões do PHP.

Agora, o site deve estar acessível com as configurações necessárias para interagir com o banco de dados PostgreSQL.

### Executando

1. Abra o terminal e navegue até a pasta onde o arquivo index.php está localizado.

2. Execute o seguinte comando para iniciar o servidor PHP:
    ```sh
    php -S localhost:8000
3. Mantenha o terminal aberto e, no navegador, acesse:
    ```sh
    http://localhost:8000/index.php
Isso permitirá o acesso ao site.
