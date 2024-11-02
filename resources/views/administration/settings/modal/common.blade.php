<div id="commonModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-sm">
        <!-- Modal content-->
        <div class="modal-content">
            <form @submit.prevent="addData">
                <div class="modal-header" style="padding: 10px 15px">
                    <button type="button" @click="resetModal" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">@{{ modalHead }}</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="name" v-model="modalData.name" autocomplete="off" />
                    </div>
                </div>
                <div class="modal-footer">
                    @if(userAction('e'))
                    <button type="button" @click="resetModal" class="btn btn-danger btn-reset" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary btn-padding">Save</button>
                    @endif
                </div>
            </form>
        </div>
    </div>
</div>