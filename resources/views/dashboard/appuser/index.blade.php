@extends('layouts.dashboard.app')

@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <h1>@lang('site.Application Users')</h1>

            <ol class="breadcrumb">
                <li><a href=""><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a></li>
                <li class="active">@lang('site.Application Users')</li>
            </ol>
        </section>





        <section class="content">

            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title" style="margin-bottom: 15px">@lang('site.Application Users') <small></small></h3>
                     @if(auth()->user()->hasPermission('create_appusers'))
                            <a href="{{route('dashboard.appuser.create')}}" class="btn btn-info btn-sm"><i class="fa fa-plus"></i> @lang('site.create')</a>
                     @endif
                </div>
                <!-- end of box header -->
                                 
             

                <div class="box-body">
                    @if($Bankacounts->count() > 0)
                        <table class="table table-bordered" id="myTable2">
                            <thead>
                                  <tr>
                                    <th>#</th>
                                    <th>@lang('site.name')</th>
                                    <th>@lang('site.email')</th>
                                    <th>@lang('site.phone')</th>
                                    <th>@lang('site.status')</th>
                                      <!--<th>@lang('site.change status')</th>-->
                                    <th>@lang('site.Options')</th>
                                </tr>

                            </thead>
                          
                        <tbody>
                            
                      
                            @foreach($Bankacounts as $index=>$single)
                                <tr>
                                    <td>{{$index +1}}</td>
                                    <td>{{$single->name}}</td>
                                    <td>{{$single->email}}</td>
                                    <td>{{$single->phone}}</td>
                                    @if($single->status==0)
                                        <td>@lang('site.Desactive')</td>
                                    @else
                                        <td>@lang('site.Active')</td>
                                    @endif
                                    <td>
                                         @if(auth()->user()->hasPermission('active_appusers'))
                                          @if($single->status == 0)
                                              <a href="{{route('dashboard.change-status',[$single->id,1])}}"><button type="submit" class="btn btn-success  btn-sm"><i class="fa fa-trash"></i> @lang('site.active')</button> </a>  
                                            @else
                                                  <a href="{{route('dashboard.change-status',[$single->id,0])}}"><button type="submit" class="btn btn-danger  btn-sm "><i class="fa fa-trash"></i> @lang('site.block')</button> </a> 
                                            @endif
                                         @endif
                                          @if(auth()->user()->hasPermission('add_adv_to_appusers'))
                                             <a href="{{route('dashboard.advertisments-create',$single->id)}}" class="btn btn-info btn-sm"><i class="fa fa-plus"></i> @lang('site.add new ad')</a>
                                         @endif
                                    
                                        <!------------------------------------------------------------------------------------------------------------>
                                        @if(auth()->user()->hasPermission('send_recharge_card_to_appusers'))
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal-{{$single->id}}">
                                                @lang('site.Send a recharge card')
                                        </button>
                                        
                                           <div class="modal fade" id="exampleModal-{{$single->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                          <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                             <form action="{{ route('dashboard.send_recharge_card', $single->id) }}" method="post" >
                                                                 {{ csrf_field() }}
                                                                  <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLabel">@lang('site.Send a recharge card')</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                      <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                  </div>
                                                                  <div class="modal-body">
                                                                   
                                                                           <div class="row">
                                                                                    <div class="col-md-3">
                                                                                        <label>@lang('site.code')</label>
                                                                                </div>
                                                                                <div class="col-md-9">
                                                                                        <input type="text" class="form-control" name="code" required />
                                                                                </div>
                                                                           </div>
                                                                          
                                                                     
                                                                  </div>
                                                                  <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('site.cancel')</button>
                                                                    <button class="btn btn-primary">@lang('site.send')</button>
                                                                  </div>
                                                            </form>
                                                </div>
                                          </div>
                                        </div>
                                       @endif
                                        <!------------------------------------------------------------------------>
                                      @if(auth()->user()->hasPermission('Adding_balance_to_appusers_wallet'))
                                           <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#add_balance_to_wallet-{{$single->id}}">
                                             @lang('site.add_balance_to_wallet')
                                        </button>
                                        <div class="modal fade" id="add_balance_to_wallet-{{$single->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                          <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                             <form action="{{ route('dashboard.add_balance_to_wallet', $single->id) }}" method="post" >
                                                                 {{ csrf_field() }}
                                                                  <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLabel">@lang('site.add_balance_to_wallet')</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                      <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                  </div>
                                                                  <div class="modal-body">
                                                                   
                                                                           <div class="row">
                                                                                    <div class="col-md-3">
                                                                                        <label>@lang('site.balance')</label>
                                                                                </div>
                                                                                <div class="col-md-9">
                                                                                        <input type="number" step="any" class="form-control" name="money" required />
                                                                                </div>
                                                                           </div>
                                                                          
                                                                     
                                                                  </div>
                                                                  <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('site.cancel')</button>
                                                                    <button class="btn btn-primary">@lang('site.send')</button>
                                                                  </div>
                                                            </form>
                                                </div>
                                          </div>
                                        </div>
                                     @endif
                                        <!---------------------------------------------------------------------------------------------------->
                                      @if(auth()->user()->hasPermission('Add_number_of_free_ads_to_appusers'))
                                          <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#add_number_adv_free-{{$single->id}}">
                                             @lang('site.add_number_adv_free')
                                        </button>
                                        <div class="modal fade" id="add_number_adv_free-{{$single->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                          <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                             <form action="{{ route('dashboard.add_number_adv_free', $single->id) }}" method="post" >
                                                                 {{ csrf_field() }}
                                                                  <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLabel">@lang('site.add_number_adv_free')</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                      <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                  </div>
                                                                  <div class="modal-body">
                                                                   
                                                                           <div class="row">
                                                                                    <div class="col-md-3">
                                                                                        <label>@lang('site.Number')</label>
                                                                                </div>
                                                                                <div class="col-md-9">
                                                                                        <input type="number"  class="form-control" name="number" required />
                                                                                </div>
                                                                           </div>
                                                                          
                                                                     
                                                                  </div>
                                                                  <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('site.cancel')</button>
                                                                    <button class="btn btn-primary">@lang('site.send')</button>
                                                                  </div>
                                                            </form>
                                                </div>
                                          </div>
                                        </div>
                                     @endif
                                        <form action="{{ route('dashboard.appuser.destroy', $single->id) }}" method="post" style="display: inline-block">
                                            {{ csrf_field() }}
                                            {{ method_field('delete') }}
                                            @if(auth()->user()->hasPermission('delete_AppUsers'))
                                                <button type="submit" class="btn btn-danger delete btn-sm"><i class="fa fa-trash"></i> @lang('site.delete')</button>
                                            @endif
                                            
                                            
                                            
                                        </form>

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
