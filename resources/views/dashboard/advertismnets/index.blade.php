@extends('layouts.dashboard.app')

@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <h1>@lang('site.advertisements')</h1>

            <ol class="breadcrumb">
                <li><a href=""><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a></li>
                <li class="active">@lang('site.advertisements')</li>
            </ol>
        </section>





        <section class="content">

            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title" style="margin-bottom: 15px">@lang('site.advertisements') <small></small></h3>


                </div> <!-- end of box header -->

                
                <div class="box-body">
                    @if(count($advertisments) > 0)
                        <table class="table table-bordered" id="myTable" style="white-space: nowrap;" >
                             <thead>
                            <tr>
                                <th>#</th>
                                <th>@lang('site.name')</th>
                                <th>@lang('site.description')</th>
                                <th>@lang('site.price')</th>
                                <th>@lang('site.phone')</th>
                                 <th>@lang('site.user-name')</th>
                                <th>@lang('site.place')</th>
                                 <th>@lang('site.end_date')</th>
                                  <th>@lang('site.status')</th>
                                <th>@lang('site.Options')</th>
                            </tr>

                            </thead>
                            <tbody>
                            @foreach($advertisments as $index=>$single)
                                <tr>
                                    <td>{{++$index}}</td>
                                    
                                    <td>{{$single->name}}</td>
                                    <td style="max-width: 200px;overflow: hidden;">{{$single->description}}</td>
                                    
                                    <td>{{$single->price}}</td>
                                    <td>{{$single->phone}}</td>
                                     <td>{{$single->user}}</td>
                                    <td>{{$single->place}}</td>
                                    <td>{{$single->end_date}}</td>
                                     <td>
                                         @if($single->status == 1)
                                             <button class="btn ">@lang('site.isactive')</button>
                                         @elseif($single->status == 2)
                                            <button class="btn">@lang('site.isban')</button>
                                        @endif
                                        
                                     </td>
                                    <td>
                                         @if (auth()->user()->hasPermission('active_advertiments'))
                                            @if($single->status == 0 || $single->status == 2)
                                             <a href="{{ route('dashboard.adv-active', [$single->id , 1]) }}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i> @lang('site.active')</a>
                                             @endif
                                             @if($single->status == 1)
                                              <a href="{{ route('dashboard.adv-active', [$single->id , 2]) }}" class="btn btn-danger btn-sm"><i class="fa fa-edit"></i> @lang('site.ban')</a>
                                            @endif
                                         @endif
                                         @if (auth()->user()->hasPermission('update_advertiments'))
                                           <a href="{{ route('dashboard.advertisments-edit',$single->id) }}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i> @lang('site.edit')</a>
                                         @endif
                                          @if (auth()->user()->hasPermission('delete_advertiments'))
                                           <a href="{{ route('dashboard.adv-active', [$single->id , 5]) }}" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> @lang('site.delete')</a>
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

