<?php
/**
 * Templates view - Enhanced version
 */

if (!defined('ABSPATH')) {
    exit;
}

$template_obj = new PSEO_Template();
$templates = $template_obj->get_all();
?>

<div class="wrap pseo-admin">
    <h1 class="wp-heading-inline">
        <i class="fas fa-layer-group"></i> Quản lý Templates
    </h1>
    <a href="#" class="page-title-action" data-toggle="modal" data-target="#templateModal">
        <i class="fas fa-plus"></i> Thêm Template
    </a>
    <a href="#" class="page-title-action" data-toggle="modal" data-target="#importModal">
        <i class="fas fa-file-import"></i> Import Template
    </a>

    <hr class="wp-header-end">

    <div class="container-fluid mt-4">

        <!-- Info Alert -->
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <i class="fas fa-info-circle"></i> <strong>Hướng dẫn:</strong> Sử dụng cú pháp <code>{{variable_name}}</code> để chèn biến vào template. Ví dụ: <code>{{city}}</code>, <code>{{product_name}}</code>
            <button type="button" class="close" data-dismiss="alert">
                <span>&times;</span>
            </button>
        </div>

        <!-- Templates List -->
        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">
                <?php if (empty($templates)): ?>
                    <div class="text-center py-5">
                        <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">Chưa có template nào</h5>
                        <p class="text-muted">Tạo template đầu tiên để bắt đầu!</p>
                        <button class="btn btn-primary" data-toggle="modal" data-target="#templateModal">
                            <i class="fas fa-plus"></i> Tạo Template
                        </button>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th width="30">ID</th>
                                    <th>Tên Template</th>
                                    <th>Mô tả</th>
                                    <th>Post Type</th>
                                    <th>Variables</th>
                                    <th>Status</th>
                                    <th>Ngày tạo</th>
                                    <th width="220">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($templates as $template): ?>
                                    <tr>
                                        <td><?php echo $template->id; ?></td>
                                        <td><strong><?php echo esc_html($template->name); ?></strong></td>
                                        <td><?php echo esc_html(substr($template->description, 0, 50)) . (strlen($template->description) > 50 ? '...' : ''); ?></td>
                                        <td><span class="badge badge-secondary"><?php echo $template->post_type; ?></span></td>
                                        <td>
                                            <?php
                                            if ($template->variables) {
                                                $vars = explode(',', $template->variables);
                                                foreach (array_slice($vars, 0, 3) as $var) {
                                                    echo '<span class="badge badge-info mr-1">' . esc_html(trim($var)) . '</span>';
                                                }
                                                if (count($vars) > 3) {
                                                    echo '<span class="badge badge-light">+' . (count($vars) - 3) . '</span>';
                                                }
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?php if ($template->status === 'active'): ?>
                                                <span class="badge badge-success">Active</span>
                                            <?php else: ?>
                                                <span class="badge badge-secondary">Inactive</span>
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo date('d/m/Y', strtotime($template->created_at)); ?></td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <button class="btn btn-sm btn-primary edit-template"
                                                        data-id="<?php echo $template->id; ?>"
                                                        title="Sửa">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="btn btn-sm btn-info duplicate-template"
                                                        data-id="<?php echo $template->id; ?>"
                                                        title="Nhân bản">
                                                    <i class="fas fa-copy"></i>
                                                </button>
                                                <button class="btn btn-sm btn-success export-template"
                                                        data-id="<?php echo $template->id; ?>"
                                                        title="Export">
                                                    <i class="fas fa-download"></i>
                                                </button>
                                                <button class="btn btn-sm btn-danger delete-template"
                                                        data-id="<?php echo $template->id; ?>"
                                                        title="Xóa">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
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

<!-- Template Modal -->
<div class="modal fade" id="templateModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title"><i class="fas fa-layer-group"></i> <span id="modalTitle">Tạo Template Mới</span></h5>
                <button type="button" class="close text-white" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form id="templateForm">
                <div class="modal-body">
                    <input type="hidden" name="template_id" id="template_id">

                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label><i class="fas fa-heading"></i> Tên Template * <small class="text-muted">(VD: Dịch vụ theo thành phố)</small></label>
                                <input type="text" class="form-control" name="name" id="template_name" required placeholder="Nhập tên template...">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label><i class="fas fa-file"></i> Post Type *</label>
                                <select class="form-control" name="post_type" id="post_type">
                                    <option value="page">Page</option>
                                    <option value="post">Post</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label><i class="fas fa-align-left"></i> Mô tả</label>
                        <textarea class="form-control" name="description" id="template_description" rows="2" placeholder="Mô tả ngắn về template này..."></textarea>
                    </div>

                    <div class="form-group">
                        <label><i class="fas fa-heading"></i> Title Template * <small class="text-muted">(Sử dụng {{variable}})</small></label>
                        <input type="text" class="form-control" name="title_template" id="title_template"
                               placeholder="VD: Dịch vụ {{service}} tại {{city}} - Giá {{price}}" required>
                        <small class="form-text text-muted">Sử dụng {{variable}} để chèn dữ liệu động</small>
                    </div>

                    <div class="form-group">
                        <label><i class="fas fa-link"></i> Slug Pattern <small class="text-muted">(Tùy chọn)</small></label>
                        <input type="text" class="form-control" name="slug_pattern" id="slug_pattern"
                               placeholder="VD: {{city}}-{{service}}">
                        <small class="form-text text-muted">Pattern cho URL slug. Để trống để tự động tạo từ title</small>
                    </div>

                    <div class="form-group">
                        <label><i class="fas fa-file-alt"></i> Content Template * <small class="text-muted">(Hỗ trợ HTML)</small></label>
                        <textarea class="form-control" name="content_template" id="content_template" rows="10" required
                                  placeholder="Nội dung template với các biến {{variable}}...&#10;&#10;VD:&#10;<h1>{{title}}</h1>&#10;<p>{{description}}</p>"></textarea>
                        <small class="form-text text-muted">Viết nội dung HTML với các biến {{variable}}</small>
                    </div>

                    <div class="form-group">
                        <label><i class="fas fa-search"></i> Meta Description Template <small class="text-muted">(Cho SEO)</small></label>
                        <textarea class="form-control" name="meta_description_template" id="meta_description" rows="2"
                                  placeholder="VD: Tìm hiểu về {{service}} tại {{city}}. Giá chỉ từ {{price}}. Liên hệ ngay!"></textarea>
                        <small class="form-text text-muted">Tối đa 150-160 ký tự cho SEO tốt nhất</small>
                    </div>

                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label><i class="fas fa-code"></i> Variables <small class="text-muted">(Phân cách bằng dấu phẩy)</small></label>
                                <input type="text" class="form-control" name="variables" id="variables"
                                       placeholder="VD: city, service, price, description">
                                <small class="form-text text-muted">Tự động detect từ template hoặc nhập thủ công</small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label><i class="fas fa-toggle-on"></i> Status</label>
                                <select class="form-control" name="status" id="status">
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="alert alert-warning">
                        <i class="fas fa-lightbulb"></i> <strong>Tips:</strong>
                        <ul class="mb-0 pl-3">
                            <li>Tên biến phải khớp với tên cột trong file CSV/JSON</li>
                            <li>Sử dụng HTML semantic tags (h1, h2, p) cho SEO tốt</li>
                            <li>Click "Preview" để xem kết quả trước khi lưu</li>
                        </ul>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times"></i> Hủy
                    </button>
                    <button type="button" class="btn btn-info" id="previewTemplateBtn">
                        <i class="fas fa-eye"></i> Preview
                    </button>
                    <button type="submit" class="btn btn-primary" id="saveTemplateBtn">
                        <i class="fas fa-save"></i> Lưu Template
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Import Modal -->
<div class="modal fade" id="importModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title"><i class="fas fa-file-import"></i> Import Template</h5>
                <button type="button" class="close text-white" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label><i class="fas fa-code"></i> Paste JSON Template</label>
                    <textarea class="form-control" id="importJson" rows="15" placeholder='{"name": "Template name", "title_template": "..."}'></textarea>
                    <small class="form-text text-muted">Paste nội dung JSON template đã export</small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fas fa-times"></i> Hủy
                </button>
                <button type="button" class="btn btn-success" id="importTemplateBtn">
                    <i class="fas fa-file-import"></i> Import
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Preview Modal -->
<div class="modal fade" id="previewModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title"><i class="fas fa-eye"></i> Preview Template</h5>
                <button type="button" class="close text-white" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i> Preview với dữ liệu mẫu
                </div>

                <h6><i class="fas fa-heading"></i> Title:</h6>
                <div class="p-3 bg-light mb-3 rounded" id="previewTitle"></div>

                <h6><i class="fas fa-link"></i> Slug (URL):</h6>
                <div class="p-3 bg-light mb-3 rounded" id="previewSlug"></div>

                <h6><i class="fas fa-file-alt"></i> Content:</h6>
                <div class="p-3 bg-light mb-3 rounded" id="previewContent"></div>

                <h6><i class="fas fa-search"></i> Meta Description:</h6>
                <div class="p-3 bg-light mb-3 rounded" id="previewMeta"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fas fa-times"></i> Đóng
                </button>
            </div>
        </div>
    </div>
</div>

<script>
jQuery(document).ready(function($) {
    // Reset form when modal closes
    $('#templateModal').on('hidden.bs.modal', function() {
        $('#templateForm')[0].reset();
        $('#template_id').val('');
        $('#modalTitle').text('Tạo Template Mới');
    });

    // Auto-extract variables from templates
    function extractVariables() {
        var templates = [
            $('#title_template').val(),
            $('#content_template').val(),
            $('#slug_pattern').val(),
            $('#meta_description').val()
        ].join(' ');

        var matches = templates.match(/\{\{([^}]+)\}\}/g);
        if (matches) {
            var vars = [];
            matches.forEach(function(match) {
                var varName = match.replace(/\{\{|\}\}/g, '').trim();
                if (vars.indexOf(varName) === -1) {
                    vars.push(varName);
                }
            });
            $('#variables').val(vars.join(', '));
        }
    }

    $('#title_template, #content_template, #slug_pattern, #meta_description').on('blur', extractVariables);

    // Edit template
    $('.edit-template').on('click', function() {
        var templateId = $(this).data('id');

        $.ajax({
            url: pseoAdmin.ajax_url,
            type: 'POST',
            data: {
                action: 'pseo_get_template',
                nonce: pseoAdmin.nonce,
                template_id: templateId
            },
            success: function(response) {
                if (response.success) {
                    var template = response.data;
                    $('#template_id').val(template.id);
                    $('#template_name').val(template.name);
                    $('#template_description').val(template.description);
                    $('#title_template').val(template.title_template);
                    $('#slug_pattern').val(template.slug_pattern);
                    $('#content_template').val(template.content_template);
                    $('#meta_description').val(template.meta_description_template);
                    $('#variables').val(template.variables);
                    $('#post_type').val(template.post_type);
                    $('#status').val(template.status);
                    $('#modalTitle').text('Sửa Template');
                    $('#templateModal').modal('show');
                }
            }
        });
    });

    // Duplicate template
    $('.duplicate-template').on('click', function() {
        if (!confirm('Bạn có muốn nhân bản template này?')) {
            return;
        }

        var templateId = $(this).data('id');
        var $btn = $(this);
        $btn.prop('disabled', true);

        $.ajax({
            url: pseoAdmin.ajax_url,
            type: 'POST',
            data: {
                action: 'pseo_duplicate_template',
                nonce: pseoAdmin.nonce,
                template_id: templateId
            },
            success: function(response) {
                if (response.success) {
                    alert('Nhân bản template thành công!');
                    location.reload();
                } else {
                    alert('Lỗi: ' + response.data);
                    $btn.prop('disabled', false);
                }
            }
        });
    });

    // Export template
    $('.export-template').on('click', function() {
        var templateId = $(this).data('id');

        $.ajax({
            url: pseoAdmin.ajax_url,
            type: 'POST',
            data: {
                action: 'pseo_export_template',
                nonce: pseoAdmin.nonce,
                template_id: templateId
            },
            success: function(response) {
                if (response.success) {
                    // Download JSON file
                    var dataStr = "data:text/json;charset=utf-8," + encodeURIComponent(response.data.json);
                    var downloadAnchorNode = document.createElement('a');
                    downloadAnchorNode.setAttribute("href", dataStr);
                    downloadAnchorNode.setAttribute("download", response.data.filename);
                    document.body.appendChild(downloadAnchorNode);
                    downloadAnchorNode.click();
                    downloadAnchorNode.remove();

                    alert('Export thành công! File đã được tải xuống.');
                } else {
                    alert('Lỗi: ' + response.data);
                }
            }
        });
    });

    // Import template
    $('#importTemplateBtn').on('click', function() {
        var json = $('#importJson').val().trim();

        if (!json) {
            alert('Vui lòng paste nội dung JSON!');
            return;
        }

        var $btn = $(this);
        $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Đang import...');

        $.ajax({
            url: pseoAdmin.ajax_url,
            type: 'POST',
            data: {
                action: 'pseo_import_template',
                nonce: pseoAdmin.nonce,
                json: json
            },
            success: function(response) {
                if (response.success) {
                    alert('Import template thành công!');
                    location.reload();
                } else {
                    alert('Lỗi: ' + response.data);
                    $btn.prop('disabled', false).html('<i class="fas fa-file-import"></i> Import');
                }
            },
            error: function() {
                alert('Có lỗi xảy ra!');
                $btn.prop('disabled', false).html('<i class="fas fa-file-import"></i> Import');
            }
        });
    });

    // Preview template
    $('#previewTemplateBtn').on('click', function() {
        var $btn = $(this);
        $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Loading...');

        $.ajax({
            url: pseoAdmin.ajax_url,
            type: 'POST',
            data: {
                action: 'pseo_preview_template',
                nonce: pseoAdmin.nonce,
                title_template: $('#title_template').val(),
                content_template: $('#content_template').val(),
                meta_description: $('#meta_description').val(),
                slug_pattern: $('#slug_pattern').val()
            },
            success: function(response) {
                if (response.success) {
                    $('#previewTitle').html('<h2>' + response.data.title + '</h2>');
                    $('#previewSlug').html('<code>' + response.data.slug + '</code>');
                    $('#previewContent').html(response.data.content);
                    $('#previewMeta').text(response.data.meta_description);
                    $('#previewModal').modal('show');
                }
                $btn.prop('disabled', false).html('<i class="fas fa-eye"></i> Preview');
            }
        });
    });

    // Delete template
    $('.delete-template').on('click', function() {
        if (!confirm('Bạn có chắc muốn xóa template này? Hành động này không thể hoàn tác!')) {
            return;
        }

        var templateId = $(this).data('id');
        var $btn = $(this);
        $btn.prop('disabled', true);

        $.ajax({
            url: pseoAdmin.ajax_url,
            type: 'POST',
            data: {
                action: 'pseo_delete_template',
                nonce: pseoAdmin.nonce,
                template_id: templateId
            },
            success: function(response) {
                if (response.success) {
                    alert('Xóa template thành công!');
                    location.reload();
                } else {
                    alert('Lỗi: ' + response.data);
                    $btn.prop('disabled', false);
                }
            }
        });
    });

    // Save template
    $('#templateForm').on('submit', function(e) {
        e.preventDefault();

        // Validate
        if (!$('#template_name').val() || !$('#title_template').val() || !$('#content_template').val()) {
            alert('Vui lòng điền đầy đủ các trường bắt buộc (*)!');
            return;
        }

        var $btn = $('#saveTemplateBtn');
        $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Đang lưu...');

        $.ajax({
            url: pseoAdmin.ajax_url,
            type: 'POST',
            data: $(this).serialize() + '&action=pseo_save_template&nonce=' + pseoAdmin.nonce,
            success: function(response) {
                if (response.success) {
                    alert('Lưu template thành công!');
                    location.reload();
                } else {
                    alert('Lỗi: ' + response.data);
                    $btn.prop('disabled', false).html('<i class="fas fa-save"></i> Lưu Template');
                }
            },
            error: function(xhr, status, error) {
                alert('Có lỗi xảy ra: ' + error);
                $btn.prop('disabled', false).html('<i class="fas fa-save"></i> Lưu Template');
            }
        });
    });
});
</script>

<style>
.btn-group .btn {
    margin-right: 2px;
}

#previewContent {
    max-height: 400px;
    overflow-y: auto;
}

#previewContent h1, #previewContent h2, #previewContent h3 {
    margin-top: 1rem;
    margin-bottom: 0.5rem;
}
</style>
