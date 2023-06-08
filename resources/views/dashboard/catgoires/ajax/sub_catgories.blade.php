                                                        <option value=''>@lang('site.Choose SubCategory')</option>
                                                        @foreach($data as $single)
                                                                <option  value="{{$single->id}}">{{$single->name}}</option>
                                                     
                                                        @endforeach
                                                   
                                      