<div class="modal form connexion" id="modal_form_connexion">
    <div class="wrapper">
        <div class="inner">
            <form id="loginForm" action="./src/connexion_site.php" method="post">
                <h3>Connexion</h3>
                <div class="alert alert-danger d-none" id="loginError"></div>
                <div class="form-holder">
                    <span class="lnr lnr-lock"></span>
                    <input type="text" class="form-control" placeholder="Numéro de sécurité sociale" required
                           style="padding-left: 20px;" name="security_number">
                </div>
                <div class="form-holder">
                    <span class="lnr lnr-envelope"></span>
                    <input type="password" class="form-control" placeholder="Mot de passe" required
                           style="padding-left: 20px;" name="password">
                </div>
                <button type="submit">
                    <span>Se connecter</span>
                </button>
            </form>
        </div>
    </div>
</div>
<div class="modal-overlay"></div>

<script>

    $(document).ready(function () {
        $('#loginForm').on('submit', function (e) {
            e.preventDefault(); // Empêcher le formulaire de soumettre normalement
            var formData = $(this).serialize(); // Sérialiser les données du formulaire

            $.ajax({
                type: "POST",
                url: $(this).attr('action'),
                data: formData,
                success: function (response) {
                    if (response.error) {
                        $('#loginError').text(response.error).removeClass('d-none');
                    } else {
                        console.log(response['role']);
                        if (response['role'] === "admin") {
                            window.location.href = "patient";
                        } else {
                            window.location.href = "accueil";
                        }
                    }
                },
                error: function () {
                    $('#loginError').text('Erreur lors de la connexion. Veuillez réessayer.').removeClass('d-none');
                }
            });
        });
    });


</script>