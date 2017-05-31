//Validando que la función $().validate exista
$.fn.validate = $().validate || function(){};


$('#formNuevo').validate({
	success: 'valid',
	rules: {
        nombre: {
            required: true,
            minlength: 3,
        },
        logo: {
            required: true,
        },
        descripcion: {
            required: true,
        },
        url: {
            required: true,
            //remote: ROOT_URL + 'Signup/Validate'
        },
        intereses: {
        	required: true,
            minlength: 1
        }
    },
    messages: {
        nombre: {
            required: 'Ingresa el nombre de la empresa',
            minlength: 'El nombre debe ser mínimo de tres caracteres'
        },
        logo: {
            required: 'Ingresa el nombre del archivo de imagen del logo'
        },
        descripcion: {
            required: 'Ingresa la descripción de la empresa'
        },
        url: {
            required: 'Ingresa la dirección del sitio web de la empresa'
        },
        intereses: {
        	required: 'Selecciona los intereses asociados a las empresas',
            minlength: 'Selecciona mínimo un interes'
        }
    }
});