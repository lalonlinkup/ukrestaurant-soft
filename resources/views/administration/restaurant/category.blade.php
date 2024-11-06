@extends('master')
@section('title', 'Menu Category Entry')
@section('breadcrumb_title', 'Menu Category Entry')
@push('style')
<style>
    .category{
        padding: 0;
    }
</style>
<style>
    .v-select .selected-tag {
        margin: 8px 2px !important;
    }

    .slider {
        padding-left: 0;
    }

    .sliderImage {
        padding-right: 0;
    }

    @media (min-width: 320px) and (max-width: 620px) {
        .slider {
            padding: 0;
        }

        .sliderImage {
            padding: 0;
        }
    }

    .ImageBackground .imageShow {
        display: block;
        height: 75px;
        width: 85px;
        border: 1px solid #cccccc;
        box-sizing: border-box;
        margin-bottom: 5px;
    }
</style>
@endpush
@section('content')
<div id="Category">
    <form @submit.prevent="saveCategory">
        <div class="row" style="margin: 0;">
            <div class="col-md-10 category">
                <fieldset class="scheduler-border bg-of-skyblue">
                    <legend class="scheduler-border">Menu Category Entry Form</legend>
                    <div class="form-group clearfix">
                        <label class="control-label col-md-2">Menu Category:</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" name="name" v-model="category.name" autocomplete="off"/>
                        </div>
                        <div class="col-md-4 text-right">
                            @if(userAction('e'))
                            <input type="button" class="btn btn-danger btn-reset" value="Reset" @click="clearForm">
                            <button :disabled="onProgress" type="submit" class="btn btn-primary btn-padding" v-html="btnText"></button>
                            @endif
                        </div>
                    </div>
                </fieldset>
            </div>
            <div class="col-md-2 sliderImage">
                <fieldset class="scheduler-border bg-of-skyblue" style="height: 155px;">
                    <legend class="scheduler-border">Image Upload</legend>
                    <div class="control-group">
                        <div class="form-group ImageBackground clearfix">
                            <span class="text-danger">(24 X 24) PX</span>
                            <img :src="imageSrc" class="imageShow" />
                            <label for="image">Upload Image</label>
                            <input type="file" id="image" class="form-control shadow-none" @change="imageUrl" />
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
    </form>

    <div class="row">
        <div class="col-sm-12 form-inline">
            <div class="form-group">
                <label for="filter" class="sr-only">Filter</label>
                <input type="text" class="form-control" v-model="filter" placeholder="Filter">
            </div>
        </div>
        <div class="col-md-12">
            <div class="table-responsive">
                <datatable :columns="columns" :data="categories" :filter-by="filter" style="margin-bottom: 5px;">
                    <template scope="{ row }">
                        <tr>
                            <td>@{{ row.sl }}</td>
                            <td>
                                <img :src="`/${row.image ? row.image : 'noImage.gif'}`" style="width: 24px; border: 1px solid gray; border-radius: 4px; padding: 1px;">
                            </td>
                            <td>@{{ row.name }}</td>
                            <td>
                                @if(userAction('u'))
                                <i @click="editData(row)" class="fa fa-pencil"></i>
                                @endif
                                @if(userAction('d'))
                                <i @click="deleteData(row.id)" class="fa fa-trash"></i>
                                @endif
                            </td>
                        </tr>
                    </template>
                </datatable>
                <datatable-pager v-model="page" type="abbreviated" :per-page="per_page" style="margin-bottom: 50px;"></datatable-pager>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
    new Vue({
        el: '#Category',
        data() {
            return {
                columns: [{
                        label: 'Sl',
                        field: 'sl',
                        align: 'center',
                        filterable: false
                    },
                    {
                        label: 'Category Image',
                        field: 'image',
                        align: 'center'
                    },
                    {
                        label: 'Category Name',
                        field: 'name',
                        align: 'center'
                    },
                    {
                        label: 'Action',
                        align: 'center',
                        filterable: false
                    }
                ],
                page: 1,
                per_page: 20,
                filter: '',

                category: {
                    id: "",
                    name: "",
                    image: "",
                },
                categories: [],

                imageSrc: "/noImage.gif",

                onProgress: false,
                btnText: "Save"
            }
        },

        created() {
            this.getCategory();
        },

        methods: {
            getCategory() {
                axios.get("/get-menu-category")
                    .then(res => {
                        this.categories = res.data.map((item, index) => {
                            item.sl = index + 1
                            return item;
                        });
                    })
            },

            saveCategory(event) {
                let formdata = new FormData(event.target)
                formdata.append('id', this.category.id);
                formdata.append('image', this.category.image);

                var url;
                if (this.category.id == '') {
                    url = '/menu-category';
                } else {
                    url = '/update-menu-category';
                }
                this.onProgress = true
                axios.post(url, formdata)
                    .then(res => {
                        toastr.success(res.data.message);
                        this.getCategory();
                        this.clearForm();
                        this.btnText = "Save";
                        this.onProgress = false
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

            editData(row) {
                this.btnText = "Update";
                let keys = Object.keys(this.category);
                keys.forEach(key => {
                    this.category[key] = row[key];
                });
                this.imageSrc = row.image != null ? "/" + row.image : "/noImage.gif";
            },

            async deleteData(rowId) {
                let tableCheck = await axios.post("/get-menu", {
                        categoryId: rowId
                    })
                    .then(res => {
                        return res.data
                    })
                if (tableCheck.length > 0) {
                    toastr.error("Menu found on this Category, You can not delete");
                    return
                }
                let formdata = {
                    id: rowId
                }
                if (confirm("Are you sure !!")) {
                    axios.post("/delete-menu-category", formdata)
                        .then(res => {
                            toastr.success(res.data.message)
                            this.getCategory();
                        })
                        .catch(err => {
                            var r = JSON.parse(err.request.response);
                            if (r.errors != undefined) {
                                console.log(r.errors);
                            }
                            toastr.error(r.message);
                        })
                }
            },

            clearForm() {
                this.category = {
                    id: "",
                    name: "",
                    image: "",
                },
                this.imageSrc = "/noImage.gif"
            },

            imageUrl(event) {
                const WIDTH = 24;
                const HEIGHT = 24;
                const allowedMimes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif', 'image/svg+xml'];

                if (event.target.files[0]) {
                    const file = event.target.files[0];

                    // Check if file type is allowed
                    if (!allowedMimes.includes(file.type)) {
                        toastr.error('Invalid file type. Please select an image with one of the following types: jpeg, png, jpg, gif, svg.');
                        event.target.value = '';
                        return;
                    }

                    let reader = new FileReader();
                    reader.readAsDataURL(file);
                    reader.onload = (ev) => {
                        let img = new Image();
                        img.src = ev.target.result;
                        img.onload = () => {
                            // Check if the image dimensions are exactly 24x24
                            if (img.width === WIDTH && img.height === HEIGHT) {
                                // If dimensions are correct, proceed with the original image
                                this.category.image = file;
                                this.imageSrc = ev.target.result;  // Optionally set image preview
                            } else {
                                toastr.error(`Image dimensions must be ${WIDTH}x${HEIGHT} pixels.`);
                                event.target.value = '';
                            }
                        }
                    }
                } else {
                    event.target.value = '';
                }
            }

        },
    })
</script>
@endpush