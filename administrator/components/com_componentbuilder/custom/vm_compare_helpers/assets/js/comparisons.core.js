;Comparisons = window.Comparisons || {};
/*=================================================== MOBILE =================================*/
/**
 * MOBILE
 * Событие кнопка сравнить для мобильных
 */
Comparisons.mobileComparison = function(el){
    var $ = jQuery ;
    var $el = $(el) ;
    var Url = Comparisons.comparison_listUrl ;
    var arr = [] ;
    if ( $el.hasClass('disabled') ) return ;
    var fData = $el.closest('.comparison-list-sect').find('ul.comparison-list-l').find('input.checked').each(function (i,a) {
        arr.push( $(a).val() );
    });
    Url = Url+'?ids='+ arr.join(',') ;
    window.location.href= Url ;
};
/**
 * MOBILE Событие отметить чекбокс в товаре для сраавненеия на странице
 * /comparison.html Для мобильных устройств
 * @param elem
 * @constructor
 */
Comparisons.CheckboxEvt = function (elem) {
    var $ = jQuery ;
    var gnz11 = new gn_z11();
    var $el = $(elem);
    var $inp = $el.parent().find('input');
    var htmlSvg = '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" class="svg-icon check-icon svg-white"><use xlink:href="#check"></use></svg>';
    var catId = $inp.closest('[data-name="category_block"]').data('category_id');
    var prodId = $inp.closest('[data-name="product-block"]').data('product_id');


    if ($el.hasClass('checkbox-label-disabled')) return ;


    $el.toggleClass('checkbox-label');
    $el.toggleClass('checkbox-label-active');

    if ($el.hasClass('checkbox-label-active')){
        $el.append(htmlSvg);
        $inp.prop( "checked", true ).addClass('checked');
    }else{
        $el.find('svg').remove();
        $inp.prop( "checked", false ).removeClass('checked');
    }
    /**
     * Записываем в историю
     */
    var data = {
        group : null,
        plugin : null ,
        virtuemart_category_id : catId ,
        virtuemart_product_id :  prodId ,
        operation :  ($inp.prop( "checked")?'add':'del') ,
        option : 'com_vm_product_comparisons' ,
        view : 'comparisons' ,
        task : 'ajax.eventHistory'
    };
    gnz11.getAjax().then(function (Ajax) {
        Ajax.send(data).then(function (r) {
            console.log(r)
        })
    });

    /**
     *  Закрываем неотмеченные чекбоксы если уже 2 отмечены
     */
    Comparisons._CheckMaxOff($el);
};
/**
 * MOBILE  Закрываем неотмеченные чекбоксы если уже 2 отмечены
 * Управление неактивными ческбоксами
 * И кнопка сравнить в блоке категории
 * /comparison.html Для мобильных устройств
 * @param $el
 * @private
 */
Comparisons._CheckMaxOff = function ($el) {
    var $ = jQuery ;
    var $ul = $el.closest('.comparison-list-l');
    var ch_span = $ul.find('.checkbox-label-active');
    var n_class = 'checkbox-label checkbox-label-disabled' ;
    var btn = $ul.closest('.comparison-list-sect').find('.comparison-list-sect-footer .comparison-list-sect-main-btn');

    if ( ch_span.length === 2 ){
        $ul.find('.checkbox-label').toggleClass(n_class);
        btn.removeClass('disabled');

    }else if(ch_span.length<2){
        $ul.find('.checkbox-label-disabled').toggleClass(n_class);
        btn.addClass('disabled')
    }

};
/**
 *
 * @param event
 * @constructor
 */
Comparisons.RemoveMobile = function(event,element){
    event.preventDefault();
    var $ = jQuery ;
    var $this = $(event.target);
    var gnz11 = new gn_z11();
    var section = $($this).closest('li');

    var data = {
        group : null,
        plugin : null ,
        option : 'com_vm_product_comparisons' ,
        view : 'comparison' ,
        task : 'ajax.getLayot',
        nameLayotValue : 'remove_popup',
        dataLayot:{
            // message : 'Недостаточно товаров для сравнения',
        }
    };
    gnz11.getAjax().then(function (Ajax) {
        Ajax.send(data).then(function (r) {
            gnz11.__loadModul.Fancybox().then(function (a) {
                a.open( r.html , {
                    touch: !1,
                    beforeShow : function ( instance, current ) {},
                    afterShow : function ( instance, current ) {
                        $('.g-remove-cancel').on('click', function (event) {
                            event.preventDefault();
                            a.close();
                        });
                        $('.g-remove-tools-i.remove').on('click', function (event) {
                            event.preventDefault();
                            var $cell = $($this).closest('[data-name="product-block"]') ;

                            var $checkbox =  $cell.find('.checkbox-block input');
                            if ($checkbox.hasClass('checked')) $checkbox.parent().find('.checkbox-label-active').trigger('click');

                            var category_id = $($this).closest('[data-name="category_block"]').data('category_id');

                            var data = {
                                group : null,
                                plugin : null ,
                                virtuemart_category_id : category_id,
                                virtuemart_product_id :  $cell.data('product_id') ,
                                option : 'com_virtuemart' ,
                                view : 'comparisons' ,
                                task : 'del_comparisons'
                            };
                            gnz11.getAjax().then(function (Ajax) {
                                Ajax.send(data).then(function (r) {
                                    if (r) {

                                        var prodsul = $($cell).closest('ul');

                                        $cell.remove();
                                        a.close();
                                        Comparisons._CheckMaxOff(section);
                                        Comparisons.ModulUpdate();

                                        if (!prodsul.find('li').length  ){
                                            prodsul.closest('.comparison-list-sect').remove();
                                        }
                                        if (!$('.comparison-list-sect')[0]){
                                            $('.comparison-list-empty-b').removeClass('hidden')
                                        }
                                    }
                                })
                            });
                        });
                        $('.g-remove-tools-i.wishlists').on('click', function (event){
                            event.preventDefault();
                            console.warn('Не настроин обработчик события')
                        });
                    },
                })
            });
            console.log( r )
            // $( r.html ).insertBefore( section );
        })
    });



};


/**
 *
 */
Comparisons.MobileAddToCart= function( event ){
    event.preventDefault();
    var $ = jQuery ;
    var $this = $(event.target);
    var gnz11 = new gn_z11();
    var $section = $this.closest('li');
    var product_id = $section.data('product_id')
    var data = {
        group : null,
        plugin : null ,
        option : 'com_virtuemart' ,
        view : 'cart' ,
        task : 'addJS' ,
        quantity : [1] ,
        virtuemart_product_id:[product_id] ,
    };
    gnz11.getAjax().then(function (Ajax) {
        Ajax.ReturnRespond = true ;
        Ajax.send(data).then(function (r) {
            $("body").trigger("updateVirtueMartCartModule");
            gnz11.__loadModul.Fancybox().then(function (a) {
                a.open( r.msg , {
                    beforeShow : function ( instance, current ) {},
                    afterShow : function ( instance, current ) {},
                })
            });
        })
    });

};


/*=================================================END MOBILE =================================*/

/**
 * Удаление товара из списка сравнения
 * @param event
 * @private
 */
Comparisons._DEL = function (event) {
    event.preventDefault();
    var $ = jQuery ;
    var $this = $(event.target);
    var gnz11 = new gn_z11();
    var $cell = $this.closest('.comparison-t-head-cell');
    var product_id = $cell.find('.comparison-g-delete').data('product_id');
    var section = $($this).closest('section');
    var data = {
        group : null,
        plugin : null ,
        virtuemart_category_id : $this.closest('section.comparison').data('category_id') ,
        virtuemart_product_id :  product_id ,
        option : 'com_virtuemart' ,
        view : 'comparisons' ,
        task : 'del_comparisons'
    };
    //
    if (typeof data.virtuemart_product_id  === 'undefined') {
        $cell = $this.closest('.c-section-g-i');
        data.virtuemart_product_id = $cell.find('.c-section-g-i-delete').data('product_id')
    }

    gnz11.getAjax().then(function (Ajax) {
        Ajax.send( data ).then(function (r) {
            if (r){
                $cell.remove();
                $('.comparison-t').find('[data-product_id="'+product_id+'"]').remove();
                if (Comparisons.View === 'comparison_list' ){
                    Comparisons.reloadComparison_list();
                }else if(Comparisons.View === 'comparison'){
                    Comparisons.reloadComparisonBtn(section);
                }

            }

        },function (err) {
            console.error(err)
        })
    },function (err) {
        console.error(err)
    });
};
/**
 * Удаление Сообщения на странице категорий сравнения
 * @param event
 */
Comparisons.clearUserMessages = function(event){
    event.preventDefault();
    var $ = jQuery ;
    var $this = $(event.target);
    $this.closest('.message').remove();
};
/**
 * Перезагрузка кнопки "Сравнить эти товары"
 * @param section
 */
Comparisons.reloadComparisonBtn = function(section){
    var $ = jQuery ;
    var IS_MOBILE = false ;
    var Url = Comparisons.comparison_listUrl;
    var idArr = [] ;
    var $btn = section.find('.btn-link-to-compare');

    var prodBlock =  section.find('.c-section-g-i-delete');

    if (!prodBlock[0]){
        IS_MOBILE = true ;
        prodBlock =  section.closest('ul').find('li');
        $btn = $('.comparison-list-sect-main-btn')
    }

    prodBlock.each(function (i,a) {
        var id = $(a).data('product_id');
        idArr.push(id)
    });





    Url = Url+'?ids=' + idArr.join(',');
    if (idArr.length === 1 ){
        if (!IS_MOBILE) {
            $btn.remove();
        }else {

        }

        /**
         * Получение сообщение "Недостаточно товаров для сравнения"
         */
        var data = {
            group : null,
            plugin : null ,
            option : 'com_vm_product_comparisons' ,
            view : 'comparison' ,
            task : 'ajax.getLayot',
            nameLayotValue : 'appmessage',
            dataLayot:{
                message : 'Недостаточно товаров для сравнения',
            }
        };
        gnz11.getAjax().then(function (Ajax) {
            Ajax.send(data).then(function (r) {
                $( r.html ).insertBefore( section );
            })
        });
    }else if(idArr.length>1){
        $btn.find('a').attr('href' , Url );
    }else if(!idArr.length){
        var $comparisons = $(section).closest('.product_comparisons');
        $(section).prev('[name="app-message"]').remove();
        $(section).remove();
        var child = $comparisons.children();

        if (child[0]){ return ; }

        /**
         * Получение сообщение "Недостаточно товаров для сравнения"
         */
        var dataMes = {
            group : null,
            plugin : null ,
            option : 'com_vm_product_comparisons' ,
            view : 'comparison' ,
            task : 'ajax.getLayot',
            nameLayotValue : 'appmessage',
            dataLayot:{
                message : 'Нет товаров для сравнения ',
            }
        };
        gnz11.getAjax().then(function (Ajax) {
            Ajax.send(dataMes).then(function (r) {
                $( r.html ).appendTo( $comparisons );
                setTimeout(function () {
                    document.location.reload(true);
                },1000)
            })
        });
       console.log($comparisons.children())
    }
    Comparisons.ModulUpdate();
};
/**
 * Перезагрузка страницы после удаление товара из сравнения
 */
Comparisons.reloadComparison_list = function(){
    var $ = jQuery ;
    var Url = Comparisons.comparison_listUrl;
    var idArr = [] ;
    $('.comparison-g-delete').each(function (i,a) {
        var id = $(a).data('product_id');
        idArr.push(id)
    });
    Url = Url+'?ids=' + idArr.join(',');
    if (idArr.length === 1 ){
        Url = Comparisons.comparisonUrl
    }
    window.location.href= Url ;
};
/**
 * Удалить категорию и вернуться в нее
 */
Comparisons.del_cat_comparisons = function( event , catId ){
    event.preventDefault();
    var $ = jQuery ;
    var $this = $(event.target);
    var data = {
        group : null,
        plugin : null ,
        virtuemart_category_id : catId ,
        option : 'com_virtuemart' ,
        view : 'comparisons' ,
        task : 'del_cat_comparisons' ,
    };
    var href = $this.attr('href');
    gnz11.getAjax().then(function (Ajax) {
        Ajax.send(data).then(function (r) {
            window.location.href= href ;
        });
    });
};
/**
 * Удалить категорию из сравненния
 * @param event
 * @private
 */
Comparisons._DELCategory = function(event){
    event.preventDefault();
    var $ = jQuery ;
    var $this = $(event.target);

    var t = $('#TPML-popup');
    var popUP = $( $.trim(  t.html()  ));
    var $catNameElem = $this.closest('.comparison-list-sect-header').find('.comparison-list-sect-header-title .catName') ;
    var catName = $catNameElem.text();
    var catId =  $catNameElem.data('cat-id');
    var catBlock =  $this.closest('.comparison-list-sect');

    popUP.find('span.catName').text(catName);
    var gnz11 = new gn_z11();
    gnz11.__loadModul.Fancybox().then(function (a) {
        a.open( popUP , {
            touch: !1,
            beforeShow : function ( instance, current ) {},
            afterShow : function ( instance, current ) {
                var $el = $('.popup-content.fancybox-content') ;
                $('.popup-info-tools .popup-info-tools-btn').on('click', function (event) {
                    event.preventDefault();
                    var $this = $(event.target);
                    var data = {
                        group : null,
                        plugin : null ,
                        virtuemart_category_id : catId ,
                        option : 'com_virtuemart' ,
                        view : 'comparisons' ,
                        task : 'del_cat_comparisons'
                    };
                    gnz11.getAjax().then(function (Ajax) {
                        Ajax.send( data ).then(function (r) {
                            if (r){

                                catBlock.remove();
                                var sect = $('.comparison-list-content').find('.comparison-list-sect');
                                if(!sect[0]){
                                    document.location.reload(true);
                                }
                                a.close();
                            }
                        },function (err) {
                            console.error(err)
                        })
                    },function (err) {
                        console.error(err)
                    });
                });
                $('.popup-info-tools-btn-cancel').on('click' , function (event) {
                    event.preventDefault();
                    a.close();
                })
            },
            afterClose : function ( instance, current ) {
                // Обновление модуля сравнения
                Comparisons.ModulUpdate();
            },
        });
    });
};
/**
 * Нажатие на кнопку ТОЛЬКО ОТЛИЧИЯ
 * @param event
 */
Comparisons.onlyDifferent = function(event){
    event.preventDefault();
    var $ = jQuery ;
    $('.comparison-t').find('[name="different"]').each(function (i,a) {
       var $cell =  $(a).find('.comparison-t-cell.differences');
       if (!$cell[0]){
           $(a).addClass('hide')
       }
    });
    var $menu =$('#compare-menu');
    var $link = Comparisons._getLink('Все параметры');
    $link.on('click' ,  Comparisons.allParams );
    $menu.find('.active').parent().empty().append($link).removeClass('active');
    $menu.find('a[href="#only-different"]').addClass('active')
};
/**
 * Нажатие на кнопку ВСЕ ПАРАМЕТРЫ
 * @param event
 */
Comparisons.allParams = function (event){
    event.preventDefault();
    var $ = jQuery ;
    $('.comparison-t').find('[name="different"].hide').removeClass('hide');
    var $menu =$('#compare-menu');
    $menu.find('.active').removeClass('active');
    $menu.find('[href="#all"]').addClass('active');
};
/**
 * Создание ссылки ВСЕ ПАРАМЕТРЫ
 * @param txt
 * @returns {jQuery|jQuery|HTMLElement}
 * @private
 */
Comparisons._getLink = function(txt){
    var $ = jQuery ;
    return $('<a />', {
        text : txt ,
        class : 'm-tabs-link novisited',
        css : {
            'cursor':'pointer' ,
            'text-decoration': 'none' ,
        },
        href : '#all',

    });
};
/**
 * Event - Обновление модуля сравнения
 * @constructor
 */
Comparisons.ModulUpdate = function () {
    var $ = jQuery ;
    var gnz11 = new gn_z11();
    var $elModul = $('[name="splash-button"]');

    var TASK = 'get_js_layot' ;
    if ( $elModul.hasClass('comparison-m')){
        TASK = 'get_js_layot_mobile' ;
    }
    var data = {
        option: 'com_virtuemart',
        group: null,
        plugin: null,
        view: 'comparisons',
        task: TASK,
        layot: 'menu.comparison',
    };
    gnz11.getAjax().then(function (Ajax) {
        Ajax.send( data ).then(function (r) {
             $('[name="splash-button"]').parent().html(r.html);
            // console.log(r.html)
        },function (err) {
            console.log( err )
        })
    });

    // console.log( this )
};
















