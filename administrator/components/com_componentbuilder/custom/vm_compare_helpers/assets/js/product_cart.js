document.addEventListener("DOMContentLoaded", function () {
    setTimeout(function () {

        document.addEventListener("gn_z11Loaded", function () {
            product_cartInit()
        });

    },500);

    var $ = jQuery ;
    var img = $('.c-section-g-i-image').find('img');

    $(img).each(function ( i , a ) {
        var image = $(a).data('image');
        $(a).attr('src' ,image )
    });

});

function  product_cartInit() {
    var $ = jQuery ;
    var img = $('.c-section-g-i-image, .comparison-g-top-b').find('img');
    var gnz11 = new gn_z11();
    var Load = ['/plugins/vmextended/vm_copmare/assets/js/comparisons.core.js'];
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