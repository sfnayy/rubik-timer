<div class="container-fluid px-2 px-md-4">
    <div class="row g-4">
        
        <div class="col-lg-8">
            <div class="card border-0 shadow-lg mb-4 text-center position-relative overflow-hidden bg-white h-100 justify-content-center d-flex flex-column">
                <div class="card-body">
                    
                    <div class="position-absolute top-0 start-0 p-4 text-start">
                        <small class="text-muted d-block text-uppercase fw-bold" style="font-size: 0.7rem;">Scramble Active</small>
                        <div id="scramble" class="h5 text-dark font-monospace fw-bold mb-0">Loading...</div>
                    </div>

                    <div class="mb-4 mt-5 d-flex justify-content-center">
                        <twisty-player 
                            id="visualScramble" 
                            puzzle="3x3x3" 
                            visualization="2D" 
                            control-panel="none" 
                            background="none"
                            alg="">
                        </twisty-player>
                    </div>
                    
                    <div class="timer-display my-2" id="timer" style="font-size: 8rem; font-weight: 700; font-family: 'Courier New', monospace; color: #212529; line-height: 1;">
                        <?= isset($displayTimer) ? $displayTimer : "00.00.00"; ?>
                    </div>

                    <p class="text-muted mt-4 animate-pulse small text-uppercase fw-bold">
                        <i class="far fa-hand-point-down me-2"></i>Tahan Spasi
                    </p>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            
            <div class="row g-2 mb-3">
                <div class="col-6">
                    <div class="card border-0 shadow-sm bg-primary text-white text-center py-2">
                        <small class="text-uppercase opacity-75" style="font-size: 0.65rem;">Best Time</small>
                        <h4 class="fw-bold mb-0"><?= $stats['best']; ?></h4>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card border-0 shadow-sm bg-white text-center py-2">
                        <small class="text-uppercase text-muted fw-bold" style="font-size: 0.65rem;">Total Solves</small>
                        <h4 class="fw-bold mb-0 text-dark"><?= $stats['total']; ?></h4>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card border-0 shadow-sm bg-warning text-dark text-center py-2">
                        <small class="text-uppercase opacity-75 fw-bold" style="font-size: 0.65rem;">Ao5</small>
                        <h4 class="fw-bold mb-0"><?= $stats['ao5']; ?></h4>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card border-0 shadow-sm bg-success text-white text-center py-2">
                        <small class="text-uppercase opacity-75" style="font-size: 0.65rem;">Ao12</small>
                        <h4 class="fw-bold mb-0"><?= $stats['ao12']; ?></h4>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm bg-white" style="height: calc(100% - 140px);"> 
                <div class="card-header bg-white border-0 pt-3 px-3">
                    <form action="index.php" method="GET" class="position-relative">
                        <i class="fas fa-search position-absolute text-muted" style="left: 15px; top: 12px;"></i>
                        <input type="text" name="search" class="form-control search-input ps-5" 
                               placeholder="Cari..." 
                               value="<?= isset($_GET['search']) ? $_GET['search'] : '' ?>"
                               onchange="this.form.submit()">
                        <?php if(isset($_GET['search'])): ?>
                            <a href="index.php" class="position-absolute text-danger" style="right: 15px; top: 10px; text-decoration: none;">
                                <i class="fas fa-times-circle"></i>
                            </a>
                        <?php endif; ?>
                    </form>
                </div>

                <div class="card-body p-0 mt-2 table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light sticky-top">
                            <tr>
                                <th class="ps-4">#</th>
                                <th>Waktu</th>
                                <th class="text-end pe-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            // --- PERBAIKAN LOGIKA NOMOR ---
                            // Hitung mundur: Total Data dikurangi (Halaman sekarang - 1 * Limit)
                            $no = $total_data - $start; 

                            while($row = $history->fetch_assoc()): 
                                // LOGIKA PENALTY DISPLAY
                                $baseTime = $row['time_ms'];
                                $displayTime = "";
                                $isDNF = ($row['penalty'] == 'DNF');
                                $isPlus2 = ($row['penalty'] == '+2');

                                if ($isDNF) {
                                    $displayTime = "DNF";
                                } else {
                                    $finalMs = $baseTime + ($isPlus2 ? 2000 : 0);
                                    $displayTime = sprintf('%02d.%02d', floor($finalMs/1000), floor(($finalMs%1000)/10));
                                    if ($isPlus2) $displayTime .= "+";
                                }

                                // JSON DATA UNTUK MODAL
                                $detailData = htmlspecialchars(json_encode([
                                    'id' => $row['id'],
                                    'base_time' => sprintf('%02d.%02d', floor($baseTime/1000), floor(($baseTime%1000)/10)),
                                    'penalty' => $row['penalty'],
                                    'scramble' => $row['scramble'],
                                    'date' => date('d M, H:i', strtotime($row['created_at']))
                                ]));
                            ?>
                            <tr style="cursor: pointer;" onclick="showDetail(this)" data-detail="<?= $detailData ?>">
                                <td class="ps-4 text-muted small"><?= $no--; ?></td>
                                
                                <td class="fw-bold text-dark fs-5 <?= $isDNF ? 'text-danger' : '' ?>">
                                    <?= $displayTime ?>
                                </td>
                                <td class="text-end pe-4">
                                    <button class="btn btn-sm btn-light text-danger rounded-circle" 
                                            onclick="event.stopPropagation(); confirmDelete(<?= $row['id'] ?>)">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>

                <div class="card-footer bg-white border-0 py-3 text-center">
                    <nav class="d-inline-block">
                        <ul class="pagination pagination-sm mb-0">
                            <?php $sParam = isset($_GET['search']) ? '&search='.$_GET['search'] : ''; ?>
                            <?php $sParam .= isset($_GET['show_last']) ? '&show_last=1' : ''; ?>
                            
                            <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
                                <a class="page-link rounded-start-pill" href="index.php?page=<?= $page-1 . $sParam ?>">&laquo;</a>
                            </li>
                            <li class="page-item disabled"><span class="page-link bg-light border-0"><?= $page ?></span></li>
                            <li class="page-item <?= ($page >= $total_pages) ? 'disabled' : '' ?>">
                                <a class="page-link rounded-end-pill" href="index.php?page=<?= $page+1 . $sParam ?>">&raquo;</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="detailModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold ms-2">Detail Solve</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center pt-2 pb-4">
                
                <h1 class="display-1 fw-bold text-dark mb-0" id="modalTime">00.00</h1>
                <span id="modalPenaltyBadge" class="badge bg-danger mb-2" style="display:none;">+2</span>
                <p class="text-muted small" id="modalDate">Date</p>

                <div class="btn-group shadow-sm rounded-pill mb-4" role="group">
                    <button type="button" class="btn btn-outline-secondary px-4" onclick="updatePenalty('OK')" id="btnOK">OK</button>
                    <button type="button" class="btn btn-outline-secondary px-4" onclick="updatePenalty('+2')" id="btnPlus2">+2</button>
                    <button type="button" class="btn btn-outline-secondary px-4" onclick="updatePenalty('DNF')" id="btnDNF">DNF</button>
                </div>

                <div class="d-flex justify-content-center mb-3">
                     <twisty-player 
                        id="modalVisualScramble" 
                        puzzle="3x3x3" 
                        visualization="2D" 
                        control-panel="none" 
                        background="none"
                        style="width: 200px; height: 150px;">
                     </twisty-player>
                </div>

                <div class="bg-light p-3 rounded-3 mx-3 mb-4">
                    <small class="text-muted text-uppercase fw-bold d-block mb-1" style="font-size: 0.7rem;">Scramble Sequence</small>
                    <span id="modalScramble" class="font-monospace text-primary fw-bold text-break"></span>
                </div>
                
                <input type="hidden" id="modalSolveId">

                <div class="d-grid gap-2 px-3">
                     <button id="detailDeleteBtn" class="btn btn-danger btn-lg rounded-pill shadow-sm">
                        Hapus Waktu Ini
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content border-0 shadow rounded-4 text-center p-3">
            <div class="modal-body">
                <div class="mb-3 text-danger">
                    <i class="fas fa-exclamation-circle fa-4x"></i>
                </div>
                <h5 class="fw-bold">Yakin Hapus?</h5>
                <p class="text-muted small">Data statistik akan berubah dan tidak bisa dikembalikan.</p>
                
                <div class="d-flex justify-content-center gap-2 mt-4">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                    <a href="#" id="finalDeleteBtn" class="btn btn-danger rounded-pill px-4 shadow-sm">Ya, Hapus</a>
                </div>
            </div>
        </div>
    </div>
</div>