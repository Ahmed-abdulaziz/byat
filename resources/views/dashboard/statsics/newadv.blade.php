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


                    <form action="{{route('dashboard.newadvertismnets.index')}}" method="get">

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
                                <th>@lang('site.phone')</th>
                                <th>@lang('site.Owner Name')</th>
                                <th>@lang('site.advertisement Type')</th>
                                <th>@lang('site.date')</th>
                                <th>@lang('site.Options')</th>
                            </tr>


                            @foreach($Bankacounts as $index=>$single)
                                <tr>
                                    <td>{{$index +1}}</td>
                                    <td>{{$single->title}}</td>
                                    <td>{{$single->phone}}</td>
                                   <td>{{$single->owner->name}}</td>
                                    @if($single->cat_id==1)
                                        <td>@lang('site.cars')</td>
                                    @elseif($single->cat_id==2)
                                        <td>@lang('site.plates')</td>
                                    @else
                                        <td>@lang('site.Others')</td>
                                    @endif
                                    <td>{{$single->created_at}}</td>
                                    <td>
                                        <a href="{{ route('dashboard.newadvertismnets.edit', $single->id) }}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i> @lang('site.View Images')</a>
                                        <a href="{{ route('dashboard.newadvertismnets.show', $single->id) }}" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i> @lang('site.set Active')</a>
                                        <form action="{{ route('dashboard.newadvertismnets.destroy', $single->id) }}" method="post" style="display: inline-block">
                                            {{ csrf_field() }}
                                            {{ method_field('delete') }}
                                            @if(auth()->user()->hasPermission('delete_advertiments'))
                                                    <button type="submit" class="btn btn-danger delete btn-sm"><i class="fa fa-trash"></i> @lang('site.delete')</button>
                                                    @else
                                                <button type="submit" class="btn btn-danger delete btn-sm disabled"><i class="fa fa-trash"></i> @lang('site.delete')</button>
                                            @endif
                                        </form>

                                    </td>
                                </tr>
                            @endforeach

                        </table>
                        {{ $Bankacounts->appends(request()->query())->links() }}
                    @else
                        <h2>@lang('site.no_data_found')</h2>
                    @endif

                </div>

            </div>

        </section><!-- end of content -->

    </div><!-- end of content wrapper -->

@endsection
