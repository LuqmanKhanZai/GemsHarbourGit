@extends('layouts.app')



{{-- For Title --}}

@section('title')  Product @endsection



{{-- Main Content --}}

@section('content')



<div class="row wrapper border-bottom white-bg page-heading">

    <div class="col-lg-10">

        <h2>Add Product Form <a href="{{route('product.index')}}" class="btn btn-info btn-xs"><i class="fa fa-reply"></i> Back</a></h2>

    </div>

    <div class="col-lg-2">

    </div>

</div>

<div class="row">

    <div class="col-md-4 col-md-offset-4">

        @if ($errors->any())

            <div class="alert alert-danger alert-dismissible" style="margin-top:40px;">

                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>

                    @foreach ($errors->all() as $error)

                        <p style="text-align: center;"><strong >{{ $error }}</strong></p>

                    @endforeach

            </div>

        @endif

    </div>

</div>



<div class="wrapper wrapper-content animated fadeInRight">

    <div class="row">

        <div class="col-lg-12">

            <div class="ibox float-e-margins">

                <div class="ibox-content">

                    <form action="{{route('product.store')}}" method="POST" id="form" enctype="multipart/form-data">

                        {{csrf_field()}}

                        <!-- First ROw -->

                        <div class="row">

                            <div class="col-md-3 form-group">

                                <label for="">Category</label>

                                <select name="category_id" class="form-control">

                                    @foreach ($category as $cat )

                                        <option value="{{$cat->id}}">{{$cat->name}}</option>

                                    @endforeach

                                </select>

                            </div>

                            <div class="col-md-3 form-group">

                                <label for="">Product Title</label>

                                <input type="text" class="form-control" name="title" value="{{old('title')}}">

                            </div>

                            <div class="col-md-3 form-group">

                                <label for="">Cover Image</label>

                                <input type="file" class="form-control" name="cover">

                            </div>

                            <div class="col-md-3 form-group">

                                <label for="">Product Images <small style="color: red;">(Maximum 4)</small></label>

                                <input type="file" class="form-control" name="images[]" multiple="multiple">

                            </div>

                        </div>

                        <!-- 2nd Row Description -->

                        <div class="row">

                            <div class="col-md-12 form-group">

                                <label for="">Description</label>

                                <textarea name="description" rows="3" class="form-control">{{old('description')}}</textarea>

                            </div>

                        </div>



                        <!-- 3rd ROw Dimintion And Weight -->

                        <div class="row">

                            <div class="col-md-3 form-group">

                                <label for="">Dimensions</label>

                                <input type="number" min="1" class="form-control" name="dimension" value="{{old('dimension')}}">

                            </div>

                            <div class="col-md-3 form-group">

                                <label for="">Dimensions 1</label>

                                <input type="number" class="form-control" min="1" name="dimension_x" value="{{old('dimension_x')}}">

                            </div>

                            <div class="col-md-3 form-group">

                                <label for="">Dimensions 2</label>

                                <input type="number" class="form-control" min="1" name="dimension_y" value="{{old('dimension_y')}}">

                            </div>

                            <div class="col-md-3 form-group">

                                <label for="">Weight</label>

                                <input type="number" class="form-control" min="1" name="weight" value="{{old('weight')}}">

                            </div>

                        </div>



                        <div class="row">

                            <div class="col-md-6 form-group">

                                <div class="i-checks">

                                    <label>

                                        <input type="checkbox"  name="certified"> Check If this gemstone is lab-tested and Certified to genuine

                                    </label>

                                </div>

                                <div class="i-checks">

                                    <label>

                                        <input type="checkbox"  name="clarity_i"> I Clarity

                                    </label>

                                </div>

                                <div class="i-checks">

                                    <label>

                                        <input type="checkbox"  name="clarity_if"> If internally Flawless

                                    </label>

                                </div>

                                <div class="i-checks">

                                    <label>

                                        <input type="checkbox"  name="clarity_si"> SI Clarity

                                    </label>

                                </div>

                                <div class="i-checks">

                                    <label>

                                        <input type="checkbox"   name="clarity_vs"> VS Clarity

                                    </label>

                                </div>

                                <div class="i-checks">

                                    <label>

                                        <input type="checkbox"  name="clarity_vvs"> VVS Clarity

                                    </label>

                                </div>

                                <div class="i-checks">

                                    <label>

                                        <input type="checkbox"  name="no_treatment"> Gemstone not treated in anyway

                                    </label>

                                </div>

                            </div>

                            <div class="col-md-6">

                                <div class="row">

                                    <div class="col-md-6 form-group">

                                        <label for="">Listing Type</label>

                                        <select name="listing_type" class="form-control">

                                            <option selected disabled value="Select Duration">Select Listing Type</option>

                                                <option value="Standard Type" {{ old('listing_type') == 'Standard Type' ? 'selected' : '' }}>Standard Type</option>

                                                <option value="YZ" {{ old('listing_type') == 'YZ' ? 'selected' : '' }}>YZ</option>

                                        </select>

                                    </div>

                                    <div class="col-md-6 form-group">

                                        <label for="">Duration</label>

                                        <select name="duration" class="form-control">

                                                <option selected disabled value="Select Duration">Select Duration</option>

                                                <option value="7 Days" {{ old('duration') == '7 Days' ? 'selected' : '' }}>7 Days</option>

                                                <option value="8 Days" {{ old('duration') == '8 Days' ? 'selected' : '' }}>8 Days</option>

                                                <option value="9 Days" {{ old('duration') == '9 Days' ? 'selected' : '' }}>9 Days</option>

                                        </select>

                                    </div>

                                </div>



                                <div class="row">



                                    <div class="col-md-12 form-group">

                                        <label for="">Item Type</label>

                                        <div class="i-checks">

                                            <label>

                                                <input type="radio" name="item_type"  value="Action" onclick="yesnoCheck();"  id="yesCheck"> Auction

                                            </label>

                                        </div>

                                        <div class="i-checks">

                                            <label>

                                                <input type="radio" name="item_type" value="Buy it Now" onclick="yesnoCheck();" id="noCheck"> Buy it Now

                                            </label>

                                        </div>

                                    </div>

                                </div>



                                {{-- Pricing Details --}}

                                <div class="row">

                                    <!-- <div class="col-md-6 form-group">

                                        <label for="" id="yes">Starting Price</label>

                                        <label for="" id="other3">Now Price</label>

                                        <input type="number" value="0" class="form-control" id="" name="starting_price" value="0" placeholder="Starting Price">

                                    </div>

                                    <div class="col-md-6 form-group">

                                        <label for="" id="acc"> Reserve Price</label>

                                        <label for="" id="other4"> RRP Price</label>

                                        <input type="number" value="0" class="form-control" id="" name="reserve_price" placeholder="Reserve Price">

                                    </div> -->

                                    {{-- <div class="col-md-6 form-group">

                                        <input type="hidden" value="0" class="form-control" id="other3" name="now_price" placeholder="Buy It Now Price">

                                    </div>

                                    <div class="col-md-6 form-group">

                                        <input type="hidden" value="0" class="form-control" id="other4" name="rrp_price" placeholder="RRP">

                                    </div> --}}

                                </div>

                                <div class="row">

                                    <div class="col-md-6 form-group">

                                         <label for="">Starting Price</label>

                                        <input type="hidden" value="0" class="form-control" id="yes" name="starting_price" value="0" placeholder="Starting Price" value="{{old('starting_price')}}">

                                    </div>

                                    <div class="col-md-6 form-group">

                                        <label for="">Reserve Price</label>

                                        <input type="hidden" value="0" class="form-control" id="acc" name="reserve_price" placeholder="Reserve Price" value="{{old('reserve_price')}}">

                                    </div>

                                    <div class="col-md-6 form-group">

                                        <label for=""> Now Price</label>

                                        <input type="hidden" value="0" class="form-control" id="other3" name="now_price" placeholder="Buy It Now Price" value="{{old('now_price')}}">

                                    </div>

                                    <div class="col-md-6 form-group">

                                        <label for=""> RRP Price</label>

                                        <input type="hidden" value="0" class="form-control" id="other4" name="rrp_price" placeholder="RRP" value="{{old('rrp_price')}}">

                                    </div>

                                </div>

                            </div>

                        </div>



                        {{-- Listing Details --}}

                        <div class="row">

                            <div class="col-md-4 form-group">

                                <label for="">Mak An Offer</label>

                                <select name="offer" class="form-control">

                                        <option selected disabled value="Select Offer">Select Offer</option>

                                        <option value="disabled" {{ old('offer') == 'disabled' ? 'selected' : '' }}>Disabled</option>

                                        <option value="enabled" {{ old('offer') == 'enabled' ? 'selected' : '' }}>Enabled</option>

                                </select>

                            </div>

                            <div class="col-md-4 form-group">

                                <label for="">Start</label>

                                <div class="i-checks">

                                    <label>

                                        <input type="radio" checked="" name="start" value="now" onclick="showHideDiv(1)"> Now

                                    </label>

                                </div>

                                <div class="i-checks">

                                    <label>

                                        <input type="radio" value="later" name="start" onclick="showHideDiv(2)"> Later

                                    </label>

                                </div>



                            </div>

                            <div class="col-md-4">

                                <div id="div" style="display: none;">

                                    <label for="">Start Date</label>

                                    <input type="date" name="start_date" value={{\Carbon\Carbon::now()->format('Y-m-d')}} class="form-control">

                                </div>

                            </div>





                        </div>







                        {{-- Shipping Details --}}

                        <div class="row">

                            <div class="col-md-4 form-group">

                                <label for="">Shipping Details</label>

                                <select name="shipping_details" class="form-control">

                                    <option selected disabled value="Select Offer">Select Sgupping Details</option>

                                        <option value="normal" {{ old('shipping_details') == 'normal' ? 'selected' : '' }}>Normal Shipping</option>

                                        <option value="free" {{ old('shipping_details') == 'free' ? 'selected' : '' }}>Free/Custom Shipping</option>

                                </select>

                            </div>

                            <div class="col-md-4 form-group">

                                <label for="">Shipping Rate</label>

                                <input type="text" class="form-control" name="shipping_price" value="{{old('shipping_price')}}">

                            </div>



                            <div class="col-md-4 form-group">

                                <label for="">Shipping Cost</label>

                                <select name="shipping_cost" class="form-control">

                                    <option selected disabled value="Select Offer">Select Shipping Cost</option>

                                        <option value="buyer" {{ old('shipping_cost') == 'normal' ? 'buyer' : '' }}>Buyer Pays</option>

                                        <option value="seller" {{ old('shipping_cost') == 'normal' ? 'seller' : '' }}>Seller Pays</option>

                                </select>

                            </div>

                        </div>



                        <!-- Button -->

                        <div class="row">

                            <div class="col-md-4 col-md-offset-4 form-group">

                                <label for=""></label>

                                <input type="submit" class="btn btn-info  btn-block" name="submit" value="Save">

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

