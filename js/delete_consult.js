// Rayan Anki
// Colombe Blachère
// Céline Martin-Parisot
// L3-APP LSI2

(document).ready(function() {

    $('.delete.btn-line').click(function() {
        let slotid = $(this).attr('data-id');
        $('#deleteEmployeeModal .modal-footer .btn.btn-danger').attr('data-id', slotid);
    });



    $(".modal-footer .consult.btn.btn-danger").click(function() {

        let patientid = $(this).attr('data-id');

        $.post('./src/deleteConsult.php', { start_date_slot: patientid }, function(data) {
            location.reload();
        });
    });










});
