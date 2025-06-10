<?php include 'app/views/shares/header.php'; ?>
<section class="vh-100 bg-light d-flex align-items-center justify-content-center">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-5 col-xl-4">
                <div class="card shadow-lg border-0" style="border-radius: 1.5rem; background: linear-gradient(135deg, #2c3e50, #3498db);">
                    <div class="card-body p-4 p-md-5 text-center">
                        <form action="/webbanhang/account/checklogin" method="post">
                            <div class="mb-4">
                                <h2 class="fw-bold text-white text-uppercase mb-3">Welcome Back</h2>
                                <p class="text-light mb-4">Sign in to your account</p>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" name="username" class="form-control form-control-lg" id="username" placeholder="Username" required>
                                <label for="username" class="text-muted">Username</label>
                            </div>
                            <div class="form-floating mb-4">
                                <input type="password" name="password" class="form-control form-control-lg" id="password" placeholder="Password" required>
                                <label for="password" class="text-muted">Password</label>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <a href="#!" class="text-light text-decoration-none small">Forgot Password?</a>
                            </div>
                            <button class="btn btn-primary btn-lg w-100 py-2 mb-4" type="submit" style="border-radius: 0.5rem;">Sign In</button>
                            <div class="d-flex justify-content-center gap-3 mb-4">
                                <a href="#!" class="text-white"><i class="fab fa-facebook-f fa-lg"></i></a>
                                <a href="#!" class="text-white"><i class="fab fa-twitter fa-lg"></i></a>
                                <a href="#!" class="text-white"><i class="fab fa-google fa-lg"></i></a>
                            </div>
                            <p class="text-light mb-0">Don't have an account? <a href="/webbanhang/account/register" class="text-white fw-bold text-decoration-none">Sign Up</a></p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<style>
body {
    background: #f0f2f5;
}
.card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2) !important;
}
.btn-primary {
    background: #1e90ff;
    border: none;
    transition: background 0.3s ease;
}
.btn-primary:hover {
    background: #187cdb;
}
.form-control {
    border-radius: 0.5rem;
    background: rgba(255, 255, 255, 0.95);
}
.form-floating > label {
    color: #6c757d;
}
</style>
<?php include 'app/views/shares/footer.php'; ?>