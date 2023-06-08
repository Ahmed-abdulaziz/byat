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
                        <form role="form" action="{{route('dashboard.packages.update',$packages->id)}}" method="post" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            {{ method_field('put') }}
                            <div class="box-body">

                                <div class="col-md-8 form-group">
                                    <label for="">@lang('site.Arabic Name')</label>
                                    <input type="text" name="name_ar" class="form-control" id="" value="{{$packages->name_ar}}" placeholder="@lang('site.Arabic Name')">
                                </div>
                                <div class="col-md-8 form-group">
                                    <label for="">@lang('site.English Name')</label>
                                    <input type="text" name="name_en" class="form-control" id="" value="{{$packages->name_en}}" placeholder="@lang('site.English Name')">
                                </div>
                                <div class="col-md-8 form-group">
                                    <label for="">@lang('site.color')</label>
                                    <input type="color" name="color" class="form-control" value="{{$packages->color}}" required id="" placeholder="@lang('site.color')">
                                </div>
                                <div class="col-md-8 form-group">
                                    <label for="">@lang('site.description')</label>
                                    <textarea name="details" class="form-control" required   placeholder="@lang('site.description')">{{$packages->details}}</textarea>
                                </div>

                                <div class="col-md-8 form-group">
                                    <label for="">@lang('site.image')</label>
                                    <input type="file" name="img" class="form-control"  id="" placeholder="@lang('site.image')">
                                </div>
                                <div class="col-md-8 form-group">
                                    <label for="">@lang('site.price')</label>
                                    <input type="text" name="price" class="form-control" id="" value="{{$packages->price}}" placeholder="@lang('site.price')">
                                </div>
                                @if($packages->adv_num!=null)
                                <div class="col-md-8 form-group">
                                    <label for="">@lang('site.advnum')</label>
                                    <input type="text" name="adv_num" class="form-control" value="{{$packages->adv_num}}" id="" placeholder="@lang('site.advnum')">
                                </div>
                                @endif
                                @if($packages->period!=null)
                                <div class="col-md-8 form-group">
                                    <label for="">@lang('site.Period in Days')</label>
                                    <input type="text" name="period" class="form-control" value="{{$packages->period}}" id="" placeholder="@lang('site.Period in Days')">
                                </div>
                                @endif
                                @if($packages->periodmonth!=null)
                                <div class="col-md-8 form-group">
                                    <label for="">@lang('site.Period in Months')</label>
                                    <input type="text" name="periodmonth" class="form-control" id="" value="{{$packages->periodmonth}}" placeholder="@lang('site.Period in Months')">
                                </div>
                                @endif



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
