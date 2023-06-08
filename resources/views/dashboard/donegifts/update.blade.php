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
                        <div class="box-body">
                        <form role="form" action="{{route('dashboard.catgoiries.update',$catgoiry->id)}}" method="post" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            {{ method_field('put') }}

                            <div class="col-md-8 form-group">
                                <label for="">@lang('site.Name')</label>
                                <input type="text" name="name" class="form-control" value="{{$catgoiry->name}}" id="" placeholder="">
                            </div>

                            <div class="col-md-8 form-group">
                                <label>@lang('site.image')</label>
                                <input type="file" name="img" class="form-control image">
                            </div>

                            <div class="col-md-8 form-group">
                                <label>@lang('site.end_date')</label>
                                <input type="date" name="end_date" value="{{$catgoiry->end_date}}" class="form-control image">
                            </div>

                            <!-- /.box-body -->

                            <div class="box-footer">
                                <button type="submit" class="btn btn-primary">@lang('site.update')</button>
                            </div>

                        </form>

                       </div>
                    </div>
                </div>
            </div>



        </section><!-- end of content -->

    </div><!-- end of content wrapper -->

    <script>
        $( document ).ready(function() {
            var id ={{$catgoiry->parent_id}}
            var elment = document.getElementById(id);

            elment.setAttribute("selected", "selected:selected");
        });
    </script>

@endsection
