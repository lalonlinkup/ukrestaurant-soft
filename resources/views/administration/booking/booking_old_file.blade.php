@extends('master')
@section('title', 'Table Booking Entry')
@section('breadcrumb_title', 'Table Booking Entry')
@push('style')
<link rel="stylesheet" href="{{asset('backend')}}/css/booking.css" />
@endpush

@section('content')
<div class="row" id="booking">
    <div class="col-md-12 col-xs-12">
        <div class="tab-content" style="border: none">
            <div id="tab1" class="tab-pane fade in active">
                <div class="row">
                    <div class="col-md-12 col-xs-12">
                        <div class="col-md-1"></div>
                        <div class="col-md-10 col-xs-12 no-padding">
                            <div class="col-md-2 col-xs-6" v-for="floorItem in floors" style="width: 12.333%">
                                <div class="card">
                                    <div class="text" v-html="floorItem.name"></div>
                                    <div class="button">
                                        View Table
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 col-xs-12 ">
                        <div class="col-md-1"></div>
                        <div class="col-md-10 col-xs-10" style="margin-top:30px">
                            <h3 style="border-bottom:1px double #e86100;padding-bottom:10px;text-align:left !important">
                                Table Information</h3>
                            <form action="">
                                <div class="col-md-12 col-xs-12 border-radius" style="padding:0 !important;background:#aee2ff;border: 1px groove #848f95 !important;">
                                    <div class="col-md-4 col-xs-4" style="padding-top:8px">
                                        <div class="date" style="display:flex">
                                            <p style="font-size:18px">From</p><span style="margin-left:10px"><input style="width: 230px" type="date" v-model="booking.checkin"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-xs-10" style="padding-top:8px">
                                        <div class="date" style="display:flex;">
                                            <p style="font-size:18px">To</p><span style="margin-left:10px"><input style="width:230px" type="date" v-model="booking.checkout"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-xs-8" style="padding-top:8px;">
                                        <div class="date" style="display:flex">
                                            <p style="font-size:18px">Type</p>
                                            <select class="form-control" v-model="typeId" style="height:32px;border-radius:5px;width:150px">
                                                <option value="">All</option>
                                                <option v-for="tabletype in tabletypes" :value="tabletype.id">@{{tabletype.name}}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-1 col-xs-4" style="padding-top:8px;float:right">
                                        <div class="date" style="display:flex">
                                            <p @click="getTables" style="cursor:pointer;font-size:18px;border:1px groove #848f95;padding:0px 10px;border-radius:5px;background:white">
                                                <i class="bi bi-search"></i>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 col-xs-12" style="margin-top:15px;margin-bottom:15px;padding:0 !important">
                                    <div class="check-box" style="display: flex;">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" id="all" name="searchType">
                                            <label class="form-check-label" for="all">All</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" id="booked" name="searchType">
                                            <label class="form-check-label" for="booked">Booked</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" id="available" name="searchType">
                                            <label class="form-check-label" for="available">Available</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" id="checkin" name="searchType">
                                            <label class="form-check-label" for="checkin">Check-in</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 col-xs-12 about-table" style="padding-left:12px !important;">
                                    <div class="row">
                                        <div class="col-md-12 col-xs-12 no-padding" style="display:flex;flex-wrap: wrap;">
                                            <div class="content" v-for="tableItem in tables">
                                                <label :for="tableItem.id">
                                                    <div class="booking-card" :style="{background: tableItem.color}">
                                                        <div class="card-image text-center">
                                                            <i class="bi bi-house fa-4x" alt="House Image" style=" color:white;width: 100%; height: 100%; object-fit: cover;"></i>
                                                            <div class="overlay">
                                                                <p>@{{tableItem.name}}</p>
                                                            </div>
                                                            <div class="top-right-text">
                                                                <input :style="{visibility: tableItem.color == '#B2BEB5' ? '' : 'hidden'}" onchange="addToCart(event)" type="checkbox" :id="tableItem.id">
                                                                <button type="button" class="icon-container" data-toggle="modal" data-target="#myModal">
                                                                    <i class="bi bi-info"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                        <div class="card-button">@{{tableItem.color == '#B2BEB5' ? 'Available' : tableItem.color == 'red' ? 'Check In' : 'Booked'}}</div>
                                                    </div>
                                                </label>
                                            </div>
                                            <div class="content">
                                                <div class="booking-card" style="background: #e28a2b;">
                                                    <div class="card-image text-center">
                                                        <i class="bi bi-house fa-4x" alt="House Image" style=" color:white;width: 100%; height: 100%; object-fit: cover;"></i>
                                                        <div class="overlay">
                                                            <p>102 Available</p>
                                                        </div>
                                                        <div class="top-right-text">
                                                            <input type="checkbox" id="available-checked" style="margin: 0px;visibility:hidden;">
                                                            <button type="button" class="icon-container" data-toggle="modal" data-target="#myModal">
                                                                <i class="bi bi-info"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="card-button">
                                                        Booked
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="content">
                                                <div class="check-in-card" style="background:red;">
                                                    <div class="card-image text-center">
                                                        <i class="bi bi-house fa-4x" alt="House Image" style=" color:white;width: 100%; height: 100%; object-fit: cover;"></i>
                                                        <div class="overlay">
                                                            <p>101 Check-in</p>
                                                        </div>
                                                        <div class="top-right-text">
                                                            <input type="checkbox" id="available-checked" style="margin: 0px;visibility:hidden;">
                                                            <button type="button" class="icon-container" data-toggle="modal" data-target="#myModal">
                                                                <i class="bi bi-info"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="card-button">
                                                        Check-in
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>

            </div>
            <div id="tab2" class="tab-pane fade">
                <div class="row">
                    <div class="col-md-12 .col-xs-12">
                        <form>
                            <div class="row" style="margin:0;">
                                <div class="col-md-12 col-xs-12 bg-of-orange border-radius " style="padding: 0;">
                                    <h5 class="top-radius" style="background:#BC2649;text-align:left;color:white;margin:0;padding:5px;">
                                        Personal Information</h5>
                                    <div class="info">
                                        <div class="col-md-4" style="padding: 0;margin-bottom:5px">
                                            <div class="form-group">
                                                <label class="control-label col-xs-4 col-md-4">
                                                    Name:</label>
                                                <div class=" col-xs-8 col-md-8">
                                                    <input type="text" class="form-control" name="name">
                                                </div>
                                            </div>
                                            <div class="form-group ">
                                                <label class="control-label col-xs-4 col-md-4">
                                                    Email:</label>
                                                <div class=" col-xs-8 col-md-8">
                                                    <input type="text" class="form-control" name="email">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4" style="padding: 0;">
                                            <div class="form-group ">
                                                <label class="control-label col-xs-4 col-md-4">
                                                    Phone:</label>
                                                <div class=" col-xs-8 col-md-8">
                                                    <input type="text" class="form-control" name="phone">
                                                </div>
                                            </div>
                                            <div class="form-group ">
                                                <label class="control-label col-xs-4 col-md-4">
                                                    NID No:</label>
                                                <div class=" col-xs-8 col-md-8">
                                                    <input type="text" class="form-control" name="nid">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4" style="padding: 0;">
                                            <div class="form-group">
                                                <label class="control-label col-xs-4 col-md-4">
                                                    Guest Address:</label>
                                                <div class="col-xs-8 col-md-8">
                                                    <textarea class="form-control" name="address"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6" style="padding: 0 !important;">
                                    <div class="cheduler-border bg-of-skyblue border-radius" style="margin-top:10px;height:280px">
                                        <div class="form-group">
                                            <label class="control-label col-xs-8 col-md-8" style="margin-top:10px">

                                                <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                                <label class="form-check-label" for="exampleCheck1">Other
                                                    Member</label>

                                        </div>
                                        <div class="col-md-12 col-xs-12" style="padding: 0px !important;margin-top:10px;margin-bottom:20px;">
                                            <div class="form-group clearfix">
                                                <div class="col-md-4 col-xs-12" style="padding:0 !important">
                                                    <label class="control-label col-xs-3 col-md-4" style="margin:0 !important">
                                                        Name:</label>
                                                    <div class=" col-xs-8 col-md-8" style="padding: 0px !important">
                                                        <input type="text" class="form-control" name="name">
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-xs-12" style="padding:0 !important">
                                                    <label class="control-label col-xs-3 col-md-4" style="margin:0 !important">
                                                        Id:</label>
                                                    <div class=" col-xs-8 col-md-8" style="padding: 0px !important">
                                                        <input type="text" class="form-control" name="id">
                                                    </div>
                                                </div>

                                                <div class="col-md-3 col-xs-12" style="padding:0 !important">
                                                    <label class="control-label col-xs-3 col-md-6" style="margin:0 !important">Gender:</label>
                                                    <div class=" col-xs-8 col-md-6" style="padding: 0 !important">

                                                        <select class="form-control col-xs-6" style="border-radius:5px;" name="gender" id="gender">
                                                            <option value="">Select</option>
                                                            <option value="male">Male</option>
                                                            <option value="female">Female</option>
                                                            <option value="other">Other</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-1 col-xs-2">
                                                    <button type="button" class="btn btn-xs btn-success" style="width: 100%;height: 24px;border: 0px;margin-left: 1px;border-radius: 3px;"><i class="fa fa-plus"></i></button>
                                                </div>

                                            </div>
                                        </div>

                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Id No</th>
                                                    <th>Gender</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Mr Haque</td>
                                                    <td>00000000</td>
                                                    <td>Male</td>
                                                    <td class=""><i class="fa fa-times btn btn-xs btn-danger" style="padding:1px !important; border-radius:3px">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Mr Haque</td>
                                                    <td>00000000</td>
                                                    <td>Male</td>
                                                    <td class=""><i class="fa fa-times btn btn-xs btn-danger" style="padding:1px !important; border-radius:3px">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Mr Haque</td>
                                                    <td>00000000</td>
                                                    <td>Male</td>
                                                    <td class=""><i class="fa fa-times btn btn-xs btn-danger" style="padding:1px !important; border-radius:3px">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Mr Haque</td>
                                                    <td>00000000</td>
                                                    <td>Male</td>
                                                    <td class=""><i class="fa fa-times btn btn-xs btn-danger" style="padding:1px !important; border-radius:3px">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Mr Haque</td>
                                                    <td>00000000</td>
                                                    <td>Male</td>
                                                    <td class=""><i class="fa fa-times btn btn-xs btn-danger" style="padding:1px !important; border-radius:3px">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Mr Haque</td>
                                                    <td>00000000</td>
                                                    <td>Male</td>
                                                    <td class=""><i class="fa fa-times btn btn-xs btn-danger" style="padding:1px !important; border-radius:3px">
                                                    </td>
                                                </tr>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="col-md-6 col-xs-12" style="padding:10px 0px 10px 10px !important;">
                                    <h5 class="top-radius" style="background:#146C94;text-align:left;color:white;margin:0;padding:5px; ">
                                        Table Booking List</h5>
                                    <div class="control-group bg-of-yellow border-radius" style="height:252px !important;">
                                        <table class="table" style="padding:5px;">
                                            <thead>
                                                <tr style="background:white;color:black;border:1px solid #D5D5D5">
                                                    <th>Table</th>
                                                    <th>Days</th>
                                                    <th>Fare</th>
                                                    <th>Sub Total</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>101</td>
                                                    <td>4</td>
                                                    <td>8000 usd</td>
                                                    <td>3200 usd</td>
                                                    <td class=""><i class="fa fa-times btn btn-xs btn-danger" style="padding:1px !important; border-radius:3px">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>101</td>
                                                    <td>4</td>
                                                    <td>8000 usd</td>
                                                    <td>3200 usd</td>
                                                    <td><i class="fa fa-times btn btn-xs btn-danger" style="padding:1px !important; border-radius:3px">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>101</td>
                                                    <td>4</td>
                                                    <td>8000 usd</td>
                                                    <td>3200 usd</td>
                                                    <td><i class="fa fa-times btn btn-xs btn-danger" style="padding:1px !important; border-radius:3px">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>101</td>
                                                    <td>4</td>
                                                    <td>8000 usd</td>
                                                    <td>3200 usd</td>
                                                    <td><i class="fa fa-times btn btn-xs btn-danger" style="padding:1px !important; border-radius:3px">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>101</td>
                                                    <td>4</td>
                                                    <td>8000 usd</td>
                                                    <td>3200 usd</td>
                                                    <td><i class="fa fa-times btn btn-xs btn-danger" style="padding:1px !important; border-radius:3px">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>101</td>
                                                    <td>4</td>
                                                    <td>8000 usd</td>
                                                    <td>3200 usd</td>
                                                    <td><i class="fa fa-times btn btn-xs btn-danger" style="padding:1px !important; border-radius:3px">
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                                <div class="col-md-12 col-xs-12 bg-light-green border-radius" style="padding: 0;">
                                    <h5 class="top-radius" style="background:#146C94;text-align:left;color:white;margin:0;padding:5px;">
                                        Payment Info</h5>
                                    <div class="info">
                                        <div class="col-md-4" style="padding: 0;margin-bottom:5px">
                                            <div class="form-group">
                                                <label class="control-label col-xs-4 col-md-4">
                                                    Sub Total:</label>
                                                <div class=" col-xs-8 col-md-8">
                                                    <input type="number" class="form-control" name="subtotal" readonly>
                                                </div>
                                            </div>
                                            <div class="form-group ">
                                                <label class="control-label col-xs-4 col-md-4">
                                                    Discount:</label>
                                                <div class=" col-xs-8 col-md-3">
                                                    <input type="number" class="form-control" name="discount">
                                                </div>
                                                <label class="control-label col-xs-4 col-md-1" style="padding:0 !important">
                                                    %</label>
                                                <div class=" col-xs-8 col-md-4">
                                                    <input type="number" class="form-control" name="discount">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3" style="padding: 0;margin-bottom:5px">
                                            <div class="form-group ">
                                                <label class="control-label col-xs-4 col-md-3">
                                                    Vat:</label>
                                                <div class=" col-xs-8 col-md-4">
                                                    <input type="number" class="form-control" name="discount">
                                                </div>
                                                <label class="control-label col-xs-4 col-md-1" style="padding:0 !important">
                                                    %</label>
                                                <div class=" col-xs-8 col-md-4">
                                                    <input type="number" class="form-control" name="discount">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-xs-4 col-md-3">
                                                    Total:</label>
                                                <div class=" col-xs-8 col-md-9">
                                                    <input type="number" class="form-control" name="subtotal">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3" style="padding: 0;margin-bottom:5px">
                                            <div class="form-group ">
                                                <label class="control-label col-xs-4 col-md-4">
                                                    Advance:</label>
                                                <div class=" col-xs-8 col-md-8">
                                                    <input type="number" class="form-control" name="advance">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-xs-4 col-md-4">
                                                    Due:</label>
                                                <div class=" col-xs-8 col-md-8">
                                                    <input type="number" class="form-control" name="due">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2" style="padding: 0;margin-bottom:5px">
                                            <div class="form-group ">
                                                <div class=" col-xs-12" style="width: 100% !important;padding-bottom:5px;">
                                                    <a data-toggle="tab" href="#tab1" class="btn btn-danger btn-reset" style="font-size:11px;padding:0px 30px !important">
                                                        <i class="bi bi-arrow-left"></i> Previous
                                                    </a>
                                                </div>
                                                <div class="col-xs-12">
                                                    <input type="submit" class="btn btn-primary btn-padding" value="Submit" style="font-size:11px;padding:0px 41px !important">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- modal for table view -->
    <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content" style="border-radius:20px;">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h3 class="modal-title" style="text-align:center;font-weight:bold">Table Information</h3>
                </div>
                <div class="modal-body" style="margin-bottom:15px">
                    <div class="row" style="margin: 10px;  box-shadow: 0px 2px 5px 0px #c2bfbf;border-radius:10px;padding-top:10px;padding-bottom:15px">
                        <div class="col-md-6 col xs-12" style="border-right:1px solid rgb(219, 214, 214)">
                            <div class="image">
                                <img src="{{ asset('backend/image/big-logo.jpg') }}" height="100%" width="100%" alt="">
                            </div>
                        </div>
                        <div class="col-md-6 col-xs-12">
                            <h4><b>Name:</b> <span>A Beautiful Name</span></h4>
                            <p style="margin-bottom:2px !important"><b>Floor:</b> <span>12 floor(Lift-11)</span>
                            </p>
                            <p style="margin-bottom:2px !important"><b>Type:</b> <span>Triple Bed Table (VIP)</span>
                            </p>
                            <p style="margin-bottom:2px !important"><b>Bed:</b> <span>2 Double Bed 1 single
                                    Bed</span>
                            </p>
                            <p style="margin-bottom:2px !important"><b>Bath:</b> <span>2 Attach Bath</span></p>
                            <p style="margin-bottom:2px !important"><b>Price: </b> <span>10 Doller</span></p>
                        </div>
                        <div class="col-md-12 col-xs-12" style="text-align: justify;margin-top:10px">
                            A table is more than just four walls; it's a canvas waiting for life to fill it. Picture
                            a
                            cozy space, where sunlight dances through curtains, casting warm hues upon the walls.
                            The
                            air carries whispers of memories, each piece of furniture holding stories of laughter,
                            comfort, and contemplation.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
    new Vue({
        el: '#booking',
        data() {
            return {
                floorId: '',
                typeId: '',
                booking: {
                    id: '',
                    checkin: moment().format("YYYY-MM-DD"),
                    checkout: moment().format("YYYY-MM-DD"),
                },
                floors: [],
                tabletypes: [],

                tables: [],

                onProgress: false,
            }
        },

        created() {
            this.getFloor();
            this.getTableType();
            this.getTables();
        },

        methods: {
            getFloor() {
                axios.get("/get-floor").then(res => {
                    this.floors = res.data;
                })
            },

            getTableType() {
                axios.get("/get-tabletype").then(res => {
                    this.tabletypes = res.data;
                })
            },

            getTables() {
                let filter = {
                    floorId: this.floorId,
                    tabletypeId: this.typeId,
                    checkin: this.booking.checkin,
                    checkout: this.booking.checkout,
                }
                axios.post("/get-table-list", filter).then(res => {
                    this.tables = res.data;
                })
            },
        },
    })
</script>
@endpush