$(document).ready(function() {

    $('.delete.btn-line').click(function() {
         let patientId = $(this).attr('data-id');
        $('#deleteEmployeeModal .modal-footer .btn .btn-danger').attr('data-patientid', patientId);
    });



    $(".delete.btn-danger").click(function() {

        let patientid = $(this).attr('data-patientid');
        //supprimer en php avec cet id 
        
        
    });










});


