## Gerenciador de autenticações - LEGO AUTH

Algumas aplicações necessitam de autenticação dos usuários para controlarem o acesso aos recursos. Sendo assim, a ideia desse componente é facilitar a integracão entre aplicações dependentes e aplicações fornecedoras das regras de autenticação utilizando criptografia assimétrica e padrão Oauth para comunicação.

## Como posso integrar?
A integração pode ser feita utilizando um framework ou PHP puro, tudo depende do quão disposto você queira utilizá-lo. No fim da página, existe um exemplo de como usar com cada um dos exemplos abaixo:
| APP | README |
| ------ | ------ |
| Laravel 8.x | [https://github.com/laravel/laravel/blob/8.x/README.md] |
| Raw Skeleton | [raw/plugins/github/README.md] |

### Se for Laravel, siga os passos:
```php
class LoginController extends LoginLaravelNotSourceController

or

class LoginController extends LoginLaravelSourceController
class RegisterController extends RegisterLaravelSourceController
```

```sh
php artisan vendor:publish --tag=routes
php artisan vendor:publish --tag=views
```

No routes/web.php, carregue os middlewares:
```php
use \Annacode\Helpers\Helper;
$middlewares = Helper::laravelWebMiddlewares(['web']);

Route::group(['middleware' => $middlewares], function () { ...
```

No config/app.php, adicione o BootstrapServiceProvider na lista dos providers:
```php
\Annacode\Providers\BootstrapServiceProvider::class
```

No .env, defina:
```
APP_URL=host.docker.internal:8082/reason-rose-core
AUTHORIZATION_APP_URL=host.docker.internal:8081/public/index.php
APP_ID=1
AUTHORIZATION_PUBLIC_KEY=""
PUBLIC_KEY=""
PRIVATE_KEY=""
APP_LOGIN_ROUTE=/public/login
```

### Se for Raw (aplicação crua, geralmente usada para ser um APP FINAL), siga:
```php
class LoginController extends LoginRawNotSourceController
```

Em routes/login.php, ignore qualquer middleware:
```php
$class = new LoginController();
$router = new Router($class, ['middlewares' => []]);
```

Em .env, defina:
```
APP_URL=host.docker.internal:80/reason-schedule-app
PUBLIC_KEY=""
PRIVATE_KEY=""
AUTHORIZATION_APP_URL=host.docker.internal:8081/public/index.php
AUTHORIZATION_PUBLIC_KEY=""
```

> Atenção: Por enquanto, somente o Laravel e a RawSkeleton foram integrados, nada impede você de fazer um fork do projeto e criar versões para os demais frameworks ou ecossistemas :)

## Configuração de ambiente
```php
return [
    'middlewares' => [
        'auth_filler_middleware' => \Annacode\Middlewares\AuthFillerMiddleware::class,
        'authenticable_middleware' => \Annacode\Middlewares\AuthenticateMiddleware::class,
    ],
    'models' => [
        'application' => \Annacode\Models\Laravel\ApplicationL::class,
        //'application' => \Annacode\Models\Laravel\ApplicationR::class, case laravel
        'authorization' => \Annacode\Models\Laravel\AuthorizationL::class,
        //'authorization' => \Annacode\Models\Laravel\AuthorizationR::class, case laravel
        'user' => App\Models\User::class
    ],
    'user_api' => \Annacode\Controllers\Api\UserApiController::class,
    'is_sourcer' => false,
    'is_laravel' => true,
    'route_group' => 'anc',
    'api_group' => 'api'
];
```

## Modelos para autenticacão flexível 
Existem algumas possibilidades de configurar seu ambiente de acordo com sua necessidade. Abaixo, seguem alguns exemplos:

- SAAS ( `not sourcer` ) deslogado até o logged inself
- SAAS ( `sourcer` ) deslogado até o logged inself
- APPS finais ( `not sourcer` ) deslogado até o logged inself
- SAAS ( `not sourcer` ) logado acessando um APP final
- SAAS ( `sourcer` ) logado acessando um APP final

> Atenção: O nome "SAAS" foi usado como exemplo, poderia ser qualquer outro nome ou qualquer outro tipo de serviço/aplicação no momento de criar um `sourcer` ou `not sourcer`.

## Exemplo: SAAS ( `not sourcer` ) deslogado até o logged inself
![alt text](https://github.com/zevitagem/lego-auth/blob/main/Images/saas_not_sourced.png?raw=true&&s=100)

## Exemplo: SAAS ( `sourcer` ) deslogado até o logged inself
![alt text](https://github.com/zevitagem/lego-auth/blob/main/Images/saas_sourcer.png?raw=true&&s=100)

## Exemplo: APPS finais ( `not sourcer` ) deslogado até o logged inself
![alt text](https://github.com/zevitagem/lego-auth/blob/main/Images/app_not_sourced.png?raw=true&&s=100)

## Exemplo: SAAS ( `not sourcer` ) logado acessando um APP final
![alt text](https://github.com/zevitagem/lego-auth/blob/main/Images/saas_not_sourced_to_app.png?raw=true&&s=100)

## Exemplo: SAAS ( `sourcer` ) logado acessando um APP final
![alt text](https://github.com/zevitagem/lego-auth/blob/main/Images/saas_sourced_to_app.png?raw=true&&s=100)

---

## Cenários descritos passo a passo

### Exemplo: SAAS ( `not sourcer` ) deslogado até o logged inself
`SAAS_NOT_SOURCER:`
- Acessar a tela de login
> saas_not_sourcer/public/login
- Buscar aplicações que possam ser utilizadas para logar
> auth?action=getApplications&type=o
- Listar aplicações para o usuário escolher em qual ele fará o login
- Redirecionar para a aplicação `sourcer` escolhida
- Parametrizar a url de retorno em caso de sucesso e o slug (identificador) da solicitante
> sourcer/public/login?url_callback= saas_not_sourcer/public/login&slug=abc

`SOURCER:`
- Se já estiver uma sessão inicializada, os dados são reaproveitados sem a necessidade de logar novamente
- Se não estiver logado:
    - Validar usuário e senha inseridos na tela de login
    - Enquanto forem inválidos os dados fornecidos, continuará preso na tela de login
- Quando validar o usuário, é feita a inserção de um código de autorização no banco de dados para checagem futura
- O código de autorização e outras informações durante o processo são criptografados antes do envio
- Com os dados criptografados, é feita uma requisição na aplicação `auth` para gerar o token temporário
> auth/generateTempToken

`AUTH:`
- Os dados são descriptografados
- É feita uma requisição de volta na aplicação que solicitou para ver se o código de autorização existe e é válido
> sourcer/authorization/verify
- Com a verificação válida, é feita a inserção no banco de dados com os dados pertinentes aquele token temporário
- Com a verificação inválida, é devolvido um erro informando o motivo

`SOURCER:`
- Caso a resposta seja inválida, é redirecionado para a tela de login com a mensagem sendo exibida
- Com o token temporário devidamente gerado, é redirecionado de acordo com aquela url de retorno informada inicialmente
> saas_not_sourcer/public/login?token=temp_access_xxx&sessionId=abc

`SAAS_NOT_SOURCER:`
- Recebido o token como parâmetro na rota de login, é feita a requisição na aplicação `auth` para validação
> auth/generateTokenByTemp
- Caso dê errado por algum motivo, então é redirecionado para a tela de login exibindo a mensagem
- Caso dê certo, a aplicação possuirá uma resposta contendo informações relevantes para a sessão, inclusive um token válido e permanente
> {link do auth}
- Então, é feita na sequência uma nova requisição para buscar os dados do usuário autenticado no `sourcer` já usando o token definitivo
> sourcer/users/{USER_ID}
- Com todos os dados necessário para a navegação em mãos, é feito o redirecionamento para a tela inicial (home)
> saas_not_sourcer/public/home
---

Falta ainda descrever os demais cenários ...