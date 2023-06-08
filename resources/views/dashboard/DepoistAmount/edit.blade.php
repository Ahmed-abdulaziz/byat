@extends('layouts.dashboard.app')

@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <h1>@lang('site.deposit amount')</h1>

            <ol class="breadcrumb">
                <li><a href=""><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a></li>
                <li><a href="{{ route('dashboard.users.index') }}"> @lang('site.Dialy Advertisemnt Count')</a></li>
                <li class="active">@lang('site.deposit amount')</li>
            </ol>
        </section>

        <section class="content">

            <div class="box box-primary">

                <div class="box-header">
                    <h3 class="box-title">@lang('site.deposit amount')</h3>
                </div><!-- end of box header -->

                <div class="box-body">

                    @include('partials._errors')

                    <form action="{{ route('dashboard.deposit_amount_update',$id) }}" method="post">
                        <div class="box-body">
                        {{ csrf_field() }}
                            <div class="col-md-6 form-group">
                                <label for="">@lang('site.deposit amount')</label>
                                <input type="text" name="deposit_amount" class="form-control" value="{{$about->deposit_amount}}" id="" placeholder="@lang('site.deposit amount')">
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
