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
                            <h3 class="box-title">@lang('site.create')</h3>
                        </div>
                        <form role="form" action="{{route('dashboard.advertismnets.store')}}" method="post" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="box-body">
                                     <input type="hidden" name="user_id" class="form-control" value="{{$user_id}}">
                                <div class="col-md-6 form-group">
                                    <label for="">@lang('site.Name')</label>
                                    <input type="text" name="name" class="form-control" required  id="" placeholder="@lang('site.Name')">
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="">@lang('site.description')</label>
                                    <textarea type="text" name="description" class="form-control" required  id=""  placeholder="@lang('site.description')"></textarea>
                                </div>
                                    <div class="col-md-6 form-group">
                                    <label for="">@lang('site.price')</label>
                                    <input type="number" step="any" name="price" required  class="form-control" id="">
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="">@lang('site.phone')</label>
                                    <input type="text" name="phone" required  class="form-control" id=""  >
                                </div>
                                 <div class="col-md-6 form-group">
                                    <label for="">@lang('site.whatsapp')</label>
                                    <input type="text" name="whatsapp" required  class="form-control" id="" placeholder="@lang('site.whatsapp')" >
                                </div>
                                     <div class="col-md-6 form-group">
                                    <label for="">@lang('site.images')</label>
                                    <input type="file"  name="images[]" multiple class="form-control">
                                </div> 
                                  <div class="col-md-6 form-group">
                                    <label for="">@lang('site.examination_certificate')</label>
                                    <input type="file"  name="examination_certificate"  class="form-control examination_certificate">
                                </div> 
                                <div class="col-md-6  form-group">
                                    @if(isset($categores))
                                        <label>@lang('site.Category-name')</label>
                                        <select class="form-control select2 cat_id" style="width: 100%;height:110%" required >
                                            <option selected="selected" value=''>@lang('site.Category-name')</option>
                                            @foreach($categores as $single)
                                                @if(app()->getLocale()=='ar')
                                                    <option  value="{{$single->id}}">{{$single->name_ar}}</option>
                                                @else
                                                    <option value="{{$single->id}}">{{$single->name_en}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    @endif
                                </div>
                                  <div class="col-md-6  form-group">
                                        <label>@lang('site.Choose SubCategory')</label>
                                        <select class="form-control select2 SubCategory" style="width: 100%;height:110%" required name="cat_id">
                                            <option selected="selected" value=''>@lang('site.Choose SubCategory')</option>
                                            
                                        </select>
                                   
                                </div>
                              <div class="col-md-6  form-group">
                                    @if(isset($areas))
                                        <label>@lang('site.Areas')</label>
                                        <select class="form-control select2" style="width: 100%;height:110%" required name="place_id">
                                            <option selected="selected" value=''>@lang('site.Areas')</option>
                                            @foreach($areas as $single)
                                                @if(app()->getLocale()=='ar')
                                                    <option  value="{{$single->id}}">{{$single->name_ar}}</option>
                                                @else
                                                    <option  value="{{$single->id}}">{{$single->name_en}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    @endif
                                </div>
                            <div class="col-md-12  form-group" id="Filters">
                               
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
@section('javascript')get_child
<script>

  $('.cat_id').change(function(){
            var val = $(this).val();
           $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
        });
     $.ajax({
            type: 'post',
            url: '{{ route("dashboard.get_filters") }}',
            data: {
            cat_id:val
            },
            success: function (response) {
                
                console.log(response);
                $("#Filters").html(response);
                
            }
        });
        
        
          
             $.ajax({
                type: 'post',
                url: '{{ route("dashboard.get_sub_catgories") }}',
                data: {
                cat_id:val
                },
                success: function (response) {
                    
                    $(".SubCategory").html(response);
                    
                }
            });
      });
  
</script>

<script>
  $(document).on('change', '.subfilter', function() {
 
            var val = $(this).val();
            var filter_id=$(this).closest('div').find(".parent_filter").val();
              $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
            });
         $.ajax({
                type: 'post',
                url: '{{ route("dashboard.get_child") }}',
                data: {
                componant:val,
                filter_id:filter_id
                },
                success: function (response) {
                    
                    $(".filterchild-"+filter_id).html(response);
                    
                }
            });
            
          
            
            
   });
  
  $(document).on('change', '.SubCategory', function() {
 
            var val = $(this).val();
              $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
            });
         $.ajax({
                type: 'post',
                url: '{{ route("dashboard.check_examination_certificate") }}',
                data: {
                cat_id:val
                },
                success: function (response) {
                    
                    if(response == 0){
                        $('.examination_certificate').removeAttr('required');
                    }else{
                        $(".examination_certificate").attr("required", true);
                        
                    }
                   console.log(response);
                    
                }
            });
            
          
            
            
   });
</script>

@endsection


