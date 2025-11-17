<?php
/**
 * Analytics view
 */

if (!defined('ABSPATH')) {
    exit;
}

global $wpdb;
$generated_pages_table = $wpdb->prefix . 'pseo_generated_pages';
$templates_table = $wpdb->prefix . 'pseo_templates';

// Get stats
$total_pages = $wpdb->get_var("SELECT COUNT(*) FROM $generated_pages_table");
$total_views = $wpdb->get_var("SELECT SUM(views) FROM $generated_pages_table");
$total_clicks = $wpdb->get_var("SELECT SUM(clicks) FROM $generated_pages_table");

// Get top performing pages
$top_pages = $wpdb->get_results("
    SELECT p.ID, p.post_title, gp.views, gp.clicks, t.name as template_name
    FROM {$wpdb->posts} p
    INNER JOIN $generated_pages_table gp ON p.ID = gp.post_id
    LEFT JOIN $templates_table t ON gp.template_id = t.id
    WHERE p.post_status = 'publish'
    ORDER BY gp.views DESC
    LIMIT 10
");

// Stats by template
$template_stats = $wpdb->get_results("
    SELECT t.name, COUNT(gp.id) as page_count, SUM(gp.views) as total_views
    FROM $templates_table t
    LEFT JOIN $generated_pages_table gp ON t.id = gp.template_id
    GROUP BY t.id
    ORDER BY page_count DESC
");
?>

<div class="wrap pseo-admin">
    <h1 class="wp-heading-inline">
        <i class="fas fa-chart-bar"></i> Analytics Dashboard
    </h1>

    <hr class="wp-header-end">

    <div class="container-fluid mt-4">

        <!-- Summary Stats -->
        <div class="row mb-4">
            <div class="col-md-4 mb-3">
                <div class="card border-0 shadow-sm bg-gradient-primary text-white">
                    <div class="card-body text-center py-4">
                        <i class="fas fa-file-alt fa-3x mb-3"></i>
                        <h2 class="display-3 mb-2"><?php echo number_format($total_pages); ?></h2>
                        <h5 class="mb-0">Tổng Pages đã tạo</h5>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-3">
                <div class="card border-0 shadow-sm bg-gradient-success text-white">
                    <div class="card-body text-center py-4">
                        <i class="fas fa-eye fa-3x mb-3"></i>
                        <h2 class="display-3 mb-2"><?php echo number_format($total_views); ?></h2>
                        <h5 class="mb-0">Tổng Lượt xem</h5>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-3">
                <div class="card border-0 shadow-sm bg-gradient-info text-white">
                    <div class="card-body text-center py-4">
                        <i class="fas fa-mouse-pointer fa-3x mb-3"></i>
                        <h2 class="display-3 mb-2"><?php echo number_format($total_clicks); ?></h2>
                        <h5 class="mb-0">Tổng Clicks</h5>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Row -->
        <div class="row mb-4">
            <div class="col-md-6 mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-bottom">
                        <h5 class="mb-0"><i class="fas fa-chart-pie"></i> Pages theo Template</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="templateChart" height="250"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-md-6 mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-bottom">
                        <h5 class="mb-0"><i class="fas fa-chart-bar"></i> Views theo Template</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="viewsChart" height="250"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Top Performing Pages -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white border-bottom">
                <h5 class="mb-0"><i class="fas fa-trophy"></i> Top 10 Pages có lượt xem cao nhất</h5>
            </div>
            <div class="card-body p-0">
                <?php if (empty($top_pages)): ?>
                    <div class="text-center py-5">
                        <i class="fas fa-chart-line fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">Chưa có dữ liệu analytics</h5>
                        <p class="text-muted">Dữ liệu sẽ được cập nhật khi có người truy cập pages</p>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th width="50">Rank</th>
                                    <th>Page Title</th>
                                    <th>Template</th>
                                    <th width="120">Views</th>
                                    <th width="120">Clicks</th>
                                    <th width="120">CTR</th>
                                    <th width="100">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($top_pages as $index => $page): ?>
                                    <?php
                                    $ctr = $page->views > 0 ? ($page->clicks / $page->views * 100) : 0;
                                    $rank_icon = $index < 3 ? '<i class="fas fa-trophy text-warning"></i>' : ($index + 1);
                                    ?>
                                    <tr>
                                        <td class="text-center"><?php echo $rank_icon; ?></td>
                                        <td><strong><?php echo esc_html($page->post_title); ?></strong></td>
                                        <td><span class="badge badge-info"><?php echo esc_html($page->template_name); ?></span></td>
                                        <td><strong><?php echo number_format($page->views); ?></strong></td>
                                        <td><strong><?php echo number_format($page->clicks); ?></strong></td>
                                        <td>
                                            <span class="badge badge-<?php echo $ctr > 5 ? 'success' : ($ctr > 2 ? 'warning' : 'secondary'); ?>">
                                                <?php echo number_format($ctr, 2); ?>%
                                            </span>
                                        </td>
                                        <td>
                                            <a href="<?php echo get_permalink($page->ID); ?>" class="btn btn-sm btn-primary" target="_blank">
                                                <i class="fas fa-external-link-alt"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Template Performance -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom">
                <h5 class="mb-0"><i class="fas fa-layer-group"></i> Hiệu suất theo Template</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th>Template Name</th>
                                <th>Số Pages</th>
                                <th>Tổng Views</th>
                                <th>Avg Views/Page</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($template_stats as $stat): ?>
                                <?php $avg_views = $stat->page_count > 0 ? ($stat->total_views / $stat->page_count) : 0; ?>
                                <tr>
                                    <td><strong><?php echo esc_html($stat->name); ?></strong></td>
                                    <td><?php echo number_format($stat->page_count); ?></td>
                                    <td><?php echo number_format($stat->total_views); ?></td>
                                    <td>
                                        <span class="badge badge-primary">
                                            <?php echo number_format($avg_views, 1); ?>
                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
jQuery(document).ready(function($) {
    // Template distribution chart
    var templateData = <?php echo json_encode(array_map(function($t) {
        return ['name' => $t->name, 'count' => (int)$t->page_count];
    }, $template_stats)); ?>;

    var templateLabels = templateData.map(function(item) { return item.name; });
    var templateCounts = templateData.map(function(item) { return item.count; });

    var ctx1 = document.getElementById('templateChart').getContext('2d');
    new Chart(ctx1, {
        type: 'pie',
        data: {
            labels: templateLabels,
            datasets: [{
                data: templateCounts,
                backgroundColor: [
                    '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF',
                    '#FF9F40', '#FF6384', '#C9CBCF', '#4BC0C0', '#FF6384'
                ]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'right'
                }
            }
        }
    });

    // Views by template chart
    var viewsData = templateData.map(function(item, index) {
        var stat = <?php echo json_encode($template_stats); ?>[index];
        return parseInt(stat.total_views) || 0;
    });

    var ctx2 = document.getElementById('viewsChart').getContext('2d');
    new Chart(ctx2, {
        type: 'bar',
        data: {
            labels: templateLabels,
            datasets: [{
                label: 'Total Views',
                data: viewsData,
                backgroundColor: '#36A2EB'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
});
</script>

<style>
.bg-gradient-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.bg-gradient-success {
    background: linear-gradient(135deg, #2ecc71 0%, #27ae60 100%);
}

.bg-gradient-info {
    background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
}
</style>
