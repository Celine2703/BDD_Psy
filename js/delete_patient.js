// Rayan Anki
// Colombe Blachère
// Céline Martin-Parisot
// L3-APP LSI2
$(document).ready(function() {

    $('.delete.btn-line').click(function() {
         let patientId = $(this).attr('data-id');
        $('#deleteEmployeeModal .modal-footer .btn.btn-danger').attr('data-id', patientId);
    });



    $(".modal-footer .btn.btn-danger").click(function() {

        let patientid = $(this).attr('data-id');

        $.post('./src/deletePatient.php', { patientId: patientid }, function(data) {
            // alert(data);
            // location.reload();
        });
    });










});


