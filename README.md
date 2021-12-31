## Gerenciador de autenticações - LEGO AUTH

Algumas aplicações necessitam de autenticação dos usuários para controlarem o acesso aos recursos. Sendo assim, a ideia desse componente é facilitar a integracão entre aplicações dependentes e aplicações fornecedoras das regras de autenticação utilizando criptografia assimétrica e padrão Oauth para comunicação.

## Como posso integrar?
A integração pode ser feita utilizando um framework ou PHP puro, tudo depende do quão disposto você queira utilizá-lo. No fim da página, existe um exemplo de como usar com cada um dos exemplos abaixo:
| APP | README |
| ------ | ------ |
| Laravel 8.x | [https://github.com/laravel/laravel/blob/8.x/README.md][PlDb] |
| Raw Skeleton | [raw/plugins/github/README.md][PlGh] |

> Atenção: Por enquanto, somente o Laravel e a RawSkeleton foram integrados, nada impede você de fazer um fork do projeto e criar versões para os demais frameworks ou ecossistemas :)

## Modelos para autenticacão flexível 
Existem algumas possibilidades de configurar seu ambiente de acordo com sua necessidade. Abaixo, seguem alguns exemplos:

- SAAS ( `not sourcer` ) sendo uma aplicação dependente de outros `sourcers`
- SAAS ( `sourcer` ) sendo uma aplicação independente de outros `sourcers`
- APPS finais ( `not sourcer` ) sendo uma aplicação dependente de outros `sourcers`

> Atenção: O nome "SAAS" foi usado como exemplo, poderia ser qualquer outro nome ou qualquer outro tipo de serviço/aplicação no momento de criar um `sourcer` ou `not sourcer`.

## Exemplo: SAAS ( `not sourcer` )
![alt text](https://github.com/zevitagem/lego-auth/blob/main/Images/saas_not_sourced.png?raw=true&&s=100)

## Exemplo: SAAS ( `sourcer` )
![alt text](https://github.com/zevitagem/lego-auth/blob/main/Images/saas_sourcer.png?raw=true&&s=100)

## Exemplo: APPS finais ( `not sourcer` )
![alt text](https://github.com/zevitagem/lego-auth/blob/main/Images/app_not_sourced.png?raw=true&&s=100)