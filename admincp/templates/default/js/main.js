

function slider_item(index){
    var owl = $("#slider_item"+index);
    owl.owlCarousel({
        itemsCustom : [
            [0, 2],
            [450, 2],
            [600, 3],
            [700, 3],
            [1000, 3],
            [1200, 3]
        ],
        margin: 20,
        pagination: false,
        navigation : false,
        navigationText : ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>']

    });
    $(".prev"+index).click(function () {
        owl.trigger('owl.prev');
    });

    $(".next"+index).click(function () {
        owl.trigger('owl.next');
    });
}



$(document).ready(function() {
    var owl = $("#owl-slide");
    owl.owlCarousel({
        itemsCustom : [
            [0, 2],
            [450, 2],
            [600, 3],
            [700, 3],
            [1000, 4],
            [1200, 4]
        ],
        navigationText : ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
        pagination: false,
        navigation : true

    });

});


