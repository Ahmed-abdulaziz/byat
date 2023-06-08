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
                            <h3 class="box-title">@lang('site.edit')</h3>
                        </div>
                        <form role="form" action="{{route('dashboard.advertisments-update-requierments',$advertisments->id)}}" method="post" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="box-body">

                                <div class="col-md-6 form-group">
                                    <label for="">@lang('site.Name')</label>
                                    <input type="text" name="name" class="form-control" required value="{{$advertisments->name}}" id="" placeholder="@lang('site.Name')">
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="">@lang('site.description')</label>
                                    <textarea type="text" name="description" class="form-control" required placeholder="@lang('site.description')">{{$advertisments->description}}</textarea>
                                </div>
                                    <div class="col-md-6 form-group">
                                    <label for="">@lang('site.price')</label>
                                    <input type="number" step="any" name="price" required  class="form-control" id="" value="{{$advertisments->price}}">
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="">@lang('site.phone')</label>
                                    <input type="text" name="phone" required  class="form-control" id="" value="{{$advertisments->phone}}" >
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="">@lang('site.whatsapp')</label>
                                    <input type="text" name="whatsapp" required  class="form-control" id="" value="{{$advertisments->whatsapp}}" >
                                </div>
                                
                                     <div class="col-md-6 form-group">
                                    <label for="">@lang('site.images')</label>
                                    <input type="file"  name="images[]" multiple class="form-control">
                                </div> 
                                <div class="col-md-6  form-group">
                                    @if(isset($categores))
                                        <label>@lang('site.Category-name')</label>
                                        <select class="form-control select2" style="width: 100%;height:110%" required name="cat_id">
                                            <option selected="selected" value=''>@lang('site.Category-name')</option>
                                            @foreach($categores as $single)
                                                @if(app()->getLocale()=='ar')
                                                    <option @if($advertisments->cat_id ==$single->id) {{"selected"}} @endif value="{{$single->id}}">{{$single->name_ar}}</option>
                                                @else
                                                    <option @if($advertisments->cat_id ==$single->id) {{"selected"}} @endif value="{{$single->id}}">{{$single->name_en}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    @endif
                                </div>
                              <div class="col-md-6  form-group">
                                    @if(isset($areas))
                                        <label>@lang('site.Areas')</label>
                                        <select class="form-control select2" style="width: 100%;height:110%" required name="place_id">
                                            <option selected="selected" value=''>@lang('site.Areas')</option>
                                            @foreach($areas as $single)
                                                @if(app()->getLocale()=='ar')
                                                    <option @if($advertisments->place_id ==$single->id) {{"selected"}} @endif value="{{$single->id}}">{{$single->name_ar}}</option>
                                                @else
                                                    <option  @if($advertisments->place_id ==$single->id) {{"selected"}} @endif value="{{$single->id}}">{{$single->name_en}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    @endif
                                </div>
                                
                                  <div class="col-md-12 form-group">
                                    <label for="">@lang('site.images')</label>
                                    <div class="row">
                                         @foreach($advertisments->images as $image)
                                            <div class="col-md-3 m-2 img-{{$image->id}}">
                                                    <button style="position: absolute;"  onclick="deleteimg({{$image->id}})" type="button" class="btn btn-danger">X</button>
                                                    <a href="{{asset('uploads/advimage/'.$image->img)}}" target="_blank">  <img  style="width:100%;height: 300px;object-fit: cover;" src="{{asset('uploads/advimage/'.$image->img)}}" /> </a> 
                                            </div>
                                             @endforeach
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
                url: '{{ route("dashboard.delete_image_requierments") }}',
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
