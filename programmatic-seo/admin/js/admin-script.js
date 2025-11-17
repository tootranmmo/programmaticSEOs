/**
 * Programmatic SEO - Admin JavaScript
 */

(function($) {
    'use strict';

    // Wait for DOM ready
    $(document).ready(function() {

        // Initialize tooltips
        if (typeof $().tooltip === 'function') {
            $('[data-toggle="tooltip"]').tooltip();
        }

        // Initialize popovers
        if (typeof $().popover === 'function') {
            $('[data-toggle="popover"]').popover();
        }

        // Auto-hide alerts after 5 seconds
        $('.alert:not(.alert-permanent)').each(function() {
            var $alert = $(this);
            setTimeout(function() {
                $alert.fadeOut(300, function() {
                    $(this).remove();
                });
            }, 5000);
        });

        // Confirm delete actions
        $('.delete-action').on('click', function(e) {
            if (!confirm(pseoAdmin.strings.confirm_delete)) {
                e.preventDefault();
                return false;
            }
        });

        // AJAX form handler helper
        window.pseoAjaxForm = function(formId, action, successCallback) {
            $(formId).on('submit', function(e) {
                e.preventDefault();

                var $form = $(this);
                var $btn = $form.find('button[type="submit"]');
                var btnOriginalText = $btn.html();

                // Disable button and show loading
                $btn.prop('disabled', true)
                    .html('<i class="fas fa-spinner fa-spin"></i> ' + pseoAdmin.strings.saving);

                // Prepare form data
                var formData = new FormData(this);
                formData.append('action', action);
                formData.append('nonce', pseoAdmin.nonce);

                // Send AJAX request
                $.ajax({
                    url: pseoAdmin.ajax_url,
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        $btn.prop('disabled', false).html(btnOriginalText);

                        if (response.success) {
                            if (typeof successCallback === 'function') {
                                successCallback(response.data);
                            } else {
                                alert(pseoAdmin.strings.success);
                                location.reload();
                            }
                        } else {
                            alert(pseoAdmin.strings.error + ': ' + response.data);
                        }
                    },
                    error: function(xhr, status, error) {
                        $btn.prop('disabled', false).html(btnOriginalText);
                        alert(pseoAdmin.strings.error + ': ' + error);
                    }
                });
            });
        };

        // Format numbers
        window.pseoFormatNumber = function(num) {
            return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        };

        // Show notification
        window.pseoNotify = function(message, type) {
            type = type || 'info';
            var alertClass = 'alert-' + type;
            var icon = {
                'success': 'check-circle',
                'error': 'exclamation-circle',
                'warning': 'exclamation-triangle',
                'info': 'info-circle'
            };

            var $alert = $('<div class="alert ' + alertClass + ' alert-dismissible fade show" role="alert">')
                .html('<i class="fas fa-' + icon[type] + '"></i> ' + message +
                      '<button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>');

            $('.wrap .container-fluid').prepend($alert);

            // Auto-hide after 5 seconds
            setTimeout(function() {
                $alert.fadeOut(300, function() {
                    $(this).remove();
                });
            }, 5000);
        };

        // Copy to clipboard
        window.pseoCopyToClipboard = function(text) {
            var $temp = $('<textarea>');
            $('body').append($temp);
            $temp.val(text).select();
            document.execCommand('copy');
            $temp.remove();
            pseoNotify('Copied to clipboard!', 'success');
        };

        // Template variable helper
        window.pseoExtractVariables = function(text) {
            var regex = /\{\{([^}]+)\}\}/g;
            var variables = [];
            var match;

            while ((match = regex.exec(text)) !== null) {
                if (variables.indexOf(match[1]) === -1) {
                    variables.push(match[1]);
                }
            }

            return variables;
        };

        // Validate template and data match
        window.pseoValidateTemplateData = function(templateVars, dataColumns) {
            var missing = [];

            templateVars.forEach(function(varName) {
                if (dataColumns.indexOf(varName) === -1) {
                    missing.push(varName);
                }
            });

            return {
                valid: missing.length === 0,
                missing: missing
            };
        };

        // Dynamic variable highlighting
        $('textarea[name="title_template"], textarea[name="content_template"], input[name="slug_pattern"], textarea[name="meta_description_template"]')
            .on('input', function() {
                var $this = $(this);
                var text = $this.val();
                var variables = pseoExtractVariables(text);

                // Update variables field if it exists
                if (variables.length > 0 && $('#variables').length) {
                    $('#variables').val(variables.join(', '));
                }
            });

        // Table row click to expand details
        $('.pseo-admin .table tbody tr').on('click', function(e) {
            if (!$(e.target).is('button, a, .btn')) {
                $(this).toggleClass('table-active');
            }
        });

        // Search/filter functionality
        $('#pseoTableSearch').on('keyup', function() {
            var value = $(this).val().toLowerCase();
            $('.pseo-admin .table tbody tr').filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
            });
        });

        // Export to CSV helper
        window.pseoExportTableToCSV = function(tableId, filename) {
            var csv = [];
            var rows = $(tableId + ' tr');

            rows.each(function() {
                var row = [];
                $(this).find('th, td').each(function() {
                    row.push('"' + $(this).text().trim().replace(/"/g, '""') + '"');
                });
                csv.push(row.join(','));
            });

            var csvContent = csv.join('\n');
            var blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
            var link = document.createElement('a');

            if (link.download !== undefined) {
                var url = URL.createObjectURL(blob);
                link.setAttribute('href', url);
                link.setAttribute('download', filename || 'export.csv');
                link.style.visibility = 'hidden';
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            }
        };

        // Print helper
        window.pseoPrint = function(selector) {
            var printContents = $(selector).html();
            var originalContents = document.body.innerHTML;

            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
            location.reload();
        };

        // Smooth scroll to element
        window.pseoScrollTo = function(selector, offset) {
            offset = offset || 100;
            $('html, body').animate({
                scrollTop: $(selector).offset().top - offset
            }, 500);
        };

        // Get AJAX helper for templates
        window.pseoGetTemplate = function(templateId, callback) {
            $.ajax({
                url: pseoAdmin.ajax_url,
                type: 'POST',
                data: {
                    action: 'pseo_get_template',
                    nonce: pseoAdmin.nonce,
                    template_id: templateId
                },
                success: function(response) {
                    if (response.success && typeof callback === 'function') {
                        callback(response.data);
                    }
                }
            });
        };

        // Console log for debugging
        if (window.location.search.indexOf('pseo_debug=1') > -1) {
            console.log('Programmatic SEO Admin JS Loaded');
            console.log('AJAX URL:', pseoAdmin.ajax_url);
            console.log('Nonce:', pseoAdmin.nonce);
        }

    }); // End document ready

})(jQuery);
