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
                            <h3 class="box-title">@lang('site.description')</h3>
                        </div>
                        <form role="form">
                            {{ csrf_field() }}
                            <div class="box-body">
                                
                                <div class="col-md-3 form-group">
                                    <label for="">@lang('site.Name')</label>
                                    <p>{{$advertisments->name}}</p>
                                </div>
                                  <div class="col-md-3 form-group">
                                    <label for="">@lang('site.price')</label>
                                     <p>{{$advertisments->price}}</p>
                                </div>
                                <div class="col-md-3 form-group">
                                    <label for="">@lang('site.phone')</label>
                                     <p>{{$advertisments->phone}}</p>
                                </div>
                              
                                 <div class="col-md-3 form-group">
                                    <label for="">@lang('site.whatsapp')</label>
                                    <p>{{$advertisments->whatsapp}}</p>
                                </div>
                                  <div class="col-md-3 form-group">
                                     <a class="btn" href="{{asset('uploads/advexamination_certificate/'.$advertisments->examination_certificate)}}" target="_blank"> 
                                          @lang('site.examination_certificate')
                                    </a> 
                                </div>
                                <div class="col-md-3 form-group">
                                        <label>@lang('site.Category-name')</label>
                                         <p>{{$categores->name}}</p>
                                </div>
                              <div class="col-md-3  form-group">
                                        <label>@lang('site.Areas')</label>
                                        <p>{{$areas->name}}</p>
                                </div>
                                <div class="col-md-12 form-group">
                                        <label>@lang('site.filters')</label>
                                         <div class="row">
                                         @foreach($filters as $filter)
                                         @php
                                            $main = \App\category_items::find($filter->category_item_id);
                                            if($main->type != 3){
                                                $sub = \App\category_item_components::find($filter->category_item_component_id)->name;
                                            }else{
                                                $sub = $filter->text;
                                            }
                                         @endphp
                                            <div class="col-md-3 m-2 ">
                                                <button type="button" class="btn btn-info">{{$main->name}}</button>
                                                <button type="button" class="btn btn-primary">{{$sub}}</button>
                                            </div>
                                    @endforeach
                                    </div>
                                </div>
                                  <div class="col-md-12 form-group">
                                    <label for="">@lang('site.description')</label>
                                    <p>{{$advertisments->description}}</p>
                                </div>
                                  <div class="col-md-12 form-group">
                                    <label for="">@lang('site.images')</label>
                                    <div class="row">
                                         @foreach($images as $image)
                                            <div class="col-md-3 m-2">
                                                    <a href="{{asset('uploads/advimage/'.$image->img)}}" target="_blank">  <img  style="width:100%" src="{{asset('uploads/advimage/'.$image->img)}}" /> </a> 
                                            </div>
                                             @endforeach
                                    </div>
                                </div> 

                            </div>
                            <!-- /.box-body -->


                        </form>
                    </div>
                </div>
            </div>



        </section><!-- end of content -->

    </div><!-- end of content wrapper -->
<script>
    function deleteimg(id){
        console.log(id);
        
              $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
        });
         $.ajax({
                type: 'post',
                url: '{{ route("dashboard.advertisments_delete_image") }}',
                data: {
                  id:id
                },
                success: function (response) {
                    
                    $(".img-"+id).hide();
                  
                }
            });
        
    }
</script>
@endsection
