@extends('layouts.app')

{{-- For Title --}}
@section('title')  Product @endsection

{{-- Main Content --}}
@section('content')


<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-content">
                    <form action="{{route('product.update',$product->id)}}" method="POST" id="form" enctype="multipart/form-data">
                        {{method_field('PATCH')}}
                        {{csrf_field()}}
                        <!-- First ROw -->
                        <div class="row">
                            <div class="col-md-3 form-group">
                                <label for="">User</label>
                                <select name="user_id" class="form-control">
                                    @foreach ($users as $user )
                                        <option value="{{$user->id}}" {{($user->id == $product->user_id)? 'selected' : ''}}>{{$user->name}}</option>
                                        {{-- <option value="{{$user->id}}">{{$user->name}}</option> --}}
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 form-group">
                                <label for="">Category</label>
                                <select name="category_id" class="form-control">
                                    @foreach ($category as $cat )
                                        <option value="{{$cat->id}}" {{($cat->id == $product->category_id)? 'selected' : ''}}>{{$cat->name}}</option>
                                        {{-- <option value="{{$cat->id}}">{{$cat->name}}</option> --}}
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 form-group">
                                <label for="">Product Title</label>
                                <input type="text" class="form-control" name="title" value="{{$product->title}}">
                            </div>
                            <div class="col-md-3 form-group">
                                <div class="user-friends">
                                    <p class="small">For Deleting Images Click On image </p>
                                    @if($product->images)
                                        @foreach ($product->images as $image )
                                        <a href="{{route('product.image_delete',$image->id)}}" title="Click On Image To Delete"><img alt="image" class="img-circle" src="{{ asset($image->url) }}"></a>
                                        @endforeach
                                    @endif

                                    <!-- <a href=""><img alt="image" class="img-circle" src="{{ asset('admin_file/img/a2.jpg') }}"></a>
                                    <a href=""><img alt="image" class="img-circle" src="{{ asset('admin_file/img/a3.jpg') }}"></a>
                                    <a href=""><img alt="image" class="img-circle" src="{{ asset('admin_file/img/a4.jpg') }}"></a>
                                    <a href=""><img alt="image" class="img-circle" src="{{ asset('admin_file/img/a5.jpg') }}"></a>
                                    <a href=""><img alt="image" class="img-circle" src="{{ asset('admin_file/img/a6.jpg') }}"></a> -->
                                </div>
                            </div>

                        </div>
                        <!-- 2nd Row Description -->
                        <div class="row">
                            <div class="col-md-9 form-group">
                                <label for="">Description</label>
                                <textarea name="description" rows="3" class="form-control">{{$product->description}}</textarea>
                            </div>
                            <div class="col-md-3 form-group">
                                <label for="">Image <small style="color: red;">(Maximum 4)</small></label>
                                <input type="file" class="form-control" name="images[]" multiple="multiple">
                            </div>
                        </div>

                        <!-- 3rd ROw Dimintion And Weight -->
                        <div class="row">
                            <div class="col-md-3 form-group">
                                <label for="">Dimensions</label>
                                <input type="number" value="{{$product->dimension}}" min="1" class="form-control" name="dimension">
                            </div>
                            <div class="col-md-3 form-group">
                                <label for="">Dimensions 1</label>
                                <input type="number" value="{{$product->dimension_x}}" class="form-control" min="1" name="dimension_x">
                            </div>
                            <div class="col-md-3 form-group">
                                <label for="">Dimensions 2</label>
                                <input type="number" value="{{$product->dimension_y}}" class="form-control" min="1" name="dimension_y">
                            </div>
                            <div class="col-md-3 form-group">
                                <label for="">Weight</label>
                                <input type="number" value="{{$product->weight}}" class="form-control" min="1" name="weight">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 form-group">
                                <div class="i-checks">
                                    <label>
                                        <input type="checkbox"  name="certified" {{($product->certified == "on")? 'checked' : ''}}> Check If this gemstone is lab-tested and Certified to genuine
                                    </label>
                                </div>
                                <div class="i-checks">
                                    <label>
                                        <input type="checkbox"   name="clarity_i" {{($product->clarity_i == "on")? 'checked' : ''}}> I Clarity
                                    </label>
                                </div>
                                <div class="i-checks">
                                    <label>
                                        <input type="checkbox"  name="clarity_if" {{($product->clarity_if == "on")? 'checked' : ''}}> If internally Flawless
                                    </label>
                                </div>
                                <div class="i-checks">
                                    <label>
                                        <input type="checkbox"  name="clarity_si" {{($product->clarity_si == "on")? 'checked' : ''}}> SI Clarity
                                    </label>
                                </div>
                                <div class="i-checks">
                                    <label>
                                        <input type="checkbox"   name="clarity_vs" {{($product->clarity_vs == "on")? 'checked' : ''}}> VS Clarity
                                    </label>
                                </div>
                                <div class="i-checks">
                                    <label>
                                        <input type="checkbox"  name="clarity_vvs" {{($product->clarity_vvs == "on")? 'checked' : ''}}> VVS Clarity
                                    </label>
                                </div>
                                <div class="i-checks">
                                    <label>
                                        <input type="checkbox"  name="no_treatment" {{($product->no_treatment == "on")? 'checked' : ''}}> Gemstone not treated in anyway
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label for="">Listing Type</label>
                                        <select name="listing_type" class="form-control">
                                            <option value="{{$product->listing_type}}">{{$product->listing_type}}</option>
                                                <option value="Standard Type">Standard Type</option>
                                                <option value="YZ">YZ</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label for="">Duration</label>
                                        <select name="duration" class="form-control">
                                            <option value="{{$product->duration}}">{{$product->duration}}</option>
                                                <option value="7 Days">7 Days</option>
                                                <option value="8 Days">8 Days</option>
                                                <option value="9 Days">9 Days</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row">

                                    <div class="col-md-12 form-group">
                                        <label for="">Item Type</label>
                                        <div class="i-checks">
                                            <label>
                                                <input type="radio" name="item_type"  value="Action" onclick="yesnoCheck();"  id="yesCheck" {{($product->item_type == "Action")? 'checked' : ''}}> Auction
                                            </label>
                                        </div>
                                        <div class="i-checks">
                                            <label>
                                                <input type="radio" name="item_type" value="Buy it Now" onclick="yesnoCheck();" id="noCheck" {{($product->item_type == "Buy it Now")? 'checked' : ''}}> Buy it Now
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                {{-- Pricing Details --}}
                                <div class="col-md-6 form-group">
                                    <label for="" id="yes"> {{($product->item_type == "Action")? 'Starting Price' : 'Now Price'}}</label>
                                    {{-- <label for="" id="other3"></label> --}}
                                    <input type="number" class="form-control" name="starting_price" value="{{$product->starting_price}}">
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="" id="acc">{{($product->item_type == "Buy it Now")? 'Reserve Price' : 'RRP Price'}} </label>
                                    <input type="number" class="form-control" name="reserve_price" value="{{$product->reserve_price}}" >
                                </div>
                                {{-- <div class="row">
                                    <div class="col-md-6 form-group">
                                        <input type="hidden" value="{{$product->starting_price}}" class="form-control" id="yes" name="starting_price" placeholder="Starting Price">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <input type="hidden" value="{{$product->reserve_price}}" class="form-control" id="acc" name="reserve_price" placeholder="Reserve Price">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <input type="hidden" value="{{$product->now_price}}" class="form-control" id="other3" name="now_price" placeholder="Buy It Now Price">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <input type="hidden" value="{{$product->rrp_price}}" class="form-control" id="other4" name="rrp_price" placeholder="RRP">
                                    </div>
                                </div> --}}
                            </div>
                        </div>

                        {{-- Listing Details --}}
                        <div class="row">
                            <div class="col-md-4 form-group">
                                <label for="">Mak An Offer</label>
                                <select name="offer" class="form-control">
                                    <option value="{{$product->offer}}">{{$product->offer}}</option>
                                        <option value="Disabled">Disabled</option>
                                        <option value="Enabled">Enabled</option>
                                </select>

                            </div>
                            {{-- <div class="col-md-4 form-group">
                                <label for="">Start</label>
                                <div class="i-checks">
                                    <label>
                                        <input type="radio" name="start" name="date_type"  onclick="showHideDiv(1)"> Now
                                    </label>
                                </div>
                                <div class="i-checks">
                                    <label>
                                        <input type="radio" name="start" name="date_type"  onclick="showHideDiv(2)"> Later
                                    </label>
                                </div>
                            </div> --}}
                            <div class="col-md-4 form-group">
                                <div >
                                    <label for="">Start Date</label>
                                    <input type="date" name="start_date" value="{{$product->start_date}}" class="form-control">
                                </div>
                            </div>


                        </div>



                        {{-- Shipping Details --}}
                        <div class="row">
                            <div class="col-md-4 form-group">
                                <label for="">Shipping Details</label>

                                <select name="shipping_details" class="form-control">
                                    <option value="{{$product->shipping_details}}">{{$product->shipping_details}}</option>
                                        <option value="normal">Normal Shipping</option>
                                        <option value="free">Free/Custom Shipping</option>
                                </select>
                            </div>
                            <div class="col-md-4 form-group">
                                <label for="">Shipping Rate</label>
                                <input type="text" class="form-control" value="{{$product->shipping_price}}" name="shipping_price">
                            </div>

                            <div class="col-md-4 form-group">
                                <label for="">Shipping Cost</label>
                                <select name="shipping_cost" class="form-control">
                                    <option value="{{$product->shipping_cost}}">{{$product->shipping_cost}}</option>
                                        <option value="buyer">Buyer Pays</option>
                                        <option value="seller">Seller Pays</option>
                                </select>
                            </div>
                        </div>


                        <!-- Button -->
                        <div class="row">
                            <div class="col-md-4 col-md-offset-4 form-group">
                                <label for=""></label>
                                <input type="submit" class="btn btn-info  btn-block" name="submit" value="Update">
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    function yesnoCheck() {
        yes1 = document.getElementById('yes')
        yes2 = document.getElementById('acc')

        no1 = document.getElementById('other3')
        no2 = document.getElementById('other4')

        if (document.getElementById('yesCheck').checked) {
            yes1.type = yes2.type = 'text';
            no1.type = no2.type = 'hidden';
        } else {
            no1.type = no2.type = 'text';
            yes1.type = yes2.type = 'hidden';
        }
    }

</script>

<script>
    function showHideDiv(val)
    {
     if(val ==1)
     {
        document.getElementById('div').style.display='none';
     }
     if(val ==2)
     {
        document.getElementById('div').style.display='block';
     }
    }
</script>
@endsection
