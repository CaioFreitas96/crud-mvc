# crud-mvc
Sistema de anotação de tarefas, com as funcionalidade do (CRUD), feito em arquitetura MVC.

## Requisitos
- MySQL 
- XAMPP
- PHP

## Execução
- Faça o download do zip do projeto e extraia ele dentro da pasta htdocs do xampp, caminho: C:\xampp\htdocs
- Renomeia ele para crud-mvc
- acesse o arquivo httpd-vhosts.conf do xampp no caminho: C:\xampp\apache\conf\extra
- copie e cole no final do arquivo essa configuração:
  
<VirtualHost *:80>
 ServerAdmin user
 DocumentRoot "C:\xampp\htdocs\crud-mvc"
 ServerName localhost      
</VirtualHost>
    
- Inicie o serviço APACHE e MySQL do XAMPP
- Copie o script do arquivo create_bd.txt na sua IDE MySQL para a criação do banco de dados do sistema.
- Acesse o localhost
