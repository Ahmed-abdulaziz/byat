@extends('layouts.front')
@section('content')

    <div class="content-page">
        <div class="container my-5 contact">
            <h2 class="my-5">@lang('site.callus')</h2>
            <div class="d-flex justify-content-around flex-wrap">
                <div class="contact_information col-md m-3  col-12 ">
                    <h5>@lang('site.This is How can You Contact souqrim')</h5>
                    <div class="details-info">
                        <p>@lang('site.Phone Number')</p>
                        <i class="fas fa-phone-alt phone-icon icon"></i><span>{{$Setting->phone}}</span>
                    </div>
                    <div class="details-info">
                        <p>@lang('site.Email')</p>
                        <i class="fas fa-envelope icon"></i><span>{{$Setting->email}}</span>
                    </div>
                    <div class="details-info follow-div">
                        <p>@lang('site.Follow us')</p>
                        <ul class="list-inline mt-3">
                            <li class="list-inline-item  li-icon icon-1"><a href="{{$Setting->facebook}}"><i class="fab fa-facebook-f "></i> </a></li>
                            <li class="list-inline-item li-icon icon-2"><a href="{{$Setting->instgram}}"><i class="fab fa-instagram"></i> </a></li>
                            <li class="list-inline-item li-icon icon-3"><a href="{{$Setting->twwiter}}"><i class="fab fa-twitter"></i> </a></li>

                        </ul>
                    </div>
                </div>
                <div class="contact_form col-md-7 col-12 my-3">
                    <h5>@lang('site.Send Message')</h5>
                    <form method="post" action="{{route('sendmessage')}}">
                       {{csrf_field()}}
                       {{method_field('post')}}
                        @include('partials._errors')
                        <div class="row mb-3">
                            <label for="inputName3" class="col-sm-3 col-form-label">@lang('site.Name')</label>
                            <div class="col-sm-9">
                                <input type="text" name="name" class="form-control" id="inputName3" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputEmail3"  class="col-sm-3 col-form-label">@lang('site.Email')</label>
                            <div class="col-sm-9">
                                <input type="email" name="email" class="form-control" id="inputEmail3" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputEmail3" class="col-sm-3 col-form-label">@lang('site.Message Type')</label>
                            <div class="col-sm-9">
                                <select class=" py-3 select-form" name="type">
                                    <option selected>@lang('site.Message Type')</option>
                                    <option value="0">@lang('site.Problem')</option>
                                    <option value="1">@lang('site.suggestion')</option>
                                </select>
                            </div>
                        </div> <!-- form-group end.// -->
                        <div class="row mb-3">
                            <label for="writeMessage" class="col-sm-3 col-form-label">@lang('site.Message')</label>
                            <div class="col-sm-9">
                                <textarea name="message" id="writeMessage" cols="30" rows="5" class="form-control" required></textarea>
                            </div>
                        </div>
                        <div class="div-btn">
                            <button type="submit" class="btn btn-primary send-btn">@lang('site.Send')</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
