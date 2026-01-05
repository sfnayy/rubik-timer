<div class="row justify-content-center mt-4">
    <div class="col-lg-10">
        <div class="card auth-card">
            <div class="row g-0 h-100">
                
                <div class="col-md-5 auth-bg text-center p-5">
                    <div class="position-relative" style="z-index: 2;">
                        <i class="fas fa-cube fa-4x mb-4"></i>
                        <h2 class="fw-bold mb-3">CuberTimer</h2>
                        <p class="opacity-75">
                            "Speedcubing is not just about solving a puzzle, it's about pushing your limits."
                        </p>
                        <div class="mt-4 d-flex justify-content-center opacity-75">
                             <twisty-player 
                                puzzle="3x3x3" 
                                visualization="2D" 
                                background="none"
                                control-panel="none"
                                style="width:100px; height:100px;">
                             </twisty-player>
                        </div>
                    </div>
                </div>

                <div class="col-md-7 auth-form-container">
                    <div class="text-center mb-4">
                        <h3 class="fw-bold text-dark">Welcome Back!</h3>
                        <p class="text-muted">Silakan login untuk melanjutkan progressmu.</p>
                    </div>

                    <form action="index.php?url=auth/authenticate" method="POST">
                        <div class="form-floating mb-3">
                            <input type="text" name="username" class="form-control" id="floatingInput" placeholder="Username" required>
                            <label for="floatingInput">Username</label>
                        </div>
                        <div class="form-floating mb-4">
                            <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Password" required>
                            <label for="floatingPassword">Password</label>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="rememberMe">
                                <label class="form-check-label text-muted small" for="rememberMe">
                                    Ingat Saya
                                </label>
                            </div>
                            <a href="#" class="text-decoration-none small">Lupa Password?</a>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 mb-3">
                            Masuk Sekarang
                        </button>
                        
                        <p class="text-center text-muted mt-4 small">
                            Belum punya akun? <a href="index.php?url=auth/register" class="fw-bold text-primary text-decoration-none">Daftar disini</a>
                        </p>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>