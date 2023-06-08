@extends('layouts.dashboard.app')

@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <h1>@lang('site.cash_payment_requests')</h1>

            <ol class="breadcrumb">
                <li><a href=""><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a></li>
                <li class="active">@lang('site.cash_payment_requests')</li>
            </ol>
        </section>





        <section class="content">

            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title" style="margin-bottom: 15px">@lang('site.cash_payment_requests') <small></small></h3>

                </div> <!-- end of box header -->

                <div class="box-body">
                    @if($data->count() > 0)
                        <table class="table table-bordered" id="myTable">
                            <tr>
                                    <th>#</th>
                                    <th>@lang('site.name')</th>
                                     <th>@lang('site.type')</th>
                                    <th>@lang('site.user-name')</th>
                                    <th>@lang('site.phone')</th>
                                    <th>@lang('site.price')</th>
                                    <th>@lang('site.Options')</th>
                            </tr>


                            @foreach($data as $index=>$single)
                            
                            @php
                                      $Package   =  \App\Models\Packages::find($single->product_id);
                                      $user   =  \App\Models\appUsers::find($single->user_id);
                                     
                            @endphp
                                <tr>
                                    <td>{{$index +1}}</td>
                                    <td>@if($Package) {{$Package->name}} @endif</td>
                                    <td>@if(app()->getLocale()=='en') Package @else باقه @endif</td>
                                    <td>@if($user) {{$user->name}} @endif</td>
                                    <td>@if($user) {{$user->phone}} @endif</td>
                                    <td>{{$single->money}}</td>
                                    <td>
                                     @if($single->status == 0) 
                                        <a href="{{ route('dashboard.cash_request_status', [$single->id , 1]) }}" class="btn btn-success btn-sm"><i class="fa fa-edit"></i> @lang('site.approve')</a>
                                        <a href="{{ route('dashboard.cash_request_status', [$single->id , 2]) }}" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> @lang('site.disapprove')</a>
                                        @endif 

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
