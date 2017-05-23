/*!
 * JQuery Messages and Buttons Plug-in 0.1
 *
 * @author      JpBaena13
 */
;(function($, undefined) {

    $.fn.untInputMsg = function(options) {
        var defaults = {
            content: '',
            title: '',
            type: 'Ok',
        }

        var opts = $.extend(defaults, options)

        return this.each(function() {

            var $this = $(this)
            $this.css('display', 'none')
            $this.html('<div class="untMsg">\
                              <div class="untMsgDelete icon-cancel-circle"></div>\
                              <div class="untMsgIcon"></div>\
                              <div class="untMsgWrapper">\
                                 <div class="untMsgTitle">' + opts.title + '</div>\
                                 <div class="untMsgContent">' + opts.content + '</div>\
                              </div>\
                          </div>')

            var children = $this.children('.untMsg')

            children
                .addClass('untMsg' + opts.type)
                .css('width', opts.width)
                .css('height', opts.height);
            
            // Inserta el tag img si el usuario ingreso una URL de imagen
            if (opts.icon) {
                children.children('.untMsgIcon')
                    .html('<img src="' + opts.icon + '"/>')
                    .css('display', 'inline-block')
            }

            if (opts.title == '')
                $this.find('.untMsgTitle').remove();

            $this.find('.untMsgDelete').on('click', function(){
                $this.remove();
            });
        });
    }

    $.untInputWin = function(options) {
        var defaults = {
            content: '',
            data: '',
            btnAccept: true,
            btnCancel: false,
            width: 'auto',
            height: 'auto',
            maxWidth: '95%',
            classes: '',
            clickCancel: function() { return true; },
            clickAccept: function() { return true; },
            onLoadContent: function() { }
        }

        if (typeof(options) != 'object')
            options = {content: options}

        var opts = $.extend(defaults, options)
        
        //Cargando el contenido dinamicamente si opts.content es una URL
        if (isURL(opts.content)) {
            var exit = false;

            $.ajax ({
                url: opts.content,
                data: opts.data,
                async: false,
                success: function(data) {
                    if (isURL(data))
                        location.href = data
                    else
                        opts.content = data
                }
            }).error(function(data){
                exit = true;
            });

            if (exit)
                return;
        }

        $('body').append('<div class="untWinBG">\n\
                          <div class="untWin ' + opts.classes + '">\n\
                              <div class="untWinHeader">' + opts.title + '</div>\n\
                              <div class="untWinContent">' + opts.content + '</div>\n\
                              <div class="untWinFooter">\n\
                                 <button class="btnWinAccept yellow untBtn">' + i18n.accept + '</button>\n\
                                 <button class="btnWinCancel untBtn">' + i18n.cancel + '</button>\n\
                             </div>\n\
                          </div></div>');
        
        if (!opts.title)
            $('.untWinHeader').last().hide()

        if (opts.btnAccept) {
            $('.btnWinAccept').last().on('click', function(){
                if (opts.clickAccept() !== false)
                    untInputWinRemove()
            })
        } else {
            $('.btnWinAccept').last().hide()
        }

        if (opts.btnCancel) {
            $('.btnWinCancel').last().on('click', function(){
                if(opts.clickCancel() !== false)
                    untInputWinRemove()
            })
        } else {
            $('.btnWinCancel').last().hide()
        }

        if (!opts.btnAccept && !opts.btnCancel) {
            $('.untWinFooter').last().hide();
        }
        
        $('.untWin').last().css({
            width: opts.width,
            height: opts.height,
            'max-width': opts.maxWidth
        });

        $('.untWinBG').last().on('click', function(e){
            if ($(e.target).hasClass('untWinBG'))
                untInputWinRemove();
        });        
        
        untInputWinCenter();
        opts.onLoadContent();
    }

    // --- Eventos de cambio de pantalla y tecla presionada
    $(window).on('resize', function() {
        untInputWinCenter()
    })

    $(document).on('keydown', function(e) {
        var key = e.which || e.keycode
        if (key == 27) {
            if($('.untWin').length != 0) {
                untInputWinRemove()
            }
        }
    });
})(jQuery);

/**
 * Permite centrar un untInputWin (Acceso público)
 */
function untInputWinCenter() {
    var win = $(window)
        ,untWin = $('.untWin').last()
        ,wDoc = win.width()
        ,hDoc = win.height()
        ,top = (hDoc - untWin.outerHeight()) / 2;

    if (top < 0)
        top = 0;

    $('.untWinBG').last().css({
        width: wDoc,
        height: hDoc
    });

    untWin.css({
        top: top
    });
}

/**
 * Borrar los elementos de una ventana
 */
function untInputWinRemove(all) {
    var untWin = $('.untWin').last()

    if (all)
        untWin = $('.untWin');

    untWin.css({ top: -untWin.outerHeight() });

    if(!Modernizr.csstransitions) {
        $('.untWinBG').last().remove();
        untWin.remove();
        return
    }

    setTimeout(function() {
        $('.untWinBG').last().remove()
        untWin.remove()
    }, 1000)
}