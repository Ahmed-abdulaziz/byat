<!-- Footer -->
<footer class="p-5 ">
    <div class="container">
        <div class="row">
            <div class="col-lg-3  col-md-6 ">
                <img src="{{asset('frontend/images/logo.png')}}" alt="site-logo">
                <p class="pt-3 text-justfy paragraph">Lorem ipsum dolor sit amet consectetur adipisicing elit. Omnis aut dolorum, vero inventore architecto dolore.</p>
            </div>
            <div class="col-lg-3 col-12 col-md-6  information" style=" display: flex;justify-content: flex-end;">
                <div>
                    <h4 class="pb-2 " >@lang('site.Informations')</h4>
                    <ul class="list-unstyled">
                        <li><a href="{{route('aboutapp')}}">@lang('site.About Us')</a></li>
                        <li><a href="{{route('callus')}}" >@lang('site.callus')</a></li>
                        <li><a href="{{route('allcat')}}">@lang('site.Categories')</a></li>
                        <li><a href="{{route('usingpolicy')}}">@lang('site.usingplocy')</a></li>
                        <li><a href="{{route('dashboard.login')}}">@lang('site.login')</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg col-12 col-md-6  Categories"  style=" display: flex;justify-content: flex-end;">
                <div>
                    <h4 class="pb-2">@lang('site.Categories')</h4>
                    <ul class="list-unstyled">
                        @foreach(collect($xyzx['categoriesx']) as $object)
                            <li><a href="{{route('getcat',$object['id'])}}">{{$object['name']}}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="col-lg col-12 col-md-6   follow-us "style=" display: flex;justify-content: flex-end;">
                <div>
                    <h4 class="pb-2">@lang('site.Follow Us')</h4>
                    <ul class="list-inline follow-ul">
                        <li class="list-inline-item"><a href="{{$Setting->facebook}}"><i class="fab fa-facebook-square follow-icon  follow-icon-1"></i></a></li>
                        <li class="list-inline-item"><a href="{{$Setting->instgram}}"><i class="fab fa-instagram follow-icon follow-icon-2"></i> </a></li>
                        <li class="list-inline-item"><a href="{{$Setting->twwiter}}"><i class="fab fa-twitter follow-icon  follow-icon-3"></i> </a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- end footer -->

<!-- copyright -->
<section class="text-center end">
    <div class="container">
        <p class="m-0 p-2">
            <a href="https://www.tec-soft.net/" target="_blank" rel="noreferrer" style="color: #373373;">
                All Right Reserved &copy; for <img src="{{asset('frontend/images/logo.png')}}" alt="site-logo" width="45px">  Design By <span class="fw-bold" style="color: #FF8038;">Tech Soft</span>
            </a>
        </p>
    </div>
</section>
<!--end copyright -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js" integrity="sha384-q2kxQ16AaE6UbzuKqyBE9/u/KzioAlnx2maXQHiDX9d4/zp8Ok3f+M7DPm+Ib6IU" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.min.js" integrity="sha384-pQQkAEnwaBkjpqZ8RU1fF1AKtTcHJwFl3pblpTlHXybJjHpMYo79HY3hIi4NKxyj" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<!-- <script src="slick/jquery-migrate.js"></script> -->
<script src="{{asset('frontend/slick/slick.min.js')}}"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=&libraries=places&callback=initialize" async defer></script>
<script src="{{asset('frontend/js/main.js')}}"></script>
<script>

    function initialize() {

        $('form').on('keyup keypress', function(e) {
            var keyCode = e.keyCode || e.which;
            if (keyCode === 13) {
                e.preventDefault();
                return false;
            }
        });
        const locationInputs = document.getElementsByClassName("map-input");

        const autocompletes = [];
        const geocoder = new google.maps.Geocoder;
        for (let i = 0; i < locationInputs.length; i++) {

            const input = locationInputs[i];
            const fieldKey = input.id.replace("-input", "");
            const isEdit = document.getElementById(fieldKey + "-latitude").value != '' && document.getElementById(fieldKey + "-longitude").value != '';

            const latitude = parseFloat(document.getElementById(fieldKey + "-latitude").value) || -33.8688;
            const longitude = parseFloat(document.getElementById(fieldKey + "-longitude").value) || 151.2195;

            const map = new google.maps.Map(document.getElementById(fieldKey + '-map'), {
                center: {lat: latitude, lng: longitude},
                zoom: 13
            });
            const marker = new google.maps.Marker({
                map: map,
                position: {lat: latitude, lng: longitude},
            });

            marker.setVisible(isEdit);

            const autocomplete = new google.maps.places.Autocomplete(input);
            autocomplete.key = fieldKey;
            autocompletes.push({input: input, map: map, marker: marker, autocomplete: autocomplete});
        }

        for (let i = 0; i < autocompletes.length; i++) {
            const input = autocompletes[i].input;
            const autocomplete = autocompletes[i].autocomplete;
            const map = autocompletes[i].map;
            const marker = autocompletes[i].marker;

            google.maps.event.addListener(autocomplete, 'place_changed', function () {
                marker.setVisible(false);
                const place = autocomplete.getPlace();

                geocoder.geocode({'placeId': place.place_id}, function (results, status) {
                    if (status === google.maps.GeocoderStatus.OK) {
                        const lat = results[0].geometry.location.lat();
                        const lng = results[0].geometry.location.lng();
                        setLocationCoordinates(autocomplete.key, lat, lng);
                    }
                });

                if (!place.geometry) {
                    window.alert("No details available for input: '" + place.name + "'");
                    input.value = "";
                    return;
                }

                if (place.geometry.viewport) {
                    map.fitBounds(place.geometry.viewport);
                } else {
                    map.setCenter(place.geometry.location);
                    map.setZoom(17);
                }
                marker.setPosition(place.geometry.location);
                marker.setVisible(true);

            });
        }
    }

    function setLocationCoordinates(key, lat, lng) {
        const latitudeField = document.getElementById(key + "-" + "latitude");
        const longitudeField = document.getElementById(key + "-" + "longitude");
        latitudeField.value = lat;
        longitudeField.value = lng;
    }
</script>
<script type="text/javascript">
    $(document).ready(function(){

        $('.autoplaySlider').slick({
            dots: false,
            infinite: true,
            speed: 300,
            autoplay: true,
            arrows:false,
            slidesToShow: 9,
            slidesToScroll: 1,
           @if(app()->getLocale()=='ar')
            rtl: true,
            @else
            rtl: false,
            @endif
            responsive: [
                {
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 6,
                        slidesToScroll: 1,
                    }
                },
                {
                    breakpoint: 600,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 1
                    }
                }
                // You can unslick at a given breakpoint now by adding:
                // settings: "unslick"
                // instead of a settings object
            ]
        });
    });
</script>

<script>

    $(document).ready(function (){

        $(document).on('change','.select2',function () {

            var parent_id=$(this).val();
            var div=$(this).parent();
            var op=" ";
            $.ajax({
                type:'get',
                url:'{{route('dashboard.getsubarea')}}',
                data:{'id':parent_id},
                success:function (subcat) {
                    //console.log('success');
                    //console.log(areas);
                    console.log(subcat)
                    op+='<option value="null" style="width: 100%;" selected disabled>@lang('site.Area')</option>';
                    for(var i=0;i<subcat.length;i++){
                        op+='<option style="width: 100%;" value="'+subcat[i].id+'">@if(app()->getLocale()=='ar')'+subcat[i].name_ar+'@else'+subcat[i].name_en+'@endif</option>';
                    }
                    $("#arrn").html(op);
                }
            })


        });

    });


</script>
<script>

    $(document).ready(function (){

        $(document).on('change','.brandsa',function () {

            var parent_id=$(this).val();
            var div=$(this).parent();
            var op=" ";
            $.ajax({
                type:'get',
                url:'{{route('dashboard.getsubmodel')}}',
                data:{'id':parent_id},
                success:function (subcat) {
                    //console.log('success');
                    //console.log(areas);
                    console.log(subcat)
                    op+='<option value="null" style="width: 100%;" selected disabled>@lang('site.Model')</option>';
                    for(var i=0;i<subcat.length;i++){
                        op+='<option style="width: 100%;" value="'+subcat[i].id+'">@if(app()->getLocale()=='ar')'+subcat[i].name_ar+'@else'+subcat[i].name_en+'@endif</option>';
                    }
                    $("#mod").html(op);
                }
            })


        });

    });


</script>
<script>

    $(document).ready(function (){

        $(document).on('change','.moja',function () {
            var parent_id=$(this).val();
            if(parent_id==2){
                $div=document.getElementById('moja');
                $div.classList.remove('invisible');
            }else{
                $div=document.getElementById('moja');
                $div.classList.add('invisible');
            }
        });

    });



</script>

<script>
    function openForm() {
        document.getElementById("myForm").style.display = "block";
    }
    function openNum() {
        document.getElementById("myNum").style.display = "block";
    }

    function closeForm() {
        document.getElementById("myForm").style.display = "none";
    }
    function closeNum() {
        document.getElementById("myNum").style.display = "none";
    }
</script>
</body>
</html>
