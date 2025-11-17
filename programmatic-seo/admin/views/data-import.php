<?php
/**
 * Data import view
 */

if (!defined('ABSPATH')) {
    exit;
}

$importer = new PSEO_Data_Importer();
$data_sources = $importer->get_all_data_sources();
?>

<div class="wrap pseo-admin">
    <h1 class="wp-heading-inline">
        <i class="fas fa-upload"></i> Import Dữ liệu
    </h1>

    <hr class="wp-header-end">

    <div class="container-fluid mt-4">

        <div class="row">
            <!-- Upload Form -->
            <div class="col-md-6 mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="fas fa-cloud-upload-alt"></i> Upload File Dữ liệu</h5>
                    </div>
                    <div class="card-body">
                        <form id="importDataForm" enctype="multipart/form-data">
                            <div class="form-group">
                                <label><i class="fas fa-tag"></i> Tên Data Source *</label>
                                <input type="text" class="form-control" name="data_source_name" id="data_source_name" required>
                            </div>

                            <div class="form-group">
                                <label><i class="fas fa-file"></i> Chọn File (CSV hoặc JSON) *</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="data_file" name="data_file" accept=".csv,.json" required>
                                    <label class="custom-file-label" for="data_file">Chọn file...</label>
                                </div>
                                <small class="form-text text-muted">
                                    Định dạng hỗ trợ: CSV, JSON. Kích thước tối đa: <?php echo ini_get('upload_max_filesize'); ?>
                                </small>
                            </div>

                            <div class="alert alert-info">
                                <h6><i class="fas fa-info-circle"></i> Định dạng file:</h6>
                                <p class="mb-2"><strong>CSV:</strong> File phải có dòng header với tên cột</p>
                                <p class="mb-0"><strong>JSON:</strong> Array of objects với cùng structure</p>
                            </div>

                            <button type="submit" class="btn btn-primary btn-block btn-lg" id="importBtn">
                                <i class="fas fa-upload"></i> Upload & Import
                            </button>
                        </form>

                        <div id="importProgress" class="mt-3" style="display: none;">
                            <div class="progress">
                                <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 100%"></div>
                            </div>
                            <p class="text-center mt-2"><i class="fas fa-spinner fa-spin"></i> Đang import dữ liệu...</p>
                        </div>

                        <div id="importResult" class="mt-3" style="display: none;"></div>
                    </div>
                </div>
            </div>

            <!-- Import Guide -->
            <div class="col-md-6 mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0"><i class="fas fa-question-circle"></i> Hướng dẫn Import</h5>
                    </div>
                    <div class="card-body">
                        <h6><i class="fas fa-file-csv"></i> Ví dụ CSV:</h6>
                        <pre class="bg-light p-3 rounded"><code>city,service,price
Hà Nội,Web Development,5000000
TP HCM,SEO Marketing,3000000
Đà Nẵng,UI/UX Design,4000000</code></pre>

                        <h6 class="mt-4"><i class="fas fa-file-code"></i> Ví dụ JSON:</h6>
                        <pre class="bg-light p-3 rounded"><code>[
  {
    "city": "Hà Nội",
    "service": "Web Development",
    "price": "5000000"
  },
  {
    "city": "TP HCM",
    "service": "SEO Marketing",
    "price": "3000000"
  }
]</code></pre>

                        <div class="alert alert-warning mt-3">
                            <i class="fas fa-exclamation-triangle"></i> <strong>Lưu ý:</strong>
                            <ul class="mb-0 pl-3">
                                <li>Tên cột/key phải khớp với variables trong template</li>
                                <li>Dữ liệu phải đầy đủ, không có giá trị null</li>
                                <li>Encoding UTF-8 để hỗ trợ tiếng Việt</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Data Sources List -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom">
                <h5 class="mb-0"><i class="fas fa-database"></i> Data Sources đã import</h5>
            </div>
            <div class="card-body p-0">
                <?php if (empty($data_sources)): ?>
                    <div class="text-center py-5">
                        <i class="fas fa-database fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">Chưa có data source nào</h5>
                        <p class="text-muted">Upload file đầu tiên để bắt đầu!</p>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th width="30">ID</th>
                                    <th>Tên</th>
                                    <th>File</th>
                                    <th>Type</th>
                                    <th>Số dòng</th>
                                    <th>Columns</th>
                                    <th>Ngày tạo</th>
                                    <th width="100">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($data_sources as $source): ?>
                                    <tr>
                                        <td><?php echo $source->id; ?></td>
                                        <td><strong><?php echo esc_html($source->name); ?></strong></td>
                                        <td>
                                            <i class="fas fa-file"></i>
                                            <?php echo esc_html($source->file_name); ?>
                                        </td>
                                        <td>
                                            <span class="badge badge-<?php echo $source->file_type === 'csv' ? 'success' : 'info'; ?>">
                                                <?php echo strtoupper($source->file_type); ?>
                                            </span>
                                        </td>
                                        <td><?php echo number_format($source->total_rows); ?></td>
                                        <td>
                                            <?php
                                            $columns = json_decode($source->columns);
                                            if ($columns) {
                                                foreach (array_slice($columns, 0, 3) as $col) {
                                                    echo '<span class="badge badge-secondary mr-1">' . esc_html($col) . '</span>';
                                                }
                                                if (count($columns) > 3) {
                                                    echo '<span class="badge badge-light">+' . (count($columns) - 3) . '</span>';
                                                }
                                            }
                                            ?>
                                        </td>
                                        <td><?php echo date('d/m/Y H:i', strtotime($source->created_at)); ?></td>
                                        <td>
                                            <button class="btn btn-sm btn-info preview-data"
                                                    data-id="<?php echo $source->id; ?>"
                                                    title="Xem trước">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>

    </div>
</div>

<script>
jQuery(document).ready(function($) {
    // Update file input label
    $('#data_file').on('change', function() {
        var fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').html(fileName);
    });

    // Import form submit
    $('#importDataForm').on('submit', function(e) {
        e.preventDefault();

        var formData = new FormData(this);
        formData.append('action', 'pseo_import_data');
        formData.append('nonce', pseoAdmin.nonce);

        $('#importBtn').prop('disabled', true);
        $('#importProgress').show();
        $('#importResult').hide();

        $.ajax({
            url: pseoAdmin.ajax_url,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                $('#importProgress').hide();
                $('#importBtn').prop('disabled', false);

                if (response.success) {
                    $('#importResult')
                        .html('<div class="alert alert-success"><i class="fas fa-check-circle"></i> ' +
                              'Import thành công! Đã import <strong>' + response.data.total_rows + '</strong> dòng dữ liệu.</div>')
                        .show();

                    setTimeout(function() {
                        location.reload();
                    }, 2000);
                } else {
                    $('#importResult')
                        .html('<div class="alert alert-danger"><i class="fas fa-exclamation-circle"></i> ' +
                              'Lỗi: ' + response.data + '</div>')
                        .show();
                }
            },
            error: function() {
                $('#importProgress').hide();
                $('#importBtn').prop('disabled', false);
                $('#importResult')
                    .html('<div class="alert alert-danger"><i class="fas fa-exclamation-circle"></i> ' +
                          'Có lỗi xảy ra khi upload file!</div>')
                    .show();
            }
        });
    });
});
</script>
