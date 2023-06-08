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
                            <h3 class="box-title">@lang('site.update')</h3>
                        </div>
                        @include('partials._errors')
                        <form role="form" action="{{route('dashboard.reports.update',$data->id)}}" method="post" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            {{ method_field('put') }}
                           <div class="box-body">
                                <input type="hidden" name="section" class="form-control" value="{{$type}}">
                                <div class="col-md-8 form-group">
                                    <label for="">@lang('site.title_ar')</label>
                                    <input type="text" name="name_ar" class="form-control" value="{{$data->name_ar}}" required id="">
                                </div>
                                <div class="col-md-8 form-group">
                                    <label for="">@lang('site.title_en')</label>
                                    <input type="text" name="name_en" class="form-control" value="{{$data->name_en}}" required id="">
                                </div>

                                <div class="col-md-8 form-group">
                                    <label for="">@lang('site.type')</label>
                                   <select  class="form-control" name="type" required> 
                                        <option @if($data->type == 1 ) selected @endif value="1">@if(app()->getLocale()=='en') Select @else اختيار @endif</option>
                                        <option @if($data->type == 2 ) selected @endif value="2">@if(app()->getLocale()=='en') Text @else نص @endif</option>
                                   </select>
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
