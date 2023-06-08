@extends('layouts.dashboard.app')

@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <h1>@lang('site.report')</h1>

            <ol class="breadcrumb">
                <li><a href=""><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a></li>
                <li class="active">@lang('site.report')</li>
            </ol>
        </section>





        <section class="content">

            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title" style="margin-bottom: 15px">@lang('site.report') <small></small></h3>


                    <form action="{{route('dashboard.reports.index')}}" method="get">

                        <div class="row">
                            <div class="col-md-4">
                               @if(auth()->user()->hasPermission('create_report'))
                                <a href="{{route('dashboard.reports.create',['type'=>$type])}}" class="btn btn-primary"><i class="fa fa-plus"></i> @lang('site.Add')</a>
                                @endif
                            </div>

                        </div>
                    </form><!-- end of form -->
                </div> <!-- end of box header -->

                <div class="box-body">
                    @if($data->count() > 0)
                        <table class="table table-bordered" id="myTable">
                            <tr>
                                <th>#</th>
                                <th>@lang('site.name')</th>
                                <th>@lang('site.Options')</th>
                            </tr>


                            @foreach($data as $index=>$single)
                                <tr>
                                    <td>{{$index +1}}</td>
                                    <td>{{$single->name}}</td>
                                    <td>
                                        @if (auth()->user()->hasPermission('update_report'))
                                                <a href="{{route('dashboard.reports.edit',$single->id)}}?type={{$type}}" class="btn btn-primary"><i class="fa fa-edit"></i>@lang('site.update')</a>
                                        @endif
                                        <form action="{{ route('dashboard.reports.destroy', $single->id) }}" method="post" style="display: inline-block">
                                            {{ csrf_field() }}
                                            {{ method_field('delete') }}
                                            @if(auth()->user()->hasPermission('delete_report'))
                                                    <button  class="btn btn-danger delete btn-sm hidden"><i class="fa fa-trash"></i> @lang('site.delete')</button>
                                                    
                                                    <button type="submit" class="btn btn-danger delete btn-sm"><i class="fa fa-trash"></i> @lang('site.delete')</button>
                                            @endif
                                        </form>

                                    </td>
                                </tr>
                            @endforeach

                        </table>
                    @else
                        <h2>@lang('site.no_data_found')</h2>
                    @endif

                </div>

            </div>

        </section><!-- end of content -->

    </div><!-- end of content wrapper -->

@endsection
