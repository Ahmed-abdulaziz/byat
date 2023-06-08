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
                            <h3 class="box-title">@lang('site.Update Information')</h3>
                        </div>
                        <form role="form" action="{{route('dashboard.carshapes.update',$catgoiry->id)}}" method="post">
                            {{ csrf_field() }}
                            {{ method_field('put') }}
                            <div class="box-body">

                                <div class="col-md-8 form-group">
                                    <label for="">@lang('site.Arabic Name')</label>
                                    <input type="text" name="name_ar" class="form-control" value="{{$catgoiry->name_ar}}" id="" placeholder="@lang('site.Arabic Name')">
                                </div>
                                <div class="col-md-8 form-group">
                                    <label for="">@lang('site.English Name')</label>
                                    <input type="text" name="name_en" class="form-control" id="" value="{{$catgoiry->name_en}}" placeholder="@lang('site.English Name')">
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
