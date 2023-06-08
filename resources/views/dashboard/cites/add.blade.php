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
                            <h3 class="box-title">@lang('site.Add new City')</h3>
                        </div>
                        @include('partials._errors')
                        <form role="form" action="{{route('dashboard.cites.store')}}" method="post">
                            {{ csrf_field() }}
                            <div class="box-body">

                                <div class="col-md-8 form-group">
                                    <label for="">@lang('site.Arabic city Name')</label>
                                    <input type="text" name="name_ar" class="form-control" id="" placeholder="">
                                </div>
                                <div class="col-md-8 form-group">
                                    <label for="">@lang('site.french city Name')</label>
                                    <input type="text" name="name_en" class="form-control" id="" placeholder="">
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
