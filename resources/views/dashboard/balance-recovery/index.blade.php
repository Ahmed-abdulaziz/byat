@extends('layouts.dashboard.app')

@section('content')



    <div class="content-wrapper">

        <section class="content-header">
            
            <h1>@if($type == 0) @lang('site.Balance_recovery') @else @lang('site.Transferred requests') @endif</h1>

            <ol class="breadcrumb">
                <li><a href=""><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a></li>
                <li class="active">@if($type == 0) @lang('site.Balance_recovery') @else @lang('site.Transferred requests') @endif</li>
            </ol>
        </section>





        <section class="content">

            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title" style="margin-bottom: 15px">@if($type == 0) @lang('site.Balance_recovery') @else @lang('site.Transferred requests') @endif<small></small></h3>


                </div> <!-- end of box header -->

                
                <div class="box-body">
                    @if(count($data) > 0)
           
                        <table class="table table-bordered" id="myTable">
                             <thead>
                            <tr>
                                <th>#</th>
                                <th>@lang('site.user-name')</th>
                                <th>@lang('site.phone')</th>
                                <th>@lang('site.type')</th>
                                  <th>@lang('site.balance')</th>
                                  <th>@lang('site.Options')</th>

                            </tr>

                            </thead>
                            <tbody>
                            @foreach($data as $index=>$single)
                            @php
                                    $user = \App\Models\appUsers::find($single->user_id);
                                    $amount= \App\users_wallet::where('user_id',$single->user_id)->sum('money');
                            @endphp
                                <tr>
                                    <td>{{++$index}}</td>
                                    <td>{{$user->name}}</td>
                                    <td>{{$user->phone}}</td>
                                    <td>{{$single->type == 1 ? 'Cash': 'Paypal'}}</td>
                                    <td>{{$type == 0 ? $amount : $single->balance }}</td> 
                                   <td> 
                                       @if($amount > 0 && $single->status == 0) 
                                             <a href="{{route('dashboard.approve-Balance-recovery',[$single->id])}}"><button type="submit" class="btn btn-success  btn-sm"> @lang('site.retrieved')</button> </a>  
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

