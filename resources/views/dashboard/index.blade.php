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
             @if (auth()->user()->hasPermission('statistics'))
                <div class="row">
    
                    {{-- categories--}}
                    <div class="col-lg-3 col-xs-6">
                        <div class="small-box bg-aqua">
                            <div class="inner">
                                <h3>@if($visits) {{$visits->counter}} @else 0 @endif</h3>
    
                                <p>@lang('site.Vistors')</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-bag"></i>
                            </div>
                            <a href="" class="small-box-footer"></a>
                        </div>
                    </div>
    
                    {{--products--}}
                    <div class="col-lg-3 col-xs-6">
                        <a href="{{route('dashboard.advertismnets.index')}}">
                              <div class="small-box bg-green">
                            <div class="inner">
                                <h3>{{$advertisments}}</h3>
    
                                <p>@lang('site.Advertismnets Count')</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-stats-bars"></i>
                            </div>
                            <!--<a href="{{route('dashboard.statsics',2)}}" class="small-box-footer"> <i class="fa fa-arrow-circle-right"></i></a>-->
                        </div>
                        </a>
                      
                    </div>
    
    
                    {{--products--}}
                    <div class="col-lg-3 col-xs-6">
                          <a href="{{route('dashboard.Auctions')}}">
                                <div class="small-box bg-info">
                                    <div class="inner">
                                        <h3>{{$Auctions}}</h3>
            
                                        <p>@lang('site.total Acutions')</p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-stats-bars"></i>
                                    </div>
                                    <!--<a href="{{route('dashboard.statsics',2)}}" class="small-box-footer"> <i class="fa fa-arrow-circle-right"></i></a>-->
                                </div>
                          </a>
                    </div>
                    
                    {{--clients--}}
                    <div class="col-lg-3 col-xs-6">
                         <a href="{{route('dashboard.appuser.index')}}">
                                <div class="small-box bg-red">
                                    <div class="inner">
                                        <h3>{{$allsuers}}</h3>
            
                                        <p>@lang('site.total App User')</p>
                                    </div>
                                    <div class="icon">
                                        <i class="fa fa-user"></i>
                                    </div>
                                    <!--<a href="{{route('dashboard.statsics',1)}}" class="small-box-footer"> <i class="fa fa-arrow-circle-right"></i></a>-->
                                </div>
                               </a>
                    </div>
    
                    {{--users--}}
                    <!--<div class="col-lg-3 col-xs-6">-->
                    <!--     <a href="{{route('dashboard.Balance_list')}}">-->
                    <!--            <div class="small-box bg-info">-->
                    <!--                <div class="inner">-->
                    <!--                    <h3>{{$total_wallet}}</h3>-->
            
                    <!--                    <p>@lang('site.total wallet')</p>-->
                    <!--                </div>-->
                    <!--                <div class="icon">-->
                    <!--                    <i class="fa fa-money"></i>-->
                    <!--                </div>-->
                                    <!--<a href="{{route('dashboard.statsics',3)}}" class="small-box-footer">@lang('site.read') <i class="fa fa-arrow-circle-right"></i></a>-->
                    <!--            </div>-->
                    <!--     </a>-->
                    <!--</div>-->
    
    
                    <div class="col-lg-3 col-xs-6">
                        <div class="small-box bg-maroon">
                            <div class="inner">
                                <h3>{{$total_package}}</h3>
    
                                <p>@lang('site.Daily Package Payment')</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-money"></i>
                            </div>
                            <!--<a href="{{route('dashboard.statsics',4)}}" class="small-box-footer">@lang('site.read') <i class="fa fa-arrow-circle-right"></i></a>-->
                        </div>
                    </div>
                    
                      <div class="col-lg-3 col-xs-6">
                                <div class="small-box bg-info">
                                    <div class="inner">
                                        <h3>{{$Auctionend}}</h3>
            
                                        <p>@lang('site.total Acutions ends')</p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-stats-bars"></i>
                                    </div>
                                    <!--<a href="{{route('dashboard.statsics',2)}}" class="small-box-footer"> <i class="fa fa-arrow-circle-right"></i></a>-->
                                </div>
                        
                    </div>
                    
                </div><!-- end of row -->
    
                <div class="box box-solid">
                    <div class="row" style="display: flex;justify-content: center;padding: 22px 0;" >
                            <div class="col-lg-6 col-xs-6">
                                <a href="{{route('dashboard.Balance_list')}}">
                                <div class="small-box bg-info" style="padding: 3px">
                                    <div class="inner">
                                        <h3>{{$total_wallet}}</h3>
            
                                        <p>@lang('site.total wallet')</p>
                                    </div>
                                    <div class="icon">
                                        <i class="fa fa-money"></i>
                                    </div>
                                    <h5>ملاحظه هامه</h5>
                                    <p>
                                        هذا الاجمالى هوه اجمالى ما تم دفعه وما تم صرفه لكل العملاء وكل العمليات حتى لو تم حذف العميل او العمليات
                                    </p>
                                </div>
                             </a>
                         </div>
                         
                    </div>
                    
                    <div class="row">
                          <div class="col-lg-4 col-xs-4">
                                <div class="alert alert-primary" style="background: #d81b60;color: #fff;" role="alert">
                                  @lang('site.adv-noactive-count') ( {{$advertismentsnoactive}} )
                                </div>
                        </div>
                        
                          <div class="col-lg-4 col-xs-4">
                                <div class="alert alert-primary" style="background: #d81b60;color: #fff;" role="alert">
                                  @lang('site.auction-noactive-count') ( {{$Auctionsnoactive}} )
                                </div>
                        </div>
                        
                          <div class="col-lg-4 col-xs-4">
                                <div class="alert alert-primary" style="background: #d81b60;color: #fff;" role="alert">
                                  @lang('site.Requests-edit-of-adv-count') ( {{$updateadvcount}} )
                                </div>
                        </div>
                        
                         <div class="col-lg-4 col-xs-4">
                                <div class="alert alert-primary" style="background: #d81b60;color: #fff;" role="alert">
                                  @lang('site.number of new complaints') ( {{$complines}} )
                                </div>
                        </div>
                        
                         <div class="col-lg-4 col-xs-4">
                                <div class="alert alert-primary" style="background: #d81b60;color: #fff;" role="alert">
                                  @lang('site.number of new suggestions') ( {{$suggestions}} )
                                </div>
                        </div>
                    </div>
                
                </div>
            @else
            <div class="row" style="justify-content: center;display: flex;">
                    <img src="{{asset('logo.png')}}" />
            </div>
            @endif
        </section><!-- end of content -->

    </div><!-- end of content wrapper -->

@endsection
