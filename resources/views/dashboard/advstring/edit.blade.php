@extends('layouts.dashboard.app')

@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <h1>@lang('site.String after ADV')</h1>

            <ol class="breadcrumb">
                <li><a href=""><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a></li>
                <li><a href="{{ route('dashboard.users.index') }}"> @lang('site.Dialy Advertisemnt Count')</a></li>
                <li class="active">@lang('site.Free Adv Numbers')</li>
            </ol>
        </section>

        <section class="content">

            <div class="box box-primary">

                <div class="box-header">
                    <h3 class="box-title">@lang('site.String after ADV')</h3>
                </div><!-- end of box header -->

                <div class="box-body">

                    @include('partials._errors')

                    <form action="{{ route('dashboard.afadvstring.update',$appSettings) }}" method="post">
                        <div class="box-body">
                        {{ csrf_field() }}
                        {{ method_field('put') }}
                            <div class="col-md-8 form-group">
                                <label for="">@lang('site.String after ADV ar')</label>
                                <input type="text" name="after_adv_ar" class="form-control" value="{{$about->after_adv_ar}}" id="" placeholder="@lang('site.Dialy Advertisemnt Count')">
                            </div>
                            <div class="col-md-8 form-group">
                                <label for="">@lang('site.String after ADV en')</label>
                                <input type="text" name="after_adv_en" class="form-control" value="{{$about->after_adv_en}}" id="" placeholder="@lang('site.Dialy Advertisemnt Count')">
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
