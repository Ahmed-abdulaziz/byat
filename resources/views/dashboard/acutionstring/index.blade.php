@extends('layouts.dashboard.app')

@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <h1>@lang('site.String after auction')</h1>

            <ol class="breadcrumb">
                <li><a href=""><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a></li>
                <li class="active">@lang('site.String after auction')</li>
            </ol>
        </section>

        <section class="content">

            <div class="box box-primary">

                <div class="box-header with-border">

                    <h3 class="box-title" style="margin-bottom: 15px">@lang('site.String after auction') <small></small></h3>

                    <form action="{{ route('dashboard.afadvstring.index') }}" method="get">

                        <div class="row">

                            <div class="col-md-4">

                            </div>

                            <div class="col-md-4">
                            </div>

                        </div>
                    </form><!-- end of form -->

                </div><!-- end of box header -->

                <div class="box-body">

                    @if ($notificationText->count() > 0)

                        <table class="table ">

                            <thead>
                            <tr>
                                <th>@lang('site.String after auction')</th>
                                <th>@lang('site.action')</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach ($notificationText as $index=>$single)
                                <tr>

                                    @if(app()->getLocale()=='ar')
                                        <td style="width: 400px">{{$single->after_acution_ar}}</td>
                                    @else
                                        <td style="width: 400px">{{$single->after_acution_en}}</td>
                                    @endif
                                    <td>
                                        @if (auth()->user()->hasPermission('update_appsetting'))
                                            <a href="{{ route('dashboard.afterstringedit', $single->id) }}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i> @lang('site.edit')</a>
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
