# Skeleton PHP

Skeleton PHP es una librería para el desarrollo rápido de aplicaciones web, 
que implementa el patrón MVC y DAO, y usa las mejores prácticas y herramientas front-end. 
Skeleton PHP NO debe confundirse con un framework para el desarrollo de aplicaciones complejas.

## Getting Started
Esta librería requiere [Stylus](http://learnboost.github.io/stylus/) y 
[grunt-contrib-concat](https://github.com/gruntjs/grunt-contrib-concat) para correr.
Para saber el trabajo que se hace con éste último plugin vea el código del archivo
[Gruntfile.js](https://github.com/jpbaena13/Skeleton/blob/master/Gruntfile.js).


Descargue la librería y descomprimala en su carpeta `/www` del servidor web colocándo 
a la carpeta el nombre del proyecto. A continuación deberá realizar los siguiente cambios 
en `NOMBRE_DEL_PROYECTO` por el nombre real, para los 3 archivos:

#### include/bootstrap.php
```php
/**
 * Nombre del Proyecto 
 */
    if (!defined('PRJCT_NAME'))
        define('PRJCT_NAME', 'NOMBRE_DEL_PROYECTO');
```

#### webroot/js/bootstrap.js

```js
/**
 * Nombre del Proyecto
 */
    var PRJCT_NAME = 'NOMBRE_DEL_PROYECTO'
```

#### .htaccess

```htaccess
ErrorDocument 404 /NOMBRE_DEL_PROYECTO/View/Errors/404.html
```
```htaccess
RewriteRule ^([a-zA-Z]+)$ /NOMBRE_DEL_PROYECTO/index.php?page=$1
```
```htaccess
RewriteRule ^p/([a-zA-Z]+)$ /NOMBRE_DEL_PROYECTO/webroot/plugins/$1
```


###Para la instalacion de plugin's corra los siguiente comandos:
```shell
npm install -g grunt-cli
```

Con este comando instala globalmente el plugin `grunt`

```shell
npm install grunt-contrib-concat
```
Con este comando instala localmente en el proyecto el plugin `concat`

```shell
npm install -g grunt-contrib-uglify
```
Con este comando instala globalmente el plugin `uglify`

Finalmente, procese los archivos `main.styl` y `home.styl`  con la herramienta `stylus`, 
y ejecute el comando `grunt` desde la raíz del proyecto.

###Creación del modelo de datos:
Siga los siguiente pasos para crear el modelo de datos de la aplicación. Dentro de este repositorio encontrará una archivo llamado skeleton.sql. Este archivo crear una base de datos con una simple tabla `users` para `MySQL`. Cree esta base de datos, configure la conexión en el archivo `Config/DataSource/ConnectionProperty.class.php`y enseguida realice la siguiente petición a través del navegador:

```shell
http://{HOST}/{NOMBRE_DEL_PROYECTO}/include/DataAccessGenerate.php?key=executeDAO
```
 Si todo sale bien deberá de aparecer algo como esto:

```shell
C:\wamp\www\Skeleton\DataAccess\DTO\UserDTO.class.php
C:\wamp\www\Skeleton\DataAccess\DAO\interfaces\UserDAO.interface.php
C:\wamp\www\Skeleton\DataAccess\DAO\mysql\gen\genUserMsDAO.class.php
C:\wamp\www\Skeleton\DataAccess\DAO\mongodb\gen\genUserMgDAO.class.php
C:\wamp\www\Skeleton\Model\genModel\genUser.class.php
C:\wamp\www\Skeleton\Lib\FactoryDAO.class.php
C:\wamp\www\Skeleton\include\includeDAO.php
Creación de Acceso a Datos Terminada Exitosamente
```

Con esta petición se crearán todas las clases del acceso a datos (DAO, DTO), y las clases asociadas al Modelo (Model).

###Controladores y sus notaciones
Skeleton trabajo con un modelo MVC, lo que significa que toda petición hecha a la aplicación será atendida a través de un `Controller`. Las convenciones para trabajar con este modelo son como sigue:

```shell
http://{HOST}/{NOMBRE_DEL_PROYECTO}/{CONTROLLER}/{METHOD}/{ID}
```

A la hora de implementar los controladores podrá usar anotaciones para ellos. Un ejemplo de una anotación es este:

```php
/**
 * @POST /Login/MyPage
 *
 * @AUTHORIZE
 * @JSON
 *	
 */
public function MyPage() {
```

Estas notaciones implica lo siguiente:

```php
@POST => Indica que la petición debe ser Method=POST, de lo contrario podría lanzar una error 404 (Page not found)
```

Al igual que esta, puede aplicar cualquiera de los método HTTP: `@GET`, `@DELETE`, `@PUT`


```php
@AUTHORIZE => Exige que el usuario este autenticado, si no lo está, entonces lo envía a la página de Login
```

Las páginas que se muestran solo cuando el usuario no está autenticado no requieren ninguna anotación. Las páginas
que pueden ser vista tanto para usuario autenticados como para usuarios no autenticas se usa la notación `@IGNORE`

```php
@JSON => Indica que la respuesta al usuario va a ser tipo applicaton/json
```

Cuando no se especifica este tipo de anotación la salida por defecto es de tipo `text/html`. También es posible especificar una notación tipo `@AJAX` lo que implica que el llamado solo se puede hacer a través de un objeto `XMLHTTPREQUEST`