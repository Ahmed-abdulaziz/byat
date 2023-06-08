@extends('layouts.dashboard.app')

@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <h1>@lang('site.Auctions introduction video')</h1>

            <ol class="breadcrumb">
                <li><a href=""><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a></li>
                <li><a href="{{ route('dashboard.users.index') }}"> @lang('site.Auctions introduction video')</a></li>
                <li class="active">@lang('site.Auctions introduction video')</li>
            </ol>
        </section>

        <section class="content">

            <div class="box box-primary">

                <div class="box-header">
                    <h3 class="box-title">@lang('site.Auctions introduction video')</h3>
                </div><!-- end of box header -->

                <div class="box-body">

                    @include('partials._errors')

                    <form action="{{ route('dashboard.update_auctions_introduction_video') }}" method="post">
                        <div class="box-body">
                        {{ csrf_field() }}
                        <div class="col-md-8 form-group">
                            <label for="">@lang('site.Auctions introduction video')</label>
                            <input type="text" name="video" class="form-control" id="" placeholder="@lang('site.Auctions introduction video')" value="{{ $appSettings->auctions_introduction_video }}" />
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
