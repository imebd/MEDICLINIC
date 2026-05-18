<div class="sidebar" style="width: 250px; background: white; border-right: 1px solid #e2e8f0;">
    <ul class="nav-list" style="list-style: none; padding: 20px 0;">
        <li>
            <a href="../dashboard/index.php" style="text-decoration: none; display: flex; align-items: center; gap: 10px; padding: 12px 20px; color: #475569; font-weight: 600;">
                <i class="fas fa-th-large"></i> Tableau de bord
            </a>
        </li>

        <?php if ($_SESSION['role'] === 'admin' || $_SESSION['role'] === 'secretaire' || $_SESSION['role'] === 'medecin'): ?>
            <li>
                <a href="../patients/index.php" style="text-decoration: none; display: flex; align-items: center; gap: 10px; padding: 12px 20px; color: #475569;">
                    <i class="fas fa-users"></i> Gestion Patients
                </a>
            </li>
            <li>
                <a href="../appointments/index.php" style="text-decoration: none; display: flex; align-items: center; gap: 10px; padding: 12px 20px; color: #475569;">
                    <i class="fas fa-calendar-alt"></i> Rendez-vous
                </a>
            </li>
            <li>
                <a href="../consultations/index.php" style="text-decoration: none; display: flex; align-items: center; gap: 10px; padding: 12px 20px; color: #475569;">
                    <i class="fas fa-stethoscope"></i> Consultations
                </a>
            </li>
            <?php if ($_SESSION['role'] === 'admin'): ?>
                <li>
                    <a href="../invoices/index.php" style="text-decoration: none; display: flex; align-items: center; gap: 10px; padding: 12px 20px; color: #475569;">
                        <i class="fas fa-file-invoice-dollar"></i> Facturation
                    </a>
                </li>
            <?php endif; ?>

        <?php else: ?>
            <li class="active">
                <a href="../dashboard/index.php" style="text-decoration: none; display: flex; align-items: center; gap: 10px; padding: 12px 20px; color: var(--primary); background: #f0fdf4; border-radius: 10px;">
                    <i class="fas fa-calendar-check"></i> Mes Rendez-vous
                </a>
            </li>
        <?php endif; ?>
    </ul>
</div>