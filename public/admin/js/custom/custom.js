$(document).ready(() => {

    window.addEventListener('show-success-toast', e => {

        // just for success messages
        toastr.success(e.detail.success_msg, 'Success')

    });



    // open-modal events
    let openModalEvents = [{ eventFromLiveWire: 'show_add_category_modal',modalToShow:'add_category_modal' },{ eventFromLiveWire: 'show_add_announcement_modal',modalToShow:'add_announcement_modal' }]
    openModalEvents.forEach((event_) => {
        window.addEventListener(event_.eventFromLiveWire, e => {
            // alert('yoh!')
            $(`#${event_.modalToShow}`).modal('show');

        });


    })

     // close-modal events
     let closeModalEvents = [{ eventFromLiveWire: 'hide_add_category_modal',modalToHide:'add_category_modal' },{ eventFromLiveWire: 'hide_add_announcement_modal',modalToHide:'add_announcement_modal' }]
     closeModalEvents.forEach((event_) => {
         window.addEventListener(event_.eventFromLiveWire, e => {
             // alert('yoh!')
             $(`#${event_.modalToHide}`).modal('hide');

         });


     })

    //delete events sweet-alerts
    let deleteEvents=[{eventFromLiveWire:'show_delete_category_alert',eventToLiveWire:'confirm_delete_category_alert'},{eventFromLiveWire:'show_delete_announcement_alert',eventToLiveWire:'confirm_delete_announcement_alert'}]
    deleteEvents.forEach((event_) => {
        window.addEventListener(event_.eventFromLiveWire, e => {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'danger',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // telling livewire user has clicked on confimation to delete
                    Livewire.emit(event_.eventToLiveWire)

                }
            })
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
