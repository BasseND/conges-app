<x-app-layout>
  
    <div class="w-full">

        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <!-- En-tête modernisé -->
            <div class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                <div class="px-6 py-4">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div class="flex items-center space-x-4">
                            <div class="flex-shrink-0">
                                <div class="bg-gradient-to-r from-blue-600 to-indigo-600 p-3 rounded-2xl shadow-lg">
                                    <svg class="w-6 h-6 sm:w-8 sm:h-8 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                                    </svg>   
                                </div>
                            </div>
                            <div>
                                <h1 class="text-2xl font-bold text-gray-900 dark:text-white"> {{ __('Organigramme') }} - {{ $department->name }}</h1>
                                <p class="text-gray-600 dark:text-gray-400 mt-1">{{ __('Consultez l\'organigramme de l\'organisation') }}</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-3">
                            <a href="{{ route('admin.departments.index') }}" 
                            class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-500 to-indigo-600 text-white rounded-lg hover:from-blue-600 hover:to-indigo-700 transition-all duration-200 shadow-lg hover:shadow-xl">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd"></path>
                                </svg>
                                Retour
                            </a>
                        </div>

                       
                    </div>
                </div>
            </div>



            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex justify-between items-center mb-4">
                        <div class="flex space-x-2">
                            <button type="button" class="inline-flex items-center px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" onclick="zoomIn()">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"></path>
                                </svg>
                                Zoom +
                            </button>
                            <button type="button" class="inline-flex items-center px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" onclick="zoomOut()">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM13 10H7"></path>
                                </svg>
                                Zoom -
                            </button>
                            <button type="button" class="inline-flex items-center px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" onclick="resetZoom()">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"></path>
                                </svg>
                                Reset
                            </button>
                            <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500" onclick="exportOrganigramme()">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                Exporter
                            </button>
                        </div>
                    </div>
                    <div id="organigramme-container" class="organigramme-wrapper">
                        <!-- L'organigramme sera généré ici -->
                    </div>
                </div>
            </div>
        </div>
    </div>

<style>
    .organigramme-wrapper {
         width: 100%;
         height: 80vh;
         overflow: auto;
         background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
         position: relative;
     }
     
     .dark .organigramme-wrapper {
         background: linear-gradient(135deg, #1f2937 0%, #374151 100%);
     }

    .org-chart {
        min-width: 100%;
        min-height: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 40px 20px;
        transform-origin: top center;
        transition: transform 0.3s ease;
    }

    /* Structure hiérarchique */
    .org-level {
        display: flex;
        flex-direction: column;
        align-items: center;
        margin-bottom: 60px;
        position: relative;
        width: 100%;
    }

    .org-level-title {
         font-size: 1.2rem;
         font-weight: bold;
         color: #2c3e50;
         margin-bottom: 20px;
         padding: 8px 16px;
         background: rgba(255, 255, 255, 0.9);
         border-radius: 20px;
         box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
     }
     
     .dark .org-level-title {
         color: #f9fafb;
         background: rgba(55, 65, 81, 0.9);
         box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
     }

    /* Cartes utilisateur */
     .user-card {
         background: white;
         border-radius: 12px;
         padding: 16px;
         box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
         border: 2px solid transparent;
         transition: all 0.3s ease;
         cursor: pointer;
         min-width: 180px;
         max-width: 200px;
         text-align: center;
         position: relative;
         margin: 8px;
     }
     
     .dark .user-card {
         background: #374151;
         box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
     }

    .user-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }

    .user-card.head {
        border-color: #e74c3c;
        background: linear-gradient(135deg, #fff 0%, #ffe6e6 100%);
    }

    .user-card.manager {
        border-color: #3498db;
        background: linear-gradient(135deg, #fff 0%, #e6f3ff 100%);
    }

    .user-card.employee {
        border-color: #2ecc71;
        background: linear-gradient(135deg, #fff 0%, #e6ffe6 100%);
    }

    .user-card.unassigned {
        border-color: #f39c12;
        background: linear-gradient(135deg, #fff 0%, #fff3e6 100%);
    }

    .user-avatar {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        margin: 0 auto 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f8f9fa;
        border: 2px solid #ecf0f1;
    }

    .user-name {
         font-size: 0.95rem;
         font-weight: bold;
         color: #2c3e50;
         margin-bottom: 4px;
         line-height: 1.2;
     }
     
     .dark .user-name {
         color: #f9fafb;
     }

     .user-position {
         font-size: 0.8rem;
         color: #7f8c8d;
         margin-bottom: 4px;
     }
     
     .dark .user-position {
         color: #d1d5db;
     }

     .user-email {
         font-size: 0.7rem;
         color: #95a5a6;
         word-break: break-word;
     }
     
     .dark .user-email {
         color: #9ca3af;
     }

    /* Structure des équipes */
    .teams-container {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 20px;
        position: relative;
        width: 100%;
    }

    .team-box {
        display: flex;
        flex-direction: column;
        align-items: center;
        position: relative;
        min-width: 165px;
        max-width: 300px;
    }

    .team-name {
        font-size: 1rem;
        font-weight: bold;
        color: #2c3e50;
        margin-bottom: 15px;
        padding: 6px 12px;
        background: rgba(52, 152, 219, 0.1);
        border: 2px solid #3498db;
        border-radius: 15px;
        text-align: center;
        min-width: 120px;
        box-shadow: 0 2px 8px rgba(52, 152, 219, 0.2);
    }
    
    .dark .team-name {
        color: #f9fafb;
        background: rgba(59, 130, 246, 0.2);
        border-color: #3b82f6;
        box-shadow: 0 2px 8px rgba(59, 130, 246, 0.3);
    }

    .team-manager {
        margin-bottom: 30px;
        position: relative;
    }

    .team-members {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 15px;
        max-width: 400px;
    }

    /* Lignes de connexion */
    .connection-line {
        position: absolute;
        background: #bdc3c7;
        z-index: 1;
    }

    /* Ligne verticale du chef vers les équipes */
    .org-level.direction::after {
        content: '';
        position: absolute;
        bottom: -30px;
        left: 50%;
        width: 2px;
        height: 30px;
        background: #bdc3c7;
        transform: translateX(-50%);
    }

    /* Ligne horizontale entre les équipes */
    .teams-container::before {
        content: '';
        position: absolute;
        top: -15px;
        left: 15%;
        right: 15%;
        height: 2px;
        background: #bdc3c7;
    }

    /* Lignes verticales vers chaque équipe */
    .team-box::before {
        content: '';
        position: absolute;
        top: -15px;
        left: 50%;
        width: 2px;
        height: 15px;
        background: #bdc3c7;
        transform: translateX(-50%);
    }

    /* Ligne du manager vers les membres */
    .team-box .team-manager::after {
        content: '';
        position: absolute;
        bottom: -15px;
        left: 50%;
        width: 2px;
        height: 15px;
        background: #bdc3c7;
        transform: translateX(-50%);
    }

    /* Ligne horizontale entre les membres */
    .team-members::before {
        content: '';
        position: absolute;
        top: -8px;
        left: 10%;
        right: 10%;
        height: 2px;
        background: #bdc3c7;
    }

    /* Lignes verticales vers chaque membre */
    .team-members .user-card::before {
        content: '';
        position: absolute;
        top: -8px;
        left: 50%;
        width: 2px;
        height: 8px;
        background: #bdc3c7;
        transform: translateX(-50%);
    }

    /* Responsive */
    @media (max-width: 768px) {
        .org-chart {
            padding: 20px 10px;
        }
        
        .user-card {
            min-width: 150px;
            padding: 12px;
        }
        
        .user-avatar {
            width: 40px;
            height: 40px;
        }

        .teams-container {
            gap: 30px;
        }

        .team-members {
            max-width: 300px;
        }
    }

    @media print {
        .organigramme-wrapper {
            height: auto !important;
            overflow: visible !important;
        }
        
        .card-header {
            display: none !important;
        }
    }
</style>

<script>
    let currentZoom = 1;
    
    // Données de l'organigramme
    const orgData = @json($organigrammeData);
    
    // Icône SVG par défaut
    const defaultAvatarSVG = `
        <svg width="30" height="30" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <circle cx="12" cy="8" r="4" fill="#95a5a6"/>
            <path d="M20 19v1a1 1 0 01-1 1H5a1 1 0 01-1-1v-1a6 6 0 016-6h4a6 6 0 016 6z" fill="#95a5a6"/>
        </svg>
    `;

    // Fonction pour créer une carte utilisateur
    function createUserCard(user, type) {
        return `
            <div class="user-card ${type}" onclick="showUserDetails(${user.id})">
                <div class="user-avatar">
                    ${defaultAvatarSVG}
                </div>
                <div class="user-name">${user.name}</div>
                <div class="user-position">${user.position}</div>
                <div class="user-email">${user.email}</div>
            </div>
        `;
    }

    // Fonction pour créer une équipe
    function createTeam(team) {
        let teamHTML = '<div class="team-box">';
        
        // Nom de l'équipe
        if (team.name) {
            teamHTML += `
                <div class="team-name">
                    ${team.name}
                </div>
            `;
        }
        
        // Manager de l'équipe
        if (team.manager) {
            teamHTML += `
                <div class="team-manager">
                    ${createUserCard(team.manager, 'manager')}
                </div>
            `;
        }
        
        // Membres de l'équipe
        if (team.members && team.members.length > 0) {
            teamHTML += '<div class="team-members">';
            team.members.forEach(member => {
                teamHTML += createUserCard(member, 'employee');
            });
            teamHTML += '</div>';
        }
        
        teamHTML += '</div>';
        return teamHTML;
    }

    // Fonction principale pour dessiner l'organigramme
    function drawOrganigramme() {
        const container = document.getElementById('organigramme-container');
        
        let html = '<div class="org-chart">';
        
        // Chef de département
        if (orgData.department && orgData.department.head) {
            html += `
                <div class="org-level direction">
                    <div class="org-level-title">Direction</div>
                    ${createUserCard(orgData.department.head, 'head')}
                </div>
            `;
        }
        
        // Équipes avec managers et membres
        const teamsWithManagers = orgData.teams ? orgData.teams.filter(team => team.manager) : [];
        if (teamsWithManagers.length > 0) {
            html += `
                <div class="org-level teams">
                    <div class="org-level-title">Équipes</div>
                    <div class="teams-container">
                        ${teamsWithManagers.map(team => createTeam(team)).join('')}
                    </div>
                </div>
            `;
        }
        
        // Utilisateurs non assignés
        if (orgData.unassignedUsers && orgData.unassignedUsers.length > 0) {
            html += `
                <div class="org-level unassigned">
                    <div class="org-level-title">Non Assignés</div>
                    <div style="display: flex; flex-wrap: wrap; justify-content: center; gap: 15px; max-width: 800px;">
                        ${orgData.unassignedUsers.map(user => createUserCard(user, 'unassigned')).join('')}
                    </div>
                </div>
            `;
        }
        
        html += '</div>';
        container.innerHTML = html;
    }

    // Fonction pour afficher les détails d'un utilisateur
    function showUserDetails(userId) {
        console.log('Afficher les détails de l\'utilisateur:', userId);
        // Ici vous pouvez ajouter une modal ou rediriger vers la page de détails
    }

    // Fonctions de zoom
    function zoomIn() {
        currentZoom = Math.min(2, currentZoom + 0.1);
        applyZoom();
    }

    function zoomOut() {
        currentZoom = Math.max(0.5, currentZoom - 0.1);
        applyZoom();
    }

    function resetZoom() {
        currentZoom = 1;
        applyZoom();
    }

    function applyZoom() {
        const chart = document.querySelector('.org-chart');
        if (chart) {
            chart.style.transform = `scale(${currentZoom})`;
        }
    }

    // Fonction d'export
    function exportOrganigramme() {
        window.print();
    }

    // Initialisation
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Données organigramme:', orgData);
        drawOrganigramme();
    });

    // Redimensionnement
    window.addEventListener('resize', function() {
        setTimeout(drawOrganigramme, 100);
    });
 </script>
</x-app-layout>