@extends('layouts.dashboard.app')

@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <h1>@lang('site.Free auction Numbers')</h1>

            <ol class="breadcrumb">
                <li><a href=""><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a></li>
                <li class="active">@lang('site.Free auction Numbers')</li>
            </ol>
        </section>

        <section class="content">

            <div class="box box-primary">

                <div class="box-header with-border">

                    <h3 class="box-title" style="margin-bottom: 15px">@lang('site.Free auction Numbers') <small></small></h3>

              

                </div><!-- end of box header -->

                <div class="box-body">

                    @if ($notificationText->count() > 0)

                        <table class="table ">

                            <thead>
                            <tr>

                                <th>@lang('site.Free auction Numbers')</th>
                                <th>@lang('site.action')</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach ($notificationText as $index=>$single)
                                <tr>


                                        <td style="width: 400px">{{$single->free_auctions}}</td>


                                    <td>
                                        @if (auth()->user()->hasPermission('update_advertiments'))
                                            <a href="{{ route('dashboard.free-Auctions-edit', $single->id) }}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i> @lang('site.edit')</a>
                                        @else
                                            <a href="#" class="btn btn-info btn-sm disabled"><i class="fa fa-edit"></i> @lang('site.edit')</a>
                                        @endif

                                    </td>
                                </tr>

                            @endforeach
                            </tbody>

                        </table><!-- end of table -->


                    @else

                        <h2>@lang('site.no_data_found')</h2>

                    @endif

                </div><!-- end of box body -->


            </div><!-- end of box -->

        </section><!-- end of content -->

    </div><!-- end of content wrapper -->


@endsection
