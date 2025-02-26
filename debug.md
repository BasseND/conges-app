J'ai un souci. J'ai une table User et une table Team. Et ils ont une relation many to many. Il y a une table intermédiaire team_user. Alors quand j'ajoute un utilisateur en selectionnant son team, le champs team_id est vide. Alors voici le controlleur : 
 public function store(Request $request)
    {
        Log::info('Request data:', $request->all());

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => ['required', Rule::in([
                User::ROLE_EMPLOYEE,
                User::ROLE_MANAGER,
                User::ROLE_ADMIN,
                User::ROLE_HR,
                User::ROLE_DEPARTMENT_HEAD
            ])],
            'department_id' => 'required|exists:departments,id',
            'team_id' => 'nullable|exists:teams,id',
            'annual_leave_days' => 'required|integer|min:0',
            'sick_leave_days' => 'required|integer|min:0',
        ]);

        Log::info('Validated data:', $validatedData);
        
        // Get team_id and remove it from validatedData
        $teamId = $request->filled('team_id') ? $validatedData['team_id'] : null;
        unset($validatedData['team_id']);

        // Vérifier s'il existe déjà un chef pour ce département
        if ($validatedData['role'] === User::ROLE_DEPARTMENT_HEAD) {
            $existingHead = User::where('department_id', $validatedData['department_id'])
                ->where('role', User::ROLE_DEPARTMENT_HEAD)
                ->exists();

            if ($existingHead) {
                return back()
                    ->withInput()
                    ->withErrors(['role' => 'Ce département a déjà un chef.']);
            }
        }

        $validatedData['password'] = Hash::make($validatedData['password']);
        $validatedData['employee_id'] = $this->generateEmployeeId();
        
        $user = User::create($validatedData);

        // Attach team if one was selected
        if ($teamId) {
            $user->teams()->attach($teamId);
        }

        return redirect()->route('admin.users.index')
            ->with('success', 'Utilisateur créé avec succès.');
    }