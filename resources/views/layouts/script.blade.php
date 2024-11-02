<script src="{{asset('backend')}}/js/bootstrap.min.js"></script>
<script src="{{asset('backend')}}/js/ace-elements.min.js"></script>
<script src="{{asset('backend')}}/js/ace.min.js"></script>
<script src="{{asset('backend')}}/js/toastr.min.js"></script>
<script src="{{asset('backend')}}/js/vue/vuejs-datatable.js"></script>
<script src="{{asset('backend')}}/js/vue/vue-select.js"></script>
<script src="{{asset('backend')}}/js/vue/axios.min.js"></script>
<script src="{{asset('backend')}}/js/vue/moment.js"></script>
<script src="{{asset('backend')}}/js/vue/lodash.min.js"></script>
<script src="{{asset('backend')}}/js/selectize.min.js"></script>
<script>
    Vue.component('v-select', VueSelect.VueSelect)
    Vue.config.devtools = false;

    function dateTime() {
        time = new Date().toLocaleTimeString();
        document.getElementById("timer").innerText = time
        setTimeout(() => {
            dateTime()
        }, 1000)
    }
    dateTime()
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    };

    @if(Session::has('error'))
    toastr.error("{{Session::get('error')}}")
    @endif
    @if(Session::has('success'))
    toastr.success("{{Session::get('success')}}")
    @endif

    // pre loader
    document.addEventListener("DOMContentLoaded", function() {
        var preloader = document.querySelector(".preloader");
        preloader.style.display = "none";
    });
</script>
@stack('script');