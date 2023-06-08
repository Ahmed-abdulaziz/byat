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
                       
                        @include('partials._errors')
                        <form role="form" action="{{route('dashboard.store-codes')}}" method="post">
                            {{ csrf_field() }}
                            <div class="box-body">

                                <div class="col-md-8 form-group">
                                    <label for="">@lang('site.code number')</label>
                                    <input type="number" name="codes" class="form-control" id="" placeholder="@lang('site.code number')" required>
                                </div>
                                <div class="col-md-8 form-group">
                                    <label for="">@lang('site.code amount')</label>
                                    <input type="text" name="amount" class="form-control" id="" placeholder="@lang('site.code amount')" required>
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
