@extends('layouts.dashboard.app')

@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <h1>@lang('site.suggestion')</h1>

            <ol class="breadcrumb">
                <li><a href=""><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a></li>
                <li><a href="{{ route('dashboard.suggestion.index') }}"> @lang('site.suggestion')</a></li>
                <li class="active">@lang('site.edit')</li>
            </ol>
        </section>

        <section class="content">

            <div class="box box-primary">

                <div class="box-header">
                    <h3 class="box-title">@lang('site.edit')</h3>
                </div><!-- end of box header -->

                <div class="box-body">

                    @include('partials._errors')

                    <form action="{{ route('dashboard.suggestion.store') }}" method="post">

                        {{ csrf_field() }}


                        <div class="form-group">
                            <label>@lang('site.to')</label>
                            <input type="text" name="email" class="form-control" value="{{ $user->email }}">
                        </div>
                        <div class="form-group">
                            <input type="hidden" name="id" class="form-control" value="{{ $user->id }}">
                            <input type="hidden" name="name" class="form-control" value="{{ $user->name }}">
                        </div>

                        <div class="form-group">
                            <label>@lang('site.subject')</label>
                            <input type="text" name="subject" class="form-control" >
                        </div>

                        <div class="form-group">
                            <label>@lang('site.message')</label>
                            <textarea name="message" class="form-control"></textarea>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-edit"></i> @lang('site.Answer')</button>
                        </div>

                    </form><!-- end of form -->

                </div><!-- end of box body -->

            </div><!-- end of box -->

        </section><!-- end of content -->

    </div><!-- end of content wrapper -->

@endsection
