$(document).ready(() => {

    window.addEventListener('show-success-toast', e => {

        // just for success messages
        toastr.success(e.detail.success_msg, 'Success')

    });



    // open-modal events
    let openModalEvents = [{ eventFromLiveWire: 'show_add_category_modal',modalToShow:'add_category_modal' }]
    openModalEvents.forEach((event_) => {
        window.addEventListener(event_.eventFromLiveWire, e => {
            // alert('yoh!')
            $(`#${event_.modalToShow}`).modal('show');

        });


    })

     // close-modal events
     let closeModalEvents = [{ eventFromLiveWire: 'hide_add_category_modal',modalToHide:'add_category_modal' }]
     closeModalEvents.forEach((event_) => {
         window.addEventListener(event_.eventFromLiveWire, e => {
             // alert('yoh!')
             $(`#${event_.modalToHide}`).modal('hide');

         });


     })




    // toastr-config
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }
});
