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

                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                             
                        <form role="form" action="{{route('dashboard.advertisments-update',$advertisments->id)}}" method="post" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="box-body">

                                <div class="col-md-6 form-group">
                                    <label for="">@lang('site.Name')</label>
                                    <input type="text" name="name" class="form-control" required value="{{$advertisments->name}}" id="" placeholder="@lang('site.Name')">
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="">@lang('site.description')</label>
                                     <textarea type="text" name="description" class="form-control" required  id=""  placeholder="@lang('site.description')">{{$advertisments->description}}</textarea>
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
                                
                                 <div class="col-md-6 form-group">
                                    <label for="">@lang('site.examination_certificate')</label>
                                    <input type="file"  name="examination_certificate"  class="form-control examination_certificate">
                                </div> 
                                <div class="col-md-6  form-group">
                                        <label>@lang('site.Category-name')</label>
                                        <select class="form-control select2 cat_id" style="width: 100%;height:110%" required >
                                            <option selected="selected" value=''>@lang('site.Category-name')</option>
                                            @foreach($main_categorys as $single)
                                                    <option @if($parent_id == $single->id) {{"selected"}} @endif value="{{$single->id}}">{{$single->name}}</option>
                                            @endforeach
                                        </select>
                                </div>
                                   
                                  <div class="col-md-6  form-group">
                                        <label>@lang('site.Choose SubCategory')</label>
                                        <select class="form-control select2 SubCategory" style="width: 100%;height:110%" required name="cat_id">
                                            <option selected="selected" value=''>@lang('site.Choose SubCategory')</option>
                                             @foreach($categores as $single)
                                                    <option @if($advertisments->cat_id ==$single->id) {{"selected"}} @endif value="{{$single->id}}">{{$single->name}}</option>
                                            @endforeach
                                        </select>
                                   
                                </div>
                              <div class="col-md-6  form-group">
                                    @if(isset($areas))
                                        <label>@lang('site.Areas')</label>
                                        <select class="form-control select2" style="width: 100%;height:110%" required name="place_id">
                                            <option selected="selected" value=''>@lang('site.Areas')</option>
                                            @foreach($areas as $single)
                                                    <option @if($advertisments->place_id ==$single->id) {{"selected"}} @endif value="{{$single->id}}">{{$single->name}}</option>
                                             
                                            @endforeach
                                        </select>
                                    @endif
                                </div>
                                <div class="col-md-12  form-group" id="Filters">
                                       <h2>@lang('site.filters')</h2> 
                                    @foreach($filters as $item)
                                            @php
                                                    $filter_component_id = 0;
                                            @endphp
                                        <div class="row">
                                            
                                             
                                             <!--//single select-->
                                            @if($item->type == 1)          
                                                 <input type="hidden" name="filters_id[]" value="{{$item->id}}" class="form-control" />
                                                  <input type="hidden" name="types[]" value="{{$item->type}}" class="form-control" />
                                            @php
                                                    $componants = \App\category_item_components::where('category_item_id' , $item->id)->get();
                                            @endphp
                                                
                                                       <div class="col-md-6  form-group">
                                                           <input type="hidden" class="parent_filter" value="{{$item->id}}" />
                                                            <label>{{$item->name}}</label>
                                                            <select class="form-control select2 subfilter"  style="width: 100%;height:110% " required name="sub_filter_id[]">
                                                                @foreach($componants as $single)
                                                                @php
                                                                    $old = \ App\category_item_products::where('category_item_id',$item->id)->where('category_item_component_id',$single->id)->where('product_id',$advertisments->id)->where('type',0)->first();
                                                                    if($old){
                                                                          $filter_component_id  = $old->category_item_component_id;
                                                                    }
                                                                   
                                                                @endphp
                                                                        <option @if($old) @if($old->category_item_component_id == $single->id ) selected @endif  @endif  value="{{$single->id}}">{{$single->name}}</option>
                                                             
                                                                @endforeach
                                                            </select>
                                                    </div>
                                                     <div class="col-md-6 filterchild-{{$item->id}}">
                                                            <!------------------------------------------------------------------------------------------------------>
                                                                    @php
                                                                    $child_filters = \App\category_items::where('parent_category_items',$item->id)->get();
                                                                    @endphp
                                                                        @foreach($child_filters as $item_child)
                                                                          @php
                                                                                $componants = \App\category_item_components::where('category_item_id' , $item_child->id)->where('parent_category_components' ,$filter_component_id)->get();
                                                                        @endphp
                                                                        @if($componants->count() > 0)
                                                                            <div class="row">
                                                                                 <input type="hidden" name="filters_id[]" value="{{$item_child->id}}" class="form-control" />
                                                                                  <input type="hidden" name="types[]" value="{{$item_child->type}}" class="form-control" />
                                                                                 <!--//single select-->
                                                                                @if($item_child->type == 1)          
                                                                              
                                                                                    
                                                                                           <div class="col-md-6  form-group">
                                                                                                <label>{{$item_child->name}}</label>
                                                                                                <select class="form-control select2 " style="width: 100%;height:110% " required name="sub_filter_id[]">
                                                                                                       @foreach($componants as $single)
                                                                                                                @php
                                                                                                                    $old = \ App\category_item_products::where('category_item_id',$item_child->id)->where('category_item_component_id',$single->id)->where('product_id',$advertisments->id)->where('type',0)->count();
                                                                                                                @endphp
                                                                                                                        <option @if($old > 0 ) selected @endif  value="{{$single->id}}">{{$single->name}}</option>
                                                                                                             
                                                                                                                @endforeach
                                                                                                </select>
                                                                                        </div>
                                                                                         <div class="col-md-6 filterchild-{{$item_child->id}}">
                                                                                             
                                                                                            </div>
                                                                                
                                                                                
                                                                                    @endif
                                                                                      </div>
                                                                              @endif
                                                                          
                                                                        @endforeach
                                                            <!------------------------------------------------------------------------------------------------------>
                                                        </div>
                                                 <!--//multiple select-->
                                                @elseif($item->type == 2)   
                                                 <input type="hidden" name="multi_filters_id[]" value="{{$item->id}}" class="form-control" />
                                                  @php
                                                    $componants = \App\category_item_components::where('category_item_id' , $item->id)->get();
                                                 @endphp
                                                       <div class="col-md-6  form-group">
                                                            <label>{{$item->name}}</label>
                                                            @php
                                                                $index=0;
                                                            @endphp
                                                                @foreach($componants as $single)
                                                                  @php
                                                                    $old = \ App\category_item_products::where('category_item_id',$item->id)->where('category_item_component_id',$single->id)->where('product_id',$advertisments->id)->where('type',0)->count();
                                                                @endphp
                                                                      <div class="custom-control custom-checkbox">
                                                                            <input type="checkbox" class="custom-control-input" @if($old > 0 ) checked @endif   name="multi_sub_filter_id[{{$item->id}}][]" value="{{$single->id}}" id="defaultUnchecked">
                                                                            <label class="custom-control-label" for="defaultUnchecked">{{$single->name}}</label>
                                                                        </div>
                                                                  @php
                                                                    $index++;
                                                                @endphp
                                                                @endforeach
                                                            
                                                    </div>
                                               
                                                 <!--// input text-->
                                                @elseif($item->type == 3) 
                                                 <input type="hidden" name="types[]" value="{{$item->type}}" class="form-control" />
                                                 <input type="hidden" name="filters_id[]" value="{{$item->id}}" class="form-control" />
                                                 @php
                                                    $componants = \App\category_item_inputs::where('category_item_id' , $item->id)->get();
                                                    
                                                 @endphp
                                                       <div class="col-md-6  form-group">
                                                            <label>{{$item->name}}</label>
                                                                @foreach($componants as $single)
                                                                  @php
                                                                    $old = \ App\category_item_products::where('category_item_id',$item->id)->where('category_item_component_id',$single->id)->where('product_id',$advertisments->id)->where('type',0)->first();
                                                                @endphp
                                                                 <input type="hidden" name="sub_filter_id[]" value="{{$single->id}}" class="form-control" />
                                                                <div class="row">
                                                                    <div class="col-md-8">
                                                                         <input type="text"  placeholder="{{$single->placeholder}}" @if($item->can_skip == 0) required @endif  name="text[{{$single->id}}]" class="form-control" />
                                                                    </div>
                                                                      <div class="col-md-3">
                                                                        {{$single->unit}} 
                                                                    </div>
                                                                      
                                                                </div>
                                                                @endforeach
                                                            
                                                    </div>
                                                @endif
                                                  </div>
                                                 
                                            @endforeach
                                </div>
                                @if(!empty($advertisments->examination_certificate))
                                  <div class="col-md-12 form-group">
                                    <div class="col-md-6">
                                         <label for="">@lang('site.examination_certificate')</label>
                                        <a href="{{asset('uploads/advexamination_certificate/'.$advertisments->examination_certificate)}}" target="_blank">  <img  style="width:100%;height: 300px;object-fit: cover;" src="{{asset('uploads/advexamination_certificate/'.$advertisments->examination_certificate)}}" /> </a> 

                                    </div>
                                </div> 
                                 @endif
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
  
</script>

@endsection

