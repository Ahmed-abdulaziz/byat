@extends('layouts.dashboard.app')

@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <h1>@lang('site.AboutAPP')</h1>

            <ol class="breadcrumb">
                <li><a href=""><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a></li>
                <li class="active">@lang('site.AboutAPP')</li>
            </ol>
        </section>

        <section class="content">

            <div class="box box-primary">

                <div class="box-header with-border">

                    <h3 class="box-title" style="margin-bottom: 15px">@lang('site.AboutAPP') <small></small></h3>

                    <form action="{{ route('dashboard.users.index') }}" method="get">

                        <div class="row">

                            <div class="col-md-4">

                            </div>

                            <div class="col-md-4">
                            </div>

                        </div>
                    </form><!-- end of form -->

                </div><!-- end of box header -->

                <div class="box-body">

                    @if ($aboutapp->count() > 0)

                        <table class="table ">

                            <thead>
                            <tr>
                                <th>#</th>
                                <th>@lang('site.AboutAPP')</th>
                                <th>@lang('site.action')</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach ($aboutapp as $index=>$single)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    @if(app()->getLocale()=='ar')
                                        <td style="width: 400px">{!!  $single->aboutapp_ar !!}</td>
                                    @else
                                        <td style="width: 400px">{!!  $single->aboutapp_en !!}</td>
                                    @endif
                                    <td>
                                        @if (auth()->user()->hasPermission('update_appsetting'))
                                            <a href="{{ route('dashboard.aboutapp.edit', $single->id) }}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i> @lang('site.edit')</a>
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
