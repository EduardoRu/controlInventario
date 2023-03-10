<?php include './templases/header.php' ?>
<section class="vh-100" style="background-color: #508bfc;">
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                <div class="card shadow-2-strong" style="border-radius: 1rem;">
                    <div class="card-body p-5 text-center">

                        <h3 class="mb-5">Inicio de sesión - Control de inventario</h3>

                        <form action="./funcionlogin.php" method="post">
                            <div class="form-outline mb-4">
                                <input type="email" id="email_personal" name="email_personal" class="form-control form-control-lg" />
                                <label class="form-label" for="email_personal">Correo electronico</label>
                            </div>

                            <div class="form-outline mb-4">
                                <input type="password" id="pass_personal" name="pass_personal" class="form-control form-control-lg" />
                                <label class="form-label" for="pass_personal">Contraseña</label>
                            </div>

                            <button class="btn btn-primary btn-lg btn-block" type="submit">Iniciar sesión</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php include "./templases/footer.php" ?>