<?php
/**
 * Templates view
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
                                    <th width="150">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($templates as $template): ?>
                                    <tr>
                                        <td><?php echo $template->id; ?></td>
                                        <td><strong><?php echo esc_html($template->name); ?></strong></td>
                                        <td><?php echo esc_html(substr($template->description, 0, 50)) . '...'; ?></td>
                                        <td><span class="badge badge-secondary"><?php echo $template->post_type; ?></span></td>
                                        <td>
                                            <?php
                                            if ($template->variables) {
                                                $vars = explode(',', $template->variables);
                                                foreach (array_slice($vars, 0, 3) as $var) {
                                                    echo '<span class="badge badge-info mr-1">' . esc_html($var) . '</span>';
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
                                            <button class="btn btn-sm btn-primary edit-template"
                                                    data-id="<?php echo $template->id; ?>"
                                                    title="Sửa">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-sm btn-danger delete-template"
                                                    data-id="<?php echo $template->id; ?>"
                                                    title="Xóa">
                                                <i class="fas fa-trash"></i>
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
                                <label><i class="fas fa-heading"></i> Tên Template *</label>
                                <input type="text" class="form-control" name="name" id="template_name" required>
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
                        <textarea class="form-control" name="description" id="template_description" rows="2"></textarea>
                    </div>

                    <div class="form-group">
                        <label><i class="fas fa-heading"></i> Title Template *</label>
                        <input type="text" class="form-control" name="title_template" id="title_template"
                               placeholder="Ví dụ: Dịch vụ tại {{city}} - {{service_name}}" required>
                        <small class="form-text text-muted">Sử dụng {{variable}} để chèn dữ liệu động</small>
                    </div>

                    <div class="form-group">
                        <label><i class="fas fa-link"></i> Slug Pattern</label>
                        <input type="text" class="form-control" name="slug_pattern" id="slug_pattern"
                               placeholder="Ví dụ: {{city}}-{{service}}">
                        <small class="form-text text-muted">Pattern cho URL slug</small>
                    </div>

                    <div class="form-group">
                        <label><i class="fas fa-file-alt"></i> Content Template *</label>
                        <textarea class="form-control" name="content_template" id="content_template" rows="8" required
                                  placeholder="Nội dung template với các biến {{variable}}..."></textarea>
                    </div>

                    <div class="form-group">
                        <label><i class="fas fa-search"></i> Meta Description Template</label>
                        <textarea class="form-control" name="meta_description_template" id="meta_description" rows="2"
                                  placeholder="Ví dụ: Tìm hiểu về {{service_name}} tại {{city}}..."></textarea>
                    </div>

                    <div class="form-group">
                        <label><i class="fas fa-code"></i> Variables (phân cách bằng dấu phẩy)</label>
                        <input type="text" class="form-control" name="variables" id="variables"
                               placeholder="city, service_name, price">
                    </div>

                    <div class="form-group">
                        <label><i class="fas fa-toggle-on"></i> Status</label>
                        <select class="form-control" name="status" id="status">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times"></i> Hủy
                    </button>
                    <button type="submit" class="btn btn-primary" id="saveTemplateBtn">
                        <i class="fas fa-save"></i> Lưu Template
                    </button>
                </div>
            </form>
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

    // Delete template
    $('.delete-template').on('click', function() {
        if (!confirm('Bạn có chắc muốn xóa template này?')) {
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
            }
        });
    });
});
</script>
