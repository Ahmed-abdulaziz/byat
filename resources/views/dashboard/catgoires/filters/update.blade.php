@extends('layouts.dashboard.app')

@section('content')
<style>
        .vodiapicker{
          display: none; 
        }
        
        #a{
          padding-left: 0px;
        }
        
        #a img, .btn-select img{
          width: 34px;
          
        }
        
        #a li{
          list-style: none;
          padding-top: 5px;
          padding-bottom: 5px;
        }
        
        #a li:hover{
         background-color: #F4F3F3;
        }
        
        #a li img{
          margin: 5px;
        }
        
        #a li span, .btn-select li span{
          margin-left: 30px;
        }
        
        /* item list */
        
        .b{
          display: none;
          width: 100%;
          max-width: 350px;
          box-shadow: 0 6px 12px rgba(0,0,0,.175);
          border: 1px solid rgba(0,0,0,.15);
          border-radius: 5px;
          
        }
        
        .open{
          display: show !important;
        }
        
        .btn-select{
          /*margin-top: 10px;*/
          width: 100%;
          max-width: 350px;
          /*height: 34px;*/
          border-radius: 5px;
          background-color: #fff;
          border: 1px solid #ccc;
         
        }
        .btn-select li{
          list-style: none;
          float: left;
          padding-bottom: 0px;
        }
        
        .btn-select:hover li{
          margin-left: 0px;
        }
        
        .btn-select:hover{
          background-color: #F4F3F3;
          border: 1px solid transparent;
          box-shadow: inset 0 0px 0px 1px #ccc;
          
          
        }
        
        .btn-select:focus{
           outline:none;
        }
        
        .lang-select{
          margin-left: 50px;
        }

/**/




.loader3 {
    width: 100%;
    height: 100%;
    display: inline-block;
    padding: 0px;
    text-align: left;
    background: #fff;
    z-index: 10000;
    position: absolute;
}
.loader3 span {
    position:absolute;
    display:inline-block;
    width:50px;
    height:50px;
    border-radius:100%;
    background:rgba(135, 211, 124,1);
    -webkit-animation:loader3 1.5s linear infinite;
    animation:loader3 1.5s linear infinite;
    left: 45%;
    top: 30%;
}
.loader3 span:last-child {
   animation-delay:-0.9s;
   -webkit-animation-delay:-0.9s;
}
@keyframes loader3 {
   0% {transform: scale(0, 0);opacity:0.8;}
   100% {transform: scale(1, 1);opacity:0;}
}
@-webkit-keyframes loader3 {
   0% {-webkit-transform: scale(0, 0);opacity:0.8;}
   100% {-webkit-transform: scale(1, 1);opacity:0;}
}


.p-snaper{
    left: 41%;
    font-size: 28px;
    top: 25%;
    position: relative;
}



</style>



<div id="snapper" ><div class="loader3">
    <p class="p-snaper">Uploding Image</p>
    <span></span>
    <span></span>

</div></div>
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
                            <h3 class="box-title">@lang('site.update')</h3>
                        </div>
                        @include('partials._errors')
                        <form role="form" action="{{route('dashboard.update_filters',$data->id)}}" method="post" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="box-body">
                                   <div class="col-md-8 form-group">
                                    <label for="">@if(app()->getLocale() == 'en') Choice Main Filter @else  اختر الفلتر الرئيسي @endif</label>
                                        <select class="form-control main_filter" name="main_filter" >
                                                <option value="">@if(app()->getLocale() == 'en') Choice Main Filter @else  اختر الفلتر الرئيسي @endif</option>
                                                @foreach($category_items as $item)
                                                    <option  @if($data->parent_category_items == $item->id) selected @endif  value="{{$item->id}}">{{$item->name}}</option>
                                                @endforeach
                                        </select>
                                </div>
                                <div class="col-md-8 form-group">
                                    <label for="">@lang('site.Arabic Name')</label>
                                    <input type="text" name="name_ar" value="{{$data->name_ar}}" required class="form-control" id="" placeholder="">
                                </div>
                                <div class="col-md-8 form-group">
                                    <label for="">@lang('site.English Name')</label>
                                    <input type="text" name="name_en" value="{{$data->name_en}}"  required class="form-control" id="" placeholder="">
                                </div>
                                  <div class="col-md-8 form-group">
                                    <label for="">@lang('site.type')</label>
                                        <select class="form-control selecttype" name="type" required >
                                            <option value="">@if(app()->getLocale() == 'en') Choice type @else  اختر النوع @endif</option>
                                            <option   @if($data->type == 1) selected @endif value="1">@if(app()->getLocale() == 'en') Single Choice @else اختيار واحد @endif</option>
                                             <option  @if($data->type == 2) selected @endif value="2">@if(app()->getLocale() == 'en') Multi Choice @else متعدد الاختيار @endif</option>
                                              <option @if($data->type == 3) selected @endif value="3">@if(app()->getLocale() == 'en') Text @else نص @endif</option>
                                        </select>
                                </div>
                                    <div class="col-md-8 form-group">
                                    <div class="form-check">
                                        <input type="checkbox" value="1" @if($data->can_skip == 1) checked @endif  class="form-check-input" name="can_skip">
                                        <label class="form-check-label" for="exampleCheck1">@lang('site.can skip')</label>
                                      </div>
                                     
                                </div>
                       
                             <div class="col-md-12 form-group checkform">
                                    <label for="">@lang('site.check form')</label>
                                        <select class="form-control  vodiapicker" name="check_fom" required >
                                            @if($data->check_fom == 1)
                                                <option value="1" class="test" data-thumbnail="{{asset('dashboard/img/radio.png')}}"></option>
                                                <option value="2"  class="test" data-thumbnail="{{asset('dashboard/img/check.png')}}"></option>

                                            @else
                                                <option value="2"  class="test" data-thumbnail="{{asset('dashboard/img/check.png')}}"></option>
                                                <option value="1" class="test" data-thumbnail="{{asset('dashboard/img/radio.png')}}"></option>
                                            @endif
                                               
                                        </select>
                                        
                                         <div class="lang-select">
                                                <button type="button" class="btn-select" value=""></button>
                                                <div class="b">
                                                     <ul id="a">
                                                     </ul>
                                                </div>
                                         </div>

                                </div>
                                        
                                 <div class="col-md-12 form-group main_items">
                                      <div class="form-check have_images" style="margin-top: 26px;">
                                        <input type="checkbox" value="1" class="form-check-input have_image" name="have_images">
                                        <label class="form-check-label" for="exampleCheck1">@lang('site.Items Have Images')</label>
                                      </div>
                                      
                                        <hr>
                                        
                                            <label>@lang('site.items')</label>
                                            <button type="button" class="btn btn-success " style="margin: 26px 0 ;" id="addnew">@lang('site.add')</button>
                                       
                                            <div id="items">
                                                @if($data->type == 1 || $data->type == 2)
                                                    @foreach($componants as $componant)
                                                        <div class="row items">
                                                            <input hidden value="{{$componant->id}}" class="componant_id" />
                                                             <input hidden value="{{$data->type}}" class="type" />
                                                                <div class="col-md-2">
                                                                       <label for="">@lang('site.Arabic Name')</label>
                                                                        <input type="text"  value="{{$componant->name_ar}}" required filedname = "name_ar" class="form-control update_name" />
                                                                </div>
                                                                <div class="col-md-2">
                                                                       <label for="">@lang('site.English Name')</label>
                                                                        <input type="text"  value="{{$componant->name_en}}" required filedname = "name_en" class="form-control update_name" />
                                                                </div>
                                                                @if(!empty($componant->image))
                                                                     <div class="col-md-2 images-uplodaed-{{$componant->id}}">
                                                                            <img src="{{asset('uploads/catgoires/filter_selection/'.$componant->image)}}" style="width:100px;"   />
                                                                            
                                                                    </div>
                                                                     

                                                                 @endif
                                                                     
                                                                  <div class="col-md-2">
                                                                       <label for="images">@lang('site.image')</label>
                                                                        <input type="file" id="updateImage" class="form-control itemsimage" onchange="loadFile(event,{{$componant->id}})" />
                                                                </div>
                                                                @if(!empty($data->parent_category_items))
                                                                     <div class="col-md-2">
                                                                           <label for="images">@lang('site.Category-name')</label>
                                                                           <select class="form-control parent_category_items" >
                                                                               @foreach($parent_category_items as $item)
                                                                                
                                                                                  <option @if($componant->parent_category_components == $item->id ) selected @endif value="{{$item->id}}">{{$item->name}}</option>  
                                                                                   @endforeach
                                                                          </select>
                                                                    </div>
                                                                 @endif
                                                                <div class="col-md-2" style="margin-top: 22px;">
                                                                        <button type="button" class="btn btn-danger deletebtn-old">@lang('site.delete')</button>
                                                                </div>
                                                        </div>
                                                        @endforeach
                                                @endif
                                            </div>
                                </div>
                                
                                
                                <!------------------------------------------------------------------------>
                                <div class="col-md-12 form-group main_items_inputs">
                                            <label>@lang('site.inputs')</label>
                                            <button type="button" class="btn btn-success " style="margin: 26px 0 ;" id="addnewitems_inputs">@lang('site.add')</button>
                                            
                                            <div id="items_inputs">
                                                 @if($data->type == 3)
                                                    @foreach($componants as $componant)
                                                        <div class="row inputs border">
                                                            <input hidden value="{{$componant->id}}" class="componant_id" />
                                                             <input hidden value="{{$data->type}}" class="type" />
                                                                <div class="col-md-2">
                                                                        <label for="">@lang('site.title_ar')</label>
                                                                        <input type="text"  value="{{$componant->title_ar}}"  required filedname = "title_ar" class="form-control update_name" />
                                                                </div>
                                                                <div class="col-md-2">
                                                                        <label for="">@lang('site.title_en')</label>
                                                                        <input type="text"  value="{{$componant->title_en}}" required filedname = "title_en" class="form-control update_name" />
                                                                </div>
                                                                <div class="col-md-2">
                                                                        <label for="">@lang('site.placeholder_ar')</label>
                                                                        <input type="text" value="{{$componant->placeholder_ar}}"  filedname = "placeholder_ar" class="form-control update_name" />
                                                                </div>
                                                                
                                                                <div class="col-md-2">
                                                                        <label for="">@lang('site.placeholder_en')</label>
                                                                        <input type="text" value="{{$componant->placeholder_en}}"  filedname = "placeholder_en" class="form-control update_name" />
                                                                </div>
                                                                <div class="col-md-1">
                                                                        <label for="">@lang('site.unit_ar')</label>
                                                                        <input type="text"  value="{{$componant->unit_ar}}" filedname = "unit_ar" class="form-control update_name" />
                                                                </div>
                                                                
                                                                <div class="col-md-1">
                                                                        <label for="">@lang('site.unit_en')</label>
                                                                        <input type="text"  value="{{$componant->unit_en}}"  filedname = "unit_en" class="form-control update_name" />
                                                                </div>
                                                                
                                                                 <div class="col-md-2" style="margin-top: 22px;">
                                                                        <button type="button" class="btn btn-danger deletebtn-old">@lang('site.delete')</button>
                                                                </div>
                                                               
                                                            </div>
                                                    @endforeach
                                                @endif
                                            </div>
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

@endsection
@section('javascript')
<script>
    $("#snapper").hide();
</script>
<script>
       $("#addnewitems_inputs").click(function () {
              $("#items_inputs").append(`<div class="row inputs border">
                                                <div class="col-md-2">
                                                        <label for="">@lang('site.title_ar')</label>
                                                        <input type="text" name="inputs_title_ar[]" value="" required class="form-control" />
                                                </div>
                                                <div class="col-md-2">
                                                        <label for="">@lang('site.title_en')</label>
                                                        <input type="text" name="inputs_title_en[]" value="" required class="form-control" />
                                                </div>
                                                <div class="col-md-2">
                                                        <label for="">@lang('site.placeholder_ar')</label>
                                                        <input type="text" name="inputs_placeholder_ar[]" value=""  class="form-control" />
                                                </div>
                                                
                                                <div class="col-md-2">
                                                        <label for="">@lang('site.placeholder_en')</label>
                                                        <input type="text" name="inputs_placeholder_en[]" value=""  class="form-control" />
                                                </div>
                                                <div class="col-md-1">
                                                        <label for="">@lang('site.unit_ar')</label>
                                                        <input type="text" name="inputs_unit_ar[]" value=""  class="form-control" />
                                                </div>
                                                
                                                <div class="col-md-1">
                                                        <label for="">@lang('site.unit_en')</label>
                                                        <input type="text" name="inputs_unit_en[]" value=""  class="form-control" />
                                                </div>
                                                
                                                 <div class="col-md-2" style="margin-top: 22px;">
                                                        <button type="button" class="btn btn-danger deletebtn">@lang('site.delete')</button>
                                                </div>
                                               
                                            </div>`);
                                       
            });
           
            $("#addnew").click(function () {
                var main_filter = $('.main_filter').val();
                if(main_filter == ''){
                              $("#items").append(`<div class="row items">
                                        <div class="col-md-2">
                                               <label for="">@lang('site.Arabic Name')</label>
                                                <input type="text" name="items_name_ar[]" required class="form-control" />
                                        </div>
                                        <div class="col-md-2">
                                               <label for="">@lang('site.English Name')</label>
                                                <input type="text" name="items_name_en[]" required class="form-control" />
                                        </div>
                                          <div class="col-md-2">
                                               <label for="images">@lang('site.image')</label>
                                                <input type="file" name="images[]"  class="form-control itemsimage" />
                                        </div>
                                        <div class="col-md-2" style="margin-top: 22px;">
                                                <button type="button" class="btn btn-danger deletebtn">@lang('site.delete')</button>
                                        </div>
                                    </div>`);
                }else{
                       $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                    });
                 $.ajax({
                        type: 'post',
                        url: '{{ route("dashboard.GetCategoryItems") }}',
                        dataType: 'json',
                        data: {
                        catgory:main_filter
                        },
                        success: function (response) {
                        var len = 0;
                        var arr = [];
                              if(response['data'] != null){
                                  len = response['data'].length;
                              }
                              if(len > 0){
                                  for(var i=0; i<len; i++){
                                     var id = response['data'][i].id;
                                     var name = response['data'][i].name_ar;
                                            var str= "<option value="+ id +">" + name + "</option>";
                                            arr.push(str);
                                  }
                              }else{
                                            var str = "<option value=''>Not Found Data</option>";
                                             arr.push(str);
                              }
                                $("#items").append(`<div class="row items">
                                        <div class="col-md-2">
                                               <label for="">@lang('site.Arabic Name')</label>
                                                <input type="text" name="items_name_ar[]" required class="form-control" />
                                        </div>
                                        <div class="col-md-2">
                                               <label for="">@lang('site.English Name')</label>
                                                <input type="text" name="items_name_en[]" required class="form-control" />
                                        </div>
                                          <div class="col-md-2">
                                               <label for="images">@lang('site.image')</label>
                                                <input type="file" name="images[]"  class="form-control itemsimage" />
                                        </div>
                                         <div class="col-md-2">
                                               <label for="images">@lang('site.Category-name')</label>
                                               <select class="form-control" name="parent_category_components[]">
                                                        `+ arr +`
                                              </select>
                                        </div>
                                        <div class="col-md-2" style="margin-top: 22px;">
                                                <button type="button" class="btn btn-danger deletebtn">@lang('site.delete')</button>
                                        </div>
                                    </div>`);
                        }
                    });
                }
    
                                       
            });
            
              $(document).on('click', '.deletebtn-old', function() {
                
                     if(!confirm("Are you sure you want to delete ?")){e.preventDefault();}
                     var componant_id   = $(this).parent().parent().closest('div').find(".componant_id").val();
                     var type           = $(this).parent().parent().closest('div').find(".type").val();
                     var div            = $(this).parent().parent();
                     
                    console.log(componant_id + ' componant_id');
                     console.log(type + ' type');
                     
                      $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                    });
                     $.ajax({
                            type: 'post',
                            url: '{{ route("dashboard.delete_componant_filter") }}',
                            data: {
                                componant_id:componant_id,
                                type:type,
                            },
                            success: function (response) {
                                console.log(response);
                                div.remove();
                                
                                new Noty({
                                    type: 'success',
                                    layout: 'topRight',
                                    text: response,
                                    timeout: 1000,
                                    killer: true
                                }).show();
                            
                            }
                        });


         
                // $(this).parent().parent().remove();
            });
            $(document).on('click', '.deletebtn', function() {
                    $(this).parent().parent().remove();
            });
            
                @if($data->type == 1)
                        $(".have_images").hide();
                        $(".main_items_inputs").hide();
                @elseif($data->type == 2)
                        $(".checkform").hide();
                        $(".main_items_inputs").hide();
                @elseif($data->type == 3)
                        $(".have_images").hide();
                        $(".checkform").hide();
                        $(".main_items").hide();
                @endif
                
            $(".selecttype").change(function(){
                console.log($(this).val()); 
                
                var value = $(this).val();
                if(value == 3){             //text
                        $(".items").remove();
                        $(".main_items").hide();
                        $(".checkform").hide();
                        $(".have_images").hide();
                        $(".main_items_inputs").show();
                }else if(value == 2){       // multi select
                        $(".inputs").remove();
                        $(".main_items").show();
                        $(".have_images").show();
                        $(".checkform").hide();
                        $(".main_items_inputs").hide();
                }else if(value == 1){       // single select
                        $(".have_images").hide();
                        $(".checkform").show();
                        $(".main_items").show();
                        $(".inputs").remove();
                        $(".main_items_inputs").hide();
                }
            });
            
            if ($('.have_image').prop('checked')) {
                //blah blah
            }
       
       
       
      
</script>

 <script type="text/javascript">
    $(function()
    {
      $('.have_image').change(function()
      {
        if ($(this).is(':checked')) {
             $(".itemsimage").prop('required',true);
        }else{
             $('.itemsimage').removeAttr('required');
        }
      });
    });
    
    
     
  </script>

<script>
    //test for getting url value from attr
// var img1 = $('.test').attr("data-thumbnail");
// console.log(img1);

//test for iterating over child elements
var langArray = [];
$('.vodiapicker option').each(function(){
  var img = $(this).attr("data-thumbnail");
  var text = this.innerText;
  var value = $(this).val();
  var item = '<li><img src="'+ img +'" alt="" value="'+value+'"/><span>'+ text +'</span></li>';
  langArray.push(item);
})

$('#a').html(langArray);

//Set the button value to the first el of the array
$('.btn-select').html(langArray[0]);
$('.btn-select').attr('value', 'en');

//change button stuff on click
$('#a li').click(function(){
   var img = $(this).find('img').attr("src");
   var value = $(this).find('img').attr('value');
   var text = this.innerText;
   var item = '<li><img src="'+ img +'" alt="" /><span>'+ text +'</span></li>';
  $('.btn-select').html(item);
  $('.btn-select').attr('value', value);
  $(".b").toggle();
  
  $('.vodiapicker option').val(value).attr("selected", "selected");
  //console.log(value);
});

$(".btn-select").click(function(){
        $(".b").toggle();
    });

//check local storage for the lang
var sessionLang = localStorage.getItem('lang');
if (sessionLang){
  //find an item with value of sessionLang
  var langIndex = langArray.indexOf(sessionLang);
  $('.btn-select').html(langArray[langIndex]);
  $('.btn-select').attr('value', sessionLang);
} else {
   var langIndex = langArray.indexOf('ch');
  console.log(langIndex);
  $('.btn-select').html(langArray[langIndex]);
  //$('.btn-select').attr('value', 'en');
}



</script>

--------------------------------Update------------------------------------>
<script>
   $(".update_name").keyup(function(){
         var componant_id   = $(this).parent().parent().closest('div').find(".componant_id").val();
         var value          = $(this).val();
         var fieldname      = $(this).attr("filedname");
         var type           = $(this).parent().parent().closest('div').find(".type").val();
         
        console.log(value + ' Value');
        console.log(componant_id + ' componant_id');
        console.log(fieldname + ' fieldname');
         console.log(type + ' type');
        
         $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
        });
     $.ajax({
            type: 'post',
            url: '{{ route("dashboard.update_componant_filter") }}',
            data: {
                componant_id:componant_id,
                value:value,
                fieldname:fieldname,
                type:type,
            },
            success: function (response) {
                console.log(response);
                   new Noty({
                                type: 'success',
                                layout: 'topRight',
                                text: response,
                                timeout: 1000,
                                killer: true
                            }).show();
            }
        });

  });
</script>
<script>
    $('.itemsimage').change(function (e) {
            $("#snapper").show();
            image               = e.target.files[0];
            var formData        = new FormData();
            var componant_id    = $(this).parent().parent().closest('div').find(".componant_id").val();
            var div             = $(this);
            formData.append('image', image);
            formData.append('componant_id', componant_id);
            
            var reader = new FileReader();
    
   
        $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
            });
            

            $.ajax({
                cache: false,
                contentType: false,
                processData: false,
                type: 'post',
                data: formData,
                url: "{{ route('dashboard.update_componant_image') }}",
                success: function (response) {
                    console.log(response);
                    // ----------------------update image view-----------------------------------------
                     reader.onload = function(){
                            $(".images-uplodaed-"+componant_id).empty();
                            $(".images-uplodaed-"+componant_id).append(`<img src='`+reader.result+`'  style="width:100px;" " /> `);
                           
                        };
                        reader.readAsDataURL(e.target.files[0]);
                // ------------------------------------------------------------------------------------------
              
                    div.val('');
                      $("#snapper").hide();
                      
                         new Noty({
                                type: 'success',
                                layout: 'topRight',
                                text: response,
                                timeout: 1000,
                                killer: true
                            }).show();
                            
                }
            });

        });
</script>

<script>
    
      $('.parent_category_items').change(function (e) {
             var componant_id   = $(this).parent().parent().closest('div').find(".componant_id").val();
             var value          = $(this).val();
             var fieldname      = 'parent_category_components';
             var type           = $(this).parent().parent().closest('div').find(".type").val();
   
           $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                    });
                     $.ajax({
                        type: 'post',
                        url: '{{ route("dashboard.update_componant_filter") }}',
                        data: {
                            componant_id:componant_id,
                            value:value,
                            fieldname:fieldname,
                            type:type,
                        },
                        success: function (response) {
                            console.log(response);
                            
                            new Noty({
                                type: 'success',
                                layout: 'topRight',
                                text: response,
                                timeout: 1000,
                                killer: true
                            }).show();
                        }
                    });

        });
</script>

@endsection


