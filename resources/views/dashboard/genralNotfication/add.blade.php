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
                            <h3 class="box-title">@lang('site.Send Genral Notifctions')</h3>
                        </div>
                        <form role="form" action="{{route('dashboard.sendnotifaction')}}" method="post" enctype="multipart/form-data">
                            {{ csrf_field() }}

                            <div class="box-body">

                                <div class="col-md-8 form-group">
                                    <label for="">@lang('site.Notifctions_Title')</label>
                                    <input type="text" name="title" class="form-control" id="" placeholder="@lang('site.Notifctions_Title')" required>
                                </div>

                                <div class="col-md-8 form-group">
                                    <label for="">@lang('site.Send Genral Notifctions')</label>
                                    <input type="text" name="notifcatoion" class="form-control" id="" placeholder="@lang('site.Send Genral Notifctions')">
                                </div>



                            </div>
                            <!-- /.box-body -->

                            <div class="box-footer">
                                <button type="submit" class="btn btn-primary">@lang('site.Send Genral Notifctions')</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>



        </section><!-- end of content -->

    </div><!-- end of content wrapper -->

@endsection
