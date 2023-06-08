@extends('layouts.dashboard.app')

@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <h1>@lang('site.codes')</h1>

            <ol class="breadcrumb">
                <li><a href=""><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a></li>
                <li class="active">@lang('site.codes')</li>
            </ol>
        </section>


        <section class="content">

            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title" style="margin-bottom: 15px">@lang('site.codes') <small></small></h3>


                </div> <!-- end of box header -->
                @if (auth()->user()->hasPermission('create_codes'))
                    <a href="{{route('dashboard.add-codes')}}" class="btn btn-primary"><i class="fa fa-plus"></i> @lang('site.Add')</a>
                 @endif
                <div class="box-body">
                    @if(count($codes) > 0)
                        <table class="table table-bordered" id="myTable">
                             <thead>
                            <tr>
                                <th>#</th>
                                <th>@lang('site.code')</th>
                                <th>@lang('site.code amount')</th>
                                <th>@lang('site.Options')</th>
                            </tr>

                            </thead>
                            <tbody>
                            @foreach($codes as $index=>$single)
                                <tr>
                                    <td>{{++$index}}</td>
                                    <td>{{$single->code}}</td>
                                    <td>{{$single->amount}}</td>
                                    <td> 
                                       @if($single->user_id != NULL) 
                                            <button class="btn btn-info">@lang('site.code used')</button>
                                        @else
                                          <form action="{{ route('dashboard.delete-codes', $single->id) }}" method="post" style="display: inline-block">
                                            {{ csrf_field() }}
                                            @if(auth()->user()->hasPermission('delete_codes'))

                                                      <button  class="btn btn-danger delete btn-sm hidden"><i class="fa fa-trash"></i> @lang('site.delete')</button>

                                                    <button type="submit" class="btn btn-danger delete btn-sm"><i class="fa fa-trash"></i> @lang('site.delete')</button>
                                            @endif
                                        </form>
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

