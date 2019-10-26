;Comparisons = window.Comparisons || {};


Comparisons.clickProcess = function(elem){
    event.preventDefault();
    var $ = jQuery ;
    var gnz11 = new gn_z11();

    var $form =  $(elem).closest('form');
    var $a_g_compare = $form.find('a.g-compare') ;

    var DEL = false ;

    if ($a_g_compare.hasClass('g-compare-added')){
        $form.find('[name="task"]').val('del_comparisons');
        DEL = true ;
    }

    var data = $form.serialize();

    gnz11.getAjax().then(function (Ajax) {
        Ajax.send( data ).then(function (r) {
            $a_g_compare.toggleClass('g-compare-added');
            if (DEL ) {
                $form.find('[name="task"]').val('add_comparisons');
            }
            var Event = 'ComparisonsModulUpdate';
            document.dispatchEvent(new CustomEvent(Event));
            console.log(r)
        })
    },function (err) {
        console.error(err)
    });
};
/**
 * Установка кнопок в категории добавить в сравнение !
 * @constructor
 */
Comparisons.Inint = function () {
    var $ = jQuery ;
    var gnz11 = new gn_z11();

    var arrProd = [];
    $('.comparisons.product-blc').each(function (i,elem) {
        var product_id = $(elem).data('product_id');
        arrProd.push( product_id ) ;
    });



    var data = {
        option:'com_virtuemart' ,
        group : null ,
        plugin : null ,
        view:'comparisons' ,
        task:'get_comparisons_form' ,
        Prod :  arrProd ,
        category_id : Comparisons.category_id
    };
    gnz11.getAjax().then(function (Ajax) {
        Ajax.send( data ).then(function (r) {
            $.each(r , function ( id , html ) {
                $('.browse-view').find('[data-product-id="'+id+'"]').find('.comparisons').html(html);
            });

            $('.product-field').on('click' , '.g-tools-to-compare-label' ,  function (event) {
                event.preventDefault();
                Comparisons.clickProcess(this)
            }  );
        })
    },function (err) {
        console.error(err)
    });
};


(function () {
    setTimeout(function() {
        var load=['/plugins/vmextended/vm_copmare/assets/css/product_comparisons_btn.css'];
        if (typeof gn_z11 !== 'function' ){
           var I =  setInterval(function () {
                if ( typeof gn_z11 === 'function' ){
                    clearInterval(I);
                    _load ()
                }
            },1000)
        }else{
            _load ()
        }

        function _load (){
            var gnz11 = new gn_z11();
            gnz11.loadAssets( load ).then(function (a) {
                Comparisons.Inint();
            });
        }


    },500);
})();



































