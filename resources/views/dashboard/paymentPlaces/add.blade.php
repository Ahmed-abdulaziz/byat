@extends('layouts.dashboard.app')

@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <h1>
                <small></small>
            </h1>

            <ol class="breadcrumb">
                <li class="active"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</li>
            </ol>
        </section>

        <section class="content">

            <div class="row">
                <div class="col-md-12">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">@lang('site.Payment Places')</h3>
                        </div>
                        @include('partials._errors')
                        <form role="form" action="{{route('dashboard.paymentPlaces.store')}}" method="post" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="box-body">

                                <div class="col-md-8 form-group">
                                    <label for="">@lang('site.name')</label>
                                    <input type="text" name="name" class="form-control" id="">
                                </div>

                                <div class="form-group">
                                    <input type="text" id="address-input" name="address_address" class="form-control map-input" required>
                                    <input type="hidden" name="lat" id="address-latitude" value="0" />
                                    <input type="hidden" name="long" id="address-longitude" value="0" />

                                </div>

                                <div id="address-map-container" style="width:100%;height:400px; ">
                                    <div style="width: 100%; height: 100%" id="address-map"></div>
                                </div>


                            </div>
                            <!-- /.box-body -->

                            <div class="box-footer">
                                <button type="submit" class="btn btn-primary">@lang('site.Save')</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>



        </section><!-- end of content -->

    </div><!-- end of content wrapper -->
    <script src="https://maps.googleapis.com/maps/api/js?key=&libraries=places&callback=initialize" async defer></script>
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
@endsection
