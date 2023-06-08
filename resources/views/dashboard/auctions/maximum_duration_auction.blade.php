@extends('layouts.dashboard.app')

@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <h1>@lang('site.The maximum duration of the auction')</h1>

            <ol class="breadcrumb">
                <li><a href=""><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a></li>
                <li><a href="{{ route('dashboard.users.index') }}"> @lang('site.The maximum duration of the auction')</a></li>
                <li class="active">@lang('site.The maximum duration of the auction')</li>
            </ol>
        </section>

        <section class="content">

            <div class="box box-primary">

                <div class="box-header">
                    <h3 class="box-title">@lang('site.The maximum duration of the auction')</h3>
                </div><!-- end of box header -->

                <div class="box-body">

                    @include('partials._errors')

                    <form action="{{ route('dashboard.maximum_auction_duration_update') }}" method="post">
                        <div class="box-body">
                        {{ csrf_field() }}
                               
                                <div class="col-md-6 form-group">
                                    <label for="">@lang('site.The maximum duration of the auction')</label>
                                    <input type="number" name="maximum_duration_auction" class="form-control" value="{{$data->maximum_duration_auction}}" id="" placeholder="@lang('site.The maximum duration of the auction')">
                                </div>
                            </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-edit"></i> @lang('site.edit')</button>
                        </div>

                    </form><!-- end of form -->

                </div><!-- end of box body -->

            </div><!-- end of box -->

        </section><!-- end of content -->

    </div><!-- end of content wrapper -->

@endsection
