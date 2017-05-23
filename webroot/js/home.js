/**
 * Javascript del index principal del sitio
 *
 * @package     webroot
 * @subpackage  js
 * @author      JpBaena13
 */


//Validando que la función $().validate exista
$.fn.validate = $().validate || function(){};

// Skeleton button
$('#btnSkeleton').on('click', function(){
    $.untInputWin(i18n.skeleton);
});

// --- Signup Page
$('#frmSignup').validate({
    success: 'valid',
    rules: {
        username: {
            required: true,
            minlength: 2,
            remote: ROOT_URL + 'Signup/Validate'
        },
        password: {
            required: true,
            minlength: 6
        },
        email: {
            required: true,
            email: true,
            remote: ROOT_URL + 'Signup/Validate'
        }
    },
    messages: {
        username: {
            required: i18n.errUsernameReq,
            minlength: i18n.errUsernameMinlength,
            remote: i18n.errUsernameUnavailable
        },
        password: {
            required: i18n.errPasswordReq,
            minlength: i18n.errPasswordMinlength
        },
        email: {
            required: i18n.errEmailReq,
            email: i18n.errEmailInvalid,
            remote: i18n.errEmailUnavailable
        }
    }
});

// --- MENSAJES --
if (getUrlVars()['error'] != undefined) {
    $('.untPlgMsg').untInputMsg({
        title: i18n.errLogin,
        content: i18n.errLoginMsg,
        type: 'Err'
    }).show();
}

// Bug @font-face
$(function() { $('body').hide().show(); });