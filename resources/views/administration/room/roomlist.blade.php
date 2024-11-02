@extends('master')
@section('title', 'Room List')
@section('breadcrumb_title', 'Room List')
@push('style')
<style scoped>
    table>thead>tr>th {
        text-align: center;
    }

    .v-select .dropdown-toggle {
        padding: 0px;
        height: 30px !important;
    }

    .v-select .dropdown-menu {
        width: 100% !important;
    }
</style>
@endpush
@section('content')
<div id="roomList">
    <div class="row" style="margin:0;">
        <fieldset class="scheduler-border bg-of-skyblue">
            <legend class="scheduler-border">Room List Search</legend>
            <div class="control-group">
                <form @submit.prevent="getRoom">
                    <div class="col-md-3 col-xs-12">
                        <div class="form-group" style="display: flex;align-items:center;">
                            <label for="" style="width:150px;">Search Type</label>
                            <select class="form-select no-padding" @change="onChangeSearchType" style="width: 100%;" v-model="searchType">
                                <option value="">All</option>
                                <option value="floor">By Floor</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3 col-xs-12" v-if="searchType == 'floor'" style="display: none;" :style="{display: searchType == 'floor' ? '':'none'}">
                        <div class="form-group">
                            <v-select v-bind:options="floors" id="floor" v-model="selectedFloor" label="name"></v-select>
                        </div>
                    </div>
                    <div class="col-md-3 col-xs-12" v-if="searchType == 'roomtype'" style="display: none;" :style="{display: searchType == 'roomtype' ? '':'none'}">
                        <div class="form-group">
                            <v-select v-bind:options="roomtypes" id="category" v-model="selectedRoomType" label="name"></v-select>
                        </div>
                    </div>
                    <div class="col-md-1 col-xs-12">
                        <div class="form-group">
                            <button :disabled="onProgress" type="submit" class="btn btn-primary" style="padding: 0 6px;">Show Report</button>
                        </div>
                    </div>
                </form>
            </div>
        </fieldset>
    </div>
    <div style="display:none;" v-bind:style="{display: rooms.length > 0 && showReport ? '' : 'none'}">
        <div class="row">
            <div class="col-md-12 text-right">
                <a href="" v-on:click.prevent="print">
                    <i class="fa fa-print"></i> Print
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive" id="reportTable">
                    <table class="table table-bordered table-condensed">
                        <thead>
                            <tr>
                                <th>Sl</th>
                                <th>Room ID</th>
                                <th>Room Name</th>
                                <th>Room Type</th>
                                <th>Floor</th>
                                <th>Bed</th>
                                <th>Bath</th>
                                <th style="text-align: right;">Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(item, sl) in rooms">
                                <td style="text-align:center;">@{{ sl + 1 }}</td>
                                <td>@{{ item.code }}</td>
                                <td style="text-align: left !important;">@{{ item.name }}</td>
                                <td>@{{ item.roomtype_name }}</td>
                                <td>@{{ item.floor_name }}</td>
                                <td>@{{ item.bed }}</td>
                                <td>@{{ item.bath }}</td>
                                <td style="text-align: right;">@{{ item.price }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div style="display:none;" v-bind:style="{display: showReport == false ? '' : 'none'}">
        <div class="row">
            <div class="col-md-12 text-center">
                <img src="{{asset('loading.gif')}}" style="width: 90px;"> Loading..
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
    new Vue({
        el: '#roomList',
        data() {
            return {
                searchType: '',
                rooms: [],

                floors: [],
                selectedFloor: null,

                roomtypes: [],
                selectedRoomType: null,

                onProgress: false,
                showReport: null,
            }
        },

        methods: {
            getFloor() {
                axios.get("/get-floor")
                    .then(res => {
                        this.floors = res.data
                    })
            },
            getRoomType() {
                axios.get("/get-roomtype")
                    .then(res => {
                        this.roomtypes = res.data
                    })
            },
            onChangeSearchType() {
                this.roomtypes = [];
                if (this.searchType == 'floor') {
                    this.getFloor();
                }
                if (this.searchType == 'roomtype') {
                    this.getRoomType();
                }
            },
            getRoom() {
                let filter = {
                    roomtypeId: this.selectedRoomType != null ? this.selectedRoomType.id : '',
                    floorId: this.selectedFloor != null ? this.selectedFloor.id : '',
                }
                this.onProgress = true
                this.showReport = false
                axios.post("/get-room", filter)
                    .then(res => {
                        let r = res.data;
                        this.rooms = r.filter(item => item.status == 'a')
                        this.onProgress = false
                        this.showReport = true
                    })
                    .catch(err => {
                        this.onProgress = false
                        this.showReport = null
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

            async print() {
                let reportContent = `
					<div class="container">
                        <div class="row">
                            <div class="col-xs-12">
                                <h4 style="text-align:center">Room List</h4 style="text-align:center">
                            </div>
                        </div>
					</div>
					<div class="container">
						<div class="row">
							<div class="col-xs-12">
								${document.querySelector('#reportTable').innerHTML}
							</div>
						</div>
					</div>
				`;

                var mywindow = window.open('', '', `width=${screen.width}, height=${screen.height}`);
                mywindow.document.write(`
                    @include('administration/reports/reportHeader')
				`);

                mywindow.document.body.innerHTML += reportContent;

                mywindow.focus();
                await new Promise(resolve => setTimeout(resolve, 1000));
                mywindow.print();
                mywindow.close();
            }
        },
    })
</script>
@endpush