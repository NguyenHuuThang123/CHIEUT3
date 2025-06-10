<?php include 'app/views/shares/header.php'; ?>
<section class="vh-100 bg-light d-flex align-items-center justify-content-center">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-5 col-xl-4">
                <div class="card shadow-lg border-0" style="border-radius: 1.5rem; background: linear-gradient(135deg, #2c3e50, #3498db);">
                    <div class="card-body p-4 p-md-5 text-center">
                        <h2 class="fw-bold text-white text-uppercase mb-3">Create Account</h2>
                        <p class="text-light mb-4">Join us today!</p>
                        <?php
                        if (isset($errors)) {
                            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
                            echo '<ul class="mb-0">';
                            foreach ($errors as $err) {
                                echo "<li>$err</li>";
                            }
                            echo '</ul>';
                            echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
                            echo '</div>';
                        }
                        ?>
                        <form class="user" action="/webbanhang/account/save" method="post">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control form-control-lg" id="username" name="username" placeholder="Username" required>
                                <label for="username" class="text-muted">Username</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control form-control-lg" id="fullname" name="fullname" placeholder="Full Name" required>
                                <label for="fullname" class="text-muted">Full Name</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="email" class="form-control form-control-lg" id="email" name="email" placeholder="Email" required>
                                <label for="email" class="text-muted">Email</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control form-control-lg" id="phone" name="phone" placeholder="Phone" required>
                                <label for="phone" class="text-muted">Phone</label>
                            </div>
                            
                            <div class="form-floating mb-3">
                                <input type="password" class="form-control form-control-lg" id="password" name="password" placeholder="Password" required>
                                <label for="password" class="text-muted">Password</label>
                            </div>
                            <div class="form-floating mb-4">
                                <input type="password" class="form-control form-control-lg" id="confirmpassword" name="confirmpassword" placeholder="Confirm Password" required>
                                <label for="confirmpassword" class="text-muted">Confirm Password</label>
                            </div>
                            <div class="form-check mb-4">
                                <input class="form-check-input" type="checkbox" value="" id="terms" required>
                                <label class="form-check    -label text-light" for="terms"> I agree to the <a href="#" class="text-white fw-bold text-decoration-underline">Terms and Conditions</a>
                                </label>
                            <button class="btn btn-primary btn-lg w-100 py-2" type="submit" style="border-radius: 0.5rem;">Register</button>
                        </form>
                        <p class="text-light mt-4 mb-0">Already have an account? <a href="/webbanhang/account/login" class="text-white fw-bold text-decoration-none">Sign In</a></p>
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
.alert-danger {
    background: rgba(220, 53, 69, 0.9);
    border: none;
    color: white;
    border-radius: 0.5rem;
}
</style>
<?php include 'app/views/shares/footer.php'; ?>