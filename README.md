João Grilo Plugin WP
====================

Descrição
---------
Esse projeto é um canivete suíço para desenvolvedores WordPress.
Ele contém as mais variadas funções para customização do projeto.

Camadas (Pastas)
-------
Todo o plugin é dividido por 'camadas' (namespace) e pode ser chamado
em qualquer área do WP bastando apenas instaciar o namespace e sua
respectiva função.

Instalação
----------
Para usá-lo basta colocar o plugin na pasta wp-content/plugins e depois
ativá-lo no administrador.

Modo de Uso
-----------
Crie um novo objeto João Grilo e após isso instacie a função desejada.
Ex.:
- Ative o plugin 
- No functions.php insira:
```php
	$core = new \JoaoGrilo\Core();
	$core->bytags();
```
Essa função remove as tags do admin.

****** As funções estão separadas por tipo. ******
Ex.: Core, Math (Funções Matemáticas), Convert, etc...  
