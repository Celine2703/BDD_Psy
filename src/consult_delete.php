<!-- Delete Modal HTML -->
<div id="deleteEmployeeModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <form>
                <div class="modal-header">
                    <h4 class="modal-title">Supprimer mon rendez-vous</h4>
                    <span type="button" class="close" data-dismiss="modal" aria-hidden="true">×</span>
                </div>
                <div class="modal-body">
                    <p>Etes-vous sur de vouloir supprimer ce rendez-vous ? <br> Cela supprimera aussi le rendez-vous des patients associés.</p>
                </div>
                <div class="modal-footer">
                    <input type="button" class="btn btn-default" data-dismiss="modal" value="Annuler">
                    <input type="submit" class="consult btn btn-danger" value="Valider">
                </div>
            </form>
        </div>
    </div>
</div>


<script src="./js/delete_consult.js"></script>