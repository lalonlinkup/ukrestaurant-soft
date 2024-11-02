@extends('master')
@section('title', 'Employee Entry')
@section('breadcrumb_title', 'Employee Entry')
@section('content')
<div id="Employee">
    <form @submit.prevent="saveEmployee">
        <div class="row">
            <!-- PAGE CONTENT BEGINS -->
            <div class="form-horizontal">
                <br />
                <div class="col-sm-6">
                    <div class="col-sm-12 align-center"> <strong>Job Information</strong></div>
                    <hr />
                    <div class="form-group">
                        <label class="col-sm-4 control-label" for="employeer_code"> Employee ID </label>
                        <label class="col-sm-1 control-label">:</label>
                        <div class="col-sm-2">
                            <input type="text" name="code" v-model="employee.code" id="employeer_code" class="form-control" readonly />
                        </div>

                        <label class="col-sm-2 control-label" for="bio_id"> Bio ID: </label>
                        <div class="col-sm-2">
                            <input type="text" id="bio_id" name="bio_id" v-model="employee.bio_id" class="form-control" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-4 control-label" for="em_name"> Employee Name </label>
                        <label class="col-sm-1 control-label">:</label>
                        <div class="col-sm-6">
                            <input type="text" id="em_name" name="name" v-model="employee.name" placeholder="Enter Name" class="form-control" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-4 control-label" for="em_Designation"> Designation </label>
                        <label class="col-sm-1 control-label">:</label>
                        <div class="col-sm-6">
                            <v-select :options="designations" v-model="selectedDesignation" label="name"></v-select>
                        </div>
                        <div class="col-sm-1" style="padding: 0;">
                            <button type="button" @click="openModal(false)" class="btn btn-xs btn-danger" style="height: 25px; border: 0; width: 27px; margin-left: -10px;"><i class="fa fa-plus" aria-hidden="true" style="margin-top: 5px;"></i></a>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-4 control-label" for="em_Depertment"> Department </label>
                        <label class="col-sm-1 control-label">:</label>
                        <div class="col-sm-6">
                            <v-select :options="departments" v-model="selectedDepartment" label="name"></v-select>
                        </div>
                        <div class="col-sm-1" style="padding: 0;">
                            <button type="button" @click="openModal(true)" class="btn btn-xs btn-danger" style="height: 25px; border: 0; width: 27px; margin-left: -10px;"><i class="fa fa-plus" aria-hidden="true" style="margin-top: 5px;"></i></button>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-4 control-label" for="em_joining">Join Date</label>
                        <label class="col-sm-1 control-label">:</label>
                        <div class="col-sm-6">
                            <input type="date" class="form-control" id="em_joining" name="joining" v-model="employee.joining" />
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="col-sm-4 control-label" for="salary_range">Salary Range</label>
                        <label class="col-sm-1 control-label">:</label>
                        <div class="col-sm-6">
                            <input type="number" min="0" step="0.001" id="salary_range" name="salary" v-model="employee.salary" placeholder="Salary Range" class="form-control" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-4 control-label" for="form-field-1"> Activation Status</label>
                        <label class="col-sm-1 control-label">:</label>
                        <div class="col-sm-6">
                            <select class="chosen-select form-control" name="status" v-model="employee.status" id="status">
                                <option value="">Choose a status...</option>
                                <option value="a"> Active </option>
                                <option value="p"> Deactive </option>
                            </select>
                        </div>
                    </div>
                </div>


                <div class="col-sm-6">
                    <div class="col-sm-12 align-center"> <strong>Contact Information</strong></div>

                    <hr />
                    <div class="form-group">
                        <label class="col-sm-4 control-label" for="em_present_address"> Present Address </label>
                        <label class="col-sm-1 control-label">:</label>
                        <div class="col-sm-6">
                            <input type="text" id="em_present_address" name="present_address" v-model="employee.present_address" placeholder="Present Address" class="form-control" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-4 control-label" for="em_permanent_address"> Permanent Address </label>
                        <label class="col-sm-1 control-label">:</label>
                        <div class="col-sm-6">
                            <input type="text" id="em_permanent_address" name="permanent_address" v-model="employee.permanent_address" placeholder="Present Address" class="form-control" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-4 control-label" for="em_contact"> Contact No </label>
                        <label class="col-sm-1 control-label">:</label>
                        <div class="col-sm-6">
                            <input type="text" id="em_contact" name="phone" v-model="employee.phone" placeholder="Contact No" class="form-control" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-4 control-label" for="ec_email"> E-mail </label>
                        <label class="col-sm-1 control-label">:</label>
                        <div class="col-sm-6">
                            <input type="text" id="ec_email" name="email" v-model="employee.email" placeholder="E-mail" class="form-control" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-4 control-label" for="em_reference"> Reference </label>
                        <label class="col-sm-1 control-label">:</label>
                        <div class="col-sm-6">
                            <input type="text" id="em_reference" name="reference" class="form-control" v-model="employee.reference" placeholder="Reference" />
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="row">
            <div class="form-horizontal">
                <br />
                <div class="col-sm-6">
                    <div class="col-sm-12 align-center"> <strong>Personal Information</strong></div>
                    <hr />
                    <div class="form-group">
                        <label class="col-sm-4 control-label" for="em_father"> Father's Name </label>
                        <label class="col-sm-1 control-label">:</label>
                        <div class="col-sm-6">
                            <input type="text" id="em_father" name="father_name" v-model="employee.father_name" placeholder="Father's Name" class="form-control" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-4 control-label" for="mother_name"> Mother's Name </label>
                        <label class="col-sm-1 control-label">:</label>
                        <div class="col-sm-6">
                            <input type="text" id="mother_name" name="mother_name" v-model="employee.mother_name" placeholder="Mother's Name" class="form-control" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-4 control-label" for="gender"> Gender </label>
                        <label class="col-sm-1 control-label">:</label>
                        <div class="col-sm-6">
                            <select class="chosen-select form-control" id="gender" name="gender" v-model="employee.gender">
                                <option value="">Choose a Gender...</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-4 control-label" for="em_dob">Date of Birth</label>
                        <label class="col-sm-1 control-label">:</label>
                        <div class="col-sm-6">
                            <input type="date" id="em_dob" class="form-control" name="dob" v-model="employee.dob" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-4 control-label" for="marital"> Marital Status </label>
                        <label class="col-sm-1 control-label">:</label>
                        <div class="col-sm-6">
                            <select class="chosen-select form-control" name="marital_status" v-model="employee.marital_status" id="marital">
                                <option value="">Choose Marital Status...</option>
                                <option value="married">Married</option>
                                <option value="unmarried">Unmarried</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="form-group ImageBackground clearfix">
                        <span class="text-danger">(150 X 150)PX</span>
                        <img :src="imageSrc" class="imageShow" />
                        <label for="image">Upload Image</label>
                        <input type="file" id="image" class="form-control shadow-none" @change="imageUrl" />
                    </div>
                    <hr style="margin: 7px 0px">
                    @if(userAction('e') || userAction('u'))
                    <div class="form-group text-right">
                        <div class="col-sm-12">
                            <button type="button" @click="clearForm" class="btn btn-danger btn-reset">Reset</button>
                            <button :disabled="onProgress" type="submit" class="btn btn-primary btn-padding" v-html="btnText"></button>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </form>
    @include('administration.settings.modal.common')
</div>
@endsection

@push('script')
<script>
    var employee = new Vue({
        el: "#Employee",

        data() {
            return {
                employee: {
                    id: "{{ $id }}",
                    code: "{{ $code }}",
                    name: '',
                    designation_id: null,
                    department_id: null,
                    bio_id: '',
                    joining: '',
                    status: 'a',
                    gender: '',
                    dob: '',
                    nid_no: '',
                    phone: '',
                    email: '',
                    marital_status: '',
                    father_name: '',
                    mother_name: '',
                    present_address: '',
                    permanent_address: '',
                    image: '',
                    salary: '',
                    reference: ''
                },

                designations: [],
                selectedDesignation: {
                    id: null,
                    name: 'select designation'
                },

                departments: [],
                selectedDepartment: {
                    id: null,
                    name: 'select department'
                },

                imageSrc: "/noImage.gif",
                onProgress: false,
                btnText: "Save",

                is_department: false,
                modalHead: "",
                modalData: {
                    id: null,
                    name: ''
                }
            }
        },

        created() {
            this.getDesignation();
            this.getDepartment();
            if (this.employee.id != 0) {
                this.getEmployee();
            }
        },

        methods: {
            getDesignation() {
                axios.get("/get-designation")
                    .then(res => {
                        this.designations = res.data;
                    })
            },

            getDepartment() {
                axios.get("/get-department")
                    .then(res => {
                        this.departments = res.data;
                    })
            },

            saveEmployee(event) {
                let formdata = new FormData(event.target)
                formdata.append('id', this.employee.id);
                formdata.append('designation_id', this.selectedDesignation.id != null ? this.selectedDesignation.id : '');
                formdata.append('department_id', this.selectedDepartment.id != null ? this.selectedDepartment.id : '');
                formdata.append('image', this.employee.image);

                var url = '/add-employee';
                if (this.employee.id != 0) {
                    url = '/update-employee';
                }

                this.onProgress = true
                axios.post(url, formdata)
                    .then(res => {
                        toastr.success(res.data.message);
                        if (this.employee.id != 0) {
                            setTimeout(() => {
                                location.href = '/employee';
                            }, 1000)
                        }
                        this.clearForm();
                        this.employee.code = res.data.code;
                        this.btnText = "Save";
                        this.onProgress = false
                    })
                    .catch(err => {
                        this.onProgress = false
                        var r = JSON.parse(err.request.response);
                        if (r.errors) {
                            $.each(r.errors, (index, value) => {
                                $.each(value, (ind, val) => {
                                    toastr.error(val)
                                })
                            })
                        } else {
                            toastr.error(r.message);
                        }
                    })
            },

            clearForm() {
                this.employee = {
                    id: "{{ $id }}",
                    code: '{{ $code }}',
                    name: '',
                    designation_id: null,
                    department_id: null,
                    bio_id: '',
                    joining: '',
                    status: 'a',
                    gender: '',
                    dob: '',
                    nid_no: '',
                    phone: '',
                    email: '',
                    marital_status: '',
                    father_name: '',
                    mother_name: '',
                    present_address: '',
                    permanent_address: '',
                    image: '',
                    salary: '',
                    reference: ''
                }
                this.imageSrc = "/noImage.gif"
                this.selectedDesignation = {
                    id: null,
                    name: 'select designation'
                }
                this.selectedDepartment = {
                    id: null,
                    name: 'select department'
                }
            },

            imageUrl(event) {
                const WIDTH = 150;
                const HEIGHT = 150;
                if (event.target.files[0]) {
                    let reader = new FileReader();
                    reader.readAsDataURL(event.target.files[0]);
                    reader.onload = (ev) => {
                        let img = new Image();
                        img.src = ev.target.result;
                        img.onload = async e => {
                            let canvas = document.createElement('canvas');
                            canvas.width = WIDTH;
                            canvas.height = HEIGHT;
                            const context = canvas.getContext("2d");
                            context.drawImage(img, 0, 0, canvas.width, canvas.height);
                            let new_img_url = context.canvas.toDataURL(event.target.files[0].type);
                            this.imageSrc = new_img_url;
                            const resizedImage = await new Promise(rs => canvas.toBlob(rs, 'image/jpeg', 1))
                            this.employee.image = new File([resizedImage], event.target.files[0].name, {
                                type: resizedImage.type
                            });
                        }
                    }
                } else {
                    event.target.value = '';
                }
            },

            getEmployee() {
                this.btnText = 'Update';
                axios.post('/get-employee', {
                        empId: this.employee.id
                    })
                    .then(res => {
                        let r = res.data;
                        let employee = r[0];

                        this.employee.name = employee.name;
                        this.employee.designation_id = employee.designation_id;
                        this.employee.department_id = employee.department_id;
                        this.employee.bio_id = employee.bio_id;
                        this.employee.joining = employee.joining;
                        this.employee.status = employee.status;
                        this.employee.gender = employee.gender;
                        this.employee.dob = employee.dob;
                        this.employee.nid_no = employee.nid_no;
                        this.employee.phone = employee.phone;
                        this.employee.email = employee.email;
                        this.employee.marital_status = employee.marital_status;
                        this.employee.father_name = employee.father_name;
                        this.employee.mother_name = employee.mother_name;
                        this.employee.present_address = employee.present_address;
                        this.employee.permanent_address = employee.permanent_address;
                        this.employee.image = employee.image;
                        this.employee.salary = employee.salary;
                        this.employee.reference = employee.reference;

                        this.selectedDepartment = {
                            id: employee.department_id,
                            name: employee.department.name
                        }

                        this.selectedDesignation = {
                            id: employee.designation_id,
                            name: employee.designation.name
                        }

                        this.imageSrc = employee.image != null ? '/' + employee.image : '/noImage.gif';
                    })
            },

            openModal(value) {
                this.is_department = value;
                this.modalHead = value == true ? 'Department Entry' : 'Designation Entry';
                $('#commonModal').modal('show');
            },

            addData() {
                let url = '';
                if (this.is_department == true) {
                    url = '/department';
                } else {
                    url = '/designation';
                }

                axios.post(url, this.modalData)
                    .then(res => {
                        toastr.success(res.data);
                        if (this.is_department == true) {
                            this.getDepartment();
                        } else {
                            this.getDesignation();
                        }
                        this.resetModal();
                        $('#commonModal').modal('hide');
                    })
                    .catch(err => {
                        var r = JSON.parse(err.request.response);
                        if (r.errors) {
                            $.each(r.errors, (index, value) => {
                                $.each(value, (ind, val) => {
                                    toastr.error(val)
                                })
                            })
                        } else {
                            toastr.error(r.message);
                        }
                    })
            },

            resetModal() {
                this.is_department = false;
                this.modalHead = '';
                this.modalData = {
                    id: null,
                    name: ''
                }
            }
        }
    })
</script>
@endpush