@extends('layouts.dashboard.app')

@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <h1>@lang('site.Complaints')</h1>

            <ol class="breadcrumb">
                <li><a href=""><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a></li>
                <li class="active">@lang('site.Complaints')</li>
            </ol>
        </section>





        <section class="content">

            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title" style="margin-bottom: 15px">@lang('site.Complaints') <small></small></h3>


                    <form action="{{route('dashboard.aboutapp.index')}}" method="get">

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
                    @if($complinte->count() > 0)
                        <table class="table table-bordered">
                            <tr>
                                <th>#</th>
                                <th>@lang('site.name')</th>
                                <th>@lang('site.email')</th>
                                <th>@lang('site.message')</th>
                                <th>@lang('site.created_at')</th>
                                <th>@lang('site.Options')</th>
                            </tr>


                            @foreach($complinte as $index=>$single)
                                <tr>
                                    <td>{{$index +1}}</td>
                                    <td> {{$single->name}}  </td>
                                    <td>  {{$single->email}} </td>
                                    <td>  {{$single->message}}</td>
                                    <td>  {{$single->created_at}}</td>

                                    <td>
                                        <a href="{{route('dashboard.complinte.edit',$single->id)}}" class="btn btn-primary"><i class="fa fa-edit"></i>@lang('site.Answer')</a>

                                        <form action="{{ route('dashboard.complinte.destroy', $single->id) }}" method="post" style="display: inline-block">
                                            {{ csrf_field() }}
                                            {{ method_field('delete') }}
                                            <button type="submit" class="btn btn-danger delete btn-sm"><i class="fa fa-trash"></i> @lang('site.delete')</button>
                                        </form>

                                    </td>
                                </tr>
                            @endforeach

                        </table>
                        {{ $complinte->appends(request()->query())->links() }}
                    @else
                        <h2>@lang('site.no_data_found')</h2>
                    @endif

                </div>

            </div>

        </section><!-- end of content -->

    </div><!-- end of content wrapper -->

@endsection
