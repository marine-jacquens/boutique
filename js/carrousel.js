$(document).ready(function(){

    $('.recommendation_1_product').slick({
        dots: false,
        infinite: true,
        speed: 2000,
        slidesToShow: 3,
        slidesToScroll: 2,
        arrows:false,
        autoplay: true,
        autoplaySpeed: 2000,
        /*centerMode:true,
        centerPadding:'8',*/
        responsive: [


            {
                breakpoint: 700,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1
                }
            },
            {
                breakpoint: 500,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            }
            // You can unslick at a given breakpoint now by adding:
            // settings: "unslick"
            // instead of a settings object
        ]
    });



});