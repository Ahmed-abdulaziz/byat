@extends('layouts.dashboard.app')

@section('content')


    <div class="content-wrapper">

        <section class="content-header">

            <h1>@lang('site.winners in Monthly Withdrawal')</h1>

            <ol class="breadcrumb">
                <li><a href=""><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a></li>
                <li class="active">@lang('site.winners in Monthly Withdrawal')</li>
            </ol>
        </section>




        <section class="content">

            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title" style="margin-bottom: 15px">@lang('site.winners in Monthly Withdrawal') <small></small></h3>
                            <div class="row">
                          
                        </div>
                </div> <!-- end of box header -->

                <div class="box-body">
                    @if($data->count() > 0)
                        <table class="table table-bordered" id="myTable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>@lang('site.user-name')</th>
                                    <th>@lang('site.phone')</th>
                                </tr>
                            </thead>
                        <tbody>
                                @foreach($data as $index=>$single)
                                    <tr>
                                        <td>{{$index +1}}</td>
                                        <td>{{$single->user->name}}</td>
                                        <td>{{$single->user->phone}}</td>
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
<!-- Button trigger modal -->

@endsection
