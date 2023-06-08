@extends('layouts.dashboard.app')

@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <h1>Blank page
                <small>it all starts here</small>
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
                            <h3 class="box-title">@lang('site.Using Policy')</h3>
                        </div>
                        <form role="form" action="{{route('dashboard.complinte.update',$maino->id)}}" method="post">
                            {{ csrf_field() }}
                            {{ method_field('put') }}

                            <div class="box-body">
                                <h3 class="box-title">@lang('site.Using Policy in Arabic') </h3>
                                <textarea type="text" name="about_ar" id="summernote1" class="form-control "
                                          placeholder="@lang('locale.About App Arabic')" required  value="{{ old('name')  }}">{{$maino->using_ar}}</textarea>
                                <h3 class="box-title">@lang('site.Using Policy in English') </h3>
                                <textarea type="text" name="about_en" id="summernote2" class="form-control "
                                          placeholder="@lang('locale.About App Arabic')" required  value="{{ old('name')  }}">{{$maino->using_en}}</textarea>
                            </div>
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
