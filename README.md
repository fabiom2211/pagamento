

## Requisitos
* PHP

```
https://www.php.net/manual/pt_BR/install.php
```

* Compose

```
https://getcomposer.org/download/
```

## INSTALAÇÃO

1. Clone o projeto:
```
git clone https://github.com/fabiom2211/pagamento.git
```

2. Arquivo .env está versionado, pois temos duas variáveis setadas:
```
PUBLIC_KEY_MERCADO_PAGO=TEST-33d6d38f-395c-4f24-a9e7-2267ddf4d259
ACCESS_TOKEN_MERCADO_PAGO=TEST-6765632652566384-031220-09d9a467a746d7d9b06febde7e32f41c-249922967
```

3. Dentro do Projeto vamos rodar instalar as dependencias: 
```
composer install
```

4. Suba projeto:
```
php artisan serve
```


## Acesso ( geralmente ele entra na porta 8001, mas observe quando subir o projeto ):
http://localhost:8001
