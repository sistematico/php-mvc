# PHP MVC

Projeto de CRUD(Create Read Update Delete) usando o [PHP](https://php.net) com o modelo MVC(Model View Controller) e SQLite como banco de dados.

## Outras ramificações

| Ramificação           | Painel de Admin       | CSS Framework         | Composer                | Status                  |
| --------------------- | --------------------- | --------------------- | :---------------------: | :---------------------: |
| [full](/../../tree/full)     | :heavy_check_mark: | Twitter Bootstrap v5.0.2 | :heavy_check_mark: | :recycle: |
| [lite](/../../tree/lite)     | :x:                | Twitter Bootstrap v5.0.2 | :x:                | :recycle: |
| [lite](/../../tree/rest)     | :x:                | :x:                      | :x:                | :recycle: |
| [ajax](/../../tree/ajax)     | :x:                | Twitter Bootstrap v5.0.2 | :x:                | :x: |
| [single](/../../tree/single) | :x:                | Bulma v0.9.3             | :x:                | :x: |

## Pré-requisitos

- [Nginx](https://www.nginx.com) ou [Apache](https://www.apache.org)
- [PHP 7.4](https://php.net)
- [Docker(opcional)](https://www.docker.com/)
- [Fé](https://pt.wikipedia.org/wiki/F%C3%A9)

## Instalação

- Clone este repositório em um subdiretório qualquer do seu servidor web: `git clone -b lite https://github.com/sistematico/php-mvc /var/www/html/php-mvc-lite`
- Acesse seu site https://localhost/php-mvc-lite
- Reze para que tudo funcione como deveria.

## Nginx

Configuração recomendada do Nginx:

```
server {
    listen 80;
    listen [::]:80;
    server_name localhost;
    return 301 https://$host$request_uri;
}

server {
    listen 443 ssl;
    listen [::]:443 ssl;

    ssl_session_cache shared:SSL:10m;
    ssl_session_timeout 5m;

    ssl_certificate      /etc/ssl/nginx/localhost.pem;
    ssl_certificate_key  /etc/ssl/nginx/localhost-key.pem;

    error_log  /var/log/nginx/error.log;
    access_log /var/log/nginx/access.log;

    server_name localhost;
    index index.php;
    root /var/www/html/php-mvc/public;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
        # ou
        # try_files /$uri /$uri/ /index.php?url=$uri&$args;
    }

    location ~ \.php$ {
        try_files $uri =404;
        fastcgi_split_path_info ^(.+\.php)(/.+)$;
        fastcgi_pass 127.0.0.1:9000;
        fastcgi_index index.php;
        include fastcgi_params;
    }
}
```

## Docker

Configuração recomendada do Docker:

- https://gist.github.com/sistematico/8798adbc6b55e8e34b0bd093588b7a5f

## Demo

- [https://mvc.lucasbrum.net](https://mvc.lucasbrum.net)

## Créditos

Agreadeço do fundo do meu :heart: as pessoas que me ajudaram a chegar até aqui.

- [William Correa](https://github.com/wilcorrea)
- [Luciano Charles de Souza](https://github.com/LucianoCharlesdeSouza)
- [Dave Hollingworth](https://www.udemy.com/course/php-mvc-from-scratch)
- [William Costa](https://www.youtube.com/watch?v=TmeyoTNu748&list=PL_zkXQGHYosGQwNkMMdhRZgm4GjspTnXs)
- [Diogo](https://dzlabs.tech)
- [Traversy Media](https://www.youtube.com/channel/UC29ju8bIPH5as8OGnQzwJyA)
- [Arch Linux](https://archlinux.org)
- [Nginx](https://nginx.org)
- [PHP](https://www.php.net)
- [PHP-FIG](https://www.php-fig.org/psr/psr-4/)
- [Mini3](https://github.com/panique/mini3)
- [Twitter Boostrap 5](https://getbootstrap.com)

## Contribua!

- Viu algum erro ou tem alguma sugestão? Abra uma [issue](https://github.com/sistematico/php-mvc/issues/new)!

## Contato

- lucas@archlinux.com.br

## Agradecimentos

Agradeço de :heart: a JetBrains por me fornecer de forma gratuita as melhores ferramentas do mundo.

[![JetBrains](https://i.imgur.com/fRGi3wI.png)](https://www.jetbrains.com) [![PhpStorm](https://i.imgur.com/lqhtz4L.png)](https://www.jetbrains.com/phpstorm/) [![WebStorm](https://i.imgur.com/hATeqvO.png)](https://www.jetbrains.com/webstorm/) [![DataGrip](https://i.imgur.com/Lhx4pdh.png)](https://www.jetbrains.com/datagrip/)

## Ajude

Se você achou meu trabalho útil de qualquer forma, considere doar qualquer valor através do das seguintes plataformas:

[![PagSeguro](https://img.shields.io/badge/PagSeguro-gray?logo=pagseguro&logoColor=white&style=flat-square)](https://pag.ae/bfxkQW) [![ko-fi](https://img.shields.io/badge/ko--fi-gray?logo=ko-fi&logoColor=white&style=flat-square)](https://ko-fi.com/L4L119L8J) [![Buy Me a Coffee](https://img.shields.io/badge/Buy_Me_a_Coffee-gray?logo=buy-me-a-coffee&logoColor=white&style=flat-square)](https://www.buymeacoffee.com/sistematico)