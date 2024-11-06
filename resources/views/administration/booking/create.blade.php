@extends('master')
@section('title', 'Table Booking Entry')
@section('breadcrumb_title', 'Table Booking Entry')
@push('style')
<link rel="stylesheet" href="{{asset('backend')}}/css/booking.css" />
<link rel="stylesheet" href="{{asset('backend')}}/css/fullcalendar.css" />
<style scoped>
    .v-select .dropdown-menu {
        width: 450px !important;
    }

    .booking .control-label {
        padding: 0 !important;
    }

    .v-select .selected-tag {
        margin: 8px 2px !important;
        white-space: nowrap;
        position: absolute;
        left: 0px;
        top: 0;
        line-height: 0px !important;
    }

    .table>tbody>tr>td {
        padding: 5px;
    }

    .membersection {
        overflow-y: auto;
    }

    .membersection::-webkit-scrollbar {
        width: 5px;
    }

    /* Track */
    .membersection::-webkit-scrollbar-track {
        box-shadow: inset 0 0 5px grey;
        border-radius: 5px;
    }

    /* Handle */
    .membersection::-webkit-scrollbar-thumb {
        background: #8726269e;
        border-radius: 5px;
    }
</style>
@endpush

@section('content')
<div class="row" id="booking">
    <div class="col-md-12 col-xs-12">
        <div class="tab-content" style="border: none;">
            <div id="tab1" class="tab-pane fade in active">
                <div class="row" style="border-bottom: 1px solid gray;">
                    <div class="col-md-12 col-xs-12 border-radius" style="display:flex;align-items:center;padding:0 !important;background:#aee2ff;border: 1px groove #848f95 !important;padding:5px 0;">
                        <div class="col-md-3">
                            <div class="date" style="display:flex;align-items:center;gap:5px;">
                                <label for="" style="width: 15%;">From</label>
                                <div style="width: 85%;">
                                    <input type="date" class="form-control" v-model="filter.checkin_date" style="margin:0;height:30px;">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="date" style="display:flex;align-items:center;gap:5px;">
                                <label for="" style="width: 15%;">To</label>
                                <div style="width: 85%;">
                                    <input type="date" class="form-control" v-model="filter.checkout_date" style="margin:0;height:30px;">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="date" style="display:flex;align-items:center;gap:5px;">
                                <label for="" style="width: 20%;">Type</label>
                                <div style="width: 80%;">
                                    <select class="form-control" v-model="filter.typeId" style="border-radius:5px;margin:0;height:30px;">
                                        <option value="">All</option>
                                        <option v-for="tabletype in tabletypes" :value="tabletype.id">@{{tabletype.name}}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="date" style="display:flex;align-items:center;gap:5px;">
                                <label for="" style="width: 30%;">Category</label>
                                <div style="width: 70%;">
                                    <select class="form-control" v-model="filter.categoryId" style="border-radius:5px;margin:0;height:30px;">
                                        <option value="">All</option>
                                        <option v-for="category in categories" :value="category.id">@{{category.name}}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-1 col-xs-12" style="float:right">
                            <button type="button" @click="getTables" style="cursor:pointer;font-size:18px;border:1px groove #848f95;padding:0px 10px;border-radius:5px;background:white;">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                    </div>
                    <div class="col-md-12 col-xs-12" style="margin-top:15px;margin-bottom:15px;padding:0 !important">
                        <div class="check-box" style="display: flex;">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" id="all" value="" name="searchType" v-model="filter.searchType">
                                <label class="form-check-label" for="all">All</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" id="booked" value="booked" name="searchType" v-model="filter.searchType">
                                <label class="form-check-label" for="booked">Booked</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" id="available" value="available" name="searchType" v-model="filter.searchType">
                                <label class="form-check-label" for="available">Available</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" id="checkin" value="checkin" name="searchType" v-model="filter.searchType">
                                <label class="form-check-label" for="checkin">Check-in</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" style="margin-top:10px;padding:0;display:none;" v-if="floors.length > 0 && showReport" :style="{display: floors.length > 0 && showReport ? '' : 'none'}">
                    <div class="col-md-12 col-xs-12" v-for="floor in floors" style="padding:0;" v-if="floor.tables.length > 0">
                        <h3 style="border-bottom: 1px double rgb(232, 97, 0); text-align: left; background: #224079; padding: 5px;">@{{floor.name}}</h3>
                        <form action="">
                            <div class="col-md-12 col-xs-12 about-table" style="padding-left:12px !important;">
                                <div class="row">
                                    <div class="col-md-12 col-xs-12 no-padding" style="display:flex;flex-wrap: wrap;">
                                        <div class="content" v-for="tableItem in floor.tables">
                                            <label :for="'table-'+tableItem.id">
                                                <div class="booking-card" :style="{background: tableItem.color}">
                                                    <div class="card-image text-center">
                                                        <!-- <i class="bi bi-house fa-4x" alt="House Image" style=" color:white;width: 100%; height: 100%; object-fit: cover;"></i> -->
                                                        <div class="overlay">
                                                            <p>@{{tableItem.name}}</p>
                                                        </div>
                                                        <div class="top-right-text">
                                                            <div class="col-xs-6 no-padding" style="text-align: left;">
                                                                <input v-if="tableItem.color == '#aee2ff'" :style="{visibility: tableItem.color == '#aee2ff' ? '' : 'hidden'}" @change="addToCart($event)" type="checkbox" :value="tableItem.id" v-model="tableItem.checkStatus" :id="'table-'+tableItem.id">
                                                            </div>
                                                            <div class="col-xs-6 no-padding" style="display: flex; justify-content: end;">
                                                                <button type="button" class="icon-container" @click="showTableInfo(tableItem.id)">
                                                                    <i class="bi bi-info"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="card-button">@{{tableItem.color == '#aee2ff' ? 'Available' : tableItem.color == '#ff0000ab' ? 'Check In' : 'Booked'}}</div>
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-12 col-xs-12 no-padding">
                        <a v-if="carts.length > 0" data-toggle="tab" href="#tab2">
                            <button type="button" class="btn btn-next" style="float:right; margin-top:10px; background:#BC2649 !important;">
                                Next <i class="bi bi-arrow-right"></i>
                            </button>
                        </a>
                        <a v-else @click="errorMsg">
                            <button type="button" class="btn btn-next" style="float:right; margin-top:10px; background:#BC2649 !important;">
                                Next <i class="bi bi-arrow-right"></i>
                            </button>
                        </a>
                    </div>
                </div>
                <div class="row" style="display:none;" v-bind:style="{display: showReport == false ? '' : 'none'}">
                    <div class="col-md-12 text-center">
                        <img src="{{asset('loading.gif')}}" style="width: 90px;"> Loading..
                    </div>
                </div>
            </div>
            <div id="tab2" class="tab-pane fade">
                <div class="row">
                    <div class="col-md-12 col-xs-12">
                        <div class="row" style="margin:0;">
                            <div class="col-md-12 col-xs-12 bg-of-orange border-radius" style="padding: 5px 0;margin-bottom:10px;background:#93d3f7;">
                                <div class="form-group">
                                    <label for="" class="col-md-1">Invoice:</label>
                                    <div class="col-md-3">
                                        <input type="text" class="form-control" readonly v-model="booking.invoice" style="margin: 0;">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="" class="col-md-1">Date</label>
                                    <div class="col-md-3">
                                        <input type="date" class="form-control" v-model="booking.date" style="margin: 0;">
                                    </div>
                                </div>
                                <div class="form-group text-right">
                                    <label class="col-md-2" for="is_booking"><input type="radio" class="form-check-input" value="booked" v-model="booking.booking_status" id="is_booking"> Is Booking</label>
                                </div>
                                <div class="form-group text-right">
                                    <label class="col-md-2" for="is_checkin"><input type="radio" class="form-check-input" value="checkin" v-model="booking.booking_status" id="is_checkin"> Is CheckIn</label>
                                </div>
                            </div>
                            <div class="col-md-12 col-xs-12 bg-of-orange border-radius " style="padding: 0;">
                                <h5 class="top-radius" style="background:#BC2649;text-align:left;color:white;margin:0;padding:5px;">Guest Information</h5>
                                <div class="info">
                                    <div class="col-md-4" style="padding: 0;margin-bottom:5px">
                                        <div class="form-group">
                                            <label class="control-label col-xs-4 col-md-4">
                                                Guest:</label>
                                            <div class=" col-xs-8 col-md-8">
                                                <v-select :options="customers" v-model="selectedCustomer" @input="customerOnChange" label="display_name"></v-select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-xs-4 col-md-4">
                                                Phone:</label>
                                            <div class=" col-xs-8 col-md-8">
                                                <input type="text" class="form-control" v-model="selectedCustomer.phone" name="phone" autocomplete="off" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4" style="padding: 0;">
                                        <div class="form-group ">
                                            <label class="control-label col-xs-4 col-md-4">
                                                Name:</label>
                                            <div class=" col-xs-8 col-md-8">
                                                <input type="text" class="form-control" v-model="selectedCustomer.name" name="name" autocomplete="off" />
                                            </div>
                                        </div>
                                        <div class="form-group ">
                                            <label class="control-label col-xs-4 col-md-4">
                                                NID No:</label>
                                            <div class=" col-xs-8 col-md-8">
                                                <input type="number" class="form-control" v-model="selectedCustomer.nid" name="nid" autocomplete="off" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4" style="padding: 0;">
                                        <div class="form-group">
                                            <label class="control-label col-xs-4 col-md-4">Address:</label>
                                            <div class="col-xs-8 col-md-8">
                                                <input type="text" class="form-control" v-model="selectedCustomer.address" name="address" autocomplete="off" />
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-xs-4 col-md-4">
                                                Reference:</label>
                                            <div class=" col-xs-8 col-md-8">
                                                <v-select :options="references" v-model="selectedReference" :disabled="selectedCustomer.reference_id != null" label="display_name"></v-select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5 col-xs-12" style="padding: 0 !important;">
                                <div class="cheduler-border bg-of-skyblue border-radius membersection" style="margin-top:10px;height:280px">
                                    <div class="col-xs-12 col-md-6" style="padding: 5px 10px !important;">
                                        <label for="is_other"><input type="checkbox" class="form-check-input" id="is_other" v-model="booking.is_other"> Other Member</label>
                                    </div>
                                    <div v-if="booking.is_other == true" class="col-md-12 col-xs-12 no-padding">
                                        <div class="form-group col-md-6">
                                            <label class="col-xs-4 no-padding-left">Table:</label>
                                            <div class="col-xs-8 no-padding-left">
                                                <v-select :options="carts" v-model="selectedCart" label="name"></v-select>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label class="col-xs-4 no-padding-left"> Name:</label>
                                            <div class="col-xs-8 no-padding">
                                                <input type="text" class="form-control" v-model="selectedOtherCustomer.name" />
                                            </div>
                                        </div>
                                    </div>
                                    <div v-if="booking.is_other == true" class="col-md-12 col-xs-12 no-padding">
                                        <div class="form-group col-md-6">
                                            <label class="col-xs-4 no-padding-left"> NID:</label>
                                            <div class="col-xs-8 no-padding-left">
                                                <input type="number" class="form-control" v-model="selectedOtherCustomer.nid" />
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label class="col-xs-4 no-padding-left"> Gender:</label>
                                            <div class="col-xs-6 no-padding">
                                                <select class="form-control" style="width: 100%;" v-model="selectedOtherCustomer.gender">
                                                    <option value="">Select</option>
                                                    <option value="male">Male</option>
                                                    <option value="female">Female</option>
                                                    <option value="other">Other</option>
                                                </select>
                                            </div>
                                            <div class="col-xs-2 no-padding">
                                                <button type="button" @click="otherAddToCart" style="width: 90%;margin-left: 2px;border: none;height: 24px;border-radius: 3px;outline: none;background: #df3737; color: #fff;">Add</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div v-if="booking.is_other == true" class="col-md-12 col-xs-12">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Sl</th>
                                                    <th>Table</th>
                                                    <th>Name</th>
                                                    <th>NID</th>
                                                    <th>Gender</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="(item, sl) in members">
                                                    <td>@{{sl + 1}}</td>
                                                    <td>@{{item.table_name}}</td>
                                                    <td style="text-align: left;">@{{item.name}}</td>
                                                    <td>@{{item.nid}}</td>
                                                    <td>@{{item.gender}}</td>
                                                    <td>
                                                        <i @click="removeOtherCart(sl)" class="fa fa-times btn btn-xs btn-danger" style="padding:1px !important; border-radius:3px;font-size:8px;">
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-7 col-xs-12" style="padding:10px 0px 10px 10px !important;">
                                <h5 class="top-radius" style="background:#146C94;text-align:left;color:white;margin:0;padding:5px; ">
                                    Table Booking List</h5>
                                <div class="control-group bg-of-yellow border-radius membersection" style="height:252px !important;">
                                    <table class="table" style="padding:5px;">
                                        <thead>
                                            <tr style="background:white;color:black;border:1px solid #D5D5D5">
                                                <th>Sl</th>
                                                <th>CheckIn</th>
                                                <th>CheckOut</th>
                                                <th>Table</th>
                                                <th>Type</th>
                                                <th>Category</th>
                                                <th>Days</th>
                                                <th>Fare</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <template v-for="(item, sl) in carts">
                                                <tr>
                                                    <td>@{{sl + 1}}</td>
                                                    <td>
                                                        <input type="date" style="width:120px;padding: 2px 5px;" @change="editCart(item)" v-model="item.checkin_date">
                                                    </td>
                                                    <td>
                                                        <input type="date" style="width:120px;padding: 2px 5px;" @change="editCart(item)" v-model="item.checkout_date">
                                                    </td>
                                                    <td>@{{item.name}}</td>
                                                    <td>@{{item.typeName}}</td>
                                                    <td>@{{item.categoryName}}</td>
                                                    <td>@{{item.days}}</td>
                                                    <td>
                                                        <input type="number" style="padding: 2px 5px;" class="form-control" step="any" min="0" v-model="item.unit_price" @input="editCart(item)" />
                                                    </td>
                                                    <td class="">
                                                        <button type="button" class="icon-container" @click="showTableInfo(item.table_id)">
                                                            <i class="bi bi-info"></i>
                                                        </button>
                                                        <!-- <i class="fa fa-times btn btn-xs btn-danger" style="padding:1px !important; border-radius:3px;font-size: 8px;"> -->
                                                    </td>
                                                </tr>
                                            </template>
                                            <tr style="top: 0; width: 100%;">
                                                <td>
                                                    <label for="note">Note</label>
                                                </td>
                                                <td colspan="8">
                                                    <div class="form-group">
                                                        <textarea name="note" class="form-control" id="note" cols="1" rows="2" v-model="booking.note" placeholder="Enter booking note"></textarea>
                                                    </div>
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
                                                <input type="number" class="form-control" name="subtotal" v-model="booking.subtotal" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group ">
                                            <label class="control-label col-xs-4 col-md-4">
                                                Discount:</label>
                                            <div class=" col-xs-8 col-md-3">
                                                <input type="number" class="form-control" id="discount" name="discount" v-model="booking.discount" @input="calculateTotal">
                                            </div>
                                            <label class="control-label col-xs-4 col-md-1" style="padding:0 !important">
                                                %</label>
                                            <div class=" col-xs-8 col-md-4 no-padding-left">
                                                <input type="number" class="form-control" id="discountAmount" name="discountAmount" v-model="booking.discountAmount" @input="calculateTotal">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3" style="padding: 0;margin-bottom:5px">
                                        <div class="form-group">
                                            <label class="control-label col-xs-4 col-md-3">
                                                Total:</label>
                                            <div class=" col-xs-8 col-md-9">
                                                <input type="number" class="form-control" name="total" v-model="booking.total" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group ">
                                            <label class="control-label col-xs-4 col-md-3">
                                                Vat:</label>
                                            <div class=" col-xs-8 col-md-4">
                                                <input type="number" class="form-control" name="vat" v-model="booking.vat">
                                            </div>
                                            <label class="control-label col-xs-4 col-md-1" style="padding:0 !important">
                                                %</label>
                                            <div class=" col-xs-8 col-md-4 no-padding-left">
                                                <input type="number" class="form-control" name="vatAmount" v-model="booking.vatAmount">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3" style="padding: 0;margin-bottom:5px">
                                        <div class="form-group ">
                                            <label class="control-label col-xs-4 col-md-4">
                                                Payment:</label>
                                            <div class=" col-xs-8 col-md-8">
                                                <input type="number" class="form-control" name="advance" @input="calculateTotal" v-model="booking.advance">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-xs-4 col-md-4">
                                                Due:</label>
                                            <div class=" col-xs-8 col-md-8">
                                                <input type="number" class="form-control" name="due" v-model="booking.due" readonly>
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
                                                <input type="button" @click="saveBooking" class="btn btn-primary btn-padding" value="Submit" style="font-size:11px;padding:0px 41px !important">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
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
                    <h3 class="modal-title" style="text-align:left;font-weight:bold;color:#000;">Table: @{{tableInfo.name}}</h3>
                </div>
                <div class="modal-body" style="margin-bottom:15px">
                    <div class="row" style="margin: 10px;  box-shadow: 0px 2px 5px 0px #c2bfbf;border-radius:10px;padding-top:10px;padding-bottom:15px">
                        <div class="col-md-12 col-xs-12" style="text-align: justify;margin-top:10px">
                            <div id="calendar"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script src="{{asset('backend')}}/js/fullcalendar.min.js"></script>
<script>
    new Vue({
        el: '#booking',
        data() {
            return {
                filter: {
                    floorId: '',
                    typeId: '',
                    categoryId: '',
                    searchType: '',
                    checkin_date: moment().format("YYYY-MM-DD"),
                    checkout_date: moment().add(1, 'days').format("YYYY-MM-DD"),
                },
                booking: {
                    id: parseInt('{{$id}}'),
                    invoice: "{{invoiceGenerate('Booking_Master', '')}}",
                    date: moment().format('YYYY-MM-DD'),
                    customer_id: '',
                    reference_id: '',
                    subtotal: 0,
                    discount: 0,
                    discountAmount: 0,
                    vat: 0,
                    vatAmount: 0,
                    total: 0,
                    advance: 0,
                    due: 0,
                    is_other: false,
                    booking_status: 'booked',
                    note: ''
                },
                floors: [],
                tabletypes: [],
                categories: [],
                customers: [],
                selectedCustomer: {
                    id: "",
                    name: "",
                    display_name: "",
                    nid: "",
                },
                selectedOtherCustomer: {
                    name: "",
                    nid: "",
                    gender: "",
                },

                references: [],
                selectedReference: {
                    id: "",
                    name: "",
                    display_name: "",
                },

                carts: [],
                selectedCart: null,
                members: [],

                tableInfo: {},
                onProgress: false,
                showReport: null,
            }
        },

        created() {
            this.getTableType();
            this.getCategory();
            this.getCustomer();
            this.getReference();
            this.getTables();
            if (this.booking.id > 0) {
                $("#tab1").removeClass('in active')
                $("#tab2").addClass('in active')
                this.getBooking();
            }
        },

        methods: {
            getCustomer() {
                axios.get("/get-customer")
                    .then(res => {
                        this.customers = res.data.map(item => {
                            item.display_name = `${item.name} - ${item.phone}`;
                            return item;
                        });
                        this.customers.unshift({
                            id: '',
                            name: '',
                            email: '',
                            phone: '',
                            nid: '',
                            address: '',
                            display_name: 'New Guest'
                        });
                    })
            },

            customerOnChange() {
                this.selectedReference = {
                    id: '',
                    name: '',
                    display_name: ''
                }
                if (this.selectedCustomer.id == '' && this.selectedCustomer.reference_id == null) {
                    return;
                }
                this.selectedReference = {
                    id: this.selectedCustomer.reference_id,
                    name: this.selectedCustomer.reference.name,
                    display_name: `${this.selectedCustomer.reference.code} - ${this.selectedCustomer.reference.name}`
                }
            },

            getCategory() {
                axios.get("/get-category")
                    .then(res => {
                        this.categories = res.data;
                    })
            },

            getReference() {
                axios.get('/get-reference').then(res => {
                    this.references = res.data.map(item => {
                        item.display_name = `${item.code} - ${item.name}`;
                        return item;
                    });
                })
            },

            getTableType() {
                axios.get("/get-tabletype").then(res => {
                    this.tabletypes = res.data;
                })
            },

            getTables() {
                this.carts = [];
                this.showReport = false;
                axios.post("/get-table-list", this.filter).then(res => {
                    this.floors = res.data.map(floor => {
                        floor.tables = floor.tables.map(item => {
                            item.checkStatus = false;
                            return item;
                        })
                        if (this.filter.searchType == 'booked') {
                            floor.tables = floor.tables.filter(item => item.booked == 'true');
                        } else if (this.filter.searchType == 'checkin') {
                            floor.tables = floor.tables.filter(item => item.checkin == 'true');
                        } else if (this.filter.searchType == 'available') {
                            floor.tables = floor.tables.filter(item => item.available == 'true');
                        }
                        return floor;
                    });
                    this.showReport = true;
                })
            },

            async addToCart(event) {
                if (event.target.checked) {
                    let avaiable = await axios.post('/get-available-table', {
                            id: event.target.value,
                            checkin_date: this.filter.checkin_date,
                            checkout_date: this.filter.checkout_date,
                        })
                        .then(res => {
                            return res.data;
                        })

                    if (avaiable.status == false) {
                        event.target.checked = false;
                        toastr.error(`This table not available on this date: ${avaiable.date}`);
                        return;
                    }

                    let table = await axios.post('/get-table', {
                            tableId: event.target.value
                        })
                        .then(res => {
                            return res.data[0];
                        })
                    let checkTime = moment(this.filter.checkin_date).format("HH:mm:ss")
                    if (checkTime > "12:00:00") {
                        this.filter.checkin_date = moment(this.filter.checkin_date).format("YYYY-MM-DD") + " 12:00:00";
                    }
                    let checkin_date = moment(this.filter.checkin_date);
                    let checkout_date = moment(this.filter.checkout_date);
                    let totalDays = checkout_date.diff(checkin_date, 'days');
                    let cart = {
                        table_id: table.id,
                        name: table.name,
                        typeName: table.tabletype_name,
                        categoryName: table.category_name,
                        days: totalDays,
                        unit_price: parseFloat(table.price).toFixed(2),
                        total: parseFloat(table.price * totalDays).toFixed(2),
                        checkin_date: moment(this.filter.checkin_date).format('YYYY-MM-DD'),
                        checkout_date: moment(this.filter.checkout_date).format('YYYY-MM-DD'),
                    }
                    this.carts.push(cart);
                } else {
                    let findIndex = this.carts.findIndex(item => item.table_id == event.target.value);
                    this.carts.splice(findIndex, 1);
                }

                this.calculateTotal();
            },

            async editCart(item) {
                let today = moment().format("YYYY-MM-DD");
                if (this.booking.id == 0 && today > item.checkin_date) {
                    toastr.error('Checkin date less then today.!');
                    item.checkin_date = today;
                    return;
                }
                let filter = {
                    id: item.table_id,
                    checkin_date: item.checkin_date,
                    checkout_date: item.checkout_date
                }
                if (this.booking.id > 0) {
                    filter.booking_id = this.booking.id;
                }
                let avaiable = await axios.post('/get-available-table', filter)
                    .then(res => {
                        return res.data;
                    })

                if (avaiable.status == false) {
                    toastr.error(`This table not available on this date: ${avaiable.date}`);
                    setTimeout(() => {
                        location.reload();
                    }, 1500);
                    return;
                }
                let checkTime = moment(item.checkin_date).format("HH:mm:ss")
                if (checkTime > "12:00:00") {
                    item.checkin_date = moment(item.checkin_date).format("YYYY-MM-DD") + " 12:00:00";
                }
                let checkin_date = moment(item.checkin_date);
                let checkout_date = moment(item.checkout_date).format("YYYY-MM-DD") + " 12:00:00";
                checkout_date = moment(checkout_date);
                let totalDays = checkout_date.diff(checkin_date, 'days');

                item.days = totalDays;
                item.total = totalDays * item.unit_price;
                this.calculateTotal();
            },

            calculateTotal() {
                this.booking.subtotal = this.carts.reduce((prev, curr) => {
                    return prev + parseFloat(curr.total)
                }, 0).toFixed(2);

                if (event.target.id == 'discount') {
                    this.booking.discountAmount = parseFloat((parseFloat(this.booking.subtotal) * parseFloat(this.booking.discount)) / 100).toFixed(2);
                }
                if (event.target.id == 'discountAmount') {
                    this.booking.discount = parseFloat((parseFloat(this.booking.discountAmount) * 100) / parseFloat(this.booking.subtotal)).toFixed(2);
                }
                this.booking.total = parseFloat(parseFloat(this.booking.subtotal) - parseFloat(this.booking.discountAmount)).toFixed(2);
                this.booking.due = parseFloat(this.booking.total - this.booking.advance).toFixed(2)
            },

            otherAddToCart() {
                if (this.selectedCart == null) {
                    toastr.error("Table name is required");
                    return
                }
                if (this.selectedOtherCustomer.name == '') {
                    toastr.error("Name is required");
                    return
                }
                let member = {
                    table_id: this.selectedCart.table_id,
                    table_name: this.selectedCart.name,
                    name: this.selectedOtherCustomer.name,
                    nid: this.selectedOtherCustomer.nid,
                    gender: this.selectedOtherCustomer.gender,
                };
                this.members.push(member);
                this.clearOtherCustomer();
            },

            removeOtherCart(sl) {
                this.members.splice(sl, 1);
            },

            clearOtherCustomer() {
                this.selectedOtherCustomer = {
                    name: '',
                    nid: '',
                    gender: '',
                }
            },

            saveBooking() {
                let filter = {
                    booking: this.booking,
                    carts: this.carts,
                }
                if (this.booking.is_other == true) {
                    filter.members = this.members;
                }
                if (this.selectedCustomer.display_name == 'New Guest') {
                    filter.customer = this.selectedCustomer;
                    filter.customer.reference_id = this.selectedReference.id != '' ? this.selectedReference.id : null;
                } else {
                    this.booking.customer_id = this.selectedCustomer.id;
                }
                if (this.selectedReference.id != '') {
                    this.booking.reference_id = this.selectedReference.id;
                }

                var url = "/save-booking"
                if (this.booking.id > 0) {
                    url = "/update-booking"
                }

                if (confirm("Are you sure!!") == false) {
                    return;
                }

                axios.post(url, filter)
                    .then(res => {
                        toastr.success(res.data.message);
                        setTimeout(() => {
                            location.reload();
                        }, 500)
                    })
                    .catch(err => {
                        this.onProgress = false
                        var r = JSON.parse(err.request.response);
                        if (err.request.status == '422' && r.errors != undefined && typeof r.errors == 'object') {
                            $.each(r.errors, (index, value) => {
                                $.each(value, (ind, val) => {
                                    toastr.error(val)
                                })
                            })
                        } else {
                            if (r.errors != undefined) {
                                console.log(r.errors);
                            }
                            toastr.error(r.message);
                        }
                    })
            },

            async showTableInfo(id) {
                let tableInfo = await axios.post('/get-table', {
                        tableId: id
                    })
                    .then(res => {
                        return res.data[0];
                    })
                setTimeout(() => {
                    this.tableCalendar(id);
                }, 500)
                this.tableInfo = tableInfo;
                $("#myModal").modal("show");
            },

            errorMsg() {
                toastr.error("Cart is empty");
            },

            getBooking() {
                axios.post("/get-booking", {
                        id: this.booking.id
                    })
                    .then(res => {
                        let booking = res.data[0];
                        let keys = Object.keys(this.booking);
                        keys.forEach(key => {
                            this.booking[key] = booking[key];
                        });
                        this.booking.is_other = booking.is_other == 'true' ? true : false;
                        this.booking.booking_status = booking.booking_details[0].booking_status

                        this.selectedCustomer = {
                            id: booking.customer_id,
                            name: booking.customer_name,
                            phone: booking.customer_phone,
                            nid: booking.customer_nid,
                            address: booking.customer_address,
                            display_name: `${booking.customer_name} - ${booking.customer_phone}`
                        }

                        if (booking.reference_id != null) {
                            this.selectedReference = {
                                id: booking.reference_id,
                                name: booking.reference_name,
                                display_name: `${booking.reference_code} - ${booking.reference_name}`
                            }
                        }

                        this.members = booking.othercustomer;
                        booking.booking_details.forEach(item => {
                            let detail = {
                                table_id: item.table_id,
                                name: item.table_name,
                                typeName: item.type_name,
                                categoryName: item.category_name,
                                days: item.days,
                                unit_price: parseFloat(item.unit_price).toFixed(2),
                                total: parseFloat(item.unit_price * item.days).toFixed(2),
                                checkin_date: moment(item.checkin_date).format('YYYY-MM-DD'),
                                checkout_date: moment(item.checkout_date).format('YYYY-MM-DD'),
                            }
                            this.carts.push(detail);
                        })
                        this.calculateTotal();
                    })
            },

            tableCalendar(tableId) {
                $.ajax({
                    url: "/get-tablecalendar",
                    method: 'post',
                    data: {
                        tableId: tableId
                    },
                    success: res => {
                        $('#calendar').fullCalendar('destroy');
                        $('#calendar').fullCalendar({
                            height: 150,
                            contentHeight: 150,
                            left: 'title',
                            center: '',
                            right: 'prev,next',
                            events: res
                        });
                    }
                })
            }
        },
    })
</script>
@endpush