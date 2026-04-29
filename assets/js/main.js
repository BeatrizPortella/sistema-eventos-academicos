// Arquivo principal de JavaScript
document.addEventListener('DOMContentLoaded', () => {
    // Adiciona evento de confirmação para exclusões
    const deleteButtons = document.querySelectorAll('.btn-delete');
    
    deleteButtons.forEach(button => {
        button.addEventListener('click', function(event) {
            if (!confirm('Tem certeza que deseja excluir este registro? Esta ação não pode ser desfeita.')) {
                event.preventDefault(); // Cancela o envio do formulário ou link
            }
        });
    });

    // Auto-fechamento de alertas após 5 segundos
    const alerts = document.querySelectorAll('.alert-dismissible');
    alerts.forEach(alert => {
        setTimeout(() => {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }, 5000);
    });
});
