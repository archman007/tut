<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h1 class="card-title h3 mb-4">Forgot Password</h1>
                    <?php if (isset($_SESSION['success'])): ?>
                        <div class="alert alert-success"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
                    <?php endif; ?>
                    
                    <form action="<?= BASE_PATH ?>/reset-password" method="POST">
                        <div class="mb-3">
                            <label for="email" class="form-label">Enter your email address</label>
                            <input type="email" name="email" id="email" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Send Reset Link</button>
                    </form>
                    
                    <div class="mt-3 text-center">
                        <p class="mb-0"><a href="<?= BASE_PATH ?>/login">Back to Login</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
