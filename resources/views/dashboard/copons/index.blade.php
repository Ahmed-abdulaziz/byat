@extends('layouts.dashboard.app')

@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <h1>@lang('site.copons')</h1>

            <ol class="breadcrumb">
                <li><a href=""><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a></li>
                <li class="active">@lang('site.copons')</li>
            </ol>
        </section>
        <section class="content">

            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title" style="margin-bottom: 15px">@lang('site.copons') <small></small></h3>


                </div> <!-- end of box header -->
                    @if(auth()->user()->hasPermission('create_copons'))
                         <a href="{{route('dashboard.copons.create')}}" class="btn btn-primary"><i class="fa fa-plus"></i> @lang('site.Add')</a>
                  @endif
                <div class="box-body">
                    @if(count($copons) > 0)
                        <table class="table table-bordered" id="myTable">
                             <thead>
                            <tr>
                                <th>#</th>
                                <th>@lang('site.code')</th>
                                <th>@lang('site.code amount')</th>
                                <th>@lang('site.end_date')</th>
                            </tr>

                            </thead>
                            <tbody>
                            @foreach($copons as $index=>$single)
                                <tr>
                                    <td>{{++$index}}</td>
                                    <td>{{$single->code}}</td>
                                    <td>{{$single->balance}}</td>
                                    <td>{{$single->end_date}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        </table>
                    @else
                        <h2>@lang('site.no_data_found')</h2>
                    @endif

                </div>

            </div>

        </section><!-- end of content -->

    </div><!-- end of content wrapper -->
  

@endsection

