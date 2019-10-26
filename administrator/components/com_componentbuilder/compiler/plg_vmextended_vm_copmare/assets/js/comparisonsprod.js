document.addEventListener("DOMContentLoaded", function () {
    var $=jQuery;
    $('.comparison-title').find('a.blacklink').on('click',function (event) {
        event.preventDefault();

    });
    setTimeout(function () {
        if ( typeof gn_z11  === 'undefined' ) {
            var I;
            I = setInterval( function () {
                if ( typeof gn_z11 === 'function') {
                    clearInterval(I);
                    product_cartInit();
                }
            }, 1500);
        }else {
            setTimeout(function() {
                product_cartInit();
            },1500)
        }



        document.addEventListener("gn_z11Loaded", function () {
            product_cartInit()
        });

    },500);



});


function  product_cartInit() {
    var $ = jQuery ;
    var img = $('.c-section-g-i-image,.comparison-g-top-b').find('img');
    var gnz11 = new gn_z11();
    var Load=['/plugins/vmextended/vm_copmare/assets/js/comparisons.core.js'];

    $(img).each(function ( i , a ) {
        var image = $(a).data('image');
        $(a).attr('src' ,image )
    });

    gnz11.loadAssets(Load).then(function () {
        // $('.browse-view').on('click' , '.c-section-g-i-delete' ,  function (event) {
        //     event.preventDefault();
        //     Comparisons._DEL(this);
        //
        //     $(this).closest('.c-section-g-i').remove()
        //
        // });
    },function (err) {
        console.error(err)
    });

}// END FN
