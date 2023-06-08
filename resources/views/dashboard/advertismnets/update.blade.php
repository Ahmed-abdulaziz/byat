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
                            <h3 class="box-title">@lang('site.Update Main Category')</h3>
                        </div>
                        <form role="form" action="{{route('dashboard.catgoiries.update',$catgoiry->id)}}" method="post">
                            {{ csrf_field() }}
                            {{ method_field('put') }}
                            <div class="box-body">

                                <div class="col-md-8 form-group">
                                    <label for="">@lang('site.Arabic Category Name')</label>
                                    <input type="text" name="name_ar" class="form-control" value="{{$catgoiry->name_ar}}" id="" placeholder="@lang('site.Enter Category name')">
                                </div>
                                <div class="col-md-8 form-group">
                                    <label for="">@lang('site.English Category Name')</label>
                                    <input type="text" name="name_en" class="form-control" id="" value="{{$catgoiry->name_en}}" placeholder="@lang('site.Enter Category name')">
                                </div>

                                <div class="col-md-8  form-group">
                                    @if(isset($catgory))
                                        <label>@lang('site.Choose Main Category')</label>
                                        <select class="form-control select2" style="width: 100%;height:110%" name="parent_id">
                                            <option selected="selected" value=null>@lang('site.Choose Main Category')</option>
                                            @foreach($catgory as $single)
                                                @if(app()->getLocale()=='ar')
                                                    <option value="{{$single->id}}">{{$single->name_ar}}</option>
                                                @else
                                                    <option value="{{$single->id}}">{{$single->name_en}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    @endif
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
