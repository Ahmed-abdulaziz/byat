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
                            <h3 class="box-title">@lang('site.Add new Brand')</h3>
                        </div>
                        @include('partials._errors')
                        <form role="form" action="{{route('dashboard.brands.store')}}" method="post" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="box-body">

                                <div class="col-md-8 form-group">
                                    <select name="cat_id" class="col-md-12 form-group">
                                        <option value="null">@lang('site.Brand Category')</option>
                                        @foreach($categories as $single)
                                        @if(app()->getLocale()=='ar')
                                                <option value="{{$single->id}}">{{$single->name_ar}}</option>
                                        @else
                                            <option value="{{$single->id}}">{{$single->name_en}}</option>
                                        @endif
                                        @endforeach
                                    </select>

                                </div>


                                <div class="col-md-8 form-group">
                                    <label for="">@lang('site.Arabic brands Name')</label>
                                    <input type="text" name="name_ar" class="form-control" id="" placeholder="@lang('site.Add new Brand')">
                                </div>
                                <div class="col-md-8 form-group">
                                    <label for="">@lang('site.french brands Name')</label>
                                    <input type="text" name="name_en" class="form-control" id="" placeholder="@lang('site.Add new Brand')">
                                </div>

                                <div class="col-md-8 form-group">
                                    <label>@lang('site.image')</label>
                                    <input type="file" name="img" class="form-control image">
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
