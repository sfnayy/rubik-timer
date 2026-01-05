<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="fw-bold text-dark mb-0">
                    <i class="fas fa-history me-2 text-primary"></i>Riwayat User
                </h3>
                <a href="index.php?url=admin/index" class="btn btn-light shadow-sm px-4 text-muted">
                    <i class="fas fa-arrow-left me-2"></i>Kembali
                </a>
            </div>

            <div class="card custom-card bg-primary text-white mb-4 border-0">
                <div class="card-body p-4 d-flex justify-content-between align-items-center">
                    <div>
                        <small class="text-white-50 text-uppercase fw-bold">Selected User</small>
                        <h2 class="fw-bold mb-0"><?= htmlspecialchars($targetUser['username']); ?></h2>
                    </div>
                    <div class="text-end">
                        <div class="h5 mb-0"><?= $solves->num_rows; ?></div>
                        <small class="text-white-50">Total Solves</small>
                    </div>
                </div>
            </div>

            <div class="card custom-card">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-custom align-middle mb-0">
                            <thead>
                                <tr>
                                    <th class="ps-4">No</th>
                                    <th>Time</th>
                                    <th>Scramble</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $no = 1;
                                if ($solves->num_rows > 0):
                                    while($row = $solves->fetch_assoc()): 
                                        $ms = $row['time_ms'];
                                        $display = sprintf('%02d.%02d', floor($ms/1000), floor(($ms%1000)/10));
                                ?>
                                <tr>
                                    <td class="ps-4 text-muted fw-bold"><?= $no++; ?></td>
                                    <td class="fw-bold fs-5 text-dark"><?= $display; ?></td>
                                    <td class="small text-muted font-monospace text-break" style="max-width: 300px;">
                                        <?= htmlspecialchars($row['scramble']); ?>
                                    </td>
                                    <td>
                                        <?php if($row['penalty'] == '+2'): ?>
                                            <span class="badge bg-warning text-dark">+2</span>
                                        <?php elseif($row['penalty'] == 'DNF'): ?>
                                            <span class="badge bg-danger">DNF</span>
                                        <?php else: ?>
                                            <span class="badge bg-light text-secondary border">OK</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="small text-muted"><?= date('d M, H:i', strtotime($row['created_at'])); ?></td>
                                    <td class="text-center">
                                        <a href="index.php?url=solve/delete/<?= $row['id']; ?>" 
                                           class="btn btn-sm btn-light text-danger shadow-sm rounded-circle"
                                           onclick="return confirm('Hapus data waktu ini?')">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php endwhile; else: ?>
                                <tr><td colspan="6" class="text-center py-5 text-muted">User ini belum bermain.</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>