# Innov - um mini (quase) framework

1. Git clone
2. composer install
3. Rode no apache ou pelo php built-in server
``` php -S localhost:8000```

4. Chame na url localhost:8000

## Rotas

Para criar novas rotas adicione no array de rotas que fica no arquivo Config\routes.php uma rota no seguinte formato:
    ``` '/nomeDaRota' => 'NomeDoController@nomeDoMetodo' ```

Qualquer parâmetro enviado em uma rota, seja ele um arquivo, ou uma query string ou parametros via POST, podem ser acessados diretamente no método do controller pela variavél request

* Parametros GET (Query Strings): ``` $request->get['nome-parametro] ```
* Parametros POST: ``` $request->post['nome-parametro] ```
* Arquivos: ``` $request->files['nome-parametro] ```

Para saber o tipo da request veja pelo atributo method no objeto request
* ```$request->method == 'POST'```

## Template System

O sistema de templates utiliza de PHP puro, ou seja, basta usar tags PHP para o código
Qualquer várivel pode ser enviada para a view, para enviar basta passar como segundo parâmetro 
no método que chama a view ( esse segundo parametro deve ser um array)
``` 
$message = 'Hello World';
$array = [
    'item1' => 'valor1',
    'item2' => 'valor2',
    'item3' => 'valor3',
];
return $this->view('example/index',compact('message','array')); 
```

Na view basta abrir tags PHP e manipular normalmente as váriaveis passadas
```
<?php
foreach ( $array as $a ) {
  echo $a . '<br>';
}
?>
```

## Testes
Para rodar os testes basta rodar
``` php phpunit.phar ```