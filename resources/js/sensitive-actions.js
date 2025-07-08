// Gestion des actions sensibles (suppression, changement de statut)
document.addEventListener('DOMContentLoaded', function() {
    // Fonction pour gérer les actions sensibles
    window.handleSensitiveAction = function(url, actionType, confirmText, userInfo) {
        const formData = new FormData();
        formData.append('confirm_text', confirmText);
        formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
        
        // Ajouter la méthode HTTP appropriée
        if (actionType === 'delete') {
            formData.append('_method', 'DELETE');
        } else if (actionType === 'status') {
            formData.append('_method', 'POST');
        }

        // Afficher un indicateur de chargement
        const submitButton = document.querySelector('[x-data] button[type="submit"]');
        if (submitButton) {
            submitButton.disabled = true;
            submitButton.innerHTML = '<svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>Traitement...';
        }

        fetch(url, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Fermer le modal
                window.dispatchEvent(new CustomEvent('close-sensitive-dialog'));
                
                // Afficher un message de succès
                showNotification(data.message, 'success');
                
                // Recharger la page après un court délai
                setTimeout(() => {
                    window.location.reload();
                }, 1500);
            } else {
                // Afficher l'erreur
                showNotification(data.message, 'error');
                
                // Réactiver le bouton
                if (submitButton) {
                    submitButton.disabled = false;
                    submitButton.innerHTML = getButtonText(actionType);
                }
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
            showNotification('Une erreur est survenue. Veuillez réessayer.', 'error');
            
            // Réactiver le bouton
            if (submitButton) {
                submitButton.disabled = false;
                submitButton.innerHTML = getButtonText(actionType);
            }
        });
    };

    // Fonction pour obtenir le texte du bouton selon le type d'action
    function getButtonText(actionType) {
        switch (actionType) {
            case 'delete':
                return 'Supprimer';
            case 'status':
                return 'Modifier le statut';
            default:
                return 'Confirmer';
        }
    }

    // Fonction pour afficher les notifications
    function showNotification(message, type = 'info') {
        // Créer l'élément de notification
        const notification = document.createElement('div');
        notification.className = `fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg max-w-sm transform transition-all duration-300 translate-x-full`;
        
        // Définir les couleurs selon le type
        if (type === 'success') {
            notification.className += ' bg-green-500 text-white';
        } else if (type === 'error') {
            notification.className += ' bg-red-500 text-white';
        } else {
            notification.className += ' bg-blue-500 text-white';
        }
        
        notification.innerHTML = `
            <div class="flex items-center">
                <div class="flex-1">
                    <p class="text-sm font-medium">${message}</p>
                </div>
                <button onclick="this.parentElement.parentElement.remove()" class="ml-4 text-white hover:text-gray-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        `;
        
        document.body.appendChild(notification);
        
        // Animer l'entrée
        setTimeout(() => {
            notification.classList.remove('translate-x-full');
        }, 100);
        
        // Supprimer automatiquement après 5 secondes
        setTimeout(() => {
            notification.classList.add('translate-x-full');
            setTimeout(() => {
                if (notification.parentElement) {
                    notification.remove();
                }
            }, 300);
        }, 5000);
    }
});