<?php
/**
 * Dashboard view
 */

if (!defined('ABSPATH')) {
    exit;
}

global $wpdb;
$generator = new PSEO_Page_Generator();
$stats = $generator->get_stats();

$templates_table = $wpdb->prefix . 'pseo_templates';
$data_sources_table = $wpdb->prefix . 'pseo_data_sources';

$total_templates = $wpdb->get_var("SELECT COUNT(*) FROM $templates_table");
$total_data_sources = $wpdb->get_var("SELECT COUNT(*) FROM $data_sources_table");
?>

<div class="wrap pseo-admin">
    <h1 class="wp-heading-inline">
        <i class="fas fa-chart-line"></i> Programmatic SEO Dashboard
    </h1>

    <hr class="wp-header-end">

    <div class="container-fluid mt-4">

        <!-- Welcome Card -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-0 shadow-sm bg-gradient-primary text-white">
                    <div class="card-body p-4">
                        <h2 class="mb-3"><i class="fas fa-rocket"></i> Chào mừng đến với Programmatic SEO</h2>
                        <p class="mb-0 lead">Tạo hàng loạt trang SEO tự động với template và dữ liệu. Tối ưu hóa nội dung và tăng traffic cho website của bạn!</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="row mb-4">
            <div class="col-md-3 mb-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center">
                        <div class="stat-icon bg-primary text-white mb-3">
                            <i class="fas fa-file-alt fa-2x"></i>
                        </div>
                        <h3 class="display-4 mb-2"><?php echo number_format($stats['total_pages']); ?></h3>
                        <p class="text-muted mb-0">Trang đã tạo</p>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center">
                        <div class="stat-icon bg-success text-white mb-3">
                            <i class="fas fa-eye fa-2x"></i>
                        </div>
                        <h3 class="display-4 mb-2"><?php echo number_format($stats['total_views']); ?></h3>
                        <p class="text-muted mb-0">Lượt xem</p>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center">
                        <div class="stat-icon bg-info text-white mb-3">
                            <i class="fas fa-layer-group fa-2x"></i>
                        </div>
                        <h3 class="display-4 mb-2"><?php echo number_format($total_templates); ?></h3>
                        <p class="text-muted mb-0">Templates</p>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center">
                        <div class="stat-icon bg-warning text-white mb-3">
                            <i class="fas fa-database fa-2x"></i>
                        </div>
                        <h3 class="display-4 mb-2"><?php echo number_format($total_data_sources); ?></h3>
                        <p class="text-muted mb-0">Data Sources</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-bottom">
                        <h5 class="mb-0"><i class="fas fa-bolt"></i> Thao tác nhanh</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <a href="<?php echo admin_url('admin.php?page=pseo-templates'); ?>" class="btn btn-primary btn-block btn-lg">
                                    <i class="fas fa-plus-circle"></i><br>
                                    <span class="mt-2 d-block">Tạo Template</span>
                                </a>
                            </div>
                            <div class="col-md-3 mb-3">
                                <a href="<?php echo admin_url('admin.php?page=pseo-data-import'); ?>" class="btn btn-success btn-block btn-lg">
                                    <i class="fas fa-upload"></i><br>
                                    <span class="mt-2 d-block">Import Data</span>
                                </a>
                            </div>
                            <div class="col-md-3 mb-3">
                                <a href="<?php echo admin_url('admin.php?page=pseo-generate'); ?>" class="btn btn-info btn-block btn-lg">
                                    <i class="fas fa-magic"></i><br>
                                    <span class="mt-2 d-block">Tạo Pages</span>
                                </a>
                            </div>
                            <div class="col-md-3 mb-3">
                                <a href="<?php echo admin_url('admin.php?page=pseo-analytics'); ?>" class="btn btn-warning btn-block btn-lg">
                                    <i class="fas fa-chart-bar"></i><br>
                                    <span class="mt-2 d-block">Analytics</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Getting Started -->
        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white border-bottom">
                        <h5 class="mb-0"><i class="fas fa-info-circle"></i> Bắt đầu sử dụng</h5>
                    </div>
                    <div class="card-body">
                        <ol class="pl-3">
                            <li class="mb-2"><strong>Tạo Template:</strong> Tạo template nội dung với các biến động ({{variable}})</li>
                            <li class="mb-2"><strong>Import Data:</strong> Upload file CSV hoặc JSON chứa dữ liệu</li>
                            <li class="mb-2"><strong>Generate Pages:</strong> Chọn template và data để tạo pages tự động</li>
                            <li class="mb-2"><strong>Theo dõi:</strong> Xem analytics để đánh giá hiệu quả</li>
                        </ol>
                    </div>
                </div>
            </div>

            <div class="col-md-6 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white border-bottom">
                        <h5 class="mb-0"><i class="fas fa-lightbulb"></i> Tính năng nổi bật</h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled">
                            <li class="mb-2"><i class="fas fa-check text-success"></i> Template động với biến</li>
                            <li class="mb-2"><i class="fas fa-check text-success"></i> Import CSV/JSON</li>
                            <li class="mb-2"><i class="fas fa-check text-success"></i> Tạo hàng loạt pages</li>
                            <li class="mb-2"><i class="fas fa-check text-success"></i> SEO tự động (Meta, Schema.org)</li>
                            <li class="mb-2"><i class="fas fa-check text-success"></i> Internal linking thông minh</li>
                            <li class="mb-2"><i class="fas fa-check text-success"></i> Analytics dashboard</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<style>
.bg-gradient-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.stat-icon {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    display: inline-flex;
    align-items: center;
    justify-content: center;
}

.card {
    transition: transform 0.2s;
}

.card:hover {
    transform: translateY(-5px);
}

.btn-lg {
    padding: 20px;
    font-size: 0.9rem;
}
</style>
