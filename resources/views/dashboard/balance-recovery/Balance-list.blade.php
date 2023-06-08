@extends('layouts.dashboard.app')

@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <h1>@lang('site.customer wallets')</h1>

            <ol class="breadcrumb">
                <li><a href=""><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a></li>
                <li class="active">@lang('site.customer wallets')</li>
            </ol>
        </section>





        <section class="content">

            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title" style="margin-bottom: 15px">@lang('site.customer wallets') <small></small></h3>


                </div> <!-- end of box header -->

                
                <div class="box-body">
                    @if(count($recoverys) > 0)
                        <table class="table table-bordered" id="myTable">
                             <thead>
                            <tr>
                                <th>#</th>
                                <th>@lang('site.Clint Name')</th>
                                <th>@lang('site.Phone Number')</th>
                                 <th>@lang('site.balance')</th>

                            </tr>

                            </thead>
                            <tbody>
                            @foreach($recoverys as $index=>$single)
                                <tr>
                                    <td>{{++$index}}</td>
                                    <td>{{$single->user_name}}</td>
                                    <td>{{$single->user_phone}}</td>
                                     <td>{{$single->amount}}</td>
                                 
                                   
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

