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
                        <form role="form" action="{{route('dashboard.auction-update',$auctions->id)}}" method="post" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="box-body">

                                <div class="col-md-6 form-group">
                                    <label for="">@lang('site.Name')</label>
                                    <input type="text" name="name" class="form-control" required value="{{$auctions->name}}" id="" placeholder="@lang('site.Name')">
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="">@lang('site.description')</label>
                                    <textarea type="text" name="description" class="form-control" required  id=""  placeholder="@lang('site.description')">{{$auctions->description}}</textarea>
                                </div>
                                    <div class="col-md-6 form-group">
                                    <label for="">@lang('site.amount-to-open')</label>
                                    <input type="number" step="any" name="amount_open" required  class="form-control" id="" value="{{$auctions->amount_open}}" placeholder="@lang('site.amount-to-open')">
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="">@lang('site.maximum-amount')</label>
                                    <input type="number" step="any" name="maximum_amount" required  class="form-control" id="" value="{{$auctions->maximum_amount}}" placeholder="@lang('site.maximum-amount')">
                                </div>
                                 <div class="col-md-6 form-group">
                                    <label for="">@lang('site.deposit amount')</label>
                                    <input type="number" step="any" name="deposit_amount"  required class="form-control" id="" value="{{$auctions->deposit_amount}}" placeholder="@lang('site.deposit amount')">
                                </div>
                                  <div class="col-md-6 form-group">
                                    <label for="">@lang('site.number-of-day')</label>
                                    <input type="number"  name="day" class="form-control" required id="" value="{{$auctions->day}}" placeholder="@lang('site.number-of-day')">
                                </div>
                                
                                  <div class="col-md-6 form-group">
                                    <label for="">@lang('site.number-of-hours')</label>
                                    <input type="number"  name="hours" class="form-control" id="" value="{{$auctions->hours}}" placeholder="@lang('site.number-of-hours')">
                                </div> 
                                     <div class="col-md-6 form-group">
                                    <label for="">@lang('site.images')</label>
                                    <input type="file"  name="images[]" multiple class="form-control">
                                </div> 
                                <div class="col-md-6  form-group">
                                    @if(isset($categores))
                                        <label>@lang('site.Category-name') ( الفرعى)</label>
                                        <select class="form-control select2" style="width: 100%;height:110%" required name="cat_id">
                                            <option selected="selected" value=''>@lang('site.Category-name')</option>
                                            @foreach($categores as $single)
                                                @if(app()->getLocale()=='ar')
                                                    <option @if($auctions->cat_id ==$single->id) {{"selected"}} @endif value="{{$single->id}}">{{$single->name_ar}}</option>
                                                @else
                                                    <option @if($auctions->cat_id ==$single->id) {{"selected"}} @endif value="{{$single->id}}">{{$single->name_en}}</option>
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
                                                    <option @if($auctions->place_id ==$single->id) {{"selected"}} @endif value="{{$single->id}}">{{$single->name_ar}}</option>
                                                @else
                                                    <option  @if($auctions->place_id ==$single->id) {{"selected"}} @endif value="{{$single->id}}">{{$single->name_en}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    @endif
                                </div>
                                
                                  <div class="col-md-12 form-group">
                                    <label for="">@lang('site.images')</label>
                                    <div class="row">
                                         @foreach($auctions->images as $image)
                                            <div class="col-md-3 m-2 img-{{$image->id}}">
                                                    <button style="position: absolute;"  onclick="deleteimg({{$image->id}})" type="button" class="btn btn-danger">X</button>
                                                    <a href="{{asset('uploads/auctions/'.$image->img)}}" target="_blank">  <img style="width: 100%;" src="{{asset('uploads/auctions/'.$image->img)}}" /> </a> 
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
                url: '{{ route("dashboard.delete_image") }}',
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
