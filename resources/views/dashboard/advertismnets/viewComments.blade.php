@extends('layouts.dashboard.app')

@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <h1>@lang('site.advertisements Comments')</h1>

            <ol class="breadcrumb">
                <li><a href=""><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a></li>
                <li class="active">@lang('site.advertisements Comments')</li>
            </ol>
        </section>





        <section class="content">

            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title" style="margin-bottom: 15px">@lang('site.advertisements Comments') <small></small></h3>


                    <form action="{{route('dashboard.advertismnets.index')}}" method="get">

                        <div class="row">

                            <div class="col-md-4">
                                <input type="text" name="search" class="form-control" placeholder="@lang('site.search')" value="{{ request()->search }}">
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
                                <th>@lang('site.title')</th>
                                <th>@lang('site.User name')</th>
                                <th>@lang('site.Comment text')</th>
                                <th>@lang('site.status')</th>
                                <th>@lang('site.Options')</th>
                            </tr>


                            @foreach($Bankacounts as $index=>$single)
                                <tr>
                                    <td>{{$index +1}}</td>
                                        <td>{{$single->advertsiment->titile}}</td>
                                        <td>{{$single->users->name}}</td>
                                        <td>{{$single->comment}}</td>
                                    @if($single->status==0)
                                        <td>@lang('site.Desactive')</td>
                                    @else
                                        <td>@lang('site.Active')</td>
                                    @endif
                                    <td>
                                        @if (auth()->user()->hasPermission('update_advertismnets'))
                                                <a href="{{route('dashboard.updatecomments',$single->id)}}" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i>@lang('site.Change Status')</a>
                                                <a href="{{route('dashboard.deletcomments',$single->id)}}" class="btn btn-danger btn-sm"><i class="fa fa-edit"></i>@lang('site.delete')</a>
                                        @else
                                            <a  class="btn btn-primary disabled"><i class="fa fa-edit"></i>@lang('site.update')</a>
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
