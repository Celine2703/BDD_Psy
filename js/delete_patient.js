
$(document).ready(function() {

    console.log("delete patient is ready ! ");

    $('.delete.btn-line').click(function() {
         let patientId = $(this).attr('data-id');
        $('#deleteEmployeeModal .modal-footer .btn.btn-danger').attr('data-id', patientId);
        console.log("delete.btn-line id ", patientId);
    });



    $(".modal-footer .btn.btn-danger").click(function() {

        let patientid = $(this).attr('data-id');

        $.post('./src/deletePatient.php', { patientId: patientid }, function(data) {

        });
    });










});


