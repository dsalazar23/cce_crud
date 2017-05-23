/*!
 * Texto en Español para internationalization (i18n)
 *
 * @package     webroot
 * @subpackage  locale
 * @author      JpBaena13 
 */

i18n = {

    //  -----------------
    //  --- DEFAULTS ----
    //  -----------------
    accept: 'Aceptar',
    cancel: 'Cancelar',
    skeleton: 'Skeleton es una librería PHP para que comiences rapidamente el desarrollo de una aplicación',

    // Signup
    errEmailReq: 'Ingresa tu correo electrónico',
    errEmailInvalid: 'Esta no es una dirección de correo válida',
    errEmailUnavailable: 'La cuenta de correo electrónica ya Exite!!',
    errUsernameReq: 'Se requiere un nombre de usuario',
    errUsernameMinlength: 'Oye!! más de 2 caractéres',
    errUsernameUnavailable: 'Nombre de usuario no esta disponible',
    errPasswordReq: 'Ingresa tu contraseña',
    errPasswordMinlength: 'Mínimo 6 caractéres',

    // ---> Server
    err400: 'Solicitud Incorrecta',
    err400Msg: 'La solicitud realizada no es correcta, por favor intente nuevamente',
    err401: 'No hay sesión iniciada',
    err401Msg: 'No se ha iniciado ninguna sesión. Por favor inicia sesión para continuar',
    err403: 'Permisos insuficientes',
    err403Msg: 'No tienes permisos para realizar esta acción',
    err432: 'Fecha Incorrecta',
    err432Msg: 'La fecha seleccionada es menor que la fecha actual. Seleccione una fecha mayor a la actual.',
    err433: 'Télefono no configurado',
    err433Msg: 'Todavía no ha configurado un número telefónico al cual se le envía el mensaje. Para configurar un número por favor haga <a href="' + ROOT_URL + 'Account/Profile"> click aqui</a>',
    err500: 'Error inesperado',
    err500Msg: 'Ha ocurrido un error inesperado y no se puedo realizar la solicitud',

    // ---> Login
    errLogin: 'Error de autenticación',
    errLoginMsg : 'La combinación de usuario y contraseña no es válida, por favor asegurate de ingresar correctamente tus datos.',
}