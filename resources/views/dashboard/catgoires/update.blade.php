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
                            <h3 class="box-title">@lang('site.update')</h3>
                        </div>
                        <form role="form" action="{{route('dashboard.catgoiries.update',$catgoiry->id)}}" method="post" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            {{ method_field('put') }}
                            <div class="box-body">
                                <div class="col-md-8 form-group">
                                    <label for="">@lang('site.Arabic Category Name')</label>
                                    <input type="text" name="name_ar" class="form-control" value="{{$catgoiry->name_ar}}" id="" placeholder="@lang('site.Enter Category name')">
                                </div>
                                <div class="col-md-8 form-group">
                                    <label for="">@lang('site.English Category Name')</label>
                                    <input type="text" name="name_en" class="form-control" id="" value="{{$catgoiry->name_en}}" placeholder="@lang('site.Enter Category name')">
                                </div>
                                <div class="col-md-8 form-group">
                                    <label>@lang('site.Category image')</label>
                                    <input type="file" name="img" class="form-control image">
                                </div>

                                @if($catgoiry->parent_id!=null)
                                <div class="col-md-8  form-group">
                                    @if(isset($catgory))
                                        <label>@lang('site.Choose Main Category')</label>
                                        <select class="form-control select2 main-parent" style="width: 100%;height:110%" name="parent_id">
                                            @foreach($catgory as $single)
                                               @if(app()->getLocale()=='ar')
                                                    <option @if($main_parent == $single->id) {{'selected'}}  @endif value="{{$single->id}}" id="{{$single->id}}">{{$single->name_ar}}</option>
                                                @else
                                                    <option @if($main_parent == $single->id) {{'selected'}}  @endif value="{{$single->id}}" id="{{$single->id}}">{{$single->name_en}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    @endif
                                </div>
                                
                              
                                   <div class="col-md-8  form-group ">
                                        <label>@lang('site.Sub Catgory')</label>
                                        <select class="form-control select2 parentcat" style="width: 100%;height:110%" name="parent_id2">
                                           
                                        </select>
                                </div>
                                
                                  @if($catgoiry->parent_id != 1 && $catgoiry->parent_id != 2)
                                        <div class="col-md-8  form-group examination_image">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" @if($catgoiry->examination_image == 1) {{'checked'}}  @endif  value="1" name="examination_image" class="custom-control-input examination_image-input" id="defaultUnchecked">
                                                <label class="custom-control-label"  for="defaultUnchecked">@lang('site.An examination and warranty certificate must be submitted')</label>
                                            </div>
                                         </div>
                                      @endif
                                @endif
                                <div class="col-md-8 form-group">
                                   <a href="{{asset('uploads/catgoires/'.$catgoiry->img)}}" target="_blank">
                                       <img src="{{asset('uploads/catgoires/'.$catgoiry->img)}}" style="width:50%"  />
                                   </a>
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
        $( document ).ready(function() {
            var id ={{$catgoiry->parent_id}}
            var elment = document.getElementById(id);

            elment.setAttribute("selected", "selected:selected");
        });
    </script>

@endsection

@section('javascript')
<script>
        
        
      
        var parent =  $('.main-parent option:selected').val();
        if(parent == 1){
                adsview();
        }else if(parent == 2){
               auctionsview();
        }
        
      $(document).on('change', '.main-parent', function() {
        
          if(this.value == 1){
              console.log("ss");
               adsview();
          }else if(this.value == 2){
               console.log("ss");
               auctionsview();
          }
        });
        
        function adsview(){
            $(".parentcat").text('');
            $(".parentcat").append(`<option value=''>@lang('site.Sub Catgory')</option>
                                            @foreach($ads as $single)
                                                @if(app()->getLocale()=='ar')
                                                    <option @if($catgoiry->parent_id == $single->id) {{'selected'}}  @endif  value="{{$single->id}}">{{$single->name_ar}}</option>
                                                @else
                                                    <option @if($catgoiry->parent_id == $single->id) {{'selected'}}  @endif value="{{$single->id}}">{{$single->name_en}}</option>
                                                @endif
                                            @endforeach`);
        }
        
           function auctionsview(){
            $(".parentcat").text('');
            $(".parentcat").append(`<option value=''>@lang('site.Sub Catgory')</option>
                                            @foreach($auctions as $single)
                                                @if(app()->getLocale()=='ar')
                                                    <option @if($catgoiry->parent_id == $single->id) {{'selected'}}  @endif value="{{$single->id}}">{{$single->name_ar}}</option>
                                                @else
                                                    <option @if($catgoiry->parent_id == $single->id) {{'selected'}}  @endif value="{{$single->id}}">{{$single->name_en}}</option>
                                                @endif
                                            @endforeach`);
        }
        
          $(".parentcat").change(function(){
                if($(this).val()!= ''){
                     $(".examination_image").show();
                }else{
                    $('.examination_image-input').prop('checked', false);
                    $(".examination_image").hide();
                }
        });
</script>

@endsection
