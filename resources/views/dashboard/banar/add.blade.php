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
                            <h3 class="box-title">@lang('site.add')</h3>
                        </div>
                        @include('partials._errors')
                        <form role="form" action="{{route('dashboard.banar.store')}}" method="post" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="box-body">
                            <!--@if(empty($cat_id))-->
                            <!--     <div class="col-md-8  form-group">-->
                            <!--            @if(isset($categories))-->
                            <!--                <label>@lang('site.Choose Main Category')</label>-->
                            <!--                <select class="form-control select2" style="width: 100%;height:110%" name="cat_id">-->
                            <!--                    <option selected="selected" value="0">@lang('site.Choose Main Category')</option>-->
                            <!--                    @foreach($categories as $single)-->
                            <!--                        @if(app()->getLocale()=='ar')-->
                            <!--                            <option value="{{$single->id}}">{{$single->name_ar}}</option>-->
                            <!--                        @else-->
                            <!--                            <option value="{{$single->id}}">{{$single->name_en}}</option>-->
                            <!--                        @endif-->
                            <!--                    @endforeach-->
                            <!--                </select>-->
                            <!--            @endif-->
                            <!--        </div>-->
                            <!-- @else-->
                            <!-- <input type="hidden" name="cat_id" value="{{$cat_id}}">-->
                            <!--@endif-->
                            
                                <input type="hidden" name="cat_id" value="{{$cat_id}}">
                                <div class="col-md-8 form-group">
                                    <label for="">@lang('site.link')</label>
                                    <input type="text" name="link" value="" class="form-control" id="" placeholder="">
                                </div>


                                <div class="col-md-8 form-group">
                                    <label for="">@lang('site.duration of appearance')</label>
                                    <input type="number" name="days" required class="form-control" id="" placeholder="">
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
