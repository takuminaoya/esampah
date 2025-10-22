$(document).ready(function() {
    
    $('.send-whatsapp').on('click', function() {
        let phone = $(this).data('phone');
        const name = $(this).data('name');
        
        // Ensure phone is treated as a string
        phone = String(phone);
        
        // Format phone number (ensure it starts with country code)
        if (phone.startsWith('0')) {
            phone = '62' + phone.substring(1);
        } else if (!phone.startsWith('62') && !phone.startsWith('+62')) {
            phone = '62' + phone;
        }
        
        // Get message from textarea or use default if not available
        let message = $('#wa_message').val();
        if (!message) {
            message = `Halo ${name}, kami dari SPS Ungasan akan melakukan peninjauan ke lokasi Anda dalam waktu dekat. Terima kasih.`;
        }
        
        // Show loading state
        const $button = $(this);
        const originalText = $button.html();
        $button.html('<i class="fas fa-spinner fa-spin"></i> Mengirim...');
        $button.prop('disabled', true);
        
        // Send WhatsApp notification using WhapIfy.id API
        $.ajax({
            url: '/whatsapp/send',
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $(this).data('csrf')
            },
            data: {
                phone: phone,
                message: message
            },
            success: function(response) {
                // Show success message using SweetAlert
                Swal.fire({
                    type: 'success',
                    title: 'Berhasil',
                    text: 'Pemberitahuan WhatsApp berhasil dikirim!',
                    showConfirmButton: false,
                    timer: 3000
                });
            },
            error: function(xhr) {
                // Show error message using SweetAlert
                console.error('WhatsApp notification error:', xhr.responseText);
                Swal.fire({
                    type: 'error',
                    title: 'Gagal',
                    text: 'Gagal mengirim pemberitahuan WhatsApp',
                    showConfirmButton: false,
                    timer: 3000
                });
            },
            complete: function() {
                // Restore button state
                $button.html(originalText);
                $button.prop('disabled', false);
            }
        });
    });
});
