<div class="row justify-content-center mt-4">
    <div class="col-lg-10">
        <div class="card auth-card">
            <div class="row g-0 h-100">
                
                <div class="col-md-5 auth-bg text-center p-5">
                    <div class="position-relative" style="z-index: 2;">
                        <i class="fas fa-user-plus fa-4x mb-4"></i>
                        <h2 class="fw-bold mb-3">Join Us!</h2>
                        <p class="opacity-75">
                            Mulai perjalanan cubingmu, simpan statistik, dan pantau perkembanganmu setiap hari.
                        </p>
                    </div>
                </div>

                <div class="col-md-7 auth-form-container">
                    <div class="text-center mb-4">
                        <h3 class="fw-bold text-dark">Buat Akun Baru</h3>
                        <p class="text-muted">Gratis dan hanya butuh 1 menit.</p>
                    </div>

                    <form action="index.php?url=auth/store" method="POST">
                        <div class="form-floating mb-3">
                            <input type="text" name="username" class="form-control" id="regUser" placeholder="Username Baru" required>
                            <label for="regUser">Username Baru</label>
                        </div>
                        <div class="form-floating mb-4">
                            <input type="password" name="password" class="form-control" id="regPass" placeholder="Password Kuat" required>
                            <label for="regPass">Password</label>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 mb-3">
                            Daftar Sekarang
                        </button>
                        
                        <p class="text-center text-muted mt-4 small">
                            Sudah punya akun? <a href="index.php?url=auth/login" class="fw-bold text-primary text-decoration-none">Login disini</a>
                        </p>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>