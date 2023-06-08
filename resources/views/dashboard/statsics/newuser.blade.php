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


                    <form action="{{route('dashboard.appuser.index')}}" method="get">

                        <div class="row">

                            <div class="col-md-4">
                                <input type="text" name="search" class="form-control" placeholder="@lang('site.user name')" value="{{ request()->search }}">
                            </div>

                            <div class="col-md-4">
                                <input type="text" name="phone" class="form-control" placeholder="@lang('site.phone')" value="{{ request()->phone }}">
                            </div>

                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> @lang('site.search')</button>
                            </div>

                        </div>
                    </form><!-- end of form -->
                </div> <!-- end of box header -->

                <div class="box-body">
                    @if($Bankacounts->count() > 0)
                        <table class="table table-bordered">
                            <tr>
                                <th>#</th>
                                <th>@lang('site.name')</th>
                                <th>@lang('site.email')</th>
                                <th>@lang('site.phone')</th>
                                <th>@lang('site.User Type')</th>
                                <th>@lang('site.status')</th>
                                <th>@lang('site.date')</th>
                                <th>@lang('site.Options')</th>
                            </tr>


                            @foreach($Bankacounts as $index=>$single)
                                <tr>
                                    <td>{{$index +1}}</td>
                                    <td>{{$single->name}}</td>
                                    <td>{{$single->email}}</td>
                                    <td>{{$single->phone}}</td>
                                    @if($single->type==0)
                                        <td>@lang('site.user')</td>
                                    @else
                                        <td>@lang('site.fair')</td>
                                    @endif
                                    @if($single->suspend==0)
                                        <td>@lang('site.Desactive')</td>
                                    @else
                                        <td>@lang('site.Active')</td>
                                    @endif
                                    <td>{{$single->created_at}}</td>
                                    <td>
                                        @if (auth()->user()->hasPermission('update_users'))
                                            <a href="{{route('dashboard.appuser.edit',$single->id)}}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i>@lang('site.Add ADV')</a>
                                            <a href="{{route('dashboard.appuser.show',$single->id)}}" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i>@lang('site.View Adv')</a>
                                        @else
                                            <a  class="btn btn-primary disabled"><i class="fa fa-edit"></i>@lang('site.update')</a>
                                        @endif
                                        <form action="{{ route('dashboard.appuser.destroy', $single->id) }}" method="post" style="display: inline-block">
                                            {{ csrf_field() }}
                                            {{ method_field('delete') }}
                                            @if(auth()->user()->hasPermission('delete_users'))
                                                <button type="submit" class="btn btn-danger delete btn-sm"><i class="fa fa-trash"></i> @lang('site.delete')</button>
                                            @else
                                                <button type="submit" class="btn btn-danger delete btn-sm disabled"><i class="fa fa-trash"></i> @lang('site.delete')</button>
                                            @endif
                                        </form>

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
