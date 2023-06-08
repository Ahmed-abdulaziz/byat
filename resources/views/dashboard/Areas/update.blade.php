@extends('layouts.dashboard.app')

@section('content')

    <div class="content-wrapper">

        <section class="content-header">


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
                        <form role="form" action="{{route('dashboard.area.update',$area)}}" method="post" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            {{ method_field('put') }}
                            @include('partials._errors')
                            <div class="box-body">
                                <div class="col-md-8  form-group">
                                    @if(isset($citeis))
                                        <label>@lang('site.Choose City')</label>
                                        <select class="form-control select2" style="width: 100%;" name="city_id">
                                            <option selected="selected" disabled>@lang('site.Choose City name')</option>
                                            @foreach($citeis as $single)
                                                @if(app()->getLocale()=='ar')
                                                    <option value="{{$single->id}}">{{$single->name_ar}}</option>
                                                @else
                                                    <option value="{{$single->id}}">{{$single->name_en}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    @endif
                                </div>
                                <div class="col-md-8 form-group">
                                    <label for="">@lang('site.Arabic Name')</label>
                                    <input type="text" name="name_ar" value="{{$maino->name_ar}}" class="form-control" id="" placeholder="@lang('site.Arabic Area Name')">
                                </div>
                                <div class="col-md-8 form-group">
                                    <label for="">@lang('site.English Name')</label>
                                    <input type="text" name="name_en" value="{{$maino->name_en}}" class="form-control" id="" placeholder="@lang('site.English Area Name')">
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
