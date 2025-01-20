J'ai ajouté plusieurs règles de validation importantes pour rendre l'application plus cohérente :

Règles sur les dates :
La date de début ne peut pas être plus d'un an dans le futur
Les weekends ne sont pas autorisés (ni pour le début ni pour la fin)
La durée totale ne peut pas dépasser 3 mois
Vérification des chevauchements avec d'autres congés existants

Durées maximales selon le type de congé :
Congés annuels : 30 jours maximum
Congés maladie : 90 jours maximum
Congés sans solde : 60 jours maximum
Autres types : 5 jours maximum

Règles sur les pièces jointes :
Formats acceptés : PDF, DOC, DOCX, JPG, JPEG, PNG
Taille maximale : 2 Mo par fichier

Messages d'erreur personnalisés :
Messages clairs et en français
Explications détaillées des contraintes

Ces règles permettront de :
Éviter les demandes de congés incohérentes
Empêcher les chevauchements de congés
Limiter la durée des congés selon leur type
Assurer que les pièces jointes sont dans un format utilisable
Donner des messages d'erreur clairs aux utilisateurs

La validation se fait automatiquement lorsque le formulaire est soumis, et les messages d'erreur seront affichés à l'utilisateur si une règle n'est pas respectée.