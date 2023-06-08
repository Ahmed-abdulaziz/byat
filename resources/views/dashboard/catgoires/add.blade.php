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
                            <h3 class="box-title">@lang('site.Add New Category')</h3>
                        </div>
                        @include('partials._errors')
                        <form role="form" action="{{route('dashboard.catgoiries.store')}}" method="post" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="box-body">

                                <div class="col-md-8 form-group">
                                    <label for="">@lang('site.Arabic Category Name')</label>
                                    <input type="text" name="name_ar" required class="form-control" id="" placeholder="">
                                </div>
                                <div class="col-md-8 form-group">
                                    <label for="">@lang('site.English Category Name')</label>
                                    <input type="text" name="name_en" required class="form-control" id="" placeholder="">
                                </div>
                                <div class="col-md-8 form-group">
                                    <label>@lang('site.Category image')</label>
                                    <input type="file" name="img" required class="form-control image">
                                </div>


                                <div class="col-md-8  form-group">
                                    @if(isset($catgory))
                                        <label>@lang('site.Choose Main Category')</label>
                                        <select class="form-control select2 main-parent" required style="width: 100%;height:110%" name="parent_id">
                                            <option selected="selected" value=''>@lang('site.Choose Main Category')</option>
                                            @foreach($catgory as $single)
                                                @if(app()->getLocale()=='ar')
                                                    <option value="{{$single->id}}">{{$single->name_ar}}</option>
                                                @else
                                                    <option value="{{$single->id}}">{{$single->name_en}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    @endif
                                </div>
                              
                                <div class="col-md-8  form-group ads">
                                        <label>@lang('site.Sub Catgory')</label>
                                        <select class="form-control select2 parentcat" style="width: 100%;height:110%" name="parent_id2">
                                          
                                        </select>
                                </div>
                                
                                    <div class="col-md-8  form-group examination_image">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" value="1" name="examination_image" class="custom-control-input examination_image-input" id="defaultUnchecked">
                                            <label class="custom-control-label"  for="defaultUnchecked">@lang('site.An examination and warranty certificate must be submitted')</label>
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
        
        
       
        $(".examination_image").hide();
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
                                                    <option    value="{{$single->id}}">{{$single->name_ar}}</option>
                                                @else
                                                    <option    value="{{$single->id}}">{{$single->name_en}}</option>
                                                @endif
                                            @endforeach`);
        }
        
           function auctionsview(){
            $(".parentcat").text('');
            $(".parentcat").append(`<option value=''>@lang('site.Sub Catgory')</option>
                                            @foreach($auctions as $single)
                                                @if(app()->getLocale()=='ar')
                                                    <option  value="{{$single->id}}">{{$single->name_ar}}</option>
                                                @else
                                                    <option  value="{{$single->id}}">{{$single->name_en}}</option>
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

