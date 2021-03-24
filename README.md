<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Comandos usados para este proyecto

composer global require laravel/installer

# "jet" el nombre del proyecto
laravel new jet --jet 

//si alguien le fallo la instalacion ... muy probablemente sea culpa de node/js   vuelva a instalarlo
https://nodejs.org/es/   de esta pagina ... la descarga de la izquierda

cd jet
code .

# Creamos la base de datos "jet"   el archivo .env    que son las variables de entorno
utf8 spanish

#.env configurar el nombre de la base de datos "jet"

php artisan migrate:refresh --seed 

#se crean las tablas que ya estan preconfiguradas para el manejo del login
*****************************   php artisan migrate:refresh --seed 

php artisan migrate

##  ******************
# se tiene que hacer esto del servidor virtual, entrando por la siguiente direccion
localhost\jet\public
No funciona ya que cuando entra a la pagina busca los estilos en la ruta principal 
localhost/css/app.css	
localhost/js/app.js

 # instalar las dependencias de javascript todas las que estan en package.json   
   npm install      // para los que no lo notaron al correr jetstream ya se corrio autmaticamente este comando

  #SIEMPRE que trabajo uso este comando
      npm run watch

## c:\Windows\System32\drivers\etc\hosts

	127.0.0.1       jet.local
	::1             jet.local

	127.0.0.1       localhost
	::1             localhost
 
## c:\xampp\apache\conf\extra\httpd-vhosts.conf
     
<VirtualHost *:80>
	DocumentRoot "C:/xampp/htdocs/jet/public/"
	ServerName jet.local
</VirtualHost>

<VirtualHost *:80>
	DocumentRoot "C:/xampp/htdocs/"
	ServerName localhost
</VirtualHost>
	
	
#modelo
'tipo',
#app/actions/fortify/createNewUser

'tipo' => ['required', 'string', 'max:255'],

'tipo' => $input['tipo'],

#resources/js/pages/auth/register.vue        

 <div class="mt-4">
	<jet-label for="tipo" value="Tipo" />
	<jet-input id="tipo" type="text" class="mt-1 block w-full" v-model="form.tipo" required  autocomplete="tipo" />
</div>

form: this.$inertia.form({
	tipo: '',
})

#migracion 
 $table->string('tipo')->nullable();
 
 # aremos un seed para incluir datos por defecto
php artisan make:seeder TodosSeeder
 
$this->call(TodosSeeder::class);

use App\Models\User;
use Illuminate\Support\Facades\Hash;

$useradmin=User::create([
	'name' => 'admin paul',
	'email' => 'admin@gmail.com',
	'password' => Hash::make('admin'),
	'tipo' => '1',
	]);
            
$user1=User::create([
	'name' => 'usuario Marcos',
	'email' => 'user@gmail.com',
	'password' => Hash::make('admin'),
	'tipo' => '2',
	]);
	
$user1=User::create([
	'name' => 'usuario Moderador',
	'email' => 'moderador@gmail.com',
	'password' => Hash::make('admin'),
	'tipo' => '3',
	]);


# para evitarnos de problemas en ambiente de desarrollo 
# se puede limpiar y empezar todo los datos denuevo

php artisan migrate:refresh --seed 

un midleware por cada tipo de usuario

#midleware 1
*********
php artisan make:middleware SoloAdmin

use Illuminate\Support\Facades\Auth;

 public function handle(Request $request, Closure $next)
    {
        switch(auth::user()->tipo){
            case ('1'):
                return $next($request);//si es administrador continua al HOME
            break;
			case('2'):
                return redirect('user');// si es un usuario normal redirige a la ruta USER
			break;	
            case ('3'):
                return redirect('moderador');//si es administrador redirige al moderador
            break;
        }
    }
#midleware 2
*********
php artisan make:middleware SoloUser	
use Illuminate\Support\Facades\Auth;

 public function handle(Request $request, Closure $next)
    {
        switch(auth::user()->tipo){
            case ('1'):
                return redirect('dashboard');//si es administrador redirige al HOME
            break;
			case('2'):
                return $next($request);// si es un usuario continua ruta USER
			break;	
            case ('3'):
                return redirect('moderador');//si es administrador redirige al moderador
            break;
        }
    }
	
#midleware 3
*********
php artisan make:middleware SoloModerador	
use Illuminate\Support\Facades\Auth;

 public function handle(Request $request, Closure $next)
    {
        switch(auth::user()->tipo){
            case ('1'):
                return redirect('dashboard');//si es administrador redirige al HOME
            break;
			case('2'):
                return redirect('user');/// si es un usuario normal redirige a la ruta USER
			break;	
            case ('3'):
                return $next($request);//si es moderador continua a su ruta moderador
            break;
        }
    }

#####   registrar en el kernel
	'soloadmin' => \App\Http\Middleware\SoloAdmin::class,
	'solouser' => \App\Http\Middleware\SoloUser::class,
	'solomoder' => \App\Http\Middleware\SoloModerador::class,


# nos copiamos de la ruta que ya por defecto tiene un midleware que verifica que este logeado

Route::middleware(['auth:sanctum', 'verified'])->get('/user', function () {
    return Inertia::render('User');
})->name('user');

Route::middleware(['auth:sanctum', 'verified'])->get('/moderador', function () {
    return Inertia::render('Moderador');
})->name('moderador');

# Luego en resources/js/Pages   duplicamos el Dashboard.vue en 
Moderador.vue
User.vue

<p>Rayos señorita</p>
<pre> bien aqui va todo el contenido
    no se si sea buena idea pero aqui esta
    bien aqui va todo el contenido
    no se si sea buena idea pero aqui esta
    bien aqui va todo el contenido
    no se si sea buena idea pero aqui esta
</pre>









# controllers
php artisan make:controller UserController --resource
//php artisan make:controller AdminController --resource
php artisan make:controller ModeradorController --resource

///home controller  para expulsar a los usuarios a su ruta solo pasan admins


$this->middleware('soloadmin',['only'=> ['index']]);

public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('solouser',['only'=> ['index']]);
    }

 public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('solomoder',['only'=> ['index']]);
    }

///crer una vista para el user y una vista para el moderador




#####   user controller

public function index()
    {
        return view('user');
    }
    
    
####   RUTAS
    
//esta es la manera antigua de usar rutas
///Route::get('/user', [App\Http\Controllers\UserController::class, 'index'])->name('user');

## comando para ver las rutas
php artisan route:list


##y esta la nueva 

use App\Http\Controllers\UserController;

Route::resource('/users', UserController::class);

use App\Http\Controllers\AdminController;

Route::resource('/admins', AdminController::class);



use App\Http\Controllers\ModeradorController;

Route::resource('/moders', ModeradorController::class);




correr el comando para que se actualicen la base de datos y los usuarios
            
php artisan migrate:refresh --seed 

# nos copiamos de la ruta que ya por defecto tiene un midleware que verifica que este logeado



Route::middleware(['auth:sanctum', 'verified'])->get('/user', function () {
    return Inertia::render('User');
})->name('user');

Route::middleware(['auth:sanctum', 'verified'])->get('/moderador', function () {
    return Inertia::render('Moderador');
})->name('moderador');

# Luego en resources/js/Pages   duplicamos el Dashboard.vue en 
Moderador.vue
User.vue

<p>Rayos señorita</p>
<pre> bien aqui va todo el contenido
    no se si sea buena idea pero aqui esta
    bien aqui va todo el contenido
    no se si sea buena idea pero aqui esta
    bien aqui va todo el contenido
    no se si sea buena idea pero aqui esta
</pre>
