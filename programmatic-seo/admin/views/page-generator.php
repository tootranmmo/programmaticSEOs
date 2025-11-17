<?php
/**
 * Page generator view
 */

if (!defined('ABSPATH')) {
    exit;
}

$template_obj = new PSEO_Template();
$templates = $template_obj->get_all();

$importer = new PSEO_Data_Importer();
$data_sources = $importer->get_all_data_sources();
?>

<div class="wrap pseo-admin">
    <h1 class="wp-heading-inline">
        <i class="fas fa-magic"></i> Tạo Pages Tự động
    </h1>

    <hr class="wp-header-end">

    <div class="container-fluid mt-4">

        <div class="row">
            <!-- Generator Form -->
            <div class="col-md-8 mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0"><i class="fas fa-cogs"></i> Cấu hình Generator</h5>
                    </div>
                    <div class="card-body">
                        <form id="generatePagesForm">
                            <div class="form-group">
                                <label><i class="fas fa-layer-group"></i> Chọn Template *</label>
                                <select class="form-control form-control-lg" name="template_id" id="template_id" required>
                                    <option value="">-- Chọn template --</option>
                                    <?php foreach ($templates as $template): ?>
                                        <option value="<?php echo $template->id; ?>">
                                            <?php echo esc_html($template->name); ?>
                                            (<?php echo $template->post_type; ?>)
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label><i class="fas fa-database"></i> Chọn Data Source *</label>
                                <select class="form-control form-control-lg" name="data_source_id" id="data_source_id" required>
                                    <option value="">-- Chọn data source --</option>
                                    <?php foreach ($data_sources as $source): ?>
                                        <option value="<?php echo $source->id; ?>" data-rows="<?php echo $source->total_rows; ?>">
                                            <?php echo esc_html($source->name); ?>
                                            (<?php echo number_format($source->total_rows); ?> dòng)
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><i class="fas fa-list-ol"></i> Giới hạn số trang</label>
                                        <input type="number" class="form-control" name="limit" id="limit" min="0" placeholder="0 = không giới hạn">
                                        <small class="form-text text-muted">Để trống hoặc 0 để tạo tất cả</small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><i class="fas fa-toggle-on"></i> Auto Publish</label>
                                        <select class="form-control" name="auto_publish" id="auto_publish">
                                            <option value="false">Lưu Draft</option>
                                            <option value="true">Publish ngay</option>
                                        </select>
                                        <small class="form-text text-muted">Publish ngay hoặc lưu draft</small>
                                    </div>
                                </div>
                            </div>

                            <div class="alert alert-warning">
                                <i class="fas fa-exclamation-triangle"></i> <strong>Lưu ý:</strong>
                                <ul class="mb-0 pl-3">
                                    <li>Kiểm tra kỹ template và data trước khi generate</li>
                                    <li>Nên test với số lượng nhỏ trước (5-10 pages)</li>
                                    <li>Quá trình có thể mất vài phút nếu tạo nhiều pages</li>
                                </ul>
                            </div>

                            <button type="submit" class="btn btn-success btn-block btn-lg" id="generateBtn">
                                <i class="fas fa-magic"></i> Bắt đầu Generate Pages
                            </button>
                        </form>

                        <div id="generateProgress" class="mt-4" style="display: none;">
                            <div class="progress" style="height: 25px;">
                                <div class="progress-bar progress-bar-striped progress-bar-animated bg-success"
                                     role="progressbar" style="width: 100%">
                                    <span class="font-weight-bold">Đang tạo pages...</span>
                                </div>
                            </div>
                        </div>

                        <div id="generateResult" class="mt-4" style="display: none;"></div>
                    </div>
                </div>
            </div>

            <!-- Preview & Info -->
            <div class="col-md-4 mb-4">
                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0"><i class="fas fa-info-circle"></i> Preview</h5>
                    </div>
                    <div class="card-body">
                        <div id="previewInfo">
                            <p class="text-muted text-center py-3">
                                <i class="fas fa-arrow-left"></i><br>
                                Chọn template và data source để xem preview
                            </p>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-warning text-dark">
                        <h5 class="mb-0"><i class="fas fa-lightbulb"></i> Tips</h5>
                    </div>
                    <div class="card-body">
                        <ul class="pl-3 mb-0">
                            <li class="mb-2">Kiểm tra variables trong template khớp với columns trong data</li>
                            <li class="mb-2">Test với 5-10 pages trước khi generate hàng loạt</li>
                            <li class="mb-2">Sử dụng Draft mode để review trước khi publish</li>
                            <li class="mb-0">Có thể edit các pages sau khi tạo</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
jQuery(document).ready(function($) {
    // Update preview when selections change
    $('#template_id, #data_source_id').on('change', function() {
        var templateId = $('#template_id').val();
        var dataSourceId = $('#data_source_id').val();

        if (templateId && dataSourceId) {
            var templateText = $('#template_id option:selected').text();
            var dataRows = $('#data_source_id option:selected').data('rows');

            $('#previewInfo').html(
                '<h6 class="mb-3"><i class="fas fa-check-circle text-success"></i> Sẵn sàng generate</h6>' +
                '<p><strong>Template:</strong><br>' + templateText + '</p>' +
                '<p><strong>Data rows:</strong><br>' + dataRows.toLocaleString() + ' dòng</p>' +
                '<p class="mb-0"><strong>Sẽ tạo:</strong><br><span class="badge badge-success badge-lg">' +
                dataRows.toLocaleString() + ' pages</span></p>'
            );
        }
    });

    // Generate pages form submit
    $('#generatePagesForm').on('submit', function(e) {
        e.preventDefault();

        if (!confirm('Bạn có chắc muốn bắt đầu generate pages? Quá trình này không thể hoàn tác.')) {
            return;
        }

        var formData = $(this).serialize();
        formData += '&action=pseo_generate_pages&nonce=' + pseoAdmin.nonce;

        $('#generateBtn').prop('disabled', true);
        $('#generateProgress').show();
        $('#generateResult').hide();

        $.ajax({
            url: pseoAdmin.ajax_url,
            type: 'POST',
            data: formData,
            success: function(response) {
                $('#generateProgress').hide();
                $('#generateBtn').prop('disabled', false);

                if (response.success) {
                    var result = response.data;
                    var html = '<div class="alert alert-success">' +
                               '<h5><i class="fas fa-check-circle"></i> Hoàn thành!</h5>' +
                               '<p class="mb-2"><strong>Đã tạo:</strong> ' + result.generated_count + '/' + result.total_rows + ' pages</p>';

                    if (result.errors && result.errors.length > 0) {
                        html += '<p class="mb-1"><strong>Có ' + result.errors.length + ' lỗi:</strong></p>' +
                                '<ul class="mb-0">';
                        result.errors.slice(0, 5).forEach(function(error) {
                            html += '<li>' + error + '</li>';
                        });
                        if (result.errors.length > 5) {
                            html += '<li>... và ' + (result.errors.length - 5) + ' lỗi khác</li>';
                        }
                        html += '</ul>';
                    }

                    html += '<p class="mt-3 mb-0"><a href="' + '<?php echo admin_url("edit.php?post_type=page"); ?>' +
                            '" class="btn btn-primary"><i class="fas fa-list"></i> Xem Pages đã tạo</a></p>' +
                            '</div>';

                    $('#generateResult').html(html).show();
                } else {
                    $('#generateResult')
                        .html('<div class="alert alert-danger"><i class="fas fa-exclamation-circle"></i> ' +
                              'Lỗi: ' + response.data + '</div>')
                        .show();
                }
            },
            error: function() {
                $('#generateProgress').hide();
                $('#generateBtn').prop('disabled', false);
                $('#generateResult')
                    .html('<div class="alert alert-danger"><i class="fas fa-exclamation-circle"></i> ' +
                          'Có lỗi xảy ra khi generate pages!</div>')
                    .show();
            }
        });
    });
});
</script>
