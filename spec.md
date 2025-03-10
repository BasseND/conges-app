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


A l'image de la page de gestion des congés par les managers, je voudrais exactement la même chose pour les chefs de departament. Cela permettrait aux chefs de departament de voir les congés de leurs employés et de les approuver ou refuser.

Je voudrais modifier la page de gestion des congés pour les managers pour que chaque manager ne voit que les congés des membres de son équipe (teams). Je voudrais que le filtre repose sur l'appartenance à une équipe et non au département. Que chaque manager qui a une équipe puisse voir les congés de ses membres. Cela permettrait à ces managers de voir les congés de leurs employés et de les approuver ou refuser. 




Je voudrais faire évoluer mon application qui pour l'instant fait de la gestion de Congés. Je voudrais à terme qu'elle soit une app SIRH complète. Donc je voudrais ajouter une couche pour la gestion des notes de frais. Pour cela, j'ai besoin de ton aide.
J'ai déjà commencé à faire cette partie. Je voudrais que tu aies une idee de la structure de la couche.
Je voudrais que tu me génères les migrations :

Migration  expense_reports :
class CreateExpenseReportsTable extends Migration
{
    public function up()
    {
        Schema::create('expense_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('status')->default('draft');
            $table->decimal('total_amount', 10, 2)->default(0.00);
            $table->timestamp('submitted_at')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('expense_reports');
    }
}

user_id fait référence à la table users.
status = draft, submitted, approved, rejected, etc.
total_amount peut être recalculé à la volée, mais le stocker peut simplifier les rapports.
submitted_at et approved_at pour tracer le workflow.

Migration  expense_lines : 

class CreateExpenseLinesTable extends Migration
{
    public function up()
    {
        Schema::create('expense_lines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('expense_report_id')->constrained()->onDelete('cascade');
            $table->string('description');
            $table->decimal('amount', 10, 2)->default(0.00);
            $table->date('spent_on')->nullable();
            $table->string('receipt_path')->nullable();  // Pour stocker le chemin/URL du justificatif
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('expense_lines');
    }
}


Ajouter ces champs (first_name
last_name
phone ) dans la table user.   
 
Le champs frist_name va remplacer le champs name.