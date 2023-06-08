@extends('layouts.dashboard.app')

@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <h1>@lang('site.monthly_withdrawals')</h1>

            <ol class="breadcrumb">
                <li><a href=""><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a></li>
                <li class="active">@lang('site.monthly_withdrawals')</li>
            </ol>
        </section>





        <section class="content">

            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title" style="margin-bottom: 15px">@lang('site.monthly_withdrawals') <small></small></h3>


                    <form action="{{route('dashboard.MonthlyWithdrawals.index')}}" method="get">

                        <div class="row">
                            <div class="col-md-4">
                               @if(auth()->user()->hasPermission('create_monthly_withdrawals'))
                                <a href="{{route('dashboard.MonthlyWithdrawals.create')}}" class="btn btn-primary"><i class="fa fa-plus"></i> @lang('site.create')</a>
                                @endif
                            </div>

                        </div>
                    </form><!-- end of form -->
                </div> <!-- end of box header -->

                <div class="box-body">
                    @if($data->count() > 0)
                        <table class="table table-bordered" id="myTable">
                            <thead>
                               <tr>
                                    <th>#</th>
                                    <th>@lang('site.month')</th>
                                    <th>@lang('site.Options')</th>
                                </tr>
                            </thead>

                        <tbody>
                               @foreach($data as $index=>$single)
                                <tr>
                                    <td>{{$index +1}}</td>
                                    <td>{{$single->month}}</td>
                                    <td>
                                        @if(auth()->user()->hasPermission('show_competitor_monthly_withdrawals'))
                                            <a href="{{route('dashboard.competitor-MonthlyWithdrawals',$single->id)}}" class="btn btn-primary">@lang('site.competitor in Monthly Withdrawal')</a>
                                        @endif
                                         @if(auth()->user()->hasPermission('show_winner_monthly_withdrawals'))
                                             <a href="{{route('dashboard.winner-MonthlyWithdrawals',$single->id)}}" class="btn btn-primary">@lang('site.winners in Monthly Withdrawal')</a>
                                        @endif
                                        @if($single->status == 1)
                                         <button type="button" class="btn btn-warning">@lang('site.closed')</button>
                                         @else
                                           @if(auth()->user()->hasPermission('stop_monthly_withdrawals'))
                                                <a href="{{route('dashboard.close-MonthlyWithdrawals',$single->id)}}" class="btn btn-warning">@lang('site.close')</a>
                                            @endif
                                         @endif
                                    </td>
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
