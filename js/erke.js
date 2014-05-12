ymaps.ready(init);
    var myMap,
        myPlacemark, 
        coord;

    function init(){     
        myMap = new ymaps.Map ("map", {
            center: [43.341499, 76.903607],
            zoom: 11,
        });

        myMap.controls.add("zoomControl")
        .add(new ymaps.control.SearchControl({provider: "yandex#publicMap",  useMapBounds: true})); 

        
        var ok = false;
        myMap.events.add("click",
            function(e) {
                coord = e.get("coordPosition");
                myMap.balloon.open(                    
                    coord, 
                    {                        
                        contentBody: '<button id="mam">Erke</button>'
                    }   
                )
            erkew(); 
            }
        );
        
            var myPlacemark2 = new ymaps.Placemark(coord, { 
                content: "Москва!", 
                balloonContent: name
            });
            myMap.geoObjects.add(myPlacemark2);
        
    }

    function erkew(){
        $('#Place_latitude').val(coord[0]);        
        $('#Place_longitude').val(coord[0]);
    }
    $("#mam").click(function () {
        
    });

    $(".karta").click(function(){   
        console.log(coord);
        var name = this.title;     
        var long = this.id;
        var lat = this.name;
        myMap.setCenter([long, lat]);
        var myPlacemark = new ymaps.Placemark([long, lat], { 
            content: "Москва!", 
            balloonContent: name
        });

        myMap.geoObjects.add(myPlacemark);
        
    return false;
});
