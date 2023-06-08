                            <hr>
                            <h2>@lang('site.filters')</h2> 
                      
                            @foreach($filters as $item)
                            
                        <div class="row">
                            
                             
                             <!--//single select-->
                            @if($item->type == 1)          
                                 <input type="hidden" name="filters_id[]" value="{{$item->id}}" class="form-control" />
                                  <input type="hidden" name="types[]" value="{{$item->type}}" class="form-control" />
                            @php
                                    $componants = \App\category_item_components::where('category_item_id' , $item->id)->get();
                            @endphp
                                
                                       <div class="col-md-6  form-group">
                                           <input type="hidden" class="parent_filter" value="{{$item->id}}" />
                                            <label>{{$item->name}}</label>
                                            <select class="form-control select2 subfilter"  style="width: 100%;height:110% " required name="sub_filter_id[]">
                                                @foreach($componants as $single)
                                                        <option  value="{{$single->id}}">{{$single->name}}</option>
                                             
                                                @endforeach
                                            </select>
                                    </div>
                                     <div class="col-md-6 filterchild-{{$item->id}}">
                                         
                                        </div>
                                 <!--//multiple select-->
                                @elseif($item->type == 2)   
                                 <input type="hidden" name="multi_filters_id[]" value="{{$item->id}}" class="form-control" />
                                  @php
                                    $componants = \App\category_item_components::where('category_item_id' , $item->id)->get();
                                 @endphp
                                       <div class="col-md-6  form-group">
                                            <label>{{$item->name}}</label>
                                            @php
                                                $index=0;
                                            @endphp
                                                @foreach($componants as $single)
                                                      <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" name="multi_sub_filter_id[{{$item->id}}][]" value="{{$single->id}}" id="defaultUnchecked">
                                                            <label class="custom-control-label" for="defaultUnchecked">{{$single->name}}</label>
                                                        </div>
                                                  @php
                                                    $index++;
                                                @endphp
                                                @endforeach
                                            
                                    </div>
                               
                                 <!--// input text-->
                                @elseif($item->type == 3) 
                                 <input type="hidden" name="types[]" value="{{$item->type}}" class="form-control" />
                                 <input type="hidden" name="filters_id[]" value="{{$item->id}}" class="form-control" />
                                 @php
                                    $componants = \App\category_item_inputs::where('category_item_id' , $item->id)->get();
                                    
                                 @endphp
                                       <div class="col-md-6  form-group">
                                            <label>{{$item->name}}</label>
                                                @foreach($componants as $single)
                                                 <input type="hidden" name="sub_filter_id[]" value="{{$single->id}}" class="form-control" />
                                                <div class="row">
                                                    <div class="col-md-8">
                                                         <input type="text" placeholder="{{$single->placeholder}}" @if($item->can_skip == 0) required @endif  name="text[{{$single->id}}]" class="form-control" />
                                                    </div>
                                                      <div class="col-md-3">
                                                        {{$single->unit}} 
                                                    </div>
                                                      
                                                </div>
                                                @endforeach
                                            
                                    </div>
                                @endif
                                  </div>
                                 
                            @endforeach