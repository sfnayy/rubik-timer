<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="fw-bold text-dark mb-0"><i class="fas fa-user-shield me-2 text-primary"></i>Admin Panel</h3>
                <span class="badge bg-white text-dark shadow-sm px-3 py-2 rounded-pill border">
                    <i class="fas fa-users me-2 text-primary"></i><?= $users->num_rows; ?> Users
                </span>
            </div>

            <div class="card custom-card">
                <div class="card-body p-0">
                    <div class="p-4 bg-light border-bottom">
                        <div class="d-flex align-items-center text-muted">
                            <i class="fas fa-info-circle fa-2x me-3 text-primary opacity-50"></i>
                            <div>
                                <strong>Halo Admin!</strong>
                                <div class="small">Kelola user dengan bijak. Menghapus user bersifat permanen.</div>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-custom align-middle mb-0">
                            <thead>
                                <tr>
                                    <th class="ps-4">No</th>
                                    <th>Username</th>
                                    <th>Role</th>
                                    <th>Joined Date</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $no = 1;
                                if ($users->num_rows > 0):
                                    while($u = $users->fetch_assoc()): 
                                ?>
                                <tr>
                                    <td class="ps-4 text-muted fw-bold"><?= $no++; ?></td>
                                    <td class="fw-bold text-dark fs-5"><?= htmlspecialchars($u['username']); ?></td>
                                    <td><span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill"><?= $u['role']; ?></span></td>
                                    <td class="text-muted small"><?= date('d M Y, H:i', strtotime($u['created_at'])); ?></td>
                                    <td class="text-center">
                                        <a href="index.php?url=admin/viewSolves/<?= $u['id']; ?>" class="btn btn-sm btn-light text-primary shadow-sm me-1">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="index.php?url=admin/deleteUser/<?= $u['id']; ?>" class="btn btn-sm btn-light text-danger shadow-sm"
                                           onclick="return confirm('Yakin hapus user ini?')">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php endwhile; else: ?>
                                <tr><td colspan="5" class="text-center py-5 text-muted">Belum ada user lain.</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            <div class="text-center mt-4">
                <a href="index.php" class="btn btn-secondary px-4 shadow-sm">
                    <i class="fas fa-arrow-left me-2"></i>Back to Timer
                </a>
            </div>
        </div>
    </div>
</div>